<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class EffectiveController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @IsGranted("ROLE_USER")
     */
    public function index()
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'EffectiveController',
        ]);
    }
}
