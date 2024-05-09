<?php

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Laraxot\LaravelAutoDev\Actions\TaskGeneratorAction;
use Laraxot\LaravelAutoDev\DTO\TaskGeneratorData;

class TaskGeneratorActionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Config::shouldReceive('get')
              ->with('make_code.url')
              ->andReturn('http://example.com/api');

        Config::shouldReceive('get')
              ->with('make_code.base_dir')
              ->andReturn('/var/www/html/generated-files');
    }

    //TODO
    /*public function testSuccessfulFileGeneration()
    {
        Http::fake([
            'http://example.com/api/task-generator' => Http::response(['value' => [['path' => 'test.php', 'content' => '<?php echo "Hello World!"; ?>']]], 200)
        ]);

        $data = new TaskGeneratorData('Generate a test', false, false);
        $action = new TaskGeneratorAction();
        $action->execute($data);

        // Assertions to ensure files are created, etc.
    }*/

    public function testHttpRequestErrors()
    {
        Http::fake([
            'http://example.com/api/task-generator' => Http::response([], 500)
        ]);

        $this->expectException(Exception::class);

        $data = new TaskGeneratorData('Generate a test', false, false);
        $action = new TaskGeneratorAction();
        $action->execute($data);
    }
}
