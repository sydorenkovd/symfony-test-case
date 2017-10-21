<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171021123436 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        if($schema->hasTable('book_compatible_status')) {
            $fakeData = [
                1 => [3,2],
                2 => [1],
                3 => [1,2],
            ];
            foreach ($fakeData as $status => $allowedStatuses) {
                $this->connection->exec('INSERT INTO book_compatible_status (status, allowed_statuses) VALUES ('. $status .', "'.json_encode($allowedStatuses).'")');
            }
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
