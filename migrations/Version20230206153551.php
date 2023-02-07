<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class  Version20230206153551 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE card_types (id INT AUTO_INCREMENT NOT NULL,
        card_type ENUM ('Mastercard maestro', 'Mastercard Standard', 'Mastercard World Elite', 'Visa Classic', 'Visa Gold', 'Visa Platinum') NOT NULL,
        type  ENUM('debit', 'credit')  DEFAULT 'debit',
        free_service_from_turnover INT,
        transfer_fees VARCHAR(255),
        withdrawal_terms VARCHAR(255) DEFAULT 'For free in PolyBank ATM',
        cashback_terms VARCHAR(255) DEFAULT 'Not applicable',
        card_validity_years ENUM('2','3','4','5')  NOT NULL ,
        interest_percent FLOAT,
        other_advantages VARCHAR(255),
     
        PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE card_types');
    }
}
