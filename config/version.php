<?php

return [
    'number' => trim((string) @file_get_contents(base_path('VERSION'))) ?: '0.0.0',
];
