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
    public function up(Schema $schema): void
    {
        $this->addSql(<<<END
            CREATE TABLE files
            (
                id         INT AUTO_INCREMENT NOT NULL,
                type_id    INT                NOT NULL,
                filename   VARCHAR(255)       NOT NULL,
                url        VARCHAR(255)       NOT NULL,
                created_at DATETIME           NOT NULL default now(),
                updated_at DATETIME           NOT NULL default now(),
                PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8mb4
              COLLATE `utf8mb4_unicode_ci`
              ENGINE = InnoDB
        END
        );

        $this->addSql(<<<END
            CREATE TABLE file_types
            (
                id         INT AUTO_INCREMENT NOT NULL,
                name       VARCHAR(255)       NOT NULL,
                created_at DATETIME           NOT NULL default now(),
                updated_at DATETIME           NOT NULL default now(),
                PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8mb4
              COLLATE `utf8mb4_unicode_ci`
              ENGINE = InnoDB;
        END
        );

        $this->addSql(<<<END
            INSERT INTO file_types (name, created_at, updated_at)
            VALUES ('audio', DEFAULT, DEFAULT);
            
            INSERT INTO file_types (name, created_at, updated_at)
            VALUES ('image', DEFAULT, DEFAULT);
            
            INSERT INTO file_types (name, created_at, updated_at)
            VALUES ('document', DEFAULT, DEFAULT);
        END
        );

        $this->addSql(<<<END
            alter table files
            add constraint files_file_types_id_fk
            foreign key (type_id) references file_types (id)
            on update cascade on delete cascade;
        END
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE file_types');
        $this->addSql('DROP TABLE files');
    }
}
