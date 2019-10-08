<?php
    require_once(dirname(__DIR__) ."/vendor/autoload.php");
    require_once(dirname(__DIR__) ."/common.php");

    use App\Cookie\UserCookie;
    use App\User;

    $tab_req = ["state" => false, "error" => [], "fatalError" => ""];

    $mdp = (string) getFormVal("login_mdp");
    $token = (string) getFormVal("_csrf");

    if (empty($mdp))
    {
        $tab_req["error"]["mdp"] = "You must enter a password !";
    }

    if (empty($tab_req["error"]))
    {
        $id_user = User::isValidLogin($mdp);

        if ($id_user !== 0)
        {
            $user = new User;
            $user->setId($id_user);
            $user->load();

            $user->setIp(getIp());

            if (!isset($_SESSION))
            {
                session_start();
            }

            if (in_array($token, $_SESSION['csrf.tokens']))
            {
                $user->update();

                $user_cookie = UserCookie::create($id_user);
                
                $tab_req["state"] = true;
            }
            else
            {
                $tab_req["fatalError"] = "You have a crsf error. Please contact the administrator";
            }
        }
        else
        {
            $tab_req["error"]["mdp"] = "You password is incorrect !";
        }
    }

echo json_encode($tab_req);
?>