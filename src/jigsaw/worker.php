#!/usr/bin/env php
<?php

namespace jigsaw;

require_once __DIR__ . '/../../vendor/autoload.php';

use GearmanWorker;
use GearmanJob;

\E2EX\Converter::register(E_ALL);

$worker = new GearmanWorker;
$worker->addServer('127.0.0.1');
$worker->addFunction('sputnik', function(GearmanJob $job) {
    var_dump($job->handle());
    $jd = unserialize($job->workload());

    ensureJobIsAvailable($jd);
});

print "Waiting for job...\n";
while ($worker->work()) {
    if ($worker->returnCode() != GEARMAN_SUCCESS) {
        echo "return_code: " . $worker->returnCode() . "\n";
        break;
    }
}

