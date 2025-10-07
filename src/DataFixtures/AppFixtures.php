<?php

namespace App\DataFixtures;

use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use APP\Entity\Character;
use APP\Entity\User;
use APP\Entity\BuildingBase;
use Faker\Generator;

class AppFixtures extends Fixture
{

    private Generator $faker;
    private ObjectManager $manager;

    public function load(ObjectManager $manager): void
    {       
        $this->faker = \Faker\Factory::create('fr_FR'); 
        $this->manager = $manager;
        
        $this->createCharacters(50);
        $this->createUsers(50);
        $this->createBuildingBases();
        $this->createLocation(10);

        $this->manager->flush();
    }

    private function createCharacters(int $nbCharacter): void {
        for ($i = 0; $i < $nbCharacter; $i++) {
        
            $character = new Character();

            // Génération de données aléatoires avec Faker
            // On utilise $this->fake->unique() pour garantir un nom unique.
            $character->setName($this->faker->unique()->firstName . ' ' . $this->faker->lastName);
            $character->setTitle($this->faker->jobTitle);

            // Pour une image, utilisez un placeholder ou une valeur aléatoire dans une liste prédéfinie
            //$imageOptions = ['warrior.png', 'mage.png', 'rogue.png', 'cleric.png'];
            //$character->setImg($imageOptions[array_rand($imageOptions)]);

            // Niveaux aléatoires entre 1 et 20
            $level = $this->faker->numberBetween(1, 50);
            $character->setLevel($level);

            // XP
            $character->setXpCurrent($this->faker->numberBetween(0, $level * 100));

            // XP MJ
            $character->setXpCurrentMj($this->faker->numberBetween(0, 500));

            // GP
            $character->setGP($this->faker->numberBetween(10, 5000));

            // PR
            $character->setPR($this->faker->numberBetween(0, 100) < 5 ? $this->faker->numberBetween(100, 500) : $this->faker->numberBetween(0, 99));

            // Fin d'activité, entre 0 et 30 jours.
            $character->setEndActivity($this->faker->numberBetween(0, 30));

            $this->manager->persist($character);

        }
    }

    private function createUsers(int $nbUser): void {
        for ($i = 0; $i < $nbUser; $i++) {
        
            $user = new User();

            // Génération de données aléatoires avec Faker
            // On utilise $this->fake->unique() pour garantir un nom unique.
            $user->setUsername($this->faker->unique()->firstName . ' ' . $this->faker->lastName);
            $user->setRole($this->faker->jobTitle);

            // Pour une image, utilisez un placeholder ou une valeur aléatoire dans une liste prédéfinie
            //$imageOptions = ['warrior.png', 'mage.png', 'rogue.png', 'cleric.png'];
            //$character->setImg($imageOptions[array_rand($imageOptions)]);

            // Niveaux aléatoires entre 1 et 20
            $level = $this->faker->numberBetween(1, 50);
            $user->setNbCharacter($level);

            $this->manager->persist($user);

        }
    }

