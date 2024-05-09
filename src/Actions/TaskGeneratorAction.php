<?php

namespace Laraxot\LaravelAutoDev\Actions;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Spatie\QueueableAction\QueueableAction;
use Laraxot\LaravelAutoDev\DTO\TaskGeneratorData;
use Exception;

class TaskGeneratorAction
{
    use QueueableAction;

    public function execute(TaskGeneratorData $data): void
    {
        $apiUrl = Config::get('make_code.url') . "/task-generator";
        $postData = [
            'task' => $data->task,
            'test' => $data->test,
            'filament' => $data->filament
        ];

        try {
            $response = Http::timeout(120)->post($apiUrl, $postData);
            $files = $response->json()['value'];

            foreach ($files as $file) {
                $this->saveToFile($file['path'], $file['content']);
            }
        } catch (Exception $e) {
            Log::error("Failed to generate files: {$e->getMessage()}");
            throw new Exception("Error in file generation: " . $e->getMessage());
        }
    }

    protected function saveToFile(string $filePath, string $content): void
    {
        $baseDir = Config::get('make_code.base_dir');
        $fullPath = $baseDir . '/' . $filePath;
        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0777, true);
        }
        file_put_contents($fullPath, $content);
    }
}
