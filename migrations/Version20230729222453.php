<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230729222453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reward DROP CONSTRAINT fk_4ed172533fc9908');
        $this->addSql('DROP INDEX idx_4ed172533fc9908');
        $this->addSql('ALTER TABLE reward DROP dispense_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE reward ADD dispense_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT fk_4ed172533fc9908 FOREIGN KEY (dispense_id) REFERENCES dispense (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_4ed172533fc9908 ON reward (dispense_id)');
    }
}
