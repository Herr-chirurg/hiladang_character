<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251030021715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE token_audit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs CLOB DEFAULT NULL --(DC2Type:json)
        , blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX type_ae0e35fb98c6ffbe6b96ebe705068a21_idx ON token_audit (type)');
        $this->addSql('CREATE INDEX object_id_ae0e35fb98c6ffbe6b96ebe705068a21_idx ON token_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_ae0e35fb98c6ffbe6b96ebe705068a21_idx ON token_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_ae0e35fb98c6ffbe6b96ebe705068a21_idx ON token_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_ae0e35fb98c6ffbe6b96ebe705068a21_idx ON token_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_ae0e35fb98c6ffbe6b96ebe705068a21_idx ON token_audit (created_at)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__token AS SELECT id, scenario_id, character_id, owner_user_id, name, type, usage_rate, date_of_reception, total_rate, delta_pr FROM token');
        $this->addSql('DROP TABLE token');
        $this->addSql('CREATE TABLE token (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, scenario_id INTEGER DEFAULT NULL, character_id INTEGER DEFAULT NULL, owner_user_id INTEGER DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, usage_rate INTEGER DEFAULT NULL, date_of_reception DATETIME DEFAULT NULL, total_rate NUMERIC(10, 0) DEFAULT NULL, delta_pr INTEGER DEFAULT NULL, CONSTRAINT FK_5F37A13BE04E49DF FOREIGN KEY (scenario_id) REFERENCES scenario (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5F37A13B1136BE75 FOREIGN KEY (character_id) REFERENCES character (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5F37A13B2B18554A FOREIGN KEY (owner_user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO token (id, scenario_id, character_id, owner_user_id, name, type, usage_rate, date_of_reception, total_rate, delta_pr) SELECT id, scenario_id, character_id, owner_user_id, name, type, usage_rate, date_of_reception, total_rate, delta_pr FROM __temp__token');
        $this->addSql('DROP TABLE __temp__token');
        $this->addSql('CREATE INDEX IDX_5F37A13BE04E49DF ON token (scenario_id)');
        $this->addSql('CREATE INDEX IDX_5F37A13B1136BE75 ON token (character_id)');
        $this->addSql('CREATE INDEX IDX_5F37A13B2B18554A ON token (owner_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE token_audit');
        $this->addSql('CREATE TEMPORARY TABLE __temp__token AS SELECT id, scenario_id, character_id, owner_user_id, name, type, usage_rate, delta_pr, date_of_reception, total_rate FROM token');
        $this->addSql('DROP TABLE token');
        $this->addSql('CREATE TABLE token (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, scenario_id INTEGER DEFAULT NULL, character_id INTEGER DEFAULT NULL, owner_user_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, usage_rate INTEGER DEFAULT NULL, delta_pr INTEGER DEFAULT NULL, date_of_reception DATETIME DEFAULT NULL, total_rate NUMERIC(10, 0) DEFAULT NULL, CONSTRAINT FK_5F37A13BE04E49DF FOREIGN KEY (scenario_id) REFERENCES scenario (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5F37A13B1136BE75 FOREIGN KEY (character_id) REFERENCES character (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5F37A13B2B18554A FOREIGN KEY (owner_user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO token (id, scenario_id, character_id, owner_user_id, name, type, usage_rate, delta_pr, date_of_reception, total_rate) SELECT id, scenario_id, character_id, owner_user_id, name, type, usage_rate, delta_pr, date_of_reception, total_rate FROM __temp__token');
        $this->addSql('DROP TABLE __temp__token');
        $this->addSql('CREATE INDEX IDX_5F37A13BE04E49DF ON token (scenario_id)');
        $this->addSql('CREATE INDEX IDX_5F37A13B1136BE75 ON token (character_id)');
        $this->addSql('CREATE INDEX IDX_5F37A13B2B18554A ON token (owner_user_id)');
    }
}
