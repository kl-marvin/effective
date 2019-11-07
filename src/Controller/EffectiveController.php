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
use App\Entity\Distraction;
use App\Repository\DistractionRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\AddTaskType;
use App\Form\AddDistractionType;


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
     * @Route("/test", name="test")
     * @IsGranted("ROLE_USER")
     */
    public function test(){
        return $this->render('test.html.twig');
    }

    /**
     * @Route("/", name="homepage")
     * @IsGranted("ROLE_USER")
     * @param Task $task
     * @param Distraction $distraction
     */
    public function index(TaskRepository $taskRepository, DistractionRepository $distractionRepository, Request $request)
    {
        $user = $this->getUser();
        $tasks = $taskRepository->findByUser($user);
        $distractions = $distractionRepository->findByUser($user);
        
        $newTask = new Task();
        $newTask->setUser($user);
        $form = $this->createForm(AddTaskType::class, $newTask);
        $form->handleRequest($request);

        $newDistraction = new Distraction();
        $newDistraction->setUser($user);
        $form2 = $this->createForm(AddDistractionType::class, $newDistraction);
        $form2->handleRequest($request);

        if($form2->isSubmitted() && $form2->isValid() ){
            $this->om->persist($newDistraction);
            $this->om->flush();
            return $this->redirectToRoute('homepage');
        }

        if($form->isSubmitted() && $form->isValid() ){
            $this->om->persist($newTask);
            $this->om->flush();
            return $this->redirectToRoute('homepage');
        }

        return $this->render('index.html.twig', [
            'user'  => $user,
            'tasks' => $tasks, 
            'distractions' => $distractions,
            'form' => $form->createView(),
            'form2' => $form2->createView()
            
        ]);
    }

    /**
     * @Route("/distraction/{id}", name="distraction.delete", methods="DELETE")
     * @IsGranted("ROLE_USER")
     */
    public function deleteDistraction(Distraction $distraction)
    {
        $this->om->remove($distraction);
        $this->om->flush();
        return $this->redirectToRoute('homepage');
    }

     /**
     * @Route("/task/{id}", name="task.delete", methods="DELETE")
     * @IsGranted("ROLE_USER")
     */
    public function deleteTask(Task $task)
    {
        $this->om->remove($task);
        $this->om->flush();
        return $this->redirectToRoute('homepage');
    }


     
}
