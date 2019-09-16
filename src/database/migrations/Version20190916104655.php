<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20190916104655 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE message_log (id INT AUTO_INCREMENT NOT NULL, direction VARCHAR(24) DEFAULT NULL, identifier VARCHAR(64) DEFAULT NULL, delivery_info LONGTEXT DEFAULT NULL, request LONGTEXT DEFAULT NULL, response LONGTEXT DEFAULT NULL, status VARCHAR(50) NOT NULL COMMENT \'(DC2Type:enum_message_log_status)\', received_at DATETIME DEFAULT NULL, processed_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE message_log');
    }
}
