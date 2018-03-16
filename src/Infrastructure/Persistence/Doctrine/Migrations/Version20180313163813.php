<?php declare(strict_types = 1);

namespace Session\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180313163813 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE session_user ADD public_id_id VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE session_user DROP public_id_id');
    }
}
