<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251015141410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, participant_id INTEGER DEFAULT NULL, type VARCHAR(255) NOT NULL, date DATETIME NOT NULL, cost_gp NUMERIC(8, 2) DEFAULT NULL, cost_pr NUMERIC(10, 0) DEFAULT NULL, duration INTEGER DEFAULT NULL, description VARCHAR(1000) NOT NULL, CONSTRAINT FK_AC74095A9D1C3019 FOREIGN KEY (participant_id) REFERENCES character (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_AC74095A9D1C3019 ON activity (participant_id)');
        $this->addSql('CREATE TABLE building (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER DEFAULT NULL, location_id INTEGER DEFAULT NULL, base_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, CONSTRAINT FK_E16F61D47E3C61F9 FOREIGN KEY (owner_id) REFERENCES character (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E16F61D464D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E16F61D46967DF41 FOREIGN KEY (base_id) REFERENCES building_base (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_E16F61D47E3C61F9 ON building (owner_id)');
        $this->addSql('CREATE INDEX IDX_E16F61D464D218E ON building (location_id)');
        $this->addSql('CREATE INDEX IDX_E16F61D46967DF41 ON building (base_id)');
        $this->addSql('CREATE TABLE building_audit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs CLOB DEFAULT NULL --(DC2Type:json)
        , blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX type_d09ea8237d0f3efadd73c7c32a2a77a1_idx ON building_audit (type)');
        $this->addSql('CREATE INDEX object_id_d09ea8237d0f3efadd73c7c32a2a77a1_idx ON building_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_d09ea8237d0f3efadd73c7c32a2a77a1_idx ON building_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_d09ea8237d0f3efadd73c7c32a2a77a1_idx ON building_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_d09ea8237d0f3efadd73c7c32a2a77a1_idx ON building_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_d09ea8237d0f3efadd73c7c32a2a77a1_idx ON building_audit (created_at)');
        $this->addSql('CREATE TABLE building_base (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 0) NOT NULL, type VARCHAR(255) NOT NULL, production NUMERIC(10, 0) NOT NULL, bonus VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE building_base_building_base (building_base_source INTEGER NOT NULL, building_base_target INTEGER NOT NULL, PRIMARY KEY(building_base_source, building_base_target), CONSTRAINT FK_15F4125AAA16D8DA FOREIGN KEY (building_base_source) REFERENCES building_base (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_15F4125AB3F38855 FOREIGN KEY (building_base_target) REFERENCES building_base (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_15F4125AAA16D8DA ON building_base_building_base (building_base_source)');
        $this->addSql('CREATE INDEX IDX_15F4125AB3F38855 ON building_base_building_base (building_base_target)');
        $this->addSql('CREATE TABLE character (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, img BLOB DEFAULT NULL, level INTEGER NOT NULL, xp_current NUMERIC(7, 0) NOT NULL, xp_current_mj NUMERIC(7, 0) NOT NULL, gp NUMERIC(8, 2) NOT NULL, pr NUMERIC(10, 0) NOT NULL, end_activity DATE NOT NULL, last_action_description VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_937AB0347E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_937AB0347E3C61F9 ON character (owner_id)');
        $this->addSql('CREATE TABLE character_audit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs CLOB DEFAULT NULL --(DC2Type:json)
        , blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX type_bb9718fea5a5f3e82edc5f9b0ad8671c_idx ON character_audit (type)');
        $this->addSql('CREATE INDEX object_id_bb9718fea5a5f3e82edc5f9b0ad8671c_idx ON character_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_bb9718fea5a5f3e82edc5f9b0ad8671c_idx ON character_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_bb9718fea5a5f3e82edc5f9b0ad8671c_idx ON character_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_bb9718fea5a5f3e82edc5f9b0ad8671c_idx ON character_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_bb9718fea5a5f3e82edc5f9b0ad8671c_idx ON character_audit (created_at)');
        $this->addSql('CREATE TABLE location (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE log (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, item_type VARCHAR(255) NOT NULL, item_id INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , field_name VARCHAR(255) NOT NULL, old_value VARCHAR(1000) DEFAULT NULL, new_value VARCHAR(1000) DEFAULT NULL, description VARCHAR(255) NOT NULL, user_id VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE log_audit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs CLOB DEFAULT NULL --(DC2Type:json)
        , blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX type_369ebb4bad84dfa069597309f25427a8_idx ON log_audit (type)');
        $this->addSql('CREATE INDEX object_id_369ebb4bad84dfa069597309f25427a8_idx ON log_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_369ebb4bad84dfa069597309f25427a8_idx ON log_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_369ebb4bad84dfa069597309f25427a8_idx ON log_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_369ebb4bad84dfa069597309f25427a8_idx ON log_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_369ebb4bad84dfa069597309f25427a8_idx ON log_audit (created_at)');
        $this->addSql('CREATE TABLE scenario (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, game_master_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, level NUMERIC(2, 0) NOT NULL, date DATETIME NOT NULL, description VARCHAR(1000) NOT NULL, img BLOB NOT NULL, post_link VARCHAR(255) NOT NULL, summary_link VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, nb_character NUMERIC(10, 0) NOT NULL, CONSTRAINT FK_3E45C8D8C1151A13 FOREIGN KEY (game_master_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3E45C8D8C1151A13 ON scenario (game_master_id)');
        $this->addSql('CREATE TABLE scenario_character (scenario_id INTEGER NOT NULL, character_id INTEGER NOT NULL, PRIMARY KEY(scenario_id, character_id), CONSTRAINT FK_81E6D42E04E49DF FOREIGN KEY (scenario_id) REFERENCES scenario (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_81E6D421136BE75 FOREIGN KEY (character_id) REFERENCES character (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_81E6D42E04E49DF ON scenario_character (scenario_id)');
        $this->addSql('CREATE INDEX IDX_81E6D421136BE75 ON scenario_character (character_id)');
        $this->addSql('CREATE TABLE scenario_audit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs CLOB DEFAULT NULL --(DC2Type:json)
        , blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX type_aa42ee6d27754f827714c5a2d71970cc_idx ON scenario_audit (type)');
        $this->addSql('CREATE INDEX object_id_aa42ee6d27754f827714c5a2d71970cc_idx ON scenario_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_aa42ee6d27754f827714c5a2d71970cc_idx ON scenario_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_aa42ee6d27754f827714c5a2d71970cc_idx ON scenario_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_aa42ee6d27754f827714c5a2d71970cc_idx ON scenario_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_aa42ee6d27754f827714c5a2d71970cc_idx ON scenario_audit (created_at)');
        $this->addSql('CREATE TABLE token (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, scenario_id INTEGER DEFAULT NULL, character_id INTEGER DEFAULT NULL, owner_user_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, usage_rate INTEGER NOT NULL, value INTEGER NOT NULL, value_pr INTEGER NOT NULL, date_of_reception DATETIME NOT NULL, CONSTRAINT FK_5F37A13BE04E49DF FOREIGN KEY (scenario_id) REFERENCES scenario (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5F37A13B1136BE75 FOREIGN KEY (character_id) REFERENCES character (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5F37A13B2B18554A FOREIGN KEY (owner_user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_5F37A13BE04E49DF ON token (scenario_id)');
        $this->addSql('CREATE INDEX IDX_5F37A13B1136BE75 ON token (character_id)');
        $this->addSql('CREATE INDEX IDX_5F37A13B2B18554A ON token (owner_user_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, discord_id VARCHAR(180) NOT NULL, username VARCHAR(255) DEFAULT NULL, role VARCHAR(255) DEFAULT NULL, nb_character_max INTEGER NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_DISCORD_ID ON user (discord_id)');
        $this->addSql('CREATE TABLE user_audit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs CLOB DEFAULT NULL --(DC2Type:json)
        , blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX type_e06395edc291d0719bee26fd39a32e8a_idx ON user_audit (type)');
        $this->addSql('CREATE INDEX object_id_e06395edc291d0719bee26fd39a32e8a_idx ON user_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_e06395edc291d0719bee26fd39a32e8a_idx ON user_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_e06395edc291d0719bee26fd39a32e8a_idx ON user_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_e06395edc291d0719bee26fd39a32e8a_idx ON user_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_e06395edc291d0719bee26fd39a32e8a_idx ON user_audit (created_at)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');

        $this->addSql("INSERT INTO building_base VALUES(1,'Bicoque',1125,'Habitation',100,'');");
        $this->addSql("INSERT INTO building_base VALUES(2,'Maison',4875,'Habitation',350,'');");
        $this->addSql("INSERT INTO building_base VALUES(3,'Manoir',13450,'Habitation',850,'');");
        $this->addSql("INSERT INTO building_base VALUES(4,'Château',29450,'Habitation',1650,'');");
        $this->addSql("INSERT INTO building_base VALUES(5,'Echoppe',1125,'Commerce',0,'Vous permez de vendre des objets');");
        $this->addSql("INSERT INTO building_base VALUES(6,'Boutique',4875,'Commerce',0,'Gagner 10% du prix en RP à chaque vente');");
        $this->addSql("INSERT INTO building_base VALUES(7,'Comptoire',13450,'Commerce',0,'Gagner 20% du prix en RP à chaque vente');");
        $this->addSql("INSERT INTO building_base VALUES(8,'Paddock',1125,'Elevage',0,'Vous permez de vendre et d''entrainer des animaux (MAX 5 DV): +1 Dressage');");
        $this->addSql("INSERT INTO building_base VALUES(9,'Corral',4875,'Elevage',0,'Vous permez de vendre tous les animaux : +2 Dressage, Vos couts de résurection d''animaux coutent 25% PR de moins');");
        $this->addSql("INSERT INTO building_base VALUES(10,'Ranch',16875,'Elevage',0,'Vos couts de résurection d''animaux coutent 50% PR de moins : +3 Dressage');");
        $this->addSql("INSERT INTO building_base VALUES(11,'Etable',1125,'Tanière',0,'1 taille G, vous pouvez êtes considéré ayant les capacités de de recyclage pour tous les équipements d''animaux');");
        $this->addSql("INSERT INTO building_base VALUES(12,'Ecurie',2500,'Tanière',0,'2 taille G, moins 10% PR pour accéder à des équipement pour animaux');");
        $this->addSql("INSERT INTO building_base VALUES(13,'Hara',4475,'Tanière',0,'4 taille G, moins 20% PR pour accéder à des équipement pour animaux');");
        $this->addSql("INSERT INTO building_base VALUES(14,'Confrerie',3375,'Communautaire',350,'Un seul chef, min 9 niv dans la guilde');");
        $this->addSql("INSERT INTO building_base VALUES(15,'Guilde',14625,'Communautaire',1475,'Un seul chef, min 18 niv dans la guilde');");
        $this->addSql("INSERT INTO building_base VALUES(16,'Ordre',40350,'Communautaire',4050,'Un seul chef, min 27 niv dans la guilde');");
        $this->addSql("INSERT INTO building_base VALUES(17,'Atelier',1125,'Artisan',0,'Bonus de 2 à un jet de profession');");
        $this->addSql("INSERT INTO building_base VALUES(18,'Manufacture',4875,'Artisan',0,'Bonus de 4 à un jet de profession');");
        $this->addSql("INSERT INTO building_base VALUES(19,'Usine',13450,'Artisan',0,'Bonus de 6 à un jet de profession');");
        $this->addSql("INSERT INTO building_base VALUES(20,'Sampan',1125,'Navire',0,'Moins 10% PR pour accéder à des équipement indisponible');");
        $this->addSql("INSERT INTO building_base VALUES(21,'Sengokubune',6850,'Navire',0,'Moins 20% PR pour accéder à des équipement indisponible');");
        $this->addSql("INSERT INTO building_base VALUES(22,'Jonque',18850,'Navire',0,'Moins 30% PR pour accéder à des équipement indisponible');");
        $this->addSql("INSERT INTO building_base VALUES(23,'Site de bucheronnage',1125,'Construction',0,'Moins 10% PR pour construire un bâtiment');");
        $this->addSql("INSERT INTO building_base VALUES(24,'Scierie',4875,'Construction',0,'Moins 20% PR pour construire un bâtiment');");
        $this->addSql("INSERT INTO building_base VALUES(25,'Taille de pierre',13450,'Construction',0,'Moins 30% PR pour construire un bâtiment');");
        $this->addSql("INSERT INTO building_base VALUES(26,'Autel',1125,'Religieux',0,'Vous pouvez être un représentant connu de votre église, -10% PR pour accéder à des équipement (les potions et parchemin divins seulement)');");
        $this->addSql("INSERT INTO building_base VALUES(27,'Eglise',4875,'Religieux',0,'Vous êtes considéré comme ayant la création de potion uniquement pour les sorts divins et uniquement pour le recyclage');");
        $this->addSql("INSERT INTO building_base VALUES(28,'Temple',16875,'Religieux',0,'Vous êtes considéré comme ayant la création de parchemin uniquement pour les sorts divins et uniquement pour le recyclage');");
        $this->addSql("INSERT INTO building_base VALUES(29,'Cathédrale',94375,'Religieux',0,'Vos cout de résurection coutent 10% de PR de moins');");
        $this->addSql("INSERT INTO building_base VALUES(30,'Etabli de magicien',1125,'Occulte',0,'Moins 10% PR pour accéder à des équipement (potions et parchemin profane seulement)');");
        $this->addSql("INSERT INTO building_base VALUES(31,'Magasin de magie',4875,'Occulte',0,'Vous êtes considéré comme ayant la création de parchemin uniquement pour les sorts profanes et uniquement pour le recyclage');");
        $this->addSql("INSERT INTO building_base VALUES(32,'Tour de mage',13450,'Occulte',0,'Vous êtes considéré comme ayant la création de potion uniquement pour les sort profane et uniquement pour le recyclage');");
        $this->addSql("INSERT INTO building_base VALUES(33,'Cercle de téléportation',90950,'Occulte',0,'Permet de lancer téléportation une fois par jour');");
        $this->addSql("INSERT INTO building_base VALUES(34,'Table d''essai',1125,'Alchimie',0,'Vous permet de vendre , Bonus +1 en craft alchimie');");
        $this->addSql("INSERT INTO building_base VALUES(35,'Laboratoire',4875,'Alchimie',0,'Bonus de +1 dégats avec les armes à aspersion , +2 en craft alchimie');");
        $this->addSql("INSERT INTO building_base VALUES(36,'Laboratoire avancé',13450,'Alchimie',0,'DC poison +1 , craft alchimie +3');");
        $this->addSql("INSERT INTO building_base VALUES(37,'Fosse',1400,'Combat',100,'Peut acceuillir les duel, gain 10% de PR miser');");
        $this->addSql("INSERT INTO building_base VALUES(38,'Arêne',6825,'Combat',350,'Vous considère d''avoir vos en rang pour le recyclage d''armure');");
        $this->addSql("INSERT INTO building_base VALUES(39,'Collisée',18825,'Combat',800,'Vous considère d''avoir vos en rang pour le recyclage d''arme');");
        $this->addSql("INSERT INTO building_base VALUES(40,'Gargotte',1125,'Spectacle',100,'Bonus de 1 à un jet de profession');");
        $this->addSql("INSERT INTO building_base VALUES(41,'Taverne',4875,'Spectacle',325,'Bonus de 2 à un jet de profession');");
        $this->addSql("INSERT INTO building_base VALUES(42,'Palace',13450,'Spectacle',675,'Bonus de 3 à un jet de profession');");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE building');
        $this->addSql('DROP TABLE building_audit');
        $this->addSql('DROP TABLE building_base');
        $this->addSql('DROP TABLE building_base_building_base');
        $this->addSql('DROP TABLE character');
        $this->addSql('DROP TABLE character_audit');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE log');
        $this->addSql('DROP TABLE log_audit');
        $this->addSql('DROP TABLE scenario');
        $this->addSql('DROP TABLE scenario_character');
        $this->addSql('DROP TABLE scenario_audit');
        $this->addSql('DROP TABLE token');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_audit');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
