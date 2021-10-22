<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211021154344 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE artefact_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE asset_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE artefact (id INT NOT NULL, name VARCHAR(255) NOT NULL, c_name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_by VARCHAR(32) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D158D2D5E237E06 ON artefact (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D158D2DFA862557 ON artefact (c_name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D158D2D989D9B62 ON artefact (slug)');
        $this->addSql('CREATE TABLE asset (id INT NOT NULL, artefact_id INT NOT NULL, path VARCHAR(255) NOT NULL, description TEXT NOT NULL, author VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, licence VARCHAR(25) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2AF5A5CB52412E3 ON asset (artefact_id)');
        $this->addSql('ALTER TABLE asset ADD CONSTRAINT FK_2AF5A5CB52412E3 FOREIGN KEY (artefact_id) REFERENCES artefact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE asset DROP CONSTRAINT FK_2AF5A5CB52412E3');
        $this->addSql('DROP SEQUENCE artefact_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE asset_id_seq CASCADE');
        $this->addSql('DROP TABLE artefact');
        $this->addSql('DROP TABLE asset');
    }
}
