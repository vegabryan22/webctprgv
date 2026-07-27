<?php

namespace App\Http\Controllers;

use App\Mail\NewContactMessage;
use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactSubmissionController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['required', 'string', 'max:180'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            'privacy_consent' => ['accepted'],
            'website' => ['nullable', 'max:0'],
        ]);

        $contactMessage = ContactMessage::create([
            ...collect($data)->only(['name', 'email', 'phone', 'subject', 'message'])->all(),
            'consented_at' => now(),
        ]);

        $recipient = SiteSetting::where('key', 'contact_notification_email')->value('value')
            ?: SiteSetting::where('key', 'contact_email')->value('value');

        if ($recipient) {
            try {
                Mail::to($recipient)->send(new NewContactMessage($contactMessage));
            } catch (Throwable $exception) {
                report($exception);
            }
        }

        return back()->with('contact_success', 'Su consulta fue recibida correctamente.');
    }
}
