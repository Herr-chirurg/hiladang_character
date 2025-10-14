<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251014020627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE building_audit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs CLOB DEFAULT NULL --(DC2Type:json)
        , blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX type_d09ea8237d0f3efadd73c7c32a2a77a1_idx ON building_audit (type)');
        $this->addSql('CREATE INDEX object_id_d09ea8237d0f3efadd73c7c32a2a77a1_idx ON building_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_d09ea8237d0f3efadd73c7c32a2a77a1_idx ON building_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_d09ea8237d0f3efadd73c7c32a2a77a1_idx ON building_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_d09ea8237d0f3efadd73c7c32a2a77a1_idx ON building_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_d09ea8237d0f3efadd73c7c32a2a77a1_idx ON building_audit (created_at)');
        $this->addSql('CREATE TABLE character_audit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs CLOB DEFAULT NULL --(DC2Type:json)
        , blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX type_bb9718fea5a5f3e82edc5f9b0ad8671c_idx ON character_audit (type)');
        $this->addSql('CREATE INDEX object_id_bb9718fea5a5f3e82edc5f9b0ad8671c_idx ON character_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_bb9718fea5a5f3e82edc5f9b0ad8671c_idx ON character_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_bb9718fea5a5f3e82edc5f9b0ad8671c_idx ON character_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_bb9718fea5a5f3e82edc5f9b0ad8671c_idx ON character_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_bb9718fea5a5f3e82edc5f9b0ad8671c_idx ON character_audit (created_at)');
        $this->addSql('CREATE TABLE scenario_audit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs CLOB DEFAULT NULL --(DC2Type:json)
        , blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX type_aa42ee6d27754f827714c5a2d71970cc_idx ON scenario_audit (type)');
        $this->addSql('CREATE INDEX object_id_aa42ee6d27754f827714c5a2d71970cc_idx ON scenario_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_aa42ee6d27754f827714c5a2d71970cc_idx ON scenario_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_aa42ee6d27754f827714c5a2d71970cc_idx ON scenario_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_aa42ee6d27754f827714c5a2d71970cc_idx ON scenario_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_aa42ee6d27754f827714c5a2d71970cc_idx ON scenario_audit (created_at)');
        $this->addSql('CREATE TABLE user_audit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs CLOB DEFAULT NULL --(DC2Type:json)
        , blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX type_e06395edc291d0719bee26fd39a32e8a_idx ON user_audit (type)');
        $this->addSql('CREATE INDEX object_id_e06395edc291d0719bee26fd39a32e8a_idx ON user_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_e06395edc291d0719bee26fd39a32e8a_idx ON user_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_e06395edc291d0719bee26fd39a32e8a_idx ON user_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_e06395edc291d0719bee26fd39a32e8a_idx ON user_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_e06395edc291d0719bee26fd39a32e8a_idx ON user_audit (created_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE building_audit');
        $this->addSql('DROP TABLE character_audit');
        $this->addSql('DROP TABLE scenario_audit');
        $this->addSql('DROP TABLE user_audit');
    }
}
