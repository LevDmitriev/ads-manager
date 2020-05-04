<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200504114357 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__you_renta_city_district AS SELECT id, name, value FROM you_renta_city_district');
        $this->addSql('DROP TABLE you_renta_city_district');
        $this->addSql('CREATE TABLE you_renta_city_district (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, value VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_7AD9E4918BAC62AF FOREIGN KEY (city_id) REFERENCES you_renta_city (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO you_renta_city_district (id, name, value) SELECT id, name, value FROM __temp__you_renta_city_district');
        $this->addSql('DROP TABLE __temp__you_renta_city_district');
        $this->addSql('CREATE INDEX IDX_7AD9E4918BAC62AF ON you_renta_city_district (city_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_7AD9E4918BAC62AF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__you_renta_city_district AS SELECT id, name, value FROM you_renta_city_district');
        $this->addSql('DROP TABLE you_renta_city_district');
        $this->addSql('CREATE TABLE you_renta_city_district (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO you_renta_city_district (id, name, value) SELECT id, name, value FROM __temp__you_renta_city_district');
        $this->addSql('DROP TABLE __temp__you_renta_city_district');
    }
}
