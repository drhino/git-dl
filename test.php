<?php

require __DIR__ . '/vendor/autoload.php';

$git = new GitDownload(__DIR__ . '/downloaded');

$author     = 'drhino';
$repository = 'git-dl';
$branch     = 'master';

$path = $git->clone($author, $repository, $branch);

echo "Saved to: $path";
