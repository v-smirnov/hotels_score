<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200825140708 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE INDEX idx_review__hotel_id_created_date ON review (hotel_id, created_date)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP INDEX idx_review__hotel_id_created_date ON review');
    }
}
