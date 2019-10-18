<?php

namespace App\Router;

use Exception;

class Router
{
    private $url;
    private $routes = [];
    private $namedRoutes = [];

    function __construct($url = null)
    {
        $this->url = $url;
        return $this;
    }

    function get($path, $callable, $name = null)
    {
        return $this->add($path, $callable, $name, 'GET');
    }

    function post($path, $callable, $name = null)
    {
        return $this->add($path, $callable, $name, 'POST');
    }

    function add($path, $callable, $name, $method)
    {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if (is_string($callable) && $name === null)
        {
            $name = $callable;
        }
        if ($name)
        {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    function run()
    {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']]))
        {
            throw new RouteException('Problème de méthode du routeur');
        }
        else
        {
            foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route)
            {
                if ($route->match($this->url))
                {
                    return $route->call();
                }
            }
        }
        try
        {
            throw new RouteException("Error404");
        }
        catch(RouteException $r)
        {   
            echo $r;
        }
    }

    function url($name, $params = [])
    {
        if(!isset($this->namedRoutes[$name])){
            throw new RouteException("No route matches this name");
        }
        return $this->namedRoutes[$name]->getUrl($params);
    }
}