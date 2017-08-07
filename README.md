# Download a Github repository with PHP.

This script will download the requested zip-archive with CURL.
Afterwards it will unpack with ZipArchive.

The Github repository will be downloaded in: GithubAuthor/Repository/

```sh
$ composer require wbadrh/git-dl
```

```php
$git = new GitDownload(__DIR__ . '/themes');

$author     = 'BlackrockDigital';
$repository = 'startbootstrap-agency';
$branch     = 'master';

$git->clone($author, $repository, $branch);
```

Would download in: themes/BlackrockDigital/startbootstrap-agency/
