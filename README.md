# Download a Github repository with PHP.

### Install with composer:

```sh
$ composer require wbadrh/git-dl
```

### Example usage:

```php
<?php

$git = new GitDownload('/your/downloads');

$author     = 'drhino';
$repository = 'git-dl';
$branch     = 'master';

$path = $git->clone($author, $repository, $branch);

// Prints: 'Saved to: /your/downloads/drhino/git-dl'
echo "Saved to: $path";

```

## How does it work?

The zip-archive is downloaded from Github. Then unpacked with ZipArchive.
<br>From version 1.1.x and above; A stream is used to keep a low memory footprint.
<br>After a succesful unpack, the downloaded archive is removed.
<br>Cloning an existing repository updates to the latest version.

## Changelog:

v1.1.0
- Uses a stream for writing.
- The PHP cURL extension is no longer used.
- Supports both Flysystem 1 and 3 (PHP 7 and 8).
- Returns the directory path on success.
- Throws Exception.

v1.0.2
- Fixes CVE-2021-32708.

v1.0.1
- Adds documentation.

v1.0.0
- Initial release.
