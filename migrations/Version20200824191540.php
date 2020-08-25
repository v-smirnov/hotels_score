<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200824191540 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== "mysql");

        $this->addSql('CREATE TABLE IF NOT EXISTS review (
              id BIGINT AUTO_INCREMENT PRIMARY KEY,
              hotel_id BIGINT NOT NULL,
              score FLOAT NOT NULL,
              comment VARCHAR(255),
              created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              FOREIGN KEY (hotel_id)
                REFERENCES hotel (id)
                ON DELETE CASCADE
            ) ENGINE=InnoDB;'
        );

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE IF EXISTS review');
    }
}
