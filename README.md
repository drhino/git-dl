# Download a Github repository with PHP.

This script will download the requested zip-archive with CURL.
Afterwards it will unpack with ZipArchive.

The Github repository will be downloaded in: GithubAuthor/Repository/

```sh
$ composer require wbadrh/git-dl
```

```php
<?php

$git = new GitDownload(__DIR__ . '/downloaded');

$author     = 'wbadrh';
$repository = 'git-dl';
$branch     = 'master';

$git->clone($author, $repository, $branch);
```

Would download in: downloaded/wbadrh/git-dl/
