<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171021122914 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        if(!$schema->hasTable('book_compatible_status')) {
            $book = $schema->createTable('book_compatible_status');
            $book->addColumn('id', Type::INTEGER, [
                'autoincrement' => true
            ]);
            $book->setPrimaryKey(['id']);
            $book->addColumn('status', Type::INTEGER, ['notnull' => false]);
            $book->addColumn('allowed_statuses', Type::SIMPLE_ARRAY, ['notnull' => false]);
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        if($schema->hasTable('book_compatible_status')) {
            $schema->dropTable('book_compatible_status');
        }

    }
}
