<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251212052007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__item AS SELECT id, cart_gp_id, name, quantity, price FROM item');
        $this->addSql('DROP TABLE item');
        $this->addSql('CREATE TABLE item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, cart_gp_id INTEGER DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, quantity NUMERIC(10, 0) DEFAULT NULL, price NUMERIC(10, 2) DEFAULT NULL, CONSTRAINT FK_1F1B251E1AD5CDBF FOREIGN KEY (cart_gp_id) REFERENCES cart_gp (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO item (id, cart_gp_id, name, quantity, price) SELECT id, cart_gp_id, name, quantity, price FROM __temp__item');
        $this->addSql('DROP TABLE __temp__item');
        $this->addSql('CREATE INDEX IDX_1F1B251E40E58DF6 ON item (cart_gp_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__item AS SELECT id, cart_gp_id, name, quantity, price FROM item');
        $this->addSql('DROP TABLE item');
        $this->addSql('CREATE TABLE item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, cart_gp_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, quantity NUMERIC(10, 0) NOT NULL, price NUMERIC(10, 2) NOT NULL, CONSTRAINT FK_1F1B251E40E58DF6 FOREIGN KEY (cart_gp_id) REFERENCES cart_gp (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO item (id, cart_gp_id, name, quantity, price) SELECT id, cart_gp_id, name, quantity, price FROM __temp__item');
        $this->addSql('DROP TABLE __temp__item');
        $this->addSql('CREATE INDEX IDX_1F1B251E40E58DF6 ON item (cart_gp_id)');
    }
}
