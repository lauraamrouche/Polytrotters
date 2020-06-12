<?php

namespace App\Controller;

use App\Entity\Follower;
use App\Entity\User;
use App\Repository\FollowerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FollowerController extends AbstractController
{
    /**
     * @Route("/follower", name="follower")
     */
    public function index()
    {
        return $this->render('follower/index.html.twig', [
            'controller_name' => 'FollowerController',
        ]);
    }


    /**
     * Permet de follow ou unfollow un User
     *
     * @Route("follower/{id}", name="follow_user")
     * @param User $user
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function follow(User $followed, EntityManagerInterface $manager, FollowerRepository $repo)
    {
        $user = $this->getUser();
        if (!$user) return $this->json([
            'code' => 403,
            'message' => "Unauthorized"
        ], 403);
        if ($followed->isFollowedByUser($user)) {
            $follow = $repo->findOneBy([
                'followed' => $followed,
                'follower' => $user
            ]);

            $manager->remove($follow);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => "Unfollow de l'utilisateur",
                'followers' => $repo->count(['followed' => $followed])
            ], 200);
        }
        $follow = new Follower();

        $follow->setFollower($user)
            ->setFollowed($followed);

        $manager->persist($follow);
        $manager->flush();

        return $this->json([
            'code' => 200,
            'message' => "Follow de l'utilisateur",
            'followers' => $repo->count(['followed' => $followed])
        ], 200);

        return $this->json(['code' => 200, 'message' => 'Ca marche bien'], 200);
    }
}
