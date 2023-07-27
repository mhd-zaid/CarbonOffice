<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230726140456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formation_skills (formation_id INT NOT NULL, skills_id INT NOT NULL, PRIMARY KEY(formation_id, skills_id))');
        $this->addSql('CREATE INDEX IDX_F528185D5200282E ON formation_skills (formation_id)');
        $this->addSql('CREATE INDEX IDX_F528185D7FF61858 ON formation_skills (skills_id)');
        $this->addSql('ALTER TABLE formation_skills ADD CONSTRAINT FK_F528185D5200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE formation_skills ADD CONSTRAINT FK_F528185D7FF61858 FOREIGN KEY (skills_id) REFERENCES skills (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE formation DROP skills');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE formation_skills DROP CONSTRAINT FK_F528185D5200282E');
        $this->addSql('ALTER TABLE formation_skills DROP CONSTRAINT FK_F528185D7FF61858');
        $this->addSql('DROP TABLE formation_skills');
        $this->addSql('ALTER TABLE formation ADD skills VARCHAR(255) NOT NULL');
    }
}
