<?php

use App\Cookie\UserCookie;

require_once(dirname(__DIR__) . "/jlf/vendor/autoload.php");
require_once(dirname(__DIR__) . "/jlf/init.php");

$cookie = UserCookie::erase();
header("Location: /login");