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
        $table = $schema->getTable('user');

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
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable('user');
        $table->dropColumn('token');
        $table->dropColumn('question');
        $table->dropColumn('answer');
        $table->dropColumn('passport_id');
        $table->dropColumn('first_name');
        $table->dropColumn('last_name');
    }
}
