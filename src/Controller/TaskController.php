<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tasks', name: 'task_')]
class TaskController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'list')]
    public function listAction(): Response
    {
        // $now = new DateTime();

        // return $this->render('task/list.html.twig', ['tasks' => $this->entityManager->getRepository(Task::class)->findActiveTasks($now)]);
        return $this->render('task/list.html.twig', ['tasks' => $this->entityManager->getRepository(Task::class)->findAll()]);
    }

    #[Route('/create', name: 'create')]
    public function createAction(Request $request): Response
    {
        $task = new Task();

        $user = $this->getUser();
        $task->setUser($user);
        
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($task);
            $this->entityManager->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function editAction(Task $task, Request $request): Response
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    #[Route('/{id}/toggle', name: 'toggle')]
    public function toggleTaskAction(Task $task): Response
    {
        $task->toggle(!$task->isDone());
        $this->entityManager->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    #[Route('/{id}/delete', name: 'delete')]
    public function deleteTaskAction(Task $task): Response
    {
        $this->entityManager->remove($task);
        $this->entityManager->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }

    #[Route('/completed', name: 'list_completed')]
    public function getValidatedTask(): Response
    {
        return $this->render('task/list.html.twig', ['tasks' => $this->entityManager->getRepository(Task::class)->findBy(['isDone'=>true])]);
    }

    #[Route('/expired', name: 'list_expired')]
    public function listExpiredTask(): Response
    {
        $now = new DateTime();

        return $this->render('task/list.html.twig', ['tasks' => $this->entityManager->getRepository(Task::class)->findExpiredTasks($now)]);
    }
}
