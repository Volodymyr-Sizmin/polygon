<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211119070443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE track (id INT AUTO_INCREMENT NOT NULL, author VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, album VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, cover VARCHAR(255) DEFAULT NULL, track_path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE files DROP FOREIGN KEY files_file_types_id_fk');
        $this->addSql('DROP INDEX files_file_types_id_fk ON files');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE track');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT files_file_types_id_fk FOREIGN KEY (type_id) REFERENCES file_types (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX files_file_types_id_fk ON files (type_id)');
    }
}
