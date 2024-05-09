<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class AiFabricatorCommandTest extends TestCase
{
    /**
     * Test the output of the MakeCodeCommand.
     *
     * @return void
     */
    public function testAiFabricatorCommand()
    {
        Http::fake([
            '*' => Http::response(['value' => [
                ['path' => 'example.txt', 'content' => 'Hello World']
            ]], 200)
        ]);

        Artisan::call('ai:fabricator', [
            'file' => __DIR__.'/../../extras/testBlock.html'
        ]);

        $output = Artisan::output();
        
        // Check if the command output indicates successful execution
        $this->assertStringContainsString('Filament Fabricator code files saved successfully!', $output);
        
        // Ensure that the API was called with the correct data
        Http::assertSent(function ($request) {
            return $request->url() == Config::get('laravel_auto_dev.url')."/filament-fabricator-block-maker" &&
                   $request['html'] == '<div>Test</div>';
        });
    }
}
