<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251209074616 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE character ADD COLUMN last_action VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__character AS SELECT id, owner_id, name, title, img, level, xp_current, xp_current_mj, gp, pr, end_activity, last_action_description, webhook_link FROM character');
        $this->addSql('DROP TABLE character');
        $this->addSql('CREATE TABLE character (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, img BLOB DEFAULT NULL, level INTEGER NOT NULL, xp_current NUMERIC(7, 0) NOT NULL, xp_current_mj NUMERIC(7, 0) NOT NULL, gp NUMERIC(8, 2) NOT NULL, pr NUMERIC(10, 0) NOT NULL, end_activity DATE NOT NULL, last_action_description VARCHAR(255) DEFAULT NULL, webhook_link VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_937AB0347E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO character (id, owner_id, name, title, img, level, xp_current, xp_current_mj, gp, pr, end_activity, last_action_description, webhook_link) SELECT id, owner_id, name, title, img, level, xp_current, xp_current_mj, gp, pr, end_activity, last_action_description, webhook_link FROM __temp__character');
        $this->addSql('DROP TABLE __temp__character');
        $this->addSql('CREATE INDEX IDX_937AB0347E3C61F9 ON character (owner_id)');
    }
}
