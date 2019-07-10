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
        if (!$this->isCommandLineInterface()) {
            $protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
            $this->host = $protocol . '://' . $_SERVER['HTTP_HOST'];
        }
        $this->getRoot();
    }

    protected function getRoot()
    {
        if ($this->isCommandLineInterface()) {
            $this->host .= '/';
        } else {
            $this->removeIndex();
            $this->host .= $this->scriptName . "/";
        }
    }

    protected function removeIndex()
    {
        $this->scriptName = preg_replace('/\/index.php/', '', $_SERVER['SCRIPT_NAME']);
    }

    public function get($path = null)
    {
        if (!$this->isCommandLineInterface()) {
            if (preg_match('/index.php/', $_SERVER['REQUEST_URI'])) {
                $this->host .= 'index.php/';
            }
        }
        $path = trim(trim($path), '/');
        $pathArray = explode('/', $path);

        if (!$this->isCommandLineInterface()) {
            if (end($pathArray) == "index") {
                array_pop($pathArray);
            }
        }

        $path = implode("/", $pathArray);

        if ($this->isCommandLineInterface()) {
            $path .= '.html';
        }
        return $this->host .= $path;
    }

    /**
     * @example "asset('css/style.css')" http://localhost/css/style.css
     * @param null $content /public
     * @return string
     */
    public function asset($content = null)
    {
        if ($this->isCommandLineInterface()) {
            return '/' . trim(trim($content), '/');
        } else {
            return $this->host . 'public/' . trim(trim($content), '/');
        }
    }

    private function isCommandLineInterface()
    {
        return (php_sapi_name() === 'cli');
    }
}