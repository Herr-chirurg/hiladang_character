<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251022235748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE log');
        $this->addSql('DROP TABLE log_audit');
        $this->addSql('CREATE TEMPORARY TABLE __temp__scenario AS SELECT id, game_master_id, name, level, date, description, img, post_link, summary_link, status, nb_character FROM scenario');
        $this->addSql('DROP TABLE scenario');
        $this->addSql('CREATE TABLE scenario (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, game_master_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, level NUMERIC(2, 0) NOT NULL, date DATETIME NOT NULL, description VARCHAR(1000) NOT NULL, img BLOB DEFAULT NULL, post_link VARCHAR(255) NOT NULL, summary_link VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, nb_character NUMERIC(10, 0) NOT NULL, CONSTRAINT FK_3E45C8D8C1151A13 FOREIGN KEY (game_master_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO scenario (id, game_master_id, name, level, date, description, img, post_link, summary_link, status, nb_character) SELECT id, game_master_id, name, level, date, description, img, post_link, summary_link, status, nb_character FROM __temp__scenario');
        $this->addSql('DROP TABLE __temp__scenario');
        $this->addSql('CREATE INDEX IDX_3E45C8D8C1151A13 ON scenario (game_master_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE log (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, item_type VARCHAR(255) NOT NULL COLLATE "BINARY", item_id INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , field_name VARCHAR(255) NOT NULL COLLATE "BINARY", old_value VARCHAR(1000) DEFAULT NULL COLLATE "BINARY", new_value VARCHAR(1000) DEFAULT NULL COLLATE "BINARY", description VARCHAR(255) NOT NULL COLLATE "BINARY", user_id VARCHAR(255) DEFAULT NULL COLLATE "BINARY")');
        $this->addSql('CREATE TABLE log_audit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(10) NOT NULL COLLATE "BINARY", object_id VARCHAR(255) NOT NULL COLLATE "BINARY", discriminator VARCHAR(255) DEFAULT NULL COLLATE "BINARY", transaction_hash VARCHAR(40) DEFAULT NULL COLLATE "BINARY", diffs CLOB DEFAULT NULL COLLATE "BINARY" --(DC2Type:json)
        , blame_id VARCHAR(255) DEFAULT NULL COLLATE "BINARY", blame_user VARCHAR(255) DEFAULT NULL COLLATE "BINARY", blame_user_fqdn VARCHAR(255) DEFAULT NULL COLLATE "BINARY", blame_user_firewall VARCHAR(100) DEFAULT NULL COLLATE "BINARY", ip VARCHAR(45) DEFAULT NULL COLLATE "BINARY", created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX created_at_369ebb4bad84dfa069597309f25427a8_idx ON log_audit (created_at)');
        $this->addSql('CREATE INDEX blame_id_369ebb4bad84dfa069597309f25427a8_idx ON log_audit (blame_id)');
        $this->addSql('CREATE INDEX transaction_hash_369ebb4bad84dfa069597309f25427a8_idx ON log_audit (transaction_hash)');
        $this->addSql('CREATE INDEX discriminator_369ebb4bad84dfa069597309f25427a8_idx ON log_audit (discriminator)');
        $this->addSql('CREATE INDEX object_id_369ebb4bad84dfa069597309f25427a8_idx ON log_audit (object_id)');
        $this->addSql('CREATE INDEX type_369ebb4bad84dfa069597309f25427a8_idx ON log_audit (type)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__scenario AS SELECT id, game_master_id, name, level, date, description, img, post_link, summary_link, status, nb_character FROM scenario');
        $this->addSql('DROP TABLE scenario');
        $this->addSql('CREATE TABLE scenario (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, game_master_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, level NUMERIC(2, 0) NOT NULL, date DATETIME NOT NULL, description VARCHAR(1000) NOT NULL, img BLOB NOT NULL, post_link VARCHAR(255) NOT NULL, summary_link VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, nb_character NUMERIC(10, 0) NOT NULL, CONSTRAINT FK_3E45C8D8C1151A13 FOREIGN KEY (game_master_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO scenario (id, game_master_id, name, level, date, description, img, post_link, summary_link, status, nb_character) SELECT id, game_master_id, name, level, date, description, img, post_link, summary_link, status, nb_character FROM __temp__scenario');
        $this->addSql('DROP TABLE __temp__scenario');
        $this->addSql('CREATE INDEX IDX_3E45C8D8C1151A13 ON scenario (game_master_id)');
    }
}
