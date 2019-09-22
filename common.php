<?php

require_once(dirname(__DIR__) . "/jlf/vendor/autoload.php");

/* Instanciation de la connexion */
function getPDO()
{
    $db = null;
    try
    {
        $db = new PDO("mysql:host=localhost;dbname=" . BDD , USER, MDP);
        $db->exec("SET NAMES UTF8");
    }
    catch(PDOException $exep)
    {
        die($exep->getMessage());
    }
    return $db;
}

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