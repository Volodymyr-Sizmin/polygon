<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211115145315 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE files ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_6354059A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6354059A76ED395 ON files (user_id)');
        $this->addSql('ALTER TABLE user ADD profilePhoto BIGINT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE files DROP FOREIGN KEY FK_6354059A76ED395');
        $this->addSql('DROP INDEX IDX_6354059A76ED395 ON files');
        $this->addSql('ALTER TABLE files DROP user_id');
        $this->addSql('ALTER TABLE user DROP profilePhoto');
    }
}
