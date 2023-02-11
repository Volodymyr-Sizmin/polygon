<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230211150918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE autopayments (id INT AUTO_INCREMENT NOT NULL, user_email VARCHAR(55) NOT NULL, name_of_payment VARCHAR(55) NOT NULL, payment_category VARCHAR(55) NOT NULL, cell_phone_operators VARCHAR(55) DEFAULT NULL, customer_number VARCHAR(55) NOT NULL, amount INT NOT NULL, card VARCHAR(55) NOT NULL, payments_period VARCHAR(55) NOT NULL, auto_charge_off TINYINT(1) NOT NULL, card_debit_number VARCHAR(55) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payments (id INT AUTO_INCREMENT NOT NULL, user_id VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, account_debit_id VARCHAR(255) NOT NULL, account_credit_id VARCHAR(255) NOT NULL, amount INT NOT NULL, currency_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', status_id INT NOT NULL, type_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, card_debit_number VARCHAR(16) DEFAULT NULL, card_credit_number VARCHAR(16) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE autopayments');
        $this->addSql('DROP TABLE payments');
    }
}
