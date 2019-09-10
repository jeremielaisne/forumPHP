<?php

namespace App\Router;

use Exception;

class RouteException extends Exception
{
    private $msg;

    function __construct($msg = null)
    {
        $this->msg = $msg;
        if (preg_match("#^Error404#", $msg))
        {
            self::redirect404();
        }
        return $this;
    }

    function __toString()
    {
        return $this->msg;
    }

    function redirect404()
    {
        header("Location: 404.php");
        exit;
    }
}