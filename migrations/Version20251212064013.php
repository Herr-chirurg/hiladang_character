<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251212064013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__cart_gp AS SELECT id, date FROM cart_gp');
        $this->addSql('DROP TABLE cart_gp');
        $this->addSql('CREATE TABLE cart_gp (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, buyer_id INTEGER DEFAULT NULL, date DATE NOT NULL, CONSTRAINT FK_9E8C344C6C755722 FOREIGN KEY (buyer_id) REFERENCES character (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO cart_gp (id, date) SELECT id, date FROM __temp__cart_gp');
        $this->addSql('DROP TABLE __temp__cart_gp');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9E8C344C6C755722 ON cart_gp (buyer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__cart_gp AS SELECT id, date FROM cart_gp');
        $this->addSql('DROP TABLE cart_gp');
        $this->addSql('CREATE TABLE cart_gp (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date DATE NOT NULL, buyer VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO cart_gp (id, date) SELECT id, date FROM __temp__cart_gp');
        $this->addSql('DROP TABLE __temp__cart_gp');
    }
}
