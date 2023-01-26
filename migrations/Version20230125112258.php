<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230125112258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->getTable('payments');
        $table->addColumn('name', 'string', [
            'length' => 255,
            'notnull' => 0
        ]);
        $table->addColumn('card_debit_number', 'string', [
            'length' => 16,
            'notnull' => 0
        ]);
        $table->addColumn('card_credit_number', 'string', [
            'length' => 16,
            'notnull' => 0
        ]);
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable('payments');
        $table->dropColumn('name');
        $table->dropColumn('card_debit_number');
        $table->dropColumn('card_credit_number');
    }
}
