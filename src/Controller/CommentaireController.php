<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\LikeCommentaire;
use App\Repository\LikeCommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{
    /**
     * Permet de supprimer un commentaire
     * 
     * @Route("commentaire/{id}/delete", name="commentaire_delete")
     * 
     *
     * @param Commentaire $poste
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function delete(Commentaire $comment, EntityManagerInterface $manager)
    {
        $manager->remove($comment);
        $manager->flush();
        $this->addFlash(
            'success',
            "Le commentaire <strong>{$comment->getContenu()}</strong> a bien été supprimé !"
        );

        return $this->redirectToRoute("poste_show", ["id" => $comment->getPoste()->getId()]);
    }


    /**
     * Permet de liker ou unliker un commentaire
     *
     * @Route("commentaire/{id}/like", name="commentaire_like")
     * @param Commentaire $commentaire
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function like(Commentaire $commentaire, EntityManagerInterface $manager, LikeCommentaireRepository $repo)
    {
        $user = $this->getUser();
        if (!$user) return $this->json([
            'code' => 403,
            'message' => "Unauthorized"
        ], 403);
        if ($commentaire->isLikedByUser($user)) {
            $like = $repo->findOneBy([
                'commentaire' => $commentaire,
                'trotter' => $user
            ]);

            $manager->remove($like);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Unlike du commentaire',
                'likes' => $repo->count(['commentaire' => $commentaire])
            ], 200);
        }
        $like = new LikeCommentaire();

        $like->setCommentaire($commentaire)
            ->setTrotter($user);

        $manager->persist($like);
        $manager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Like du poste',
            'likes' => $repo->count(['commentaire' => $commentaire])
        ], 200);

        return $this->json(['code' => 200, 'message' => 'Ca marche bien'], 200);
    }
}
