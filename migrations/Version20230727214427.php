<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230727214427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dispense ADD formation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dispense ALTER link SET NOT NULL');
        $this->addSql('ALTER TABLE dispense ADD CONSTRAINT FK_2CB2B9475200282E FOREIGN KEY (formation_id) REFERENCES formation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2CB2B9475200282E ON dispense (formation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE dispense DROP CONSTRAINT FK_2CB2B9475200282E');
        $this->addSql('DROP INDEX IDX_2CB2B9475200282E');
        $this->addSql('ALTER TABLE dispense DROP formation_id');
        $this->addSql('ALTER TABLE dispense ALTER link DROP NOT NULL');
    }
}
