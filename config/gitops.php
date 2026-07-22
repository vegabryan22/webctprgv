<?php

return [
    'repository' => env('GITHUB_REPOSITORY'),
    'branch' => env('GITHUB_DEFAULT_BRANCH', 'main'),
    'workflow' => env('GITHUB_DEPLOY_WORKFLOW', 'deploy.yml'),
    'token' => env('GITHUB_TOKEN'),
    'api_url' => env('GITHUB_API_URL', 'https://api.github.com'),
    'api_version' => '2026-03-10',
];
