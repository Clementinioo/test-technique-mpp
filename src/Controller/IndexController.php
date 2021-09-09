<?php
// src/Controller/IndexController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{
    public function index(): Response
    {

        $token = $this->get('security.token_storage')->getToken();
        if ($token != NULL) {
            $user = $token->getUsername();
        } else {
            $user = "";
        }
        //var_dump($user);
        return $this->render('index/index.html.twig', [
            'username' => $user,
        ]);
    }
}
