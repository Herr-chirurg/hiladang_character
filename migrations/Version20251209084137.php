<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251209084137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart_gp (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, buyer_id INTEGER DEFAULT NULL, date DATE NOT NULL, status VARCHAR(255) NOT NULL, CONSTRAINT FK_BA388B76C755722 FOREIGN KEY (buyer_id) REFERENCES character (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA388B76C755722 ON cart_gp (buyer_id)');
        $this->addSql('CREATE TABLE item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, cart_gp_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, quantity NUMERIC(10, 0) NOT NULL, price NUMERIC(10, 2) NOT NULL, CONSTRAINT FK_1F1B251E1AD5CDBF FOREIGN KEY (cart_gp_id) REFERENCES cart_gp (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_1F1B251E1AD5CDBF ON item (cart_gp_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cart_gp');
        $this->addSql('DROP TABLE item');
    }
}
