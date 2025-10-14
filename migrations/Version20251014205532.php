<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251014205532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__character AS SELECT id, owner_id, name, title, img, level, xp_current, xp_current_mj, gp, pr, end_activity, last_action_description FROM character');
        $this->addSql('DROP TABLE character');
        $this->addSql('CREATE TABLE character (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, img BLOB DEFAULT NULL, level INTEGER DEFAULT NULL, xp NUMERIC(7, 0) DEFAULT NULL, xp_current_mj NUMERIC(7, 0) DEFAULT NULL, gp NUMERIC(8, 2) DEFAULT NULL, pr NUMERIC(10, 0) DEFAULT NULL, end_activity INTEGER DEFAULT NULL, last_action_description VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_937AB0347E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO character (id, owner_id, name, title, img, level, xp, xp_current_mj, gp, pr, end_activity, last_action_description) SELECT id, owner_id, name, title, img, level, xp_current, xp_current_mj, gp, pr, end_activity, last_action_description FROM __temp__character');
        $this->addSql('DROP TABLE __temp__character');
        $this->addSql('CREATE INDEX IDX_937AB0347E3C61F9 ON character (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__character AS SELECT id, owner_id, name, title, img, level, xp, xp_current_mj, gp, pr, end_activity, last_action_description FROM character');
        $this->addSql('DROP TABLE character');
        $this->addSql('CREATE TABLE character (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, img BLOB DEFAULT NULL, level INTEGER DEFAULT NULL, xp_current NUMERIC(7, 0) DEFAULT NULL, xp_current_mj NUMERIC(7, 0) DEFAULT NULL, gp NUMERIC(8, 2) DEFAULT NULL, pr NUMERIC(10, 0) DEFAULT NULL, end_activity INTEGER DEFAULT NULL, last_action_description VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_937AB0347E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO character (id, owner_id, name, title, img, level, xp_current, xp_current_mj, gp, pr, end_activity, last_action_description) SELECT id, owner_id, name, title, img, level, xp, xp_current_mj, gp, pr, end_activity, last_action_description FROM __temp__character');
        $this->addSql('DROP TABLE __temp__character');
        $this->addSql('CREATE INDEX IDX_937AB0347E3C61F9 ON character (owner_id)');
    }
}
