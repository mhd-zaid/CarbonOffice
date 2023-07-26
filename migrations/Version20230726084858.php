<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230726084858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dispense ADD start_time DATE NOT NULL');
        $this->addSql('ALTER TABLE planning DROP start_time');
        $this->addSql('ALTER TABLE planning DROP end_time');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE planning ADD start_time DATE NOT NULL');
        $this->addSql('ALTER TABLE planning ADD end_time DATE NOT NULL');
        $this->addSql('ALTER TABLE dispense DROP start_time');
    }
}
