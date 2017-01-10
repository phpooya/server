<?php
namespace phpooya\server\core;

include __DIR__ . "/functions.php";
include __DIR__ . "/Object.php";
include __DIR__ . "/Request.php";
include __DIR__ . "/Route.php";

/** This line should be at the end of all */
$config = require __DIR__ . "/../config.php";

class Server
{
    public $name = 'Phpooya';

    public $version = '1.0.0';

    /** @var Request */
    public $request;

    /** @var Route */
    public $route;

    public $mimeType = [
        'css'  => 'text/css',
        'htm'  => 'text/html',
        'html' => 'text/html',
        'js'   => 'application/js'
    ];

    public function start()
    {
        header("X-Powered-By: {$this->name}/{$this->version}");
        $route = $this->route->route();

        if($route) {
            $type = substr($route, strrpos($route, '.') + 1);

            if(isset($this->mimeType[$type])) {
                header("Content-Type: {$this->mimeType[$type]}");
            }

            functions\serverInclude($route);
        } else {
            header("HTTP/1.1 404 NOT FOUND");
        }

        return $this;
    }

    public function end($code = 0)
    {
        exit($code);
    }

    public function __construct($config = [])
    {
        if(is_array($config)) {
            $config = array_merge($this->coreComponent(), $config);
            foreach($config as $prop => $value) {
                if(isset($this->coreComponent()[$prop])) {
                    $this->{$prop} = functions\createObject($value, ['server' => $this]);
                } else {
                    $this->{$prop} = $value;
                }
            }
        }
    }

    public function coreComponent()
    {
        return [
            'request' => 'phpooya\server\core\Request',
            'route' => 'phpooya\server\core\Route'
        ];
    }
}

(new Server($config))->start()->end();