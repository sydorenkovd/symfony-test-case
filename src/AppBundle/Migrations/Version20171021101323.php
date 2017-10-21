<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171021101323 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        if($schema->hasTable('book_status')) {
            foreach (['free' => 'свободна', 'taken' => 'взята', 'reserved' => "зарезервирована"] as $bookStatusCode => $bookStatus) {
                $this->connection->exec('INSERT INTO book_status (status_name, status_code) VALUES ("'. $bookStatus .'", "'.$bookStatusCode.'")');
            }
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        if($schema->hasTable('book_status')) {
            $this->connection->exec('TRUNCATE book_status');
        }

    }
}
