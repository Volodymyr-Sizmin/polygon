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
        $table = $schema->getTable('user');
        $table->addColumn('email', 'string', [
            'length' => 255,
            'notnull' => 0,
        ]);
        $table->addColumn('roles', 'json', [
            'unsigned' => 1,
            'notnull' => 0,
        ]);
        $table->addColumn('password', 'string', [
            'length' => 255,
            'unsigned' => 0,
            'notnull' => 0,
        ]);
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable('user');
        $table->dropColumn('email');
        $table->dropColumn('roles');
        $table->dropColumn('password');
    }
}
