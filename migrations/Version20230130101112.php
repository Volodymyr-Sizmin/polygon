<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230130101112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE fast_payments ADD created_at DATETIME NOT NULL');;
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE fast_payments DROP created_at');
    }
}
