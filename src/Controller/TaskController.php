<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Liste;
use App\Repository\ListeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class TaskController extends AbstractController
{

    /**
     * @Route("/liste/new")
     */


    public function createAction(Request $request)
    {
        $task = new Task();
        $form = $this->createFormBuilder($task)
            ->add('description', TextType::class)
            ->add('id_liste', EntityType::class, [
                'class' => Liste::class,
                'query_builder' => function (ListeRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.owner = :val')
                        ->setParameter('val', $this->getUser()->getUsername())
                        ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name',
            ])
            ->add('save', SubmitType::class, ['label' => 'Valider'])
            ->getForm();

        dump($form->handleRequest($request));
        die;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $task->setOwner($this->getUser()->getUsername());
            $em->persist($task);
            $em->flush();
            echo 'Tâche créé';
        }
        return $this->render('task/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
