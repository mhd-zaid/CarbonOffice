<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230725122834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE technology_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE public_holiday_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE skills_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE public_holiday (id INT NOT NULL, date DATE NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE skills (id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE technology');
        $this->addSql('ALTER TABLE dispense ADD link VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE formation RENAME COLUMN technologies TO skills');
        $this->addSql('ALTER TABLE participations RENAME COLUMN formation_id TO dispense_id');
        $this->addSql('ALTER TABLE planning ADD start_time DATE NOT NULL');
        $this->addSql('ALTER TABLE planning ADD end_time DATE NOT NULL');
        $this->addSql('ALTER TABLE planning DROP start_date');
        $this->addSql('ALTER TABLE planning DROP end_date');
        $this->addSql('ALTER TABLE planning RENAME COLUMN place TO type');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE public_holiday_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE skills_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE technology_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE technology (id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE public_holiday');
        $this->addSql('DROP TABLE skills');
        $this->addSql('ALTER TABLE dispense DROP link');
        $this->addSql('ALTER TABLE participations RENAME COLUMN dispense_id TO formation_id');
        $this->addSql('ALTER TABLE planning ADD start_date DATE NOT NULL');
        $this->addSql('ALTER TABLE planning ADD end_date DATE NOT NULL');
        $this->addSql('ALTER TABLE planning DROP start_time');
        $this->addSql('ALTER TABLE planning DROP end_time');
        $this->addSql('ALTER TABLE planning RENAME COLUMN type TO place');
        $this->addSql('ALTER TABLE formation RENAME COLUMN skills TO technologies');
    }
}
