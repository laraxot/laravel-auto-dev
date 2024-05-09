<?php

namespace Laraxot\LaravelAutoDev\config;

return [
    'base_dir' => env('API_BASE_DIR', base_path()),
    'url' => env('API_URL', 'http://127.0.0.1:3000'),

    'asana' => [
        'workspace_id' => env('ASANA_WORKSPACE_ID', 'default_workspace_id'),
        'assignee' => env('ASANA_ASSIGNEE', 'default_assignee_email')
    ]


];
