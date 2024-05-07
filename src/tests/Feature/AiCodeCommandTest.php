<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class AiCodeCommandTest extends TestCase
{
    /**
     * Test the output of the MakeCodeCommand.
     *
     * @return void
     */
    public function testAiCodeCommand()
    {
        Http::fake([
            '*' => Http::response(['value' => [
                ['path' => 'example.txt', 'content' => 'Hello World']
            ]], 200)
        ]);

        Artisan::call('ai:code', [
            'task' => 'Generate code for example task',
            '--test' => true,
            '--filament' => true
        ]);

        $output = Artisan::output();
        
        // Check if the command output indicates successful execution
        $this->assertStringContainsString('Files saved successfully!', $output);
        
        // Ensure that the API was called with the correct data
        Http::assertSent(function ($request) {
            return $request->url() == Config::get('make_code.url')."/task-generator" &&
                   $request['task'] == 'Generate code for example task' &&
                   $request['test'] === true &&
                   $request['filament'] === true;
        });
    }
}
