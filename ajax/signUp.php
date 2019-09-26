<?php
    require_once(dirname(__DIR__) ."/vendor/autoload.php");
    require_once(dirname(__DIR__) ."/common.php");

    use App\User;

    $tab_req = ["state"=> false, "error"=> [], "fatalError" => ""];

    $firstname = (string) getFormVal("firstname");
    $lastname = (string) getFormVal("lastname");
    $email = (string) getFormVal("email");

    if (empty($firstname))
    {
        $tab_req["error"]["lastname"] = "Il manque le nom";
    }

    if (empty($lastname))
    {
        $tab_req["error"]["firstname"] = "Il manque le prénom";
    }

    if (empty($email))
    {
        $tab_req["error"]["email"] = "Il manque l'email";
    }

    if (empty($tab_req["error"]))
    {
        $user = new User;
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        if ($user->verifyUniqueEmail($email))
        {
            $user->setEmail($email);
        }
        else
        {
            $tab_req["error"]["email"] = "Cette adresse email existe déjà en base de donnée";
        }

        if($user->create())
        {
            $tab_req["state"] = true;
        }
        else
        {
            $tab_req["fatalError"] = "Il y a une erreur de saisie";
        }
    }

echo json_encode($tab_req);
?>