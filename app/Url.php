<?php namespace App;

class Url
{
    protected $request;

    protected $public_url;

    protected $base_url;

    public function __construct()
    {
        $this->request = \App\Component\Request::getInstance();

        $this->base_url = $this->request->getSchemeAndHttpHost() . $this->request->getBaseUrl();
        $this->public_url = $this->base_url . '/public/';
    }

    public function get($path = null)
    {
        if ($this->isCommandLineInterface()) {
            return '/' . trim(trim($path), '/');
        } else {
            return $this->base_url . $path;
        }
    }

    /**
     * @example "asset('css/style.css')" http://localhost/public/css/style.css
     * @param null $content /public
     * @return string
     */
    public function asset($content = null)
    {
        if ($this->isCommandLineInterface()) {
            return '/' . trim(trim($content), '/');
        } else {
            return $this->public_url . trim(trim($content), '/');
        }
    }

    private function isCommandLineInterface()
    {
        return (php_sapi_name() === 'cli');
    }
}