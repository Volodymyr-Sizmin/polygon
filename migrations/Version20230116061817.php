<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116061817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE autopayments (id INT AUTO_INCREMENT NOT NULL, user_email VARCHAR(55) NOT NULL, name_of_payment VARCHAR(55) NOT NULL, payment_category VARCHAR(55) NOT NULL, cell_phone_operators VARCHAR(55) DEFAULT NULL, customer_number VARCHAR(55) NOT NULL, amount INT NOT NULL, card VARCHAR(55) NOT NULL, payments_period VARCHAR(55) NOT NULL, auto_charge_off TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utility_services (id INT AUTO_INCREMENT NOT NULL, service_name VARCHAR(55) DEFAULT NULL, account_number VARCHAR(55) DEFAULT NULL, balance VARCHAR(55) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE autopayments');
        $this->addSql('DROP TABLE utility_services');
    }
}
