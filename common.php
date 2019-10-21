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
function getIp()
{
    return $_SERVER['REMOTE_ADDR'] . " : Port : " . $_SERVER['REMOTE_PORT'];
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
function textDatetime($dt)
{
    $now = time();
    $timestamp = strtotime($dt);
    $diff = abs($now - $timestamp); //abs pour une valeur positive > 0
    $yearstamp = 60*60*24*365;
    $monthstamp = $yearstamp/30;
    $daystamp = $yearstamp/365;
    $hourstamp = $daystamp/24;
    $minutestamp = $hourstamp/60;
    $secondstamp = $minutestamp/60;

    $res = "NULL";
    
    switch($diff){
        case $diff < $minutestamp:
            $second = floor($diff/$secondstamp);
            if ($second == 1)
            {
                $res = "a second ago";
            }
            else
            {
                $res = $second . " seconds ago";
            }
            break;
        case ($diff >= $minutestamp) && ($diff < $hourstamp):
            $minute = floor($diff/$minutestamp);
            if ($minute == 1)
            {
                $res = "a minute ago";
            }
            else
            {
                $res = $minute . " minutes ago";
            }
            break;
        case ($diff >= $hourstamp) && ($diff < $daystamp):
            $hour = floor($diff/$hourstamp);
            if ($hour == 1)
            {
                $res = "a day ago";
            }
            else
            {
                $res = $hour . " days ago";
            }
            break;
        case ($diff >= $daystamp) && ($diff < $monthstamp):
            $day = floor($diff/$daystamp);
            if ($day == 1)
            {
                $res = "a day ago";
            }
            else
            {
                $res = $day . " days ago";
            }
            break;
        case ($diff >= $monthstamp) && ($diff < $yearstamp):
            $month = floor($diff/$monthstamp);
            if ($month == 1)
            {
                $res = "a month ago";
            }
            else
            {
                $res = $month . " months ago";
            }
            break;
        case $diff >= $yearstamp:
            $years = floor($diff/$yearstamp);
            if ($years == 1)
            {
                $res = "a year ago";
            }
            else
            {
                $res = $years . " years ago";
            }
            break;
    };
    return $res;
}