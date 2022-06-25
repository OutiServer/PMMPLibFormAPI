<?php

declare(strict_types=1);

namespace Ken_Cir\LibFormAPI\Tasks;

use pocketmine\scheduler\Task;

class BackFormTask extends Task
{
    private $callable;
    private array $args;

    public function __construct(callable $callable, array $args = [])
    {
        $this->callable = $callable;
        $this->args = $args;
    }

    public function onRun(): void
    {
        call_user_func_array($this->callable, $this->args);
    }
}