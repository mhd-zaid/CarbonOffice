<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230725212453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dispense_user (dispense_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(dispense_id, user_id))');
        $this->addSql('CREATE INDEX IDX_A5F462CB3FC9908 ON dispense_user (dispense_id)');
        $this->addSql('CREATE INDEX IDX_A5F462CBA76ED395 ON dispense_user (user_id)');
        $this->addSql('CREATE TABLE dispense_formation (dispense_id INT NOT NULL, formation_id INT NOT NULL, PRIMARY KEY(dispense_id, formation_id))');
        $this->addSql('CREATE INDEX IDX_9B3688F3FC9908 ON dispense_formation (dispense_id)');
        $this->addSql('CREATE INDEX IDX_9B3688F5200282E ON dispense_formation (formation_id)');
        $this->addSql('CREATE TABLE mission_user (mission_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(mission_id, user_id))');
        $this->addSql('CREATE INDEX IDX_A4D17A46BE6CAE90 ON mission_user (mission_id)');
        $this->addSql('CREATE INDEX IDX_A4D17A46A76ED395 ON mission_user (user_id)');
        $this->addSql('CREATE TABLE participations_dispense (participations_id INT NOT NULL, dispense_id INT NOT NULL, PRIMARY KEY(participations_id, dispense_id))');
        $this->addSql('CREATE INDEX IDX_399431122E175398 ON participations_dispense (participations_id)');
        $this->addSql('CREATE INDEX IDX_399431123FC9908 ON participations_dispense (dispense_id)');
        $this->addSql('CREATE TABLE participations_mentor (participation_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(participation_id, user_id))');
        $this->addSql('CREATE INDEX IDX_9C8143856ACE3B73 ON participations_mentor (participation_id)');
        $this->addSql('CREATE INDEX IDX_9C814385A76ED395 ON participations_mentor (user_id)');
        $this->addSql('CREATE TABLE participations_consultant (participation_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(participation_id, user_id))');
        $this->addSql('CREATE INDEX IDX_60BD35846ACE3B73 ON participations_consultant (participation_id)');
        $this->addSql('CREATE INDEX IDX_60BD3584A76ED395 ON participations_consultant (user_id)');
        $this->addSql('ALTER TABLE dispense_user ADD CONSTRAINT FK_A5F462CB3FC9908 FOREIGN KEY (dispense_id) REFERENCES dispense (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dispense_user ADD CONSTRAINT FK_A5F462CBA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dispense_formation ADD CONSTRAINT FK_9B3688F3FC9908 FOREIGN KEY (dispense_id) REFERENCES dispense (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dispense_formation ADD CONSTRAINT FK_9B3688F5200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mission_user ADD CONSTRAINT FK_A4D17A46BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mission_user ADD CONSTRAINT FK_A4D17A46A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participations_dispense ADD CONSTRAINT FK_399431122E175398 FOREIGN KEY (participations_id) REFERENCES participations (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participations_dispense ADD CONSTRAINT FK_399431123FC9908 FOREIGN KEY (dispense_id) REFERENCES dispense (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participations_mentor ADD CONSTRAINT FK_9C8143856ACE3B73 FOREIGN KEY (participation_id) REFERENCES participations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participations_mentor ADD CONSTRAINT FK_9C814385A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participations_consultant ADD CONSTRAINT FK_60BD35846ACE3B73 FOREIGN KEY (participation_id) REFERENCES participations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participations_consultant ADD CONSTRAINT FK_60BD3584A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dispense DROP mentor_id');
        $this->addSql('ALTER TABLE dispense DROP formation_id');
        $this->addSql('ALTER TABLE formation ALTER reward_id DROP NOT NULL');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BFE466ACA1 FOREIGN KEY (reward_id) REFERENCES reward (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_404021BFE466ACA1 ON formation (reward_id)');
        $this->addSql('ALTER TABLE mission ADD manager_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mission DROP participants');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C783E3463 FOREIGN KEY (manager_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9067F23C783E3463 ON mission (manager_id)');
        $this->addSql('ALTER TABLE participations DROP mentor_id');
        $this->addSql('ALTER TABLE participations DROP user_id');
        $this->addSql('ALTER TABLE participations DROP dispense_id');
        $this->addSql('ALTER TABLE planning ADD consultant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE planning DROP user_id');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF644F779A2 FOREIGN KEY (consultant_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D499BFF644F779A2 ON planning (consultant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE dispense_user DROP CONSTRAINT FK_A5F462CB3FC9908');
        $this->addSql('ALTER TABLE dispense_user DROP CONSTRAINT FK_A5F462CBA76ED395');
        $this->addSql('ALTER TABLE dispense_formation DROP CONSTRAINT FK_9B3688F3FC9908');
        $this->addSql('ALTER TABLE dispense_formation DROP CONSTRAINT FK_9B3688F5200282E');
        $this->addSql('ALTER TABLE mission_user DROP CONSTRAINT FK_A4D17A46BE6CAE90');
        $this->addSql('ALTER TABLE mission_user DROP CONSTRAINT FK_A4D17A46A76ED395');
        $this->addSql('ALTER TABLE participations_dispense DROP CONSTRAINT FK_399431122E175398');
        $this->addSql('ALTER TABLE participations_dispense DROP CONSTRAINT FK_399431123FC9908');
        $this->addSql('ALTER TABLE participations_mentor DROP CONSTRAINT FK_9C8143856ACE3B73');
        $this->addSql('ALTER TABLE participations_mentor DROP CONSTRAINT FK_9C814385A76ED395');
        $this->addSql('ALTER TABLE participations_consultant DROP CONSTRAINT FK_60BD35846ACE3B73');
        $this->addSql('ALTER TABLE participations_consultant DROP CONSTRAINT FK_60BD3584A76ED395');
        $this->addSql('DROP TABLE dispense_user');
        $this->addSql('DROP TABLE dispense_formation');
        $this->addSql('DROP TABLE mission_user');
        $this->addSql('DROP TABLE participations_dispense');
        $this->addSql('DROP TABLE participations_mentor');
        $this->addSql('DROP TABLE participations_consultant');
        $this->addSql('ALTER TABLE mission DROP CONSTRAINT FK_9067F23C783E3463');
        $this->addSql('DROP INDEX IDX_9067F23C783E3463');
        $this->addSql('ALTER TABLE mission ADD participants INT NOT NULL');
        $this->addSql('ALTER TABLE mission DROP manager_id');
        $this->addSql('ALTER TABLE planning DROP CONSTRAINT FK_D499BFF644F779A2');
        $this->addSql('DROP INDEX IDX_D499BFF644F779A2');
        $this->addSql('ALTER TABLE planning ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE planning DROP consultant_id');
        $this->addSql('ALTER TABLE formation DROP CONSTRAINT FK_404021BFE466ACA1');
        $this->addSql('DROP INDEX IDX_404021BFE466ACA1');
        $this->addSql('ALTER TABLE formation ALTER reward_id SET NOT NULL');
        $this->addSql('ALTER TABLE dispense ADD mentor_id INT NOT NULL');
        $this->addSql('ALTER TABLE dispense ADD formation_id INT NOT NULL');
        $this->addSql('ALTER TABLE participations ADD mentor_id INT NOT NULL');
        $this->addSql('ALTER TABLE participations ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE participations ADD dispense_id INT NOT NULL');
    }
}
