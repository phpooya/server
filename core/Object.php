<?php
namespace phpooya\server\core;

class Object
{
    /**
     * @var Server
     */
    public $server;
    
    public function __construct($config = [])
    {
        if(is_array($config)) {
            foreach($config as $prop => $value) {
                $this->{$prop} = $value;
            }
        }
    }

    public static function className()
    {
        return get_called_class();
    }
}