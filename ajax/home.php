<?php
    require_once(dirname(__DIR__ , 2) . "/vendor/autoload.php");
    require_once(dirname(__DIR__ , 2) . "/init.php");

    $tab_req = ["state" => false, "error"=> []];

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
        $tab_req = true;
    }

echo json_encode($tab_req);
?>