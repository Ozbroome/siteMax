<?php
namespace BlogBundle\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

class Recaptcha
{

    private $secret;

    public function __construct($secret)
    {
        $this->secret = $secret;
    }

    public function verifCaptcha()
    {
        // Ma clé privée
        $secret = $this->secret;
        // Paramètre renvoyé par le recaptcha
        $response = $_POST['g-recaptcha-response'];
        // On récupère l'IP de l'utilisateur
        $remoteip = $_SERVER['REMOTE_ADDR'];

        $api_url = "https://www.google.com/recaptcha/api/siteverify?secret="
            . $secret
            . "&response=" . $response
            . "&remoteip=" . $remoteip ;

        $decode = json_decode(file_get_contents($api_url), true);

    return $decode;
    }
}