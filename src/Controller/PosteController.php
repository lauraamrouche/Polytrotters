<?php

namespace App\Controller;

use App\Entity\Poste;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PosteController extends AbstractController
{
    /**
     * @Route("/poste/", name="poste")
     */
    public function index()
    {
        return $this->render('poste/index.html.twig', [
            'controller_name' => 'PosteController',
        ]);
    }

    /**
     * Affiche un poste avec ses photos, commentaires...
     * 
     * @Route("/poste/{id}", name="poste_show")
     * @return Response
     */
    public function show($id){

        $poste = new Poste();
        $repo = $this->getDoctrine()->getRepository(Poste::class);
        $poste = $repo->find($id);

        return $this->render('poste/show.html.twig', [
            'poste' => $poste
        ]);

    }
    
}
