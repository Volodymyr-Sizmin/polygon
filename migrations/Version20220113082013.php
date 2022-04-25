<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220113082013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE verification_request ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE verification_request ADD CONSTRAINT FK_20FDDF4EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_20FDDF4EA76ED395 ON verification_request (user_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE verification_request DROP FOREIGN KEY FK_20FDDF4EA76ED395');
        $this->addSql('DROP INDEX IDX_20FDDF4EA76ED395 ON verification_request');
        $this->addSql('ALTER TABLE verification_request DROP user_id');
    }
}
