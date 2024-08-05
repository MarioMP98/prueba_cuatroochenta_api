<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240805143311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE measuring_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sensor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE wine_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE measuring (id INT NOT NULL, sensor_id INT DEFAULT NULL, wine_id INT DEFAULT NULL, year INT DEFAULT NULL, color VARCHAR(255) DEFAULT NULL, temperature DOUBLE PRECISION DEFAULT NULL, graduation DOUBLE PRECISION DEFAULT NULL, ph DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_ECF3A169A247991F ON measuring (sensor_id)');
        $this->addSql('CREATE INDEX IDX_ECF3A16928A2BD76 ON measuring (wine_id)');
        $this->addSql('CREATE TABLE sensor (id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE wine (id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, year INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE measuring ADD CONSTRAINT FK_ECF3A169A247991F FOREIGN KEY (sensor_id) REFERENCES sensor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE measuring ADD CONSTRAINT FK_ECF3A16928A2BD76 FOREIGN KEY (wine_id) REFERENCES wine (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE measuring_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE sensor_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE wine_id_seq CASCADE');
        $this->addSql('ALTER TABLE measuring DROP CONSTRAINT FK_ECF3A169A247991F');
        $this->addSql('ALTER TABLE measuring DROP CONSTRAINT FK_ECF3A16928A2BD76');
        $this->addSql('DROP TABLE measuring');
        $this->addSql('DROP TABLE sensor');
        $this->addSql('DROP TABLE wine');
    }
}
