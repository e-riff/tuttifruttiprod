<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260605095658 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'ajout url musicien';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE musician ADD url VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE musician DROP url');
    }
}
