<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220919134113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD resident TINYINT(1) NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE email email VARCHAR(180) NOT NULL, CHANGE roles roles JSON NOT NULL, CHANGE question question VARCHAR(255) NOT NULL, CHANGE pin pin INT DEFAULT NULL, CHANGE reset_pin reset_pin INT DEFAULT NULL, CHANGE counter counter INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user DROP resident, CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE roles roles JSON DEFAULT NULL, CHANGE question question VARCHAR(255) DEFAULT NULL, CHANGE pin pin INT UNSIGNED DEFAULT NULL, CHANGE reset_pin reset_pin INT UNSIGNED DEFAULT NULL, CHANGE counter counter INT UNSIGNED DEFAULT NULL');
    }
}
