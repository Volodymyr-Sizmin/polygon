<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230211144833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accounts (id INT AUTO_INCREMENT NOT NULL, user_id VARCHAR(100) NOT NULL, number VARCHAR(255) NOT NULL, currency_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', card_number VARCHAR(16) DEFAULT NULL, balance INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE card_types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(10) NOT NULL, free_service_from_turnover VARCHAR(255) DEFAULT NULL, transfer_fees VARCHAR(255) DEFAULT NULL, withdrawal_terms VARCHAR(255) DEFAULT NULL, cashback_terms VARCHAR(255) DEFAULT NULL, card_validity_years VARCHAR(255) NOT NULL, interest_percent DOUBLE PRECISION DEFAULT NULL, other_advantages VARCHAR(255) DEFAULT NULL, currency VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE currencies (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fast_payments (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, payment_reason VARCHAR(255) NOT NULL, amount INT NOT NULL, address VARCHAR(255) DEFAULT NULL, recepient_name VARCHAR(255) NOT NULL, user_email VARCHAR(255) NOT NULL, card_number VARCHAR(255) NOT NULL, account_number VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_statuses (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, name_id VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE accounts');

        $this->addSql('DROP TABLE card_types');
        $this->addSql('DROP TABLE currencies');
        $this->addSql('DROP TABLE fast_payments');
        $this->addSql('DROP TABLE payment_statuses');
    }
}
