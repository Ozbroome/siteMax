<?php
namespace BlogBundle\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\RequestStack;

class Recaptcha
{

    private $secret;
    protected $requestStack;

    public function __construct($secret, RequestStack $requestStack)
    {
        $this->secret = $secret;
        $this->requestStack = $requestStack;
    }

    public function verifCaptcha()
    {
        $request = $this->requestStack->getCurrentRequest();
        // Ma clé privée
        $secret = $this->secret;
        // Paramètre renvoyé par le recaptcha
        $response = $request->request->get('g-recaptcha-response');
        // On récupère l'IP de l'utilisateur
        $remoteip = $request->server->get('REMOTE_ADDR');

        $api_url = "https://www.google.com/recaptcha/api/siteverify?secret="
            . $secret
            . "&response=" . $response
            . "&remoteip=" . $remoteip ;

        $decode = json_decode(file_get_contents($api_url), true);

    return $decode;
    }
}