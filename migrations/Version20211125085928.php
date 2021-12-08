<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211125085928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE playlists_tracks (playlist_id INT NOT NULL, track_id INT NOT NULL, PRIMARY KEY(playlist_id, track_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE files DROP FOREIGN KEY files_file_types_id_fk');
        $this->addSql('DROP INDEX files_file_types_id_fk ON files');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE playlists_tracks');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT files_file_types_id_fk FOREIGN KEY (type_id) REFERENCES file_types (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX files_file_types_id_fk ON files (type_id)');
    }
}
