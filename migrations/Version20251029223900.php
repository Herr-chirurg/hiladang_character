<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251029223900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE token ADD COLUMN total_rate NUMERIC(10, 0) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__token AS SELECT id, scenario_id, character_id, owner_user_id, name, type, usage_rate, value, value_pr, date_of_reception FROM token');
        $this->addSql('DROP TABLE token');
        $this->addSql('CREATE TABLE token (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, scenario_id INTEGER DEFAULT NULL, character_id INTEGER DEFAULT NULL, owner_user_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, usage_rate INTEGER NOT NULL, value INTEGER NOT NULL, value_pr INTEGER NOT NULL, date_of_reception DATETIME NOT NULL, CONSTRAINT FK_5F37A13BE04E49DF FOREIGN KEY (scenario_id) REFERENCES scenario (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5F37A13B1136BE75 FOREIGN KEY (character_id) REFERENCES character (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5F37A13B2B18554A FOREIGN KEY (owner_user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO token (id, scenario_id, character_id, owner_user_id, name, type, usage_rate, value, value_pr, date_of_reception) SELECT id, scenario_id, character_id, owner_user_id, name, type, usage_rate, value, value_pr, date_of_reception FROM __temp__token');
        $this->addSql('DROP TABLE __temp__token');
        $this->addSql('CREATE INDEX IDX_5F37A13BE04E49DF ON token (scenario_id)');
        $this->addSql('CREATE INDEX IDX_5F37A13B1136BE75 ON token (character_id)');
        $this->addSql('CREATE INDEX IDX_5F37A13B2B18554A ON token (owner_user_id)');
    }
}
