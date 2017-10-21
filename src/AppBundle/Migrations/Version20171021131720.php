<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171021131720 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->connection->exec('INSERT INTO books (authors, title, status, year, date_create) VALUES ("Ayn Rand", "Atlas Shrugged", 1, 1957, "' . date('Y-m-d H:i:s')  .'")');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        if($schema->hasTable('books')) {
            $this->connection->exec('TRUNCATE books');
        }

    }
}