     private function createBuildingBases(): void {
        
        
        $building = new BuildingBase(	"Bicoque"	                , "Habitation"	, 1125	, 100	, ""	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Maison"	                , "Habitation"	, 4875	, 350	, ""	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Manoir"	                , "Habitation"	, 13450	, 850	, ""	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Château"	                , "Habitation"	, 29450	, 1650	, ""	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Echoppe"	                , "Commerce"	    , 1125	, null	, "Vous permez de vendre des objets"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Boutique"	            , "Commerce"	    , 4875	, null	, "Gagner 10% du prix en RP à chaque vente"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Comptoire"	            , "Commerce"	    , 13450	, null	, "Gagner 20% du prix en RP à chaque vente"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Paddock"	                , "Elevage"	    , 1125	, null	, "Vous permez de vendre et d'entrainer des animaux (MAX 5 DV): +1 Dressage"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Corral"	                , "Elevage"	    , 4875	, null	, "Vous permez de vendre tous les animaux : +2 Dressage, Vos couts de résurection d'animaux coutent 25% PR de moins"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Ranch"	                , "Elevage"	    , 16875	, null	, "Vos couts de résurection d'animaux coutent 50% PR de moins : +3 Dressage"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Etable"        	        , "Tanière"	    , 1125	, null	, "1 taille G, vous pouvez êtes considéré ayant les capacités de de recyclage pour tous les équipements d'animaux"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Ecurie"	                , "Tanière"	    , 2500	, null	, "2 taille G, moins 10% PR pour accéder à des équipement pour animaux"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Hara"	                , "Tanière"	    , 4475	, null	, "4 taille G, moins 20% PR pour accéder à des équipement pour animaux"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Confrerie"	            , "Communautaire" , 3375	, 350	, "Un seul chef, min 9 niv dans la guilde"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Guilde"	                , "Communautaire" , 14625	, 1475	, "Un seul chef, min 18 niv dans la guilde"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Ordre"	                , "Communautaire" , 40350	, 4050	, "Un seul chef, min 27 niv dans la guilde"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Atelier"	                , "Artisan"	    , 1125	, null	, "Bonus de 2 à un jet de profession"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Manufacture"	            , "Artisan"	    , 4875	, null	, "Bonus de 4 à un jet de profession"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Usine"	                , "Artisan"	    , 13450	, null	, "Bonus de 6 à un jet de profession"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Sampan"	                , "Navire"	    , 1125	, null	, "Moins 10% PR pour accéder à des équipement indisponible"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Sengokubune"	            , "Navire"	    , 6850	, null	, "Moins 20% PR pour accéder à des équipement indisponible"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Jonque"	                , "Navire"	    , 18850	, null	, "Moins 30% PR pour accéder à des équipement indisponible"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Site de bucheronnage"    , "Construction"	, 1125	, null	, "Moins 10% PR pour construire un bâtiment"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Scierie"	                , "Construction"	, 4875	, null	, "Moins 20% PR pour construire un bâtiment"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Taille de pierre"	    , "Construction"	, 13450	, null	, "Moins 30% PR pour construire un bâtiment"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Autel"	                , "Religieux"	    , 1125	, null	, "Vous pouvez être un représentant connu de votre église, -10% PR pour accéder à des équipement (les potions et parchemin divins seulement)"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Eglise"	                , "Religieux"	    , 4875	, null	, "Vous êtes considéré comme ayant la création de potion uniquement pour les sorts divins et uniquement pour le recyclage"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Temple"	                , "Religieux"	    , 16875	, null	, "Vous êtes considéré comme ayant la création de parchemin uniquement pour les sorts divins et uniquement pour le recyclage"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Cathédrale"	            , "Religieux"	    , 94375	, null	, "Vos cout de résurection coutent 10% de PR de moins"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Etabli de magicien"    	, "Occulte"	    , 1125	, null	, "Moins 10% PR pour accéder à des équipement (potions et parchemin profane seulement)"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Magasin de magie"	    , "Occulte"	    , 4875	, null	, "Vous êtes considéré comme ayant la création de parchemin uniquement pour les sorts profanes et uniquement pour le recyclage"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Tour de mage"	        , "Occulte"	    , 13450	, null	, "Vous êtes considéré comme ayant la création de potion uniquement pour les sort profane et uniquement pour le recyclage"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Cercle de téléportation"	, "Occulte"	    , 90950	, null	, "Permet de lancer téléportation une fois par jour"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Table d'essai"	        , "Alchimie"	    , 1125	, null	, "Vous permet de vendre , Bonus +1 en craft alchimie"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Laboratoire"	            , "Alchimie"	    , 4875	, null	, "Bonus de +1 dégats avec les armes à aspersion , +2 en craft alchimie"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Laboratoire avancé"	    , "Alchimie"	    , 13450	, null	, "DC poison +1 , craft alchimie +3"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Fosse"	                , "Combat"	    , 1400	, 100	, "Peut acceuillir les duel, gain 10% de PR miser"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Arêne"	                , "Combat"	    , 6825	, 350	, "Vous considère d'avoir vos en rang pour le recyclage d'armure"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Collisée"	            , "Combat"	    , 18825	, 800	, "Vous considère d'avoir vos en rang pour le recyclage d'arme"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Gargotte"	            , "Spectacle"	    , 1125	, 100	, "Bonus de 1 à un jet de profession"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Taverne"	                , "Spectacle"	    , 4875	, 325	, "Bonus de 2 à un jet de profession"	);
        $this->manager->persist($building);
        $building = new BuildingBase(	"Palace"	                , "Spectacle"	    , 13450	, 675	, "Bonus de 3 à un jet de profession"	);
        $this->manager->persist($building);

    }

    private function createLocation(int $nbUser): void {
        for ($i = 0; $i < $nbUser; $i++) {
        
            $location = new Location();

            // Génération de données aléatoires avec Faker
            // On utilise $this->fake->unique() pour garantir un nom unique.
            $location->setName($this->faker->unique()->city()); //($this->faker->unique()->firstName . ' ' . $this->faker->lastName);

            $this->manager->persist($location);

        }
    }

    
}
