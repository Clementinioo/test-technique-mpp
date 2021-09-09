<?php
// src/Controller/IndexController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{
    public function index(): Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        return $this->render('index/index.html.twig', [
            'username' => $user->getUsername(),
        ]);
    }
}
