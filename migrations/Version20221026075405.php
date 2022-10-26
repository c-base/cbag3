<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221026075405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE artefact_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE asset_id_seq CASCADE');
        $this->addSql('CREATE TABLE artefact_image (artefact_id VARCHAR(255) NOT NULL, image_id VARCHAR(255) NOT NULL, PRIMARY KEY(artefact_id, image_id))');
        $this->addSql('CREATE INDEX IDX_336BA576B52412E3 ON artefact_image (artefact_id)');
        $this->addSql('CREATE INDEX IDX_336BA5763DA5256D ON artefact_image (image_id)');
        $this->addSql('ALTER TABLE artefact_image ADD CONSTRAINT FK_336BA576B52412E3 FOREIGN KEY (artefact_id) REFERENCES artefact (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE artefact_image ADD CONSTRAINT FK_336BA5763DA5256D FOREIGN KEY (image_id) REFERENCES asset (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE artefact ADD primary_image_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE artefact ALTER id TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE artefact ALTER created_at TYPE DATE');
        $this->addSql('COMMENT ON COLUMN artefact.created_at IS \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE artefact ADD CONSTRAINT FK_8D158D2D1CDA489C FOREIGN KEY (primary_image_id) REFERENCES asset (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D158D2D1CDA489C ON artefact (primary_image_id)');
        $this->addSql('ALTER TABLE asset DROP CONSTRAINT fk_2af5a5cb52412e3');
        $this->addSql('DROP INDEX idx_2af5a5cb52412e3');
        $this->addSql('ALTER TABLE asset DROP artefact_id');
        $this->addSql('ALTER TABLE asset ALTER id TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE asset ALTER created_at TYPE DATE');
        $this->addSql('ALTER TABLE asset ALTER created_at DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN asset.created_at IS \'(DC2Type:date_immutable)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2AF5A5CB548B0F ON asset (path)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE artefact_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE asset_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE artefact_image DROP CONSTRAINT FK_336BA576B52412E3');
        $this->addSql('ALTER TABLE artefact_image DROP CONSTRAINT FK_336BA5763DA5256D');
        $this->addSql('DROP TABLE artefact_image');
        $this->addSql('DROP INDEX UNIQ_2AF5A5CB548B0F');
        $this->addSql('ALTER TABLE asset ADD artefact_id INT NOT NULL');
        $this->addSql('ALTER TABLE asset ALTER id TYPE INT');
        $this->addSql('ALTER TABLE asset ALTER created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE asset ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('COMMENT ON COLUMN asset.created_at IS NULL');
        $this->addSql('ALTER TABLE asset ADD CONSTRAINT fk_2af5a5cb52412e3 FOREIGN KEY (artefact_id) REFERENCES artefact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_2af5a5cb52412e3 ON asset (artefact_id)');
        $this->addSql('ALTER TABLE artefact DROP CONSTRAINT FK_8D158D2D1CDA489C');
        $this->addSql('DROP INDEX UNIQ_8D158D2D1CDA489C');
        $this->addSql('ALTER TABLE artefact DROP primary_image_id');
        $this->addSql('ALTER TABLE artefact ALTER id TYPE INT');
        $this->addSql('ALTER TABLE artefact ALTER created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('COMMENT ON COLUMN artefact.created_at IS NULL');
    }
}
