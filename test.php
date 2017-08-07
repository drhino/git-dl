<?php

require __DIR__ . '/vendor/autoload.php';

$git = new GitDownload(__DIR__ . '/themes');
$git->clone('BlackrockDigital', 'startbootstrap-agency', 'master');
