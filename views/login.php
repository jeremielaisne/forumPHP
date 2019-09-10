<?php

require_once(dirname(__DIR__, 2) . "/jlf/vendor/autoload.php");
require_once(dirname(__DIR__, 2) . "/jlf/init.php");

$pm = new App\Cookie\PageMaker("Accueil", "Accueil - Forum");

if ($pm->getUsercookie()->getIsConnect() == true)
{
    header("location:" . URL_HOME);
    exit(0);
}

?>

<!DOCTYPE HTML>
<html>
    <head>
        <title><?php echo $pm->getTitle(); ?></title>
    </head>
    <body>
        <main>
            <p>Formulaire de connexion</p>
            <form id="form_login">
                <div class="form-group">
                    <label for="email_login">Email</label>
                    <input type="email" name="email_login" id="email_login" />
                </div>
                <div class="form-group">
                    <label for="mdp_login">Mot de passe</label>
                    <input type="mdp" name="mdp_login" id="mdp_login" />
                </div>
                <div class="form-group">
                    <button>Valider</button>
                </div>
            </form>
            <p><a href="signUp.php">S'enregistrer</a>
        </main>
    </body>
</html>