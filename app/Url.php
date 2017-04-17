<?php namespace App;

class Url
{
    protected $host;

    protected $root;

    protected $scriptName;

    public function __construct()
    {
        $this->getHost();
    }

    protected function getHost()
    {
        $protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
        $this->host = $protocol . '://' . $_SERVER['HTTP_HOST'];
        $this->getRoot();
    }

    protected function getRoot()
    {
        $this->removeIndex();
        $this->host .= $this->scriptName . "/";
    }

    protected function removeIndex()
    {
        $this->scriptName = preg_replace('/\/index.php/', '', $_SERVER['SCRIPT_NAME']);
    }

    public function get($path = null)
    {
        if (preg_match('/index.php/', $_SERVER['REQUEST_URI'])) {
            $this->host .= 'index.php/';
        }
        return $this->host .= trim(trim($path), '/');
    }

    public function asset($content = null)
    {
        return $this->host . 'public/' . trim(trim($content), '/');
    }
}