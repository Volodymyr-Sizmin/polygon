<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230209111541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("ALTER TABLE card_types
        ADD currency ENUM('GBP', 'multi') default 'GBP',
        RENAME COLUMN card_type TO name");
        $this->addSql("ALTER TABLE card_types MODIFY COLUMN type ENUM('Debit Card','Credit Card')");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("ALTER TABLE card_types DROP currency");
    }
}
