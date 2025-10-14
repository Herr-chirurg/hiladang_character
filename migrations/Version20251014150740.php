<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251014150740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE transfer');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transfer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, initiator_id INTEGER NOT NULL, recipient_id INTEGER DEFAULT NULL, gp NUMERIC(8, 2) NOT NULL, pr NUMERIC(10, 0) NOT NULL, extra_pr NUMERIC(10, 0) NOT NULL, description VARCHAR(1000) NOT NULL COLLATE "BINARY", CONSTRAINT FK_4034A3C07DB3B714 FOREIGN KEY (initiator_id) REFERENCES character (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4034A3C0E92F8F78 FOREIGN KEY (recipient_id) REFERENCES character (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_4034A3C0E92F8F78 ON transfer (recipient_id)');
        $this->addSql('CREATE INDEX IDX_4034A3C07DB3B714 ON transfer (initiator_id)');
    }
}
