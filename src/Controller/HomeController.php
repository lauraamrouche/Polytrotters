<?php

namespace App\Controller;

use App\Entity\Poste;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Poste::class);

        $postes = $repo->findAll();
        return $this->render('home/index.html.twig', [
            'postes' => $postes
        ]);
    }
}
