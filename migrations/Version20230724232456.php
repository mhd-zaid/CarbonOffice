<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230724232456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE discussion_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE dispense_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE formation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE mentor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE mission_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE participations_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planning_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE post_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reward_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE technology_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE discussion (id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, technlogy_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE dispense (id INT NOT NULL, mentor_id INT NOT NULL, formation_id INT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE formation (id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, duration INT NOT NULL, requirements VARCHAR(255) NOT NULL, technologies VARCHAR(255) NOT NULL, reward_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE mentor (id INT NOT NULL, user_id INT NOT NULL, formation_id INT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE mission (id INT NOT NULL, user_id INT NOT NULL, company VARCHAR(255) NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, description VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE participations (id INT NOT NULL, mentor_id INT NOT NULL, user_id INT NOT NULL, formation_id INT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE planning (id INT NOT NULL, date DATE NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, place VARCHAR(255) NOT NULL, user_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE post (id INT NOT NULL, user_id INT NOT NULL, date DATE NOT NULL, message VARCHAR(255) NOT NULL, discussion_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE reward (id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE technology (id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE "user" ADD firstname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD lastname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD age INT NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD phone VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD address VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD city VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD zip_code INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE discussion_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE dispense_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE formation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE mentor_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE mission_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE participations_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planning_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE post_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reward_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE technology_id_seq CASCADE');
        $this->addSql('DROP TABLE discussion');
        $this->addSql('DROP TABLE dispense');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE mentor');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP TABLE participations');
        $this->addSql('DROP TABLE planning');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE reward');
        $this->addSql('DROP TABLE technology');
        $this->addSql('ALTER TABLE "user" DROP firstname');
        $this->addSql('ALTER TABLE "user" DROP lastname');
        $this->addSql('ALTER TABLE "user" DROP age');
        $this->addSql('ALTER TABLE "user" DROP phone');
        $this->addSql('ALTER TABLE "user" DROP address');
        $this->addSql('ALTER TABLE "user" DROP city');
        $this->addSql('ALTER TABLE "user" DROP zip_code');
    }
}
