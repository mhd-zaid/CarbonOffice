<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230726142802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation ALTER title TYPE VARCHAR(1000)');
        $this->addSql('ALTER TABLE formation ALTER description TYPE VARCHAR(1000)');
        $this->addSql('ALTER TABLE formation ALTER requirements TYPE VARCHAR(1000)');
        $this->addSql('ALTER TABLE reward ALTER title TYPE VARCHAR(1000)');
        $this->addSql('ALTER TABLE reward ALTER description TYPE VARCHAR(1000)');
        $this->addSql('ALTER TABLE skills ALTER title TYPE VARCHAR(1000)');
        $this->addSql('ALTER TABLE skills ALTER description TYPE VARCHAR(1000)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE skills ALTER title TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE skills ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE reward ALTER title TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE reward ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE formation ALTER title TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE formation ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE formation ALTER requirements TYPE VARCHAR(255)');
    }
}
