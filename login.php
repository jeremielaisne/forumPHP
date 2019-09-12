<?php

require_once(dirname(__DIR__) . "/jlf/vendor/autoload.php");
require_once(dirname(__DIR__) . "/jlf/init.php");

use App\Cookie\PageMaker;

$pm = new PageMaker("Accueil", "Accueil - Forum");

if ($pm->getUsercookie()->getIsConnect() == true)
{
    header("location: /home");
    exit(0);
}
$pm->start();
?>
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
<?php
$pm->end();
?>