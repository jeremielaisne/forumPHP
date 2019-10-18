<?php

namespace App\Router;

class Route
{
    private $path;
    private $callable;
    private $matches = [];
    private $params = [];

    function __construct($path = null, $callable = null)
    {
        $this->path = trim($path, "/"); //suppression du slash de l'url
        $this->callable = $callable;
        return $this;
    }

    function match($url)
    {
        $url = trim($url, "/");
        $path = preg_replace_callback("#:([\w]+)#" , [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";
        
        if (!preg_match($regex, $url, $matches))
        {
            return false;
        }

        array_shift($matches);
        $this->matches = $matches;
        
        return true;
    }

    public function with($param, $regex)
    {
        $this->params[$param] = str_replace('(', '(?', $regex);
        return $this;
    }

    private function paramMatch($match)
    {
        if (isset($this->params[$match[1]]))
        {
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    public function getUrl($params)
    {
        $path = $this->path;
        foreach($params as $k => $v)
        {
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }

    function call()
    {
        if (is_string($this->callable))
        {
            $params = explode("#", $this->callable);
            $controller = "App\Controller\\" . $params[0] . "Controller";
            $controller = new $controller();
            return call_user_func_array([$controller, $params[1]], $this->matches);
        }
        else
        {
            return call_user_func_array($this->callable, $this->matches);
        }
    }
}