<?php 

namespace Laraxot\LaravelAutoDev\DTO;

class TaskGeneratorData
{
    public string $task;
    public bool $test;
    public bool $filament;

    public function __construct(string $task, bool $test, bool $filament)
    {
        $this->task = $task;
        $this->test = $test;
        $this->filament = $filament;
    }
}