<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\AddTaskType;


class EffectiveController extends AbstractController
{

    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * @Route("/", name="homepage")
     * @IsGranted("ROLE_USER")
     * @param Task $task
     */
    public function index(TaskRepository $taskRepository, Request $request)
    {
        $user = $this->getUser();
        $tasks = $taskRepository->findByUser($user);
        
        $newTask = new Task();
        $newTask->setUser($user);
        $form = $this->createForm(AddTaskType::class, $newTask);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $this->om->persist($newTask);
            $this->om->flush();
            return $this->redirectToRoute('homepage');
        }

        return $this->render('index.html.twig', [
            'tasks' => $tasks, 
            'form' => $form->createView()
            
        ]);
    }

     /**
     * @Route("/{id}", name="task.delete", methods="DELETE")
     * @IsGranted("ROLE_USER")
     * @param Task $task
     */
    public function deleteAction(Task $task)
    {
        $this->om->remove($task);
        $this->om->flush();
       
        return $this->redirectToRoute('homepage');
    }
}
