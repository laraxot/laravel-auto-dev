<?php

namespace Laraxot\LaravelAutoDev\Console;

use Illuminate\Console\Command;
use Laraxot\LaravelAutoDev\DTO\TaskGeneratorData;
use Laraxot\LaravelAutoDev\Actions\TaskGeneratorAction;

class AiCodeCommand extends Command
{
    protected $signature = 'ai:code {task : Description of the task to generate code for}
                                         {--test : Generate test files} 
                                         {--filament : Generate Filament panels}';
    protected $description = 'Automate Laravel development with AI-driven code generation and PHPDoc support';

    public function handle(): void
    {
        
        $data = new TaskGeneratorData(
            $this->argument('task'),
            $this->option('test'),
            $this->option('filament')
        );

       
        // Dispatch the action as a queued job
        app(TaskGeneratorAction::class)->execute($data);

        $this->info('Files saved successfully!');
    }
}
