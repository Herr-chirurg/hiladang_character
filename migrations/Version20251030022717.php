<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251030022717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__scenario AS SELECT id, game_master_id, name, level, date, img, post_link, summary_link, status FROM scenario');
        $this->addSql('DROP TABLE scenario');
        $this->addSql('CREATE TABLE scenario (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, game_master_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, level NUMERIC(2, 0) NOT NULL, date DATETIME NOT NULL, img BLOB DEFAULT NULL, post_link VARCHAR(255) NOT NULL, summary_link VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, CONSTRAINT FK_3E45C8D8C1151A13 FOREIGN KEY (game_master_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO scenario (id, game_master_id, name, level, date, img, post_link, summary_link, status) SELECT id, game_master_id, name, level, date, img, post_link, summary_link, status FROM __temp__scenario');
        $this->addSql('DROP TABLE __temp__scenario');
        $this->addSql('CREATE INDEX IDX_3E45C8D8C1151A13 ON scenario (game_master_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scenario ADD COLUMN description VARCHAR(1000) NOT NULL');
    }
}
