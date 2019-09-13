<?php
    
use App\Cookie\PageMaker;
use App\User;

require_once(dirname(__DIR__) . "/jlf/vendor/autoload.php");
require_once(dirname(__DIR__) . "/jlf/init.php");

$pm = new PageMaker("Home - Dollars Forum", "Accueil du forum dollars durarara!");
$pm->start();

$user = new User();
$user->setId($pm->getUsercookie()->getUser()->getId());
$user->load();

?>
<p><?php echo $user->getFirstname() . " " . $user->getLastname(); ?></p>
<p>Dernière connexion : </p>
<p>Votre cookie : <?php echo $_COOKIE['testForumCookie']; ?></p>
<br/>
<a href="/logout">Se déconnecté</a>
<?php
$pm->end();
?>