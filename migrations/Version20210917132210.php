<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210917132210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create files.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE files (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, filename VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL default now(), updated_at DATETIME NOT NULL default now(), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file_types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL default now(), updated_at DATETIME NOT NULL default now(), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql("INSERT INTO api.file_types (id, name, created_at, updated_at)
            VALUES (1, 'audio', DEFAULT, DEFAULT);
            
            INSERT INTO api.file_types (id, name, created_at, updated_at)
            VALUES (2, 'image', DEFAULT, DEFAULT);
            
            INSERT INTO api.file_types (id, name, created_at, updated_at)
            VALUES (3, 'document', DEFAULT, DEFAULT);
        ");

        $this->addSql("
            alter table files
                add constraint files_file_types_id_fk
                    foreign key (type_id) references file_types (id)
                        on update cascade on delete cascade;
        ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE files');
        $this->addSql('DROP TABLE file_types');
    }
}
