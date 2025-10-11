<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251011161501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__building AS SELECT id, owner_id, location_id, name FROM building');
        $this->addSql('DROP TABLE building');
        $this->addSql('CREATE TABLE building (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER DEFAULT NULL, location_id INTEGER DEFAULT NULL, base_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, CONSTRAINT FK_E16F61D47E3C61F9 FOREIGN KEY (owner_id) REFERENCES character (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E16F61D464D218E FOREIGN KEY (location_id) REFERENCES location (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E16F61D46967DF41 FOREIGN KEY (base_id) REFERENCES building_base (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO building (id, owner_id, location_id, name) SELECT id, owner_id, location_id, name FROM __temp__building');
        $this->addSql('DROP TABLE __temp__building');
        $this->addSql('CREATE INDEX IDX_E16F61D464D218E ON building (location_id)');
        $this->addSql('CREATE INDEX IDX_E16F61D47E3C61F9 ON building (owner_id)');
        $this->addSql('CREATE INDEX IDX_E16F61D46967DF41 ON building (base_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__building AS SELECT id, owner_id, location_id, name FROM building');
        $this->addSql('DROP TABLE building');
        $this->addSql('CREATE TABLE building (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER DEFAULT NULL, location_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, production NUMERIC(10, 0) DEFAULT NULL, bonus VARCHAR(255) DEFAULT NULL, alias VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_E16F61D47E3C61F9 FOREIGN KEY (owner_id) REFERENCES character (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E16F61D464D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO building (id, owner_id, location_id, name) SELECT id, owner_id, location_id, name FROM __temp__building');
        $this->addSql('DROP TABLE __temp__building');
        $this->addSql('CREATE INDEX IDX_E16F61D47E3C61F9 ON building (owner_id)');
        $this->addSql('CREATE INDEX IDX_E16F61D464D218E ON building (location_id)');
    }
}
