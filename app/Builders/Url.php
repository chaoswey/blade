<?php namespace App\Builders;

use Illuminate\Filesystem\Filesystem;

class Url
{
    protected static $public_url;

    protected static $base_url;

    public function __construct($base_url = null)
    {
        if (empty(self::$base_url)) {
            self::$base_url = $base_url ?? request()->getSchemeAndHttpHost().request()->getBaseUrl();
        }

        if (empty(self::$public_url)) {
            self::$public_url = self::$base_url.'/public/';
        }
    }

    public function get($path = null): string
    {
        return self::$base_url.'/'.ltrim($path, '/');
    }

    /**
     * @example "asset('css/style.css')" http://localhost/public/css/style.css
     * @param  null  $content  /public
     * @return string
     */
    public function asset($content = null): string
    {
        $filesystem = new Filesystem();
        $target = \App\Builders\Path::os(dirname(__DIR__, 2)."/mix-manifest.json");
        if ($filesystem->exists($target)) {
            $manifest = json_decode($filesystem->get($target));
            $ver = "/public/".trim(trim($content), "/");
            if (!empty($manifest) && !empty($manifest->{$ver})) {
                return self::$base_url.$manifest->{$ver};
            }
        }
        return self::$public_url.trim(trim($content), '/');
    }
}