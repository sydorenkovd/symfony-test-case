<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171021095034 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        if(!$schema->hasTable('books')) {
            $book = $schema->createTable('books');
            $book->addColumn('id', Type::INTEGER, [
                'autoincrement' => true
            ]);
            $book->setPrimaryKey(['id']);
            $book->addColumn('authors', Type::STRING, ['notnull' => false]);
            $book->addColumn('title', Type::STRING, ['notnull' => false]);
            $book->addColumn('status', Type::INTEGER, ['notnull' => false]);
            $book->addColumn('year', Type::INTEGER, ['notnull' => false]);
            $book->addColumn('date_create', Type::DATETIME, ['notnull' => false]);
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        if($schema->hasTable('books')) {
            $schema->dropTable('books');
        }

    }
}
