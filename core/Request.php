<?php
namespace phpooya\server\core;

class Request extends Object
{
    public function getDocumentRoot()
    {
        return $_SERVER['DOCUMENT_ROOT'];
    }

    private $uri;
    public function getUri()
    {
        if($this->uri === null) {
            $this->uri = preg_replace("/[\\\\\\/]+/", "/", rtrim(urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)), "\\/"));
        }
        return $this->uri;
    }
}