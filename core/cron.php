<?php
namespace phpooya\server\core;

use phpooya\server\core;
use phpooya\server\cron\BaseCron;

include __DIR__ . "/functions.php";
include __DIR__ . "/Object.php";
include __DIR__ . "/../cron/BaseCron.php";
include __DIR__ . "/../cron/PhpCron.php";

/** This line should be at the end of all */
$crons = require __DIR__ . "/../crons.php";
$cronClassOption = ['class' => 'phpooya\server\cron\PhpCron'];

if(is_array($crons)) {
    foreach($crons as $cron) {
        if (is_string($cron)) {
            $cron = ['filename' => $cron];
        }
        $cron = array_merge($cronClassOption, $cron);
        /** @var BaseCron $cron */
        $cron = functions\createObject($cron);
        $cron->run();
    }
}