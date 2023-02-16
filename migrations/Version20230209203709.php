<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230209203709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE cards (id INT AUTO_INCREMENT NOT NULL,
        user_id VARCHAR(255) NOT NULL,
        name VARCHAR(255),
        card_type_name VARCHAR(255) NOT NULL,
        number VARCHAR(16) UNIQUE NOT NULL,
        account_number VARCHAR(29) UNIQUE NOT NULL,
        currency_name VARCHAR(3) UNIQUE NOT NULL ,
        transaction_limit NUMERIC(10,2),
        credit_limit NUMERIC(10,2),
        status ENUM('active', 'blocked', 'expired') DEFAULT 'active',
        pin_code SMALLINT(4) UNSIGNED DEFAULT '1234',
        answer_attempts SMALLINT DEFAULT '3',
        expiry_date DATETIME NOT NULL ,
        created_at DATETIME,
        updated_at DATETIME,

PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE cards");
    }
}
