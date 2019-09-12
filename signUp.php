<?php

require_once(dirname(__DIR__) . "/jlf/vendor/autoload.php");
require_once(dirname(__DIR__) . "/jlf/init.php");

$pm = new App\Cookie\PageMaker("Inscription, Inscription - Forum");

if ($pm->getUsercookie()->getIsConnect() === true)
{
    header("Location: /home");
    exit(0);
}

$pm->start();
?>
    <p>Inscription</p>
    <form id="form_signup">
        <div class="form-group">
            <label for="firstname_signup">Nom</label>
            <input type="text" name="firstname" id="firstname_signup" />
        </div>
        <div class="form-group">
            <label for="lastname_signup">Prénom</label>
            <input type="text" name="lastname" id="lastname_signup" />
        </div>
        <div class="form-group">
            <label for="email_signup">Email</label>
            <input type="email" name="email" id="email_signup" />
        </div>
        <div class="form-group">
            <label for="mdp_signup">Mot de passe</label>
            <input type="password" name="mdp" id="mdp_signup" />
        </div>
        <div class="form-group">
            <button>Valider</button>
        </div>
    </form>
    <p><a href="/login">Retour à l'accueil</a>
<?php
$pm->end();
?>