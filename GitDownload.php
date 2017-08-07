<?php

use Curl\Curl;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

/*
 * Clone a Github repository with PHP & ZipArchive. Without using Git or exec()!
 */
class GitDownload
{
    private $curl;
    private $dir;
    private $fs;

    function __construct($dir)
    {
        $this->curl = new Curl;
        $this->dir  = $dir;
        $this->fs   = new Filesystem(new Local($dir));
    }

    function __destruct()
    {
        $this->curl->close();
    }

    /**
     * Download & unpack zip.
     *
     * @param String $author Github author
     * @param String $repo   Github repository
     * @param String $branch Repository branch
     */
    public function clone($author, $repo, $branch)
    {
        $contents = $this->get('https://codeload.github.com/' . $author . '/' . $repo . '/zip/' . $branch);
        $absolute = $this->dir . '/' . $author . '/';
        
        $this->fs->put($author . '/' . $repo . '.zip', $contents);

        $zip = new ZipArchive;
        $zip->open($absolute . $repo . '.zip');
        $zip->extractTo($absolute);
        $zip->close();

        $this->fs->delete($author . '/' . $repo . '.zip');
        $this->fs->deleteDir($author . '/' . $repo);
        $this->fs->rename($author . '/' . $repo . '-' . $branch, $author . '/' . $repo);
    }

    /**
     * Get CURL response.
     *
     * @param  String $url
     * @return String $response 
     */
    private function get($url)
    {
        $this->curl->get($url);

        if ($this->curl->error)
            return 'Curl error: ' . $this->curl->error_code;

        return $this->curl->response;
    }
}
