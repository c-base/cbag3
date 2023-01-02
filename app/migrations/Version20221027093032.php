<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221027093032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('CREATE TABLE artefact_image (artefact_id VARCHAR(255) NOT NULL, image_id VARCHAR(255) NOT NULL, PRIMARY KEY(artefact_id, image_id))');
        $this->addSql('CREATE INDEX idx_336ba5763da5256d ON artefact_image (image_id)');
        $this->addSql('CREATE INDEX idx_336ba576b52412e3 ON artefact_image (artefact_id)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('CREATE TABLE artefact (id VARCHAR(255) NOT NULL, primary_image_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, c_name VARCHAR(255) NOT NULL, description TEXT NOT NULL, created_at DATE NOT NULL, slug VARCHAR(255) NOT NULL, created_by VARCHAR(32) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d158d2d1cda489c ON artefact (primary_image_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d158d2d989d9b62 ON artefact (slug)');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d158d2dfa862557 ON artefact (c_name)');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d158d2d5e237e06 ON artefact (name)');
        $this->addSql('COMMENT ON COLUMN artefact.created_at IS \'(DC2Type:date_immutable)\'');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('CREATE TABLE image (id VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, description TEXT NOT NULL, author VARCHAR(255) NOT NULL, created_at DATE NOT NULL, licence VARCHAR(25) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_c53d045fb548b0f ON image (path)');
        $this->addSql('COMMENT ON COLUMN image.created_at IS \'(DC2Type:date_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('DROP TABLE artefact_image');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('DROP TABLE artefact');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('DROP TABLE image');
    }
}
