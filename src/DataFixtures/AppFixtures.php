<?php

namespace App\DataFixtures;

use App\Entity\Poste;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create("FR-fr");

        for ($i = 0; $i < 100; $i++) {
            $poste = new Poste();
            $image = $faker->imageUrl($width = 640, $height = 480);
            $trotter = $faker->firstName();
            $description = $faker->sentence();
            $date = $faker->dateTimeThisYear('now', 'Europe/Paris');
            $adresse = $faker->city();
            $titre = $faker->sentence();
            $slugify = new Slugify();
            $url = $slugify->slugify($titre);
            $poste->setImage($image)
                ->setTrotter($trotter)
                ->setDescriptionImage($description)
                ->setDatePoste($date)
                ->setAdresse($adresse)
                ->setTitrePoste($titre)
                ->setUrlPoste($url);
            $manager->persist($poste);
        }


        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
