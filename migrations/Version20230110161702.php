<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230110161702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('currencies');
        $table->addColumn('id', 'integer', [
            'autoincrement' => 1,
            'notnull' => 1,
            'unsigned' => 1,
        ]);
        $table->addColumn('name', 'string', [
            'length' => 255,
            'notnull' => 1
        ]);
        $table->addColumn('full_name', 'string', [
            'length' => 255,
            'notnull' => 1
        ]);
        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('currencies');
    }
}
