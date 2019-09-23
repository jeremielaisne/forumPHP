<?php

namespace App\Router;

class Route
{
    private $path;
    private $callable;
    private $matches = [];

    function __construct($path = null, $callable = null)
    {
        $this->path = trim($path, "/"); //suppression du slash de l'url
        $this->callable = $callable;
        return $this;
    }

    function match($url)
    {
        $url = trim($url, "/");
        $path = preg_replace("#:([\w]+)#" , "([^/]+)", $this->path);
        $regex = "#^$path$#i";
        
        if (!preg_match($regex, $url, $matches))
        {
            return false;
        }

        array_shift($matches);
        $this->matches = $matches;
        
        return true;
    }

    function call()
    {
        return call_user_func_array($this->callable, $this->matches);
    }
}