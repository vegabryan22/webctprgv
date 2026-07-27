<?php

namespace App\Support;

final class CurricularIllustrations
{
    public static function path(string $slug): ?string
    {
        $path = "images/curricular/items/{$slug}.jpg";

        if (! is_file(public_path($path))) {
            return null;
        }

        return $path;
    }
}
