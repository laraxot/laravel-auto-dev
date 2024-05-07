<?php

namespace Laraxot\LaravelAutoDev\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class AiFabricatorCommand extends Command
{
    protected $signature = 'ai:fabricator {file : Path to the HTML file to process}';
    protected $description = 'Generate Filament Fabricator code from an HTML file';

    public function handle(): void
    {
        $filePath = $this->argument('file');
        if (!File::exists($filePath)) {
            $this->error("The file {$filePath} does not exist.");
            return;
        }

        $htmlContent = File::get($filePath);

        $baseDir = Config::get('make_code.base_dir');  // Uses the same base directory configuration as make-code.php
        
        $apiUrl = Config::get('make_code.url');        // Reuses the same API URL configuration

        $apiUrl .= "/filament-fabricator-block-maker";

        $postData = ['html' => $htmlContent];

        try {
            $response = Http::timeout(120)->post($apiUrl, $postData);
            if ($response->successful()) {
                $files = $response->json()['value'];

                foreach ($files as $file) {
                    $this->saveToFile($baseDir, $file['path'], $file['content']);
                }

                $this->info('Filament Fabricator code files saved successfully!');
            } else {
                $this->error("Failed to generate code: " . $response->body());
            }
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
