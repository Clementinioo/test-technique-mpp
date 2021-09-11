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
     * @Route("/task/new")
     * 
     * Créer une tâche
     * 
     */


    public function createAction(Request $request)
    {
        $task = new Task();
        $form = $this->createFormBuilder($task)
            ->add('description', TextType::class)
            ->add('id_liste', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Valider'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            echo 'Tâche créé';
        }
        return $this->render('task/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/task/all")
     * 
     * Affiche toutes les tâches 
     * 
     */

    public function showAction()
    {
        $task = $this->getDoctrine()->getRepository(Task::class);
        $task = $task->findAll();
        return $this->render(
            'task/tasks.html.twig',
            array('task' => $task)
        );
    }

    /**
     * @Route("/my/tasks")
     * 
     * Affiche les tâches de l'utilisateur connecté
     */
    public function showOwnLists()
    {
        $repository = $this->getDoctrine()->getRepository(Task::class);
        $array = array();
        $task = $repository->findOwnTasks($this->getUser()->getUsername());
        if (!empty($task)) {
            return $this->render(
                'task/ownertasks.html.twig',
                array('task' => $task)
            );
        } else {
            return $this->render(
                'task/ownertasks.html.twig',
                array('task' => null)
            );
        }
    }

    /**
     * @Route("/task/delete/{id}" , name="task_delete")
     * 
     * Suppression d'une tâche 
     * 
     */

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $task = $this->getDoctrine()->getRepository(Task::class);
        $task = $task->find($id);
        if (!$task) {
            throw $this->createNotFoundException(
                'Il n\'y a pas de liste avec l\'id : ' . $id
            );
        }
        $em->remove($task);
        $em->flush();
        return $this->redirect($this->generateUrl('my_tasks'));
    }

    /**
     * @Route("/task/edit/{id}", name="task_edit")
     * 
     * Edition d'une tâche 
     * 
     */

    public function updateAction(Request $request, $id)
    {
        $task = $this->getDoctrine()->getRepository(Task::class);
        $task = $task->find($id);
        if (!$task) {
            throw $this->createNotFoundException(
                'Il n\'y a pas de liste avec l\'id : ' . $id
            );
        }
        $form = $this->createFormBuilder($task)
            ->add('description', TextType::class)
            ->add('id_liste', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Editer'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $task = $form->getData();
            $em->flush();
            return $this->redirect($this->generateUrl('my_tasks'));
        }
        return $this->render(
            'task/edit.html.twig',
            array('form' => $form->createView())
        );
    }
}
