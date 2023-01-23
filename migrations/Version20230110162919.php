<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230110162919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('payment_types');
        $table->addColumn('id', 'integer', [
            'autoincrement' => 1,
            'notnull' => 1,
            'unsigned' => 1,
        ]);
        $table->addColumn('name', 'string', [
            'length' => 255,
            'notnull' => 1
        ]);
        $table->addColumn('on_the_main_page', 'integer', [
            'length' => 1,
            'notnull' => 1
        ]);
        $table->addColumn('name_id', 'string', [
            'length' => 255,
            'notnull' => 1
        ]);
        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('payment_types');
    }
}
