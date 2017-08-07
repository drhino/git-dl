<?php

require __DIR__ . '/vendor/autoload.php';

$git = new GitDownload(__DIR__ . '/themes');

$author     = 'BlackrockDigital';
$repository = 'startbootstrap-agency';
$branch     = 'master';

$git->clone($author, $repository, $branch);
