<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260605143000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add homepage hero fields to association';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE association ADD hero_title VARCHAR(160) DEFAULT NULL, ADD hero_subtitle LONGTEXT DEFAULT NULL, ADD hero_image VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE association DROP hero_title, DROP hero_subtitle, DROP hero_image, DROP updated_at');
    }
}
