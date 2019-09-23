<?php
    require_once(dirname(__DIR__) ."/vendor/autoload.php");
    require_once(dirname(__DIR__) ."/common.php");

    use App\Cookie\UserCookie;
    use App\User;

    $tab_req = ["state" => false, "error"=> ""];

    $email = (string) getFormVal("email_login");
    $mdp = (string) getFormVal("mdp_login");

    if (empty($email))
    {
        $tab_req["error"] = "Vous devez saisir une adresse email";
    }

    if (empty($mdp))
    {
        $tab_req["error"] = "Vous devez saisir un mot de passe";
    }

    if (empty($tab_req["error"]))
    {
        $id_user = User::isValidLogin($email, $mdp);

        if ($id_user !== null)
        {
            $user = new User;
            $user->setId($id_user);
            $user->load();

            $user->update();

            $user_cookie = UserCookie::create($id_user);
            
            $tab_req["state"] = true;
        }
    }

echo json_encode($tab_req);
?>