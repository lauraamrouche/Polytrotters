<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\LikePoste;
use App\Entity\Photo;
use App\Entity\Poste;
use App\Entity\User;
use App\Form\CommentaireType;
use App\Form\PosteType;
use App\Repository\LikePosteRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/poste/{id}", name="poste_show", requirements={"id"="\d+"})
     * 
     * @param Request $request
     * @param EnEntityManagerInterface $manager
     * 
     * @return Response
     */
    public function show($id, Request $request, EntityManagerInterface $manager)
    {

        $comment = new Commentaire();

        $form = $this->createForm(CommentaireType::class, $comment);
        $form->handleRequest($request);


        $poste = new Poste();
        $repo = $this->getDoctrine()->getRepository(Poste::class);
        $poste = $repo->find($id);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setPoste($poste)
                ->setAuteur($this->getUser());
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre commentaire a bien été ajouté"
            );

            return $this->redirectToRoute("poste_show", ["id" => $id]);
        }


        return $this->render('poste/show.html.twig', [
            'poste' => $poste,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de créer un poste
     * 
     * @Route("/poste/new", name="creer_poste")
     *
     * @return Response
     */
    public function createPoste(Request $request, EntityManagerInterface $manager)
    {
        $poste = new Poste();

        $form = $this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);


        if ($form->isSubmitted()) {

            foreach ($poste->getPhotos() as $photo) {
                $photo->setPoste($poste);
                $manager->persist($photo);
            }

            $poste->setDatePoste(new DateTime())
                ->setTrotter($this->get('security.token_storage')->getToken()->getUser());

            $manager->persist($poste);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre poste a bien été créé !"
            );
        }
        return $this->render('poste/creer.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer une annonce
     * 
     * @Route("poste/{id}/delete", name="poste_delete")
     * 
     *
     * @param Poste $poste
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function delete(Poste $poste, EntityManagerInterface $manager)
    {
        $manager->remove($poste);
        $manager->flush();
        $this->addFlash(
            'success',
            "L'annonce <strong>{$poste->getTitre()}</strong> a bien été supprimé !"
        );

        return $this->redirectToRoute("home");
    }

    /**
     * Permet de liker ou unliker un poste
     *
     * @Route("poste/{id}/like", name="poste_like")
     * @param Poste $poste
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function like(Poste $poste, EntityManagerInterface $manager, LikePosteRepository $repo)
    {
        $user = $this->getUser();
        if (!$user) return $this->json([
            'code' => 403,
            'message' => "Unauthorized"
        ], 403);
        if ($poste->isLikedByUser($user)) {
            $like = $repo->findOneBy([
                'poste' => $poste,
                'trotter' => $user
            ]);

            $manager->remove($like);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Unlike du poste',
                'likes' => $repo->count(['poste' => $poste])
            ], 200);
        }
        $like = new LikePoste();

        $like->setPoste($poste)
            ->setTrotter($user);

        $manager->persist($like);
        $manager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Like du poste',
            'likes' => $repo->count(['poste' => $poste])
        ], 200);

        return $this->json(['code' => 200, 'message' => 'Ca marche bien'], 200);
    }
}
