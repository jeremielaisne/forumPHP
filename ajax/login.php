<?php
    require_once(dirname(__DIR__) ."/vendor/autoload.php");
    require_once(dirname(__DIR__) ."/common.php");

    use App\Cookie\UserCookie;
    use App\User;

    $tab_req = ["state" => false, "error" => [], "fatalError" => ""];

    $mdp = (string) getFormVal("login_mdp");

    if (empty($mdp))
    {
        $tab_req["error"]["mdp"] = "Vous devez saisir un mot de passe !";
    }

    if (empty($tab_req["error"]))
    {
        $id_user = User::isValidLogin($mdp);

        if ($id_user !== 0)
        {
            $user = new User;
            $user->setId($id_user);
            $user->load();

            $user->update();

            $user_cookie = UserCookie::create($id_user);
            
            $tab_req["state"] = true;
        }
        else
        {
            $tab_req["error"]["mdp"] = "Votre mot de passe est incorrect !";
        }
    }

echo json_encode($tab_req);
?>