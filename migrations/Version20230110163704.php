<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230110163704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('accounts');
        $table->addColumn('id', 'integer', [
            'autoincrement' => 1,
            'notnull' => 1,
            'unsigned' => 1,
        ]);
        $table->addColumn('user_id', 'integer', [
            'notnull' => 1
        ]);
        $table->addColumn('number', 'string', [
            'length' => 255,
            'notnull' => 1
        ]);
        $table->addColumn('currency_id', 'integer', [
            'notnull' => 1
        ]);
        $table->addColumn('created_at', 'datetime', [
            'notnull' => 1
        ]);
        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('accounts');
    }
}
