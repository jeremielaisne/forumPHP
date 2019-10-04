<?php

namespace App\Mailer;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once(dirname(__DIR__, 2) . "/common.php");
require_once(__DIR__ . "/init.php");

class Mailling {

    private $obj_user;
    private $from;
    private $reply_to;
    private $title;
    private $content;
    private $bbc;

    public function __construct($obj_user = [], $from = ["mail" => ADMIN_MAILER, "name" => FROM_NAME_MAILER], $reply_to = null, $title = null, $content = null, $bbc = null)
    {
        $this->obj_user = $obj_user;
        $this->from = $from;
        $this->reply_to = $reply_to;
        $this->title = $title;
        $this->content = $content;
        $this->bbc = $bbc;
        return true;
    }

    /***
     * Getter et Setter
     */
    public function getUser($user) : array
    {
        return $this->obj_user[$user];
    }

    public function addUser($key, $user) : void
    {
        $this->obj_user[$key] = $user;
    }

    public function getFrom($val) : string
    {
        return $this->from[$val];
    }

    public function getReply() : ?string
    {
        return $this->reply_to;
    }
    public function setReply($reply_to) : void
    {
        $this->reply_to = $reply_to;
    }

    public function getTitle() : ?string
    {
        return $this->title;
    }
    public function setTitle($title) : void
    {
        $this->title = $title;
    }

    public function getContent() : ?string
    {
        return $this->content;
    }
    public function setContent($content) : void
    {
        $this->content = $content;
    }

    public function getBBC() : ?string
    {
        return $this->bbc;
    }
    public function setBBC($bbc) : void
    {
        $this->bbc = $bbc;
    }

    public function send() 
    {
        /* Envoi du mail à l'administrateur */
        $tab_admin = array(
            "name" => LASTNAME_MAILER,
            "first_name" => FIRSTNAME_MAILER,
            "mail" => ADMIN_MAILER
        );
        $this->obj_user["Admin"] = $tab_admin;

        /* Si envoie mail à plusieurs utilisateurs, la boucle parcours cette liste et envoi à chacun*/
        foreach ($this->obj_user as $user)
        {
            $content = "Titre  : " . $this->getTitle(). "  ::: Contenu : " . $this->getContent();

            $mail = new PHPMailer(true);
            try
            {
                $mail->isSMTP(true);
                $mail->Debugoutput = "html";
                $mail->SMTPAuth = true;
                $mail->Host = HOST_MAILER;
                $mail->Username = USERNAME_MAILER;
                $mail->Password = PASSWORD_MAILER;
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->SMTPSecure = "ssl";
                $mail->Port = PORT_MAILER;

                $mail->CharSet = PHPMailer::CHARSET_UTF8;
                $mail->Encoding = PHPMailer::ENCODING_BASE64;

                $mail->setFrom($this->getFrom("mail"), $this->getFrom("name"));
                $mail->addAddress($user["mail"], $user["name"] . $user["first_name"]);
                if (!empty($this->reply_to))
                {
                    $mail->addReplyTo($this->getReply());
                }

                if (!empty($this->bbc))
                {
                    $mail->addBCC($this->getBBC());
                }

                $mail->isHTML(true);
                $mail->Subject = '[Durarara Forum !] '. $this->title;
                $mail->Body = $content;
                $mail->AltBody = "test";

                $mail->send();
            }
            catch(Exception $e)
            {
                echo "Erreur : {$mail->ErrorInfo}" .  $e->getMessage() . "\n";
                return false;
            }
        }
        return true;
    }

    protected function edebug($msg) {
        print('Erreur Mailer');
        print('Description:');
        printf('%s', $msg);
        exit;
    }
}