<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Photo;
use App\Entity\Poste;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {

        gc_collect_cycles();

        $faker = Factory::create("FR-fr");
        $genres = ["men", "women"];
        $users = [];
        // Nouveaux Users
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $genre = $genres[mt_rand(0, 1)];
            $nb = $faker->numberBetween(1, 99);
            $picture = "https://randomuser.me/api/portraits/$genre/$nb.jpg";

            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setPseudo($faker->firstName())
                ->setNom($faker->firstName())
                ->setEmail($faker->email())
                ->setAvatarUser($picture)
                ->setPasswd($hash)
                ->setDescriptionUser($faker->sentence());

            $manager->persist($user);
            $users[] = $user;
        }

        for ($i = 0; $i < 5; $i++) {
            $poste = new Poste();
            $description = $faker->sentence();
            $date = $faker->dateTimeThisYear('now', 'Europe/Paris');
            $ville = $faker->city();
            $titre = $faker->sentence();
            $trotter = $users[mt_rand(0, count($users) - 1)];

            $poste->setTitre($titre)
                ->setDescription($description)
                ->setDatePoste($date)
                ->setVille($ville)
                ->setTrotter($trotter);
            $manager->persist($poste);

            for ($i = 0; $i < mt_rand(1, 4); $i++) {

                $photo = new Photo();

                $photo->setNom($faker->sentence())
                    ->setPoste($poste)
                    ->setUrlPhoto($faker->imageUrl($width = 640, $height = 480))
                    ->setDescriptionPhoto($faker->sentence());
                $manager->persist($photo);
            }
        }


        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
