<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class MakeFabricatorCodeCommandTest extends TestCase
{
    /**
     * Test the output of the MakeCodeCommand.
     *
     * @return void
     */
    public function testMakeFabricatorCodeCommand()
    {
        Http::fake([
            '*' => Http::response(['value' => [
                ['path' => 'example.txt', 'content' => 'Hello World']
            ]], 200)
        ]);

        Artisan::call('make:fabricator-code', [
            'file' => 'extras/testBlock.html'
        ]);

        $output = Artisan::output();
        
        // Check if the command output indicates successful execution
        $this->assertStringContainsString('Filament Fabricator code files saved successfully!', $output);
        
        // Ensure that the API was called with the correct data
        Http::assertSent(function ($request) {
            return $request->url() == Config::get('make_code.url')."/filament-fabricator-block-maker" &&
                   $request['html'] == '<div>Test</div>';
        });
    }
}
