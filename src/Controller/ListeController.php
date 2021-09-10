<?php

namespace App\Controller;

use App\Entity\Liste;
use App\Repository\ListeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ListeController extends AbstractController
{

    /**
     * @Route("/liste/new")
     */


    public function createAction(Request $request)
    {
        $liste = new Liste();
        $form = $this->createFormBuilder($liste)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Valider'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $liste = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $liste->setOwner($this->getUser()->getUsername());
            $em->persist($liste);
            $em->flush();
            echo 'Liste créé';
        }
        return $this->render('liste/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/liste/all")
     */
    public function showAction()
    {
        $liste = $this->getDoctrine()->getRepository(Liste::class);
        $liste = $liste->findAll();
        return $this->render(
            'liste/list.html.twig',
            array('liste' => $liste)
        );
    }

    /**
     * @Route("/my/lists")
     */
    public function showOwnLists()
    {
        $repository = $this->getDoctrine()->getRepository(Liste::class);
        $array = array();
        $liste = $repository->testFunction($this->getUser()->getUsername());
        array_push($array, $liste);
        return $this->render(
            'liste/ownerlists.html.twig',
            array('liste' => $array)
        );
    }
}
