<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251007114927 extends AbstractMigration
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
        $this->addSql('CREATE TABLE building (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER DEFAULT NULL, location_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, production NUMERIC(10, 0) DEFAULT NULL, bonus VARCHAR(255) DEFAULT NULL, alias VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_E16F61D47E3C61F9 FOREIGN KEY (owner_id) REFERENCES character (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E16F61D464D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_E16F61D47E3C61F9 ON building (owner_id)');
        $this->addSql('CREATE INDEX IDX_E16F61D464D218E ON building (location_id)');
        $this->addSql('CREATE TABLE building_base (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, price NUMERIC(10, 0) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, production NUMERIC(10, 0) DEFAULT NULL, bonus VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE building_base_building_base (building_base_source INTEGER NOT NULL, building_base_target INTEGER NOT NULL, PRIMARY KEY(building_base_source, building_base_target), CONSTRAINT FK_15F4125AAA16D8DA FOREIGN KEY (building_base_source) REFERENCES building_base (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_15F4125AB3F38855 FOREIGN KEY (building_base_target) REFERENCES building_base (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_15F4125AAA16D8DA ON building_base_building_base (building_base_source)');
        $this->addSql('CREATE INDEX IDX_15F4125AB3F38855 ON building_base_building_base (building_base_target)');
        $this->addSql('CREATE TABLE character (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, img BLOB DEFAULT NULL, level INTEGER DEFAULT NULL, xp_current NUMERIC(7, 0) DEFAULT NULL, xp_current_mj NUMERIC(7, 0) DEFAULT NULL, gp NUMERIC(8, 2) DEFAULT NULL, pr NUMERIC(10, 0) DEFAULT NULL, end_activity INTEGER DEFAULT NULL, CONSTRAINT FK_937AB0347E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_937AB0347E3C61F9 ON character (owner_id)');
        $this->addSql('CREATE TABLE location (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, price NUMERIC(10, 0) DEFAULT NULL)');
        $this->addSql('CREATE TABLE scenario (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, game_master_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, level NUMERIC(2, 0) NOT NULL, date DATETIME NOT NULL, description VARCHAR(1000) NOT NULL, img BLOB NOT NULL, post_link VARCHAR(255) NOT NULL, summary_link VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, CONSTRAINT FK_3E45C8D8C1151A13 FOREIGN KEY (game_master_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3E45C8D8C1151A13 ON scenario (game_master_id)');
        $this->addSql('CREATE TABLE token (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, scenario_id INTEGER DEFAULT NULL, character_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, usage_rate INTEGER NOT NULL, value INTEGER NOT NULL, value_pr INTEGER NOT NULL, date_of_reception DATETIME NOT NULL, CONSTRAINT FK_5F37A13BE04E49DF FOREIGN KEY (scenario_id) REFERENCES scenario (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5F37A13B1136BE75 FOREIGN KEY (character_id) REFERENCES character (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_5F37A13BE04E49DF ON token (scenario_id)');
        $this->addSql('CREATE INDEX IDX_5F37A13B1136BE75 ON token (character_id)');
        $this->addSql('CREATE TABLE transfer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, initiator_id INTEGER NOT NULL, recipient_id INTEGER NOT NULL, gp NUMERIC(8, 2) NOT NULL, pr NUMERIC(10, 0) NOT NULL, extra_pr NUMERIC(10, 0) NOT NULL, CONSTRAINT FK_4034A3C07DB3B714 FOREIGN KEY (initiator_id) REFERENCES character (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4034A3C0E92F8F78 FOREIGN KEY (recipient_id) REFERENCES character (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_4034A3C07DB3B714 ON transfer (initiator_id)');
        $this->addSql('CREATE INDEX IDX_4034A3C0E92F8F78 ON transfer (recipient_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, nb_character INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE building');
        $this->addSql('DROP TABLE building_base');
        $this->addSql('DROP TABLE building_base_building_base');
        $this->addSql('DROP TABLE character');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE scenario');
        $this->addSql('DROP TABLE token');
        $this->addSql('DROP TABLE transfer');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
