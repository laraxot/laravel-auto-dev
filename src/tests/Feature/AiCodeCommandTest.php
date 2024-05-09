<?php

use Illuminate\Support\Facades\Artisan;
use Laraxot\LaravelAutoDev\Console\AiCodeCommand;
use Laraxot\LaravelAutoDev\Actions\TaskGeneratorAction;
use Illuminate\Support\Facades\App;
use Tests\TestCase;


class AiCodeCommandTest extends TestCase
{
    public function testCommandExecution():void
    {
        // Mock the action class
        $mockAction = $this->createMock(TaskGeneratorAction::class);
        $mockAction->expects($this->once())
                   ->method('execute');

        App::instance(TaskGeneratorAction::class, $mockAction);

        // Execute the command
        $this->artisan('ai:code', ['task' => 'Create a new user system'])
             ->expectsOutput('Files saved successfully!')
             ->assertExitCode(0);
    }
}
