<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use APP\Entity\Character;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
        
            $character = new Character();

            // Génération de données aléatoires avec Faker
            // On utilise $faker->unique() pour garantir un nom unique.
            $character->setName($faker->unique()->firstName . ' ' . $faker->lastName);
            $character->setTitle($faker->jobTitle);

            // Pour une image, utilisez un placeholder ou une valeur aléatoire dans une liste prédéfinie
            //$imageOptions = ['warrior.png', 'mage.png', 'rogue.png', 'cleric.png'];
            //$character->setImg($imageOptions[array_rand($imageOptions)]);

            // Niveaux aléatoires entre 1 et 20
            $level = $faker->numberBetween(1, 50);
            $character->setLevel($level);

            // XP
            $character->setXpCurrent($faker->numberBetween(0, $level * 100));

            // XP MJ
            $character->setXpCurrentMj($faker->numberBetween(0, 500));

            // GP
            $character->setGP($faker->numberBetween(10, 5000));

            // PR
            $character->setPR($faker->numberBetween(0, 100) < 5 ? $faker->numberBetween(100, 500) : $faker->numberBetween(0, 99));

            // Fin d'activité, entre 0 et 30 jours.
            $character->setEndActivity($faker->numberBetween(0, 30));

            $manager->persist($character);

        }

        $manager->flush();
    }
}
