<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220628115530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->getTable('user');
        $table->addColumn('reset_pin', 'integer', [
            'unsigned' => 1,
            'notnull' => 0,
        ]);
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable('user');
        $table->dropColumn('reset_pin');
    }
}
