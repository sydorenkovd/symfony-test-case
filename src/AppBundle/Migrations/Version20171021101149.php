<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171021101149 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        if(!$schema->hasTable('book_status')) {
            $book = $schema->createTable('book_status');
            $book->addColumn('id', Type::INTEGER, [
                'autoincrement' => true
            ]);
            $book->setPrimaryKey(['id']);
            $book->addColumn('status_name', Type::STRING, ['notnull' => false]);
            $book->addColumn('status_code', Type::STRING, ['notnull' => false]);
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        if($schema->hasTable('book_status')) {
            $schema->dropTable('book_status');
        }
    }
}
