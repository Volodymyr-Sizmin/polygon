<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230213183211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accounts ADD currency_name VARCHAR(255) NOT NULL, DROP currency_id');
        $this->addSql('ALTER TABLE card CHANGE pin_code pin_code VARCHAR(255) NOT NULL, CHANGE answer_attempts answer_attempts INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accounts ADD currency_id INT NOT NULL, DROP currency_name');
        $this->addSql('ALTER TABLE card CHANGE pin_code pin_code VARCHAR(4) NOT NULL, CHANGE answer_attempts answer_attempts INT NOT NULL');
    }
}
