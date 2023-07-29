<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230729222048 extends AbstractMigration
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
        $this->addSql('CREATE SEQUENCE planning_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE post_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE public_holiday_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reward_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE skills_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE discussion (id INT NOT NULL, skill_id INT DEFAULT NULL, title VARCHAR(300) NOT NULL, description VARCHAR(1000) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C0B9F90F5585C142 ON discussion (skill_id)');
        $this->addSql('CREATE TABLE dispense (id INT NOT NULL, mentor_id INT DEFAULT NULL, formation_id INT DEFAULT NULL, date DATE NOT NULL, start_time TIME(0) WITHOUT TIME ZONE NOT NULL, link VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2CB2B947DB403044 ON dispense (mentor_id)');
        $this->addSql('CREATE INDEX IDX_2CB2B9475200282E ON dispense (formation_id)');
        $this->addSql('CREATE TABLE dispense_user (dispense_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(dispense_id, user_id))');
        $this->addSql('CREATE INDEX IDX_A5F462CB3FC9908 ON dispense_user (dispense_id)');
        $this->addSql('CREATE INDEX IDX_A5F462CBA76ED395 ON dispense_user (user_id)');
        $this->addSql('CREATE TABLE formation (id INT NOT NULL, reward_id INT DEFAULT NULL, title VARCHAR(300) NOT NULL, description VARCHAR(1000) NOT NULL, duration INT NOT NULL, requirements VARCHAR(1000) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_404021BFE466ACA1 ON formation (reward_id)');
        $this->addSql('CREATE TABLE formation_skills (formation_id INT NOT NULL, skills_id INT NOT NULL, PRIMARY KEY(formation_id, skills_id))');
        $this->addSql('CREATE INDEX IDX_F528185D5200282E ON formation_skills (formation_id)');
        $this->addSql('CREATE INDEX IDX_F528185D7FF61858 ON formation_skills (skills_id)');
        $this->addSql('CREATE TABLE mentor (id INT NOT NULL, consultant_id INT DEFAULT NULL, formation_id INT DEFAULT NULL, status BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_801562DE44F779A2 ON mentor (consultant_id)');
        $this->addSql('CREATE INDEX IDX_801562DE5200282E ON mentor (formation_id)');
        $this->addSql('CREATE TABLE mission (id INT NOT NULL, manager_id INT DEFAULT NULL, company VARCHAR(255) NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, description VARCHAR(1000) NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9067F23C783E3463 ON mission (manager_id)');
        $this->addSql('CREATE TABLE mission_user (mission_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(mission_id, user_id))');
        $this->addSql('CREATE INDEX IDX_A4D17A46BE6CAE90 ON mission_user (mission_id)');
        $this->addSql('CREATE INDEX IDX_A4D17A46A76ED395 ON mission_user (user_id)');
        $this->addSql('CREATE TABLE planning (id INT NOT NULL, consultant_id INT DEFAULT NULL, date_start DATE NOT NULL, date_end DATE NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D499BFF644F779A2 ON planning (consultant_id)');
        $this->addSql('CREATE TABLE post (id INT NOT NULL, employee_id INT DEFAULT NULL, discussion_id INT DEFAULT NULL, date DATE NOT NULL, message VARCHAR(1000) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D8C03F15C ON post (employee_id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D1ADED311 ON post (discussion_id)');
        $this->addSql('CREATE TABLE public_holiday (id INT NOT NULL, date DATE NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE reward (id INT NOT NULL, dispense_id INT DEFAULT NULL, consultant_id INT DEFAULT NULL, level INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4ED172533FC9908 ON reward (dispense_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4ED1725344F779A2 ON reward (consultant_id)');
        $this->addSql('CREATE TABLE skills (id INT NOT NULL, title VARCHAR(1000) NOT NULL, description VARCHAR(1000) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, age INT NOT NULL, phone VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, zip_code INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE TABLE user_skills (user_id INT NOT NULL, skills_id INT NOT NULL, PRIMARY KEY(user_id, skills_id))');
        $this->addSql('CREATE INDEX IDX_B0630D4DA76ED395 ON user_skills (user_id)');
        $this->addSql('CREATE INDEX IDX_B0630D4D7FF61858 ON user_skills (skills_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90F5585C142 FOREIGN KEY (skill_id) REFERENCES skills (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dispense ADD CONSTRAINT FK_2CB2B947DB403044 FOREIGN KEY (mentor_id) REFERENCES mentor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dispense ADD CONSTRAINT FK_2CB2B9475200282E FOREIGN KEY (formation_id) REFERENCES formation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dispense_user ADD CONSTRAINT FK_A5F462CB3FC9908 FOREIGN KEY (dispense_id) REFERENCES dispense (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dispense_user ADD CONSTRAINT FK_A5F462CBA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BFE466ACA1 FOREIGN KEY (reward_id) REFERENCES reward (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE formation_skills ADD CONSTRAINT FK_F528185D5200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE formation_skills ADD CONSTRAINT FK_F528185D7FF61858 FOREIGN KEY (skills_id) REFERENCES skills (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mentor ADD CONSTRAINT FK_801562DE44F779A2 FOREIGN KEY (consultant_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mentor ADD CONSTRAINT FK_801562DE5200282E FOREIGN KEY (formation_id) REFERENCES formation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C783E3463 FOREIGN KEY (manager_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mission_user ADD CONSTRAINT FK_A4D17A46BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mission_user ADD CONSTRAINT FK_A4D17A46A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF644F779A2 FOREIGN KEY (consultant_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D8C03F15C FOREIGN KEY (employee_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D1ADED311 FOREIGN KEY (discussion_id) REFERENCES discussion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED172533FC9908 FOREIGN KEY (dispense_id) REFERENCES dispense (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED1725344F779A2 FOREIGN KEY (consultant_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_skills ADD CONSTRAINT FK_B0630D4DA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_skills ADD CONSTRAINT FK_B0630D4D7FF61858 FOREIGN KEY (skills_id) REFERENCES skills (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
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
        $this->addSql('DROP SEQUENCE planning_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE post_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE public_holiday_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reward_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE skills_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE discussion DROP CONSTRAINT FK_C0B9F90F5585C142');
        $this->addSql('ALTER TABLE dispense DROP CONSTRAINT FK_2CB2B947DB403044');
        $this->addSql('ALTER TABLE dispense DROP CONSTRAINT FK_2CB2B9475200282E');
        $this->addSql('ALTER TABLE dispense_user DROP CONSTRAINT FK_A5F462CB3FC9908');
        $this->addSql('ALTER TABLE dispense_user DROP CONSTRAINT FK_A5F462CBA76ED395');
        $this->addSql('ALTER TABLE formation DROP CONSTRAINT FK_404021BFE466ACA1');
        $this->addSql('ALTER TABLE formation_skills DROP CONSTRAINT FK_F528185D5200282E');
        $this->addSql('ALTER TABLE formation_skills DROP CONSTRAINT FK_F528185D7FF61858');
        $this->addSql('ALTER TABLE mentor DROP CONSTRAINT FK_801562DE44F779A2');
        $this->addSql('ALTER TABLE mentor DROP CONSTRAINT FK_801562DE5200282E');
        $this->addSql('ALTER TABLE mission DROP CONSTRAINT FK_9067F23C783E3463');
        $this->addSql('ALTER TABLE mission_user DROP CONSTRAINT FK_A4D17A46BE6CAE90');
        $this->addSql('ALTER TABLE mission_user DROP CONSTRAINT FK_A4D17A46A76ED395');
        $this->addSql('ALTER TABLE planning DROP CONSTRAINT FK_D499BFF644F779A2');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8D8C03F15C');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8D1ADED311');
        $this->addSql('ALTER TABLE reward DROP CONSTRAINT FK_4ED172533FC9908');
        $this->addSql('ALTER TABLE reward DROP CONSTRAINT FK_4ED1725344F779A2');
        $this->addSql('ALTER TABLE user_skills DROP CONSTRAINT FK_B0630D4DA76ED395');
        $this->addSql('ALTER TABLE user_skills DROP CONSTRAINT FK_B0630D4D7FF61858');
        $this->addSql('DROP TABLE discussion');
        $this->addSql('DROP TABLE dispense');
        $this->addSql('DROP TABLE dispense_user');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE formation_skills');
        $this->addSql('DROP TABLE mentor');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP TABLE mission_user');
        $this->addSql('DROP TABLE planning');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE public_holiday');
        $this->addSql('DROP TABLE reward');
        $this->addSql('DROP TABLE skills');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_skills');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
