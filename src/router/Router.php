<?php

namespace App\Router;

class Router
{
    private $url;
    private $routes = [];

    function __construct($url = null)
    {
        $this->url = $url;
        return $this;
    }

    function get($path, $callable)
    {
        $route = new Route($path, $callable);
        $this->routes['GET'][] = $route;
        return $route;
    }

    function post($path, $callable)
    {
        $route = new Route($path, $callable);
        $this->routes['POST'][] = $route;
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
}