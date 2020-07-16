<?php namespace App\Builders;

use Illuminate\Filesystem\Filesystem;

class Url
{
    protected $public_url;

    protected $base_url;

    public function __construct($base_url = null)
    {
        if (!empty($base_url)) {
            $this->base_url = $base_url;
        } else {
            $request = \App\Component\Request::getInstance();
            $this->base_url = $request->getSchemeAndHttpHost() . $request->getBaseUrl();
        }
        $this->public_url = $this->base_url . '/public/';
    }

    public function get($path = null)
    {
        return $this->base_url . '/' . ltrim($path, '/');
    }

    /**
     * @example "asset('css/style.css')" http://localhost/public/css/style.css
     * @param null $content /public
     * @return string
     */
    public function asset($content = null)
    {
        $filesystem = new Filesystem();
        $target = $this->getPath(dirname(dirname(__DIR__)) . "/mix-manifest.json");
        if ($filesystem->exists($target)) {
            $manifest = json_decode($filesystem->get($target));
            $ver = "/public/" . trim(trim($content), "/");
            if (!empty($manifest) && !empty($manifest->{$ver})) {
                return $this->base_url . $manifest->{$ver};
            }
        }
        return $this->public_url . trim(trim($content), '/');
    }

    private function getPath($path)
    {
        return windows_os() ? str_replace('/', '\\', $path) : $path;
    }
}