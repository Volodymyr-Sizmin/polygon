<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220616141417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->getTable('user');
        $table->addColumn('code', 'string', [
            'length' => 255,
            'unsigned' => 0,
            'notnull' => 0,
        ]);
        $table->addColumn('token', 'string', [
            'length' => 255,
            'unsigned' => 0,
            'notnull' => 0,
        ]);
        $table->addColumn('question', 'string', [
            'length' => 255,
            'unsigned' => 0,
            'notnull' => 0,
        ]);
        $table->addColumn('answer', 'string', [
            'length' => 255,
            'unsigned' => 0,
            'notnull' => 0,
        ]);
        $table->addColumn('passport_id', 'string', [
            'length' => 255,
            'unsigned' => 0,
            'notnull' => 0,
        ]);
        $table->addColumn('first_name', 'string', [
            'length' => 255,
            'unsigned' => 0,
            'notnull' => 0,
        ]);
        $table->addColumn('last_name', 'string', [
            'length' => 255,
            'unsigned' => 0,
            'notnull' => 0,
        ]);
        $table->addColumn('reset_code', 'integer', [
            'unsigned' => 0,
            'notnull' => 0,
        ]);

        // $this->addSql('ALTER TABLE user ADD passport_id VARCHAR(255) DEFAULT NULL, ADD first_name VARCHAR(255) DEFAULT NULL, ADD last_name VARCHAR(255) DEFAULT NULL, ADD reset_code VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP passport_id, DROP first_name, DROP last_name, DROP reset_code');
    }
}
