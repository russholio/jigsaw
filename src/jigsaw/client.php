<?php

namespace jigsaw;

require_once __DIR__ . '/../../vendor/autoload.php';

use sputnik\Model\Entity\JobDescription;
use GearmanClient;

$client = new GearmanClient;
$client->addServer('127.0.0.1');

$job = $client->doBackground('sputnik', new JobDescription([
    'repository' => 'russholio/device-sync',
    'version' => 'dev-master',
    'runCommand' => 'build/device-sync',
    'arguments' => ['a', 'b', 'c']
]));

var_dump($client->jobStatus($job));
