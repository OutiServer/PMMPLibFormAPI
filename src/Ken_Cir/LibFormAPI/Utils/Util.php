<?php

declare(strict_types=1);

namespace Ken_Cir\LibFormAPI\Utils;

use Ken_Cir\LibFormAPI\Tasks\BackFormTask;
use pocketmine\plugin\PluginBase;

class Util
{
    static function backForm(PluginBase $plugin, callable $callable, array $args = [], int $timeout = 1): void
    {
        $plugin->getScheduler()->scheduleDelayedTask(new BackFormTask($callable, $args), $timeout * 20);
    }
}