<?php

require_once(__DIR__ . "/vendor/autoload.php");

define("COOKIE_NAME", "DurararaForum");

/* Usage de variables $GET et $POST */
function getURL($full = false)
{
    $val = null;
    if ($full == true)
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === "on")
        {
            $val .= "https://";
        }
        else
        {
            $val .= "http://";
        }
        $val .= $_SERVER['HTTP_HOST'];
    }
    else
    {
        $val .= $_SERVER['REQUEST_URI'];
    }
    return $val;
}
function getFormVal($name, $meth = null)
{
    $val = NULL;
    if (is_null($meth) || $meth === 'get')
    {
        if (isset($_GET[$name]))
        {
            $val = unescapeFormVal($_GET[$name]);
        }
    }
    if (is_null($val) && (is_null($meth) || $meth === 'post'))
    {
        if (isset($_POST[$name]))
        {
            $val = unescapeFormVal($_POST[$name]);
        }
    }
    return $val;
}
function unescapeFormVal($val)
{
    // SI les caracteres d'une chaine sont "echappées", on supprime les antislash d'une chaine de caractères
    if (get_magic_quotes_gpc())
    {
        if (is_array($val))
        {
            return array_map('stripslashes', $val);
        }
        else
        {
            return stripslashes($val);
        }
    }
    else
    {
        return $val;
    }
}
function escape($val)
{
    return htmlspecialchars($val, ENT_QUOTES);
}
function verifyEmail($email)
{
    $pattern = "#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#";
    if (preg_match($pattern, $email))
    {
        return true;
    }
    return false;
}