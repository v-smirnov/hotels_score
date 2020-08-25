<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200824182933 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== "mysql");

        $this->addSql('CREATE TABLE IF NOT EXISTS hotel (
              id BIGINT AUTO_INCREMENT PRIMARY KEY,
              name VARCHAR(255) NOT NULL
            ) ENGINE=InnoDB;'
        );

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE IF EXISTS hotel');
    }
}
