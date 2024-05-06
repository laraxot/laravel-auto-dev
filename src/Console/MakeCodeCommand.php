<?php

namespace Laraxot\LaravelAutoDev\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class MakeCodeCommand extends Command
{
    protected $signature = 'make:code {task : Description of the task to generate code for} 
                                         {--test : Generate test files} 
                                         {--filament : Generate Filament panels}';
    protected $description = 'Automate Laravel development with AI-driven code generation and PHPDoc support';

    public function handle(): void
    {
        /**
         * @var string
         */
        $baseDir = Config::get('make_code.base_dir');

        /**
         * @var string
         */
        $apiUrl = Config::get('make_code.url');

        // Preparing data to be sent to the API
        $postData = [
            'task' => $this->argument('task'),
            'test' => $this->option('test'),
            'filament' => $this->option('filament')
        ];

        try {
            $response = Http::timeout(120)->post($apiUrl, $postData);
            $files = $response->json()['value'];

            foreach ($files as $file) {
                $this->saveToFile($baseDir, $file['path'], $file['content']);
            }

            $this->info('Files saved successfully!');
        } catch (\Exception $e) {
            $this->error('Error fetching data: ' . $e->getMessage());
        }
    }

    protected function saveToFile(string $baseDir, string $filePath, string $content): void
    {
        $fullPath = $baseDir . '/' . $filePath;
        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0777, true);
        }
        file_put_contents($fullPath, $content);
    }
}
