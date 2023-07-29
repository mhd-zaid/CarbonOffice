<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230729202917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reward_user (reward_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(reward_id, user_id))');
        $this->addSql('CREATE INDEX IDX_8C8246D2E466ACA1 ON reward_user (reward_id)');
        $this->addSql('CREATE INDEX IDX_8C8246D2A76ED395 ON reward_user (user_id)');
        $this->addSql('ALTER TABLE reward_user ADD CONSTRAINT FK_8C8246D2E466ACA1 FOREIGN KEY (reward_id) REFERENCES reward (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reward_user ADD CONSTRAINT FK_8C8246D2A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reward ADD dispense_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED172533FC9908 FOREIGN KEY (dispense_id) REFERENCES dispense (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_4ED172533FC9908 ON reward (dispense_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE reward_user DROP CONSTRAINT FK_8C8246D2E466ACA1');
        $this->addSql('ALTER TABLE reward_user DROP CONSTRAINT FK_8C8246D2A76ED395');
        $this->addSql('DROP TABLE reward_user');
        $this->addSql('ALTER TABLE reward DROP CONSTRAINT FK_4ED172533FC9908');
        $this->addSql('DROP INDEX IDX_4ED172533FC9908');
        $this->addSql('ALTER TABLE reward DROP dispense_id');
    }
}
