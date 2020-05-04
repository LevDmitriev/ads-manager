<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200504173121 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_79FA29EA76ED395');
        $this->addSql('DROP INDEX UNIQ_79FA29EC5020C33');
        $this->addSql('DROP INDEX UNIQ_79FA29E8BAC62AF');
        $this->addSql('DROP INDEX UNIQ_79FA29EB08FA272');
        $this->addSql('DROP INDEX UNIQ_79FA29E3922F2F5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__you_renta_advertisement AS SELECT id, object_type_id, city_id, district_id, guest_count_id, user_id, street, building_number, rooms_number, price_day, price_night, price_hour, price_wedding, floor, floors_count, total_area, first_phone, second_phone, internet, conditioner, washer, parking, description, rent_conditions, rent_conditions_wedding, you_tube FROM you_renta_advertisement');
        $this->addSql('DROP TABLE you_renta_advertisement');
        $this->addSql('CREATE TABLE you_renta_advertisement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, object_type_id INTEGER NOT NULL, city_id INTEGER NOT NULL, district_id INTEGER NOT NULL, guest_count_id INTEGER NOT NULL, user_id INTEGER NOT NULL, street VARCHAR(255) NOT NULL COLLATE BINARY, building_number VARCHAR(255) NOT NULL COLLATE BINARY, rooms_number SMALLINT NOT NULL, price_day INTEGER NOT NULL, price_night INTEGER DEFAULT NULL, price_hour INTEGER DEFAULT NULL, price_wedding INTEGER DEFAULT NULL, floor INTEGER DEFAULT NULL, floors_count INTEGER DEFAULT NULL, total_area DOUBLE PRECISION DEFAULT NULL, first_phone VARCHAR(255) NOT NULL COLLATE BINARY, second_phone VARCHAR(255) DEFAULT NULL COLLATE BINARY, internet BOOLEAN NOT NULL, conditioner BOOLEAN NOT NULL, washer BOOLEAN NOT NULL, parking BOOLEAN NOT NULL, description CLOB DEFAULT NULL COLLATE BINARY, rent_conditions CLOB DEFAULT NULL COLLATE BINARY, rent_conditions_wedding CLOB DEFAULT NULL COLLATE BINARY, you_tube CLOB DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_79FA29EC5020C33 FOREIGN KEY (object_type_id) REFERENCES you_renta_object_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_79FA29E8BAC62AF FOREIGN KEY (city_id) REFERENCES you_renta_city (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_79FA29EB08FA272 FOREIGN KEY (district_id) REFERENCES you_renta_city_district (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_79FA29E3922F2F5 FOREIGN KEY (guest_count_id) REFERENCES you_renta_guest_count (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_79FA29EA76ED395 FOREIGN KEY (user_id) REFERENCES you_renta_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO you_renta_advertisement (id, object_type_id, city_id, district_id, guest_count_id, user_id, street, building_number, rooms_number, price_day, price_night, price_hour, price_wedding, floor, floors_count, total_area, first_phone, second_phone, internet, conditioner, washer, parking, description, rent_conditions, rent_conditions_wedding, you_tube) SELECT id, object_type_id, city_id, district_id, guest_count_id, user_id, street, building_number, rooms_number, price_day, price_night, price_hour, price_wedding, floor, floors_count, total_area, first_phone, second_phone, internet, conditioner, washer, parking, description, rent_conditions, rent_conditions_wedding, you_tube FROM __temp__you_renta_advertisement');
        $this->addSql('DROP TABLE __temp__you_renta_advertisement');
        $this->addSql('CREATE INDEX IDX_79FA29EA76ED395 ON you_renta_advertisement (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_79FA29EC5020C33 ON you_renta_advertisement (object_type_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_79FA29E8BAC62AF ON you_renta_advertisement (city_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_79FA29EB08FA272 ON you_renta_advertisement (district_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_79FA29E3922F2F5 ON you_renta_advertisement (guest_count_id)');
        $this->addSql('DROP INDEX IDX_53683436A1FBF71B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__you_renta_advertisement_photo AS SELECT id, advertisement_id, image, updated_at, created_at FROM you_renta_advertisement_photo');
        $this->addSql('DROP TABLE you_renta_advertisement_photo');
        $this->addSql('CREATE TABLE you_renta_advertisement_photo (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, advertisement_id INTEGER NOT NULL, image VARCHAR(255) NOT NULL COLLATE BINARY, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, CONSTRAINT FK_53683436A1FBF71B FOREIGN KEY (advertisement_id) REFERENCES you_renta_advertisement (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO you_renta_advertisement_photo (id, advertisement_id, image, updated_at, created_at) SELECT id, advertisement_id, image, updated_at, created_at FROM __temp__you_renta_advertisement_photo');
        $this->addSql('DROP TABLE __temp__you_renta_advertisement_photo');
        $this->addSql('CREATE INDEX IDX_53683436A1FBF71B ON you_renta_advertisement_photo (advertisement_id)');
        $this->addSql('DROP INDEX IDX_7AD9E4918BAC62AF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__you_renta_city_district AS SELECT id, city_id, name, value FROM you_renta_city_district');
        $this->addSql('DROP TABLE you_renta_city_district');
        $this->addSql('CREATE TABLE you_renta_city_district (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, value VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_7AD9E4918BAC62AF FOREIGN KEY (city_id) REFERENCES you_renta_city (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO you_renta_city_district (id, city_id, name, value) SELECT id, city_id, name, value FROM __temp__you_renta_city_district');
        $this->addSql('DROP TABLE __temp__you_renta_city_district');
        $this->addSql('CREATE INDEX IDX_7AD9E4918BAC62AF ON you_renta_city_district (city_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_79FA29EC5020C33');
        $this->addSql('DROP INDEX UNIQ_79FA29E8BAC62AF');
        $this->addSql('DROP INDEX UNIQ_79FA29EB08FA272');
        $this->addSql('DROP INDEX UNIQ_79FA29E3922F2F5');
        $this->addSql('DROP INDEX IDX_79FA29EA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__you_renta_advertisement AS SELECT id, object_type_id, city_id, district_id, guest_count_id, user_id, street, building_number, rooms_number, price_day, price_night, price_hour, price_wedding, floor, floors_count, total_area, first_phone, second_phone, internet, conditioner, washer, parking, description, rent_conditions, rent_conditions_wedding, you_tube FROM you_renta_advertisement');
        $this->addSql('DROP TABLE you_renta_advertisement');
        $this->addSql('CREATE TABLE you_renta_advertisement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, object_type_id INTEGER NOT NULL, city_id INTEGER NOT NULL, district_id INTEGER NOT NULL, guest_count_id INTEGER NOT NULL, user_id INTEGER NOT NULL, street VARCHAR(255) NOT NULL, building_number VARCHAR(255) NOT NULL, rooms_number SMALLINT NOT NULL, price_day INTEGER NOT NULL, price_night INTEGER DEFAULT NULL, price_hour INTEGER DEFAULT NULL, price_wedding INTEGER DEFAULT NULL, floor INTEGER DEFAULT NULL, floors_count INTEGER DEFAULT NULL, total_area DOUBLE PRECISION DEFAULT NULL, first_phone VARCHAR(255) NOT NULL, second_phone VARCHAR(255) DEFAULT NULL, internet BOOLEAN NOT NULL, conditioner BOOLEAN NOT NULL, washer BOOLEAN NOT NULL, parking BOOLEAN NOT NULL, description CLOB DEFAULT NULL, rent_conditions CLOB DEFAULT NULL, rent_conditions_wedding CLOB DEFAULT NULL, you_tube CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO you_renta_advertisement (id, object_type_id, city_id, district_id, guest_count_id, user_id, street, building_number, rooms_number, price_day, price_night, price_hour, price_wedding, floor, floors_count, total_area, first_phone, second_phone, internet, conditioner, washer, parking, description, rent_conditions, rent_conditions_wedding, you_tube) SELECT id, object_type_id, city_id, district_id, guest_count_id, user_id, street, building_number, rooms_number, price_day, price_night, price_hour, price_wedding, floor, floors_count, total_area, first_phone, second_phone, internet, conditioner, washer, parking, description, rent_conditions, rent_conditions_wedding, you_tube FROM __temp__you_renta_advertisement');
        $this->addSql('DROP TABLE __temp__you_renta_advertisement');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_79FA29EC5020C33 ON you_renta_advertisement (object_type_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_79FA29E8BAC62AF ON you_renta_advertisement (city_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_79FA29EB08FA272 ON you_renta_advertisement (district_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_79FA29E3922F2F5 ON you_renta_advertisement (guest_count_id)');
        $this->addSql('CREATE INDEX IDX_79FA29EA76ED395 ON you_renta_advertisement (user_id)');
        $this->addSql('DROP INDEX IDX_53683436A1FBF71B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__you_renta_advertisement_photo AS SELECT id, advertisement_id, image, updated_at, created_at FROM you_renta_advertisement_photo');
        $this->addSql('DROP TABLE you_renta_advertisement_photo');
        $this->addSql('CREATE TABLE you_renta_advertisement_photo (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, advertisement_id INTEGER NOT NULL, image VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO you_renta_advertisement_photo (id, advertisement_id, image, updated_at, created_at) SELECT id, advertisement_id, image, updated_at, created_at FROM __temp__you_renta_advertisement_photo');
        $this->addSql('DROP TABLE __temp__you_renta_advertisement_photo');
        $this->addSql('CREATE INDEX IDX_53683436A1FBF71B ON you_renta_advertisement_photo (advertisement_id)');
        $this->addSql('DROP INDEX IDX_7AD9E4918BAC62AF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__you_renta_city_district AS SELECT id, city_id, name, value FROM you_renta_city_district');
        $this->addSql('DROP TABLE you_renta_city_district');
        $this->addSql('CREATE TABLE you_renta_city_district (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO you_renta_city_district (id, city_id, name, value) SELECT id, city_id, name, value FROM __temp__you_renta_city_district');
        $this->addSql('DROP TABLE __temp__you_renta_city_district');
        $this->addSql('CREATE INDEX IDX_7AD9E4918BAC62AF ON you_renta_city_district (city_id)');
    }
}
