<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240209122109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE refresh_tokens_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE apartment (id UUID NOT NULL, building_id UUID NOT NULL, thumbnail_id UUID DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, address VARCHAR(255) NOT NULL, floor SMALLINT NOT NULL, rooms SMALLINT NOT NULL, price DOUBLE PRECISION NOT NULL, square DOUBLE PRECISION NOT NULL, living_square DOUBLE PRECISION NOT NULL, floors SMALLINT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4D7E68544D2A7E12 ON apartment (building_id)');
        $this->addSql('CREATE INDEX IDX_4D7E6854FDFF2E92 ON apartment (thumbnail_id)');
        $this->addSql('COMMENT ON COLUMN apartment.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN apartment.building_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN apartment.thumbnail_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE apartment_metadata (apartment_id UUID NOT NULL, metadata_id UUID NOT NULL, PRIMARY KEY(apartment_id, metadata_id))');
        $this->addSql('CREATE INDEX IDX_42F568C4176DFE85 ON apartment_metadata (apartment_id)');
        $this->addSql('CREATE INDEX IDX_42F568C4DC9EE959 ON apartment_metadata (metadata_id)');
        $this->addSql('COMMENT ON COLUMN apartment_metadata.apartment_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN apartment_metadata.metadata_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE building (id UUID NOT NULL, thumbnail_id UUID DEFAULT NULL, title VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, floors SMALLINT NOT NULL, year SMALLINT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E16F61D4FDFF2E92 ON building (thumbnail_id)');
        $this->addSql('COMMENT ON COLUMN building.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN building.thumbnail_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE building_metadata (building_id UUID NOT NULL, metadata_id UUID NOT NULL, PRIMARY KEY(building_id, metadata_id))');
        $this->addSql('CREATE INDEX IDX_9498354F4D2A7E12 ON building_metadata (building_id)');
        $this->addSql('CREATE INDEX IDX_9498354FDC9EE959 ON building_metadata (metadata_id)');
        $this->addSql('COMMENT ON COLUMN building_metadata.building_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN building_metadata.metadata_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE media (id UUID NOT NULL, type VARCHAR(255) NOT NULL, image_size INT NOT NULL, image_name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN media.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE metadata (id UUID NOT NULL, key VARCHAR(255) NOT NULL, value TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN metadata.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE refresh_tokens (id INT NOT NULL, refresh_token VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, valid TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE apartment ADD CONSTRAINT FK_4D7E68544D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE apartment ADD CONSTRAINT FK_4D7E6854FDFF2E92 FOREIGN KEY (thumbnail_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE apartment_metadata ADD CONSTRAINT FK_42F568C4176DFE85 FOREIGN KEY (apartment_id) REFERENCES apartment (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE apartment_metadata ADD CONSTRAINT FK_42F568C4DC9EE959 FOREIGN KEY (metadata_id) REFERENCES metadata (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE building ADD CONSTRAINT FK_E16F61D4FDFF2E92 FOREIGN KEY (thumbnail_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE building_metadata ADD CONSTRAINT FK_9498354F4D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE building_metadata ADD CONSTRAINT FK_9498354FDC9EE959 FOREIGN KEY (metadata_id) REFERENCES metadata (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE refresh_tokens_id_seq CASCADE');
        $this->addSql('ALTER TABLE apartment DROP CONSTRAINT FK_4D7E68544D2A7E12');
        $this->addSql('ALTER TABLE apartment DROP CONSTRAINT FK_4D7E6854FDFF2E92');
        $this->addSql('ALTER TABLE apartment_metadata DROP CONSTRAINT FK_42F568C4176DFE85');
        $this->addSql('ALTER TABLE apartment_metadata DROP CONSTRAINT FK_42F568C4DC9EE959');
        $this->addSql('ALTER TABLE building DROP CONSTRAINT FK_E16F61D4FDFF2E92');
        $this->addSql('ALTER TABLE building_metadata DROP CONSTRAINT FK_9498354F4D2A7E12');
        $this->addSql('ALTER TABLE building_metadata DROP CONSTRAINT FK_9498354FDC9EE959');
        $this->addSql('DROP TABLE apartment');
        $this->addSql('DROP TABLE apartment_metadata');
        $this->addSql('DROP TABLE building');
        $this->addSql('DROP TABLE building_metadata');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE metadata');
        $this->addSql('DROP TABLE refresh_tokens');
    }
}
