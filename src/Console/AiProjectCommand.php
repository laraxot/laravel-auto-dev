<?php

namespace Laraxot\LaravelAutoDev\Console;

use Torann\LaravelAsana\Asana;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class AiProjectCommand extends Command
{
    protected $signature = 'ai:project {project : Description of the project to quote}';
    protected $description = 'Automate Laravel development with AI-driven code generation and PHPDoc support';

    public function handle(): void
    {
        //dd(asana()->getCurrentUser());
        /**
         * @var string
         */
        $baseDir = Config::get('laravel_auto_dev.base_dir');

        /**
         * @var string
         */
        $apiUrl = Config::get('laravel_auto_dev.url');

        $apiUrl .= "/project-quote";

        // Preparing data to be sent to the API
        $postData = [
            'project' => $this->argument('project')
        ];

        try {
            $response = Http::timeout(120)->post($apiUrl, $postData);

            $tasks = $response->json()['value'];

            $total = $tasks['total'];

            //dd(["tasks" => $tasks["tasks"],"total" => $total ]);

            foreach ($tasks["tasks"] as $task) {
                $this->saveToAsana($task['name']);
            }

            $this->info('Tasks saved! Total: €' . $total);
        } catch (\Exception $e) {
            $this->error('Error fetching data: ' . $e->getMessage());
        }
    }

    protected function saveToAsana(string $name): void
    {
        $this->info("Creating Asana Task: $name");

        $workspaceId = Config::get('laravel_auto_dev.asana.workspace_id');
        $assignee = Config::get('laravel_auto_dev.asana.assignee');

        asana()->createTask([
            'workspace' => $workspaceId,
            'name'      => $name,
            'assignee'  => $assignee
        ]);
    }
}
