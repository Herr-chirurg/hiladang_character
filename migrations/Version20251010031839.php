<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251010031839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__log AS SELECT id, item_type, item_id, created_at, field_name, old_value, new_value, description, user_id FROM log');
        $this->addSql('DROP TABLE log');
        $this->addSql('CREATE TABLE log (id VARCHAR(255) NOT NULL, item_type VARCHAR(255) NOT NULL, item_id INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , field_name VARCHAR(255) NOT NULL, old_value VARCHAR(1000) DEFAULT NULL, new_value VARCHAR(1000) DEFAULT NULL, description VARCHAR(255) NOT NULL, user_id VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO log (id, item_type, item_id, created_at, field_name, old_value, new_value, description, user_id) SELECT id, item_type, item_id, created_at, field_name, old_value, new_value, description, user_id FROM __temp__log');
        $this->addSql('DROP TABLE __temp__log');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__log AS SELECT id, item_type, item_id, created_at, field_name, old_value, new_value, description, user_id FROM log');
        $this->addSql('DROP TABLE log');
        $this->addSql('CREATE TABLE log (id VARCHAR(255) NOT NULL, item_type VARCHAR(255) NOT NULL, item_id INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , field_name VARCHAR(255) NOT NULL, old_value VARCHAR(1000) DEFAULT NULL, new_value VARCHAR(1000) DEFAULT NULL, description VARCHAR(255) NOT NULL, user_id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO log (id, item_type, item_id, created_at, field_name, old_value, new_value, description, user_id) SELECT id, item_type, item_id, created_at, field_name, old_value, new_value, description, user_id FROM __temp__log');
        $this->addSql('DROP TABLE __temp__log');
    }
}
