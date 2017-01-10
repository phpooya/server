<?php
namespace phpooya\server\core\functions;

/** 
 * @param $file string name of the file which needed to include.
 */
function serverInclude($file) { include $file; }
function createObject($class, array $options = [])
{
    if (is_string($class)) {
        return new $class($options);
    }
    elseif (is_array($class) and isset($class['class'])) {
        $options = array_merge($class, $options);
        unset($options['class']);
        $class = $class['class'];
        return new $class($options);
    }
    elseif (is_object($class)) {
        return $class;
    }
    else {
        throw new \Exception("Invalid argument given: (" . gettype($class) . ")");
    }
}