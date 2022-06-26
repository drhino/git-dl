<?php

use League\Flysystem\Filesystem;

/*
 * Clone a Github repository with PHP & ZipArchive. Without using Git or exec()!
 */
class GitDownload
{
    private $dir;
    private $fs;

    /**
     * Sets the output directory location and creates the Filesystem.
     *
     * @param String $dir Directory to store the contents into.
     */
    public function __construct(String $dir)
    {
        $this->dir = $dir;

        // Creates a Filesystem based on the Flysystem version.
        $this->fs = new Filesystem(
            class_exists('League\Flysystem\Adapter\Local')
            // Version 1
            ? new League\Flysystem\Adapter\Local($dir) 
            // Version 3
            : new League\Flysystem\Local\LocalFilesystemAdapter($dir)
        );
    }

    /**
     * Download & unpack zip.
     *
     * @param String $author Github author
     * @param String $repo   Github repository
     * @param String $branch Repository branch
     *
     * @throws Exception ZipArchive failed
     *
     * @return String $absolute path to directory location.
     *
     * @see https://www.php.net/manual/en/function.fopen
     * @see https://stackoverflow.com/a/2174899/19052212
     * @see https://www.php.net/manual/en/function.stream-context-create.php
     * @see https://www.php.net/manual/en/ziparchive.open.php
     * @see https://www.php.net/manual/en/zip.constants.php#ziparchive.constants.rdonly
     * @see https://www.php.net/manual/en/ziparchive.extractto.php
     */
    public function clone(String $author, String $repo, String $branch): String
    {
        $url = 'https://codeload.github.com/' . $author . '/' . $repo . '/zip/' . $branch;

        $relative = $author . '/' . $repo . '.zip';
        $absolute = $this->dir . '/' . $author . '/' . $repo;
        $resource = @fopen($url, 'rb');

        // Downloads the zipfile to the local filesystem.
        $this->fs->has($relative) && $this->fs->delete($relative);
        $this->fs->writeStream($relative, $resource);

        // Extracts the zipfile.
        $zip = new ZipArchive;
        $status = $zip->open($absolute . '.zip', ZipArchive::CHECKCONS);
        if (true === $status) $status = $zip->extractTo(dirname($absolute));
        $zip->close();

        // $status = false when extractTo() failed.
        // Otherwise $status has one of the error code constants:
        // https://www.php.net/manual/en/ziparchive.open.php
        if ($status !== true) throw new Exception('ZipArchive failed', $status);

        // Removes the zipfile.
        $this->fs->delete($relative);

        // Strips the '.zip' from the path.
        $relative = substr($relative, 0, -4);

        // Handles according to Flysystem version,
        // 'rename' only exists in Flysystem 1.
        if (method_exists($this->fs, 'rename')) {
            $this->fs->deleteDir($relative);
            $this->fs->rename($relative . '-' . $branch, $relative);
        } else {
            $this->fs->deleteDirectory($relative);
            $this->fs->move($relative . '-' . $branch, $relative);
        }

        return $absolute;
    }
}
