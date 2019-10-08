<?php
    require_once(dirname(__DIR__) ."/vendor/autoload.php");
    require_once(dirname(__DIR__) ."/common.php");

    use App\Cookie\UserCookie;
    use App\User;

    $tab_req = ["state"=> false, "error"=> [], "ancre" => null, "fatalError" => ""];

    $nickname = (string) getFormVal("nickname");
    $firstname = (string) getFormVal("firstname");
    $lastname = (string) getFormVal("lastname");
    $email = (string) getFormVal("email");
    $avatar = (int) getFormVal("avatar");
    $token = (string) getFormVal("_csrf");

    if (empty($nickname))
    {
        $tab_req["error"]["nickname"] = "it's missing the nickname";
        $tab_req["ancre"] = "nickname_signup";
    }
    else if(strlen($nickname)>=15)
    {
        $tab_req["error"]["nickname"] = "Your nickname contains to many characters. Only 15 are allowed";
        $tab_req["ancre"] = "nickname_signup";
    }
    else if(strlen($nickname)<=3)
    {
        $tab_req["error"]["nickname"] = "Your nickname does not contains enough characters. 4 minimum";
        $tab_req["ancre"] = "nickname_signup";
    }
    else if (!User::verifyUniqueNickname($nickname))
    {
        $tab_req["error"]["nickname"] = "This nickname already exists in database";
        $tab_req["ancre"] = "nickname_signup";
    }

    if(strlen($firstname)>=50 && !empty($firstname))
    {
        $tab_req["error"]["firstname"] = "Your firstname contains to many characters. Only 50 are allowed";
        if (empty($tab_req["ancre"]))
        {
            $tab_req["ancre"] = "firstname_signup";
        }
    }
    else if(strlen($firstname)<=1 && !empty($firstname))
    {
        $tab_req["error"]["firstname"] = "Your firstname does not contains enough characters. 2 minimum";
        if (empty($tab_req["ancre"]))
        {
            $tab_req["ancre"] = "firstname_signup";
        }
    }

    if(strlen($lastname)>=50 && !empty($lastname))
    {
        $tab_req["error"]["lastname"] = "Your lastname contains to many characters. Only 50 are allowed";
        if (empty($tab_req["ancre"]))
        {
            $tab_req["ancre"] = "lastname_signup";
        }
    }
    else if(strlen($lastname)<=1 && !empty($lastname))
    {
        $tab_req["error"]["lastname"] = "Your lastname does not contains enough characters. 2 minimum";
        if (empty($tab_req["ancre"]))
        {
            $tab_req["ancre"] = "lastname_signup";
        }
    }

    if (empty($email))
    {
        $tab_req["error"]["email"] = "it's missing the mail";
        if (empty($tab_req["ancre"]))
        {
            $tab_req["ancre"] = "email_signup";
        }
    }
    else
    {
        if(!verifyEmail($email))
        {
            $tab_req["error"]["email"] = "Your email pattern is incorrect";
            if (!empty($tab_req["ancre"]))
            {
                $tab_req["ancre"] = "email_signup";
            }
        }
        else if (!User::verifyUniqueEmail($email))
        {
            $tab_req["error"]["email"] = "This email already exists in database";
            if (!empty($tab_req["ancre"]))
            {
                $tab_req["ancre"] = "email_signup";
            }
        }
    }

    if (empty($avatar))
    {
        $tab_req["error"]["avatar"] = "it's missing the avatar. Reload the page please";
        if (!empty($tab_req["ancre"]))
        {
            $tab_req["ancre"] = "avatar_signup";
        }
    }
    else
    {
        if ($avatar<0 || $avatar>24)
        {
            $tab_req["error"]["avatar"] = "Problems !!!. Reload the page please";
            if (!empty($tab_req["ancre"]))
            {
                $tab_req["ancre"] = "avatar_signup";
            }
        }
    }

    if (empty($tab_req["error"]))
    {
        $user = new User;
        $user->setNickname(escape($nickname));
        if (!empty($firstname))
        {
            $user->setFirstname(escape($firstname));
        }
        else
        {
            $user->setFirstname(null);
        }
        if (!empty($lastname))
        {
            $user->setLastname(escape($lastname));
        }
        else
        {
            $user->setLastname(null);
        }
        $user->setAvatar($avatar);
        $user->setEmail(escape($email));
        $user->setIp(getIp());
        
        if($user->create())
        {
            if (!isset($_SESSION))
            {
                session_start();
            }

            if (in_array($token, $_SESSION['csrf.tokens']))
            {
                UserCookie::create($user->getId());
                $tab_req["state"] = true;
            }
            else
            {
                $tab_req["fatalError"] = "You have a crsf error. Please contact the administrator";
            }
        }
        else
        {
            $tab_req["fatalError"] = "There is in an entry error";
        }
    }

echo json_encode($tab_req);
?>