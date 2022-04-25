<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211215112518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $sql = "SELECT id FROM country WHERE name='Belarus'";
        $id = $this->connection->fetchOne($sql);
        $this->addSql('INSERT INTO city (name, country_id) VALUES ("Gomel",'.$id.')');
        $this->addSql('INSERT INTO city (name, country_id) VALUES ("Minsk",'.$id.')');
        $this->addSql('INSERT INTO city (name, country_id) VALUES ("Polotsk",'.$id.')');
        $this->addSql('INSERT INTO city (name, country_id) VALUES ("Vitebsk",'.$id.')');
        $sql = "SELECT id FROM country WHERE name='Poland'";
        $id = $this->connection->fetchOne($sql);
        $this->addSql('INSERT INTO city (name, country_id) VALUES ("Krakow",'.$id.')');
        $sql = "SELECT id FROM country WHERE name='Russia'";
        $id = $this->connection->fetchOne($sql);
        $this->addSql('INSERT INTO city (name, country_id) VALUES ("Kazan",'.$id.')');
        $this->addSql('INSERT INTO city (name, country_id) VALUES ("Remote RF",'.$id.')');
        $this->addSql('INSERT INTO city (name, country_id) VALUES ("Rostov",'.$id.')');
        $this->addSql('INSERT INTO city (name, country_id) VALUES ("Saint-Petersburg",'.$id.')');
        $sql = "SELECT id FROM country WHERE name='Ukraine'";
        $id = $this->connection->fetchOne($sql);
        $this->addSql('INSERT INTO city (name, country_id) VALUES ("Cherkasy",'.$id.')');
        $this->addSql('INSERT INTO city (name, country_id) VALUES ("Chernihiv",'.$id.')');
        $this->addSql('INSERT INTO city (name, country_id) VALUES ("Dnipro",'.$id.')');
        $this->addSql('INSERT INTO city (name, country_id) VALUES ("Kharkiv",'.$id.')');
        $this->addSql('INSERT INTO city (name, country_id) VALUES ("Kyiv",'.$id.')');
        $this->addSql('INSERT INTO city (name, country_id) VALUES ("Odessa",'.$id.')');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM city');
    }
}
