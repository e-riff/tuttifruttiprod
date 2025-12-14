<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251214195330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE association CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE band CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL, CHANGE is_on_homepage is_on_homepage TINYINT(1) DEFAULT 0 NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE price_category price_category VARCHAR(32) DEFAULT NULL');
        $this->addSql('ALTER TABLE concert CHANGE date date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE media CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE musician CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE association CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE concert CHANGE date date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE media CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE is_active is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE band CHANGE is_active is_active TINYINT(1) NOT NULL, CHANGE is_on_homepage is_on_homepage TINYINT(1) NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE price_category price_category VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE musician CHANGE is_active is_active TINYINT(1) NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
    }
}
