<?php

namespace App\DataFixtures;

use App\Entity\Activity;
use App\Entity\Building;
use App\Entity\Location;
use App\Entity\Scenario;
use App\Entity\Token;
use App\Entity\Transfer;
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

        //creation location
        $this->createLocations(10);

        //creation users
        $this->createUsers(40);

        //creation characters
        //ajout à des users existants   
        $this->createCharacters(50);

        //creation de buildings bases
        $this->createBuildingBases();

        //creations de buildings à partir de building bases
        //associations de la moitiés des bâtiments à des characters
        $this->createBuildings(50);

        //creation de scénarios
        $this->createScenarios(10);

        //tokens MJ, les tokens non PJ sont générés dans les scénarios.
        $this->createTokens(10);
        
        //création de transfers
        //association de destinataires à des characters
        $this->createTransfers(10);
        
        //association d'activités à des characters
        $this->createActivities(10);
        
    }

    private function createCharacters(int $nbCharacters): void {

        $users = $this->manager->getRepository(User::class)->findAll();

        for ($i = 0; $i < $nbCharacters; $i++) {
        
            $character = new Character();

            $character->setOwner($this->faker->randomElement($users));

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

        $this->manager->flush();
    }

    private function createUsers(int $nbUsers): void {
        for ($i = 0; $i < $nbUsers; $i++) {
        
            $user = new User();

            $firstName = $this->faker->unique()->firstName;
            $lastName = $this->faker->unique()->lastName;

            $user->setDiscordId($firstName);
            $user->setPassword($firstName);

            // Génération de données aléatoires avec Faker
            // On utilise $this->fake->unique() pour garantir un nom unique.
            $user->setUsername($firstName . ' ' . $this->faker->lastName);
            $user->setRole($this->faker->jobTitle);

            // Pour une image, utilisez un placeholder ou une valeur aléatoire dans une liste prédéfinie
            //$imageOptions = ['warrior.png', 'mage.png', 'rogue.png', 'cleric.png'];
            //$character->setImg($imageOptions[array_rand($imageOptions)]);

            // Niveaux aléatoires entre 1 et 2
            $user->setNbCharacterMax($this->faker->numberBetween(1, 2));

            $this->manager->persist($user);

        }

        $this->manager->flush();
    }

     private function createBuildingBases(): void {
        
        
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Bicoque"	                , "Habitation"	, 1125	, 100	, ""	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Maison"	                , "Habitation"	, 4875	, 350	, ""	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Manoir"	                , "Habitation"	, 13450	, 850	, ""	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Château"	                , "Habitation"	, 29450	, 1650	, ""	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Echoppe"	                , "Commerce"	    , 1125	, null	, "Vous permez de vendre des objets"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Boutique"	            , "Commerce"	    , 4875	, null	, "Gagner 10% du prix en RP à chaque vente"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Comptoire"	            , "Commerce"	    , 13450	, null	, "Gagner 20% du prix en RP à chaque vente"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Paddock"	                , "Elevage"	    , 1125	, null	, "Vous permez de vendre et d'entrainer des animaux (MAX 5 DV): +1 Dressage"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Corral"	                , "Elevage"	    , 4875	, null	, "Vous permez de vendre tous les animaux : +2 Dressage, Vos couts de résurection d'animaux coutent 25% PR de moins"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Ranch"	                , "Elevage"	    , 16875	, null	, "Vos couts de résurection d'animaux coutent 50% PR de moins : +3 Dressage"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Etable"        	        , "Tanière"	    , 1125	, null	, "1 taille G, vous pouvez êtes considéré ayant les capacités de de recyclage pour tous les équipements d'animaux"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Ecurie"	                , "Tanière"	    , 2500	, null	, "2 taille G, moins 10% PR pour accéder à des équipement pour animaux"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Hara"	                , "Tanière"	    , 4475	, null	, "4 taille G, moins 20% PR pour accéder à des équipement pour animaux"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Confrerie"	            , "Communautaire" , 3375	, 350	, "Un seul chef, min 9 niv dans la guilde"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Guilde"	                , "Communautaire" , 14625	, 1475	, "Un seul chef, min 18 niv dans la guilde"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Ordre"	                , "Communautaire" , 40350	, 4050	, "Un seul chef, min 27 niv dans la guilde"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Atelier"	                , "Artisan"	    , 1125	, null	, "Bonus de 2 à un jet de profession"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Manufacture"	            , "Artisan"	    , 4875	, null	, "Bonus de 4 à un jet de profession"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Usine"	                , "Artisan"	    , 13450	, null	, "Bonus de 6 à un jet de profession"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Sampan"	                , "Navire"	    , 1125	, null	, "Moins 10% PR pour accéder à des équipement indisponible"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Sengokubune"	            , "Navire"	    , 6850	, null	, "Moins 20% PR pour accéder à des équipement indisponible"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Jonque"	                , "Navire"	    , 18850	, null	, "Moins 30% PR pour accéder à des équipement indisponible"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Site de bucheronnage"    , "Construction"	, 1125	, null	, "Moins 10% PR pour construire un bâtiment"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Scierie"	                , "Construction"	, 4875	, null	, "Moins 20% PR pour construire un bâtiment"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Taille de pierre"	    , "Construction"	, 13450	, null	, "Moins 30% PR pour construire un bâtiment"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Autel"	                , "Religieux"	    , 1125	, null	, "Vous pouvez être un représentant connu de votre église, -10% PR pour accéder à des équipement (les potions et parchemin divins seulement)"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Eglise"	                , "Religieux"	    , 4875	, null	, "Vous êtes considéré comme ayant la création de potion uniquement pour les sorts divins et uniquement pour le recyclage"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Temple"	                , "Religieux"	    , 16875	, null	, "Vous êtes considéré comme ayant la création de parchemin uniquement pour les sorts divins et uniquement pour le recyclage"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Cathédrale"	            , "Religieux"	    , 94375	, null	, "Vos cout de résurection coutent 10% de PR de moins"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Etabli de magicien"    	, "Occulte"	    , 1125	, null	, "Moins 10% PR pour accéder à des équipement (potions et parchemin profane seulement)"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Magasin de magie"	    , "Occulte"	    , 4875	, null	, "Vous êtes considéré comme ayant la création de parchemin uniquement pour les sorts profanes et uniquement pour le recyclage"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Tour de mage"	        , "Occulte"	    , 13450	, null	, "Vous êtes considéré comme ayant la création de potion uniquement pour les sort profane et uniquement pour le recyclage"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Cercle de téléportation"	, "Occulte"	    , 90950	, null	, "Permet de lancer téléportation une fois par jour"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Table d'essai"	        , "Alchimie"	    , 1125	, null	, "Vous permet de vendre , Bonus +1 en craft alchimie"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Laboratoire"	            , "Alchimie"	    , 4875	, null	, "Bonus de +1 dégats avec les armes à aspersion , +2 en craft alchimie"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Laboratoire avancé"	    , "Alchimie"	    , 13450	, null	, "DC poison +1 , craft alchimie +3"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Fosse"	                , "Combat"	    , 1400	, 100	, "Peut acceuillir les duel, gain 10% de PR miser"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Arêne"	                , "Combat"	    , 6825	, 350	, "Vous considère d'avoir vos en rang pour le recyclage d'armure"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Collisée"	            , "Combat"	    , 18825	, 800	, "Vous considère d'avoir vos en rang pour le recyclage d'arme"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Gargotte"	            , "Spectacle"	    , 1125	, 100	, "Bonus de 1 à un jet de profession"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Taverne"	                , "Spectacle"	    , 4875	, 325	, "Bonus de 2 à un jet de profession"	);
        $this->manager->persist($building);
        $building = BuildingBase::CreateFromNameTypePriceProductionBonus(	"Palace"	                , "Spectacle"	    , 13450	, 675	, "Bonus de 3 à un jet de profession"	);
        $this->manager->persist($building);

        $this->manager->flush();

    }

    private function createLocations(int $nbLocations): void {
        for ($i = 0; $i < $nbLocations; $i++) {
        
            $location = new Location();

            $location->setName($this->faker->unique()->city()); //($this->faker->unique()->firstName . ' ' . $this->faker->lastName);

            $this->manager->persist($location);

        }

        $this->manager->flush();
    }

    private function createScenarios(int $nbScenarios): void {

        $users = $this->manager->getRepository(User::class)->findAll();

        $statuses = ['Draft', 'Published', 'Archived', 'Pending Review'];

        $concepts = [
                'Le Mystère', 'L\'Ombre', 'Le Secret', 'La Malédiction', 'L\'Héritage', 
                'La Chute', 'Le Réveil', 'L\'Ascension', 'Le Pillage', 'Le Pacte'
        ];
        
        $adjectives = [
            'Oublié', 'Éternel', 'Sanglant', 'Cristallin', 'Interdit', 'Céleste', 'Funeste'
        ];

        for ($i = 0; $i < $nbScenarios; $i++) {

            $gameMaster = $this->faker->randomElement($users); 

            $characters = $this->manager->getRepository(Character::class)->findAll();

            $concept = $this->faker->randomElement($concepts);
            $lieu = $this->faker->city();
            $adjectif = $this->faker->randomElement($adjectives);

            $scenarioTitle = sprintf('%s de %s %s', $concept, $lieu, $adjectif);
            
            $scenarioTitle = str_replace('de La', 'de la', $scenarioTitle);
        
            $scenario = new Scenario();

            $scenario->setGameMaster($gameMaster);

            $scenario->setNbCharacter($this->faker->numberBetween(1, 10));

            for ($i = 0; $i < $scenario->getNbCharacter(); $i++) {
                $scenario->addCharacter($this->faker->randomElement($characters));
            }
            
            $scenario->setName($scenarioTitle);

            $scenario->setLevel($this->faker->numberBetween(1, 20));
            
            $scenario->setDate($this->faker->dateTimeBetween('-6 months', 'now'));

            $scenario->setDescription($this->faker->paragraphs(3, true)); // 3 paragraphes joints en une seule chaîne

            $binaryData = random_bytes(256);
            $scenario->setImg($binaryData); 

            $scenario->setPostLink('https://perdu.com/');

            $scenario->setSummaryLink('https://perdu.com/');

            $scenario->setStatus($this->faker->randomElement($statuses));

            $this->manager->persist($scenario);

        }
        
        $this->manager->flush();
    }

    private function createTokens(int $nbToken): void {

        $characters = $this->manager->getRepository(Character::class)->findAll();
        $users = $this->manager->getRepository(User::class)->findAll();

        for ($i = 0; $i < floor($nbToken/2); $i++) {
        
            $token = new Token();

            $token->setName("placeholder");

            $token->setType("MJ");
            if ($i%2) {
                $token->setType("MJ");
                $token->setCharacter($this->faker->randomElement($characters));
            } else {
                $token->setOwnerUser($this->faker->randomElement($users));
            }
            
            $token->setDateOfReception($this->faker->dateTimeBetween('-2 months', 'now'));
            $token->setUsageRate($this->faker->numberBetween(0,200));
            $token->setValue($this->faker->numberBetween(1,));
            $token->setValuePr($i%2 ? 0 : $this->faker->numberBetween(1,5));

            $this->manager->persist($token);
        }

        $this->manager->flush();
    }

    
    private function createActivities(int $nbActivity): void {

        $characters = $this->manager->getRepository(Character::class)->findAll();

        for ($i = 0; $i < $nbActivity; $i++) {
        
            $activity = new Activity();

            $activity->setParticipant($this->faker->randomElement($characters));
            
            // Assumons que $faker a été initialisé via : $faker = Factory::create('fr_FR');

            // Définitions des listes
            $activityTypes = ['Exploration', 'Restauration', 'Combat', 'Formation'];

            // L'objet Activity
            $activity->setType($this->faker->randomElement($activityTypes));
            $activity->setDate($this->faker->dateTimeBetween('-1 year', 'now')); // Date passée, jusqu'à aujourd'hui
            $activity->setCostGp($this->faker->numberBetween(1, 1000)); // Coût en Gold Pieces (GP)
            $activity->setCostPr($this->faker->numberBetween(10, 5000)); // Coût en Platinum Rank (PR)
            $activity->setDuration($this->faker->numberBetween(1, 48)); // Durée en heures ou unités de temps
            $activity->setDescription($this->faker->paragraphs(2, true)); // Deux paragraphes de texte


            $this->manager->persist($activity);

        }

        $this->manager->flush();
    }

    private function createTransfers(int $nbTransfer): void {

        $characters = $this->manager->getRepository(Character::class)->findAll();

        for ($i = 0; $i < $nbTransfer; $i++) {
        
            $transfer = new Transfer();

            $transfer->setGp($this->faker->randomFloat(2, 0.01, 50000.99));
            $transfer->setPr($this->faker->numberBetween(100, 9999999999)); 
            $transfer->setExtraPr($this->faker->numberBetween(0, 100));
            $transfer->setDescription(''. $this->faker->sentence(3) .'');
            
            $transfer->setInitiator($this->faker->randomElement($characters));
            $transfer->setRecipient($i%2 ? $this->faker->randomElement($characters) : null);

            $this->manager->persist($transfer);

        }

        $this->manager->flush();
    }

    private function createBuildings(int $nbBuilding): void {

        $characters = $this->manager->getRepository(Character::class)->findAll();
        $locations = $this->manager->getRepository(Location::class)->findAll();

        for ($i = 0; $i < $nbBuilding; $i++) {
        
            $building = new Building();

            $owner = $i%2 ?$this->faker->randomElement($characters) : null;

            $building->setOwner($i%2 ?$this->faker->randomElement($characters) : null);
            $building->setLocation($this->faker->randomElement($locations));

            $building->setName($this->faker->unique()->word() . ' ' . $this->faker->lastName());
            $building->setType($this->faker->randomElement(['Maison', 'Ferme', 'Caserne', 'Mine d\'Or', 'Bâtiment Administratif']));

            $building->setProduction($this->faker->randomElement(['100', '500', '1000', '2500', '5000']));
            $building->setBonus($this->faker->optional(0.7)->randomElement(['+1 Morale', '+2 Defense', 'Fast Travel', 'Resource Multiplier']));
            
            $building->setAlias($building->getName());

            $this->manager->persist($building);

        }
        
        $this->manager->flush();
    }

    
}
