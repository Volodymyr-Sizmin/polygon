<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220516123916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->getTable('user');
        $table->addColumn('email', 'string', [
            'length' => 255,
        ]);
        $table->addColumn('roles', 'integer', [
            'unsigned' => 0,
            'notnull' => 0,
        ]);
        $table->addColumn('password', 'string', [
            'length' => 255,
            'unsigned' => 0,
            'notnull' => 0,
        ]);
        // $this->addSql('ALTER TABLE user ADD code VARCHAR(255) DEFAULT NULL, ADD token LONGTEXT NOT NULL, ADD question VARCHAR(255) DEFAULT NULL, ADD answer VARCHAR(255) DEFAULT NULL, CHANGE password VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE user DROP code, DROP token, DROP question, DROP answer, CHANGE password password VARCHAR(255) NOT NULL');
    }
}
