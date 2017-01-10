<?php
namespace phpooya\server\core;

class Route extends Object
{
    public $rules = [];
    
    public $route;

    public $defaultDocuments = ['index.php', 'index.html', 'index.htm'];
    
    public function route()
    {
        foreach($this->rules as $pattern => $path) {
            if(preg_match($pattern, $this->server->request->getUri())) {
                $this->route = $this->directRoute($path);
                break;
            }
        }
        
        if(!$this->route) {
            $this->route = $this->directRoute($this->server->request->getUri());
        }
        
        return $this->route;
    }
    
    public function directRoute($path)
    {
        $req = $this->server->request;
        $file = $req->getDocumentRoot() . $path;
        
        if(is_file($file)) {
            return $file;
        }
        elseif (is_dir($file)) {
            foreach($this->defaultDocuments as $document) {
                $tmp = $file . DIRECTORY_SEPARATOR . $document;
                if(is_file($tmp)) {
                    return $tmp;
                }
            }
        }
        
        return null;
    }
}