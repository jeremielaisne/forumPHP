<?php
    require_once(dirname(__DIR__, 2) . "/jlf/vendor/autoload.php");
    require_once(dirname(__DIR__, 2) . "/jlf/init.php");

    use App\User;

    $tab_req = ["state"=> false, "error"=> ""];

    $firstname = (string) getFormVal("firstname");
    $lastname = (string) getFormVal("lastname");
    $email = (string) getFormVal("email");
    $mdp = (string) getFormVal("mdp");

    if (empty($firstname))
    {
        $tab_req["error"] = "Il manque le nom";
    }

    if (empty($lastname))
    {
        $tab_req["error"] = "Il manque le prénom";
    }

    if (empty($email))
    {
        $tab_req["error"] = "Il manque l'email";
    }

    if (empty($mdp))
    {
        $tab_req["error"] = "Il manque le mot de passe";
    }

    if (empty($tab_req["error"]))
    {
        $user = new User;
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setEmail($email);
        $user->setMdp($mdp);

        if($user->create())
        {
            $tab_req["state"] = true;
        }
        else
        {
            $tab_req["error"] = "Il y a une erreur de saisie";
        }
    }

echo json_encode($tab_req);
?>