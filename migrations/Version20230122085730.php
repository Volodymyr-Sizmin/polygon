<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230122085730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('fast_payments');
        $table->addColumn('id', 'integer', [
            'autoincrement' => 1,
            'notnull' => 1,
            'unsigned' => 1,
        ]);
        $table->addColumn('user_email', 'string', [
            'length' => 255,
            'notnull' => 1
        ]);
        $table->addColumn('name', 'string', [
            'length' => 255,
            'notnull' => 1
        ]);
        $table->addColumn('card_number', 'string', [
            'unsigned' => 1,
            'notnull' => 1
        ]);

        $table->addColumn('payment_reason', 'string', [
            'length' => 255,
            'notnull' => 1
        ]);
        $table->addColumn('amount', 'integer', [
            'unsigned' => 1,
            'notnull' => 1
        ]);
        $table->addColumn('account_number','string',[
            'unsigned' => 1,
            'notnull' => 1
        ]);
        $table->addColumn('adress','string',[
            'length' => 255,
        ]);$table->addColumn('recepient_name','string',[
        'length' => 255,
        'notnull' => 1
    ]);
        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('fast_payments');
    }
}
