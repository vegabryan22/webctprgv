<?php

namespace App\Services;

use App\Models\ExploratoryWorkshop;
use App\Models\Specialty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CurricularDocumentService
{
    public function sync(Request $request, Specialty|ExploratoryWorkshop $owner): void
    {
        $this->deleteSelected($request, $owner);

        foreach ($request->file('plan_files', []) as $index => $file) {
            if (! $file) {
                continue;
            }

            $grade = $request->input("plan_grades.$index");
            $language = $request->input("plan_languages.$index", 'es');
            $title = $request->input("plan_titles.$index")
                ?: 'Programa de estudio de '.$grade;
            $path = $file->store('curricular-plans', 'public');

            $owner->curricularDocuments()->create([
                'title' => $title,
                'grade_level' => $grade,
                'language' => $language,
                'file_path' => 'storage/'.$path,
                'sort_order' => ((int) $owner->curricularDocuments()->max('sort_order')) + 10,
            ]);
        }
    }

    public function deleteAll(Specialty|ExploratoryWorkshop $owner): void
    {
        $owner->curricularDocuments->each(fn (Model $document) => $this->deleteDocument($document));
    }

    private function deleteSelected(Request $request, Specialty|ExploratoryWorkshop $owner): void
    {
        $ids = collect($request->input('delete_plan_ids', []))->map(fn ($id) => (int) $id);

        $owner->curricularDocuments()
            ->whereIn('id', $ids)
            ->get()
            ->each(fn (Model $document) => $this->deleteDocument($document));
    }

    private function deleteDocument(Model $document): void
    {
        if (Str::startsWith($document->file_path, 'storage/curricular-plans/')) {
            Storage::disk('public')->delete(Str::after($document->file_path, 'storage/'));
        }

        $document->delete();
    }
}
