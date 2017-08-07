<?php

require __DIR__ . '/vendor/autoload.php';

$git = new GitDownload(__DIR__ . '/downloaded');

$author     = 'wbadrh';
$repository = 'git-dl';
$branch     = 'master';

$git->clone($author, $repository, $branch);
