<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210930074505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE verification_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, expires_at DATETIME NOT NULL, url VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_20FDDF4EF47645AE (url), INDEX IDX_20FDDF4EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE verification_request ADD CONSTRAINT FK_20FDDF4EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD verified TINYINT(1) DEFAULT \'0\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE verification_request');
        $this->addSql('ALTER TABLE user DROP verified');
    }
}
