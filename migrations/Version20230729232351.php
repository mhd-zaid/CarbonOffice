<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230729232351 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reward_dispense (reward_id INT NOT NULL, dispense_id INT NOT NULL, PRIMARY KEY(reward_id, dispense_id))');
        $this->addSql('CREATE INDEX IDX_9F3E7494E466ACA1 ON reward_dispense (reward_id)');
        $this->addSql('CREATE INDEX IDX_9F3E74943FC9908 ON reward_dispense (dispense_id)');
        $this->addSql('ALTER TABLE reward_dispense ADD CONSTRAINT FK_9F3E7494E466ACA1 FOREIGN KEY (reward_id) REFERENCES reward (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reward_dispense ADD CONSTRAINT FK_9F3E74943FC9908 FOREIGN KEY (dispense_id) REFERENCES dispense (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE reward_dispense DROP CONSTRAINT FK_9F3E7494E466ACA1');
        $this->addSql('ALTER TABLE reward_dispense DROP CONSTRAINT FK_9F3E74943FC9908');
        $this->addSql('DROP TABLE reward_dispense');
    }
}
