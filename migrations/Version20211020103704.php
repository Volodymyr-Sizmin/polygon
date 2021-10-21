<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211020103704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP verified, CHANGE is_deleted is_deleted TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE verification_request DROP FOREIGN KEY FK_20FDDF4EA76ED395');
        $this->addSql('DROP INDEX IDX_20FDDF4EA76ED395 ON verification_request');
        $this->addSql('ALTER TABLE verification_request ADD verified TINYINT(1) DEFAULT \'0\' NOT NULL, ADD email VARCHAR(255) DEFAULT NULL, DROP user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD verified TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE is_deleted is_deleted TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE verification_request ADD user_id INT NOT NULL, DROP verified, DROP email');
        $this->addSql('ALTER TABLE verification_request ADD CONSTRAINT FK_20FDDF4EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_20FDDF4EA76ED395 ON verification_request (user_id)');
    }
}
