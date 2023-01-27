<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230125113804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE autopayments ADD created_at DATETIME');
        $this->addSql('ALTER TABLE autopayments ADD updated_at DATETIME');
        $this->addSql('ALTER TABLE payment_types ADD on_the_main_page INT NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE autopayments DROP created_at');
        $this->addSql('ALTER TABLE autopayments DROP updated_at');
        $this->addSql('ALTER TABLE payment_types DROP on_the_main_page, CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
     }
}
