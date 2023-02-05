<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230131201107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE association (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(80) NOT NULL, phone VARCHAR(20) DEFAULT NULL, adress VARCHAR(255) DEFAULT NULL, zip_code VARCHAR(20) DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, siret VARCHAR(20) DEFAULT NULL, created_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE band (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE band_category (band_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_C60758CB49ABEB17 (band_id), INDEX IDX_C60758CB12469DE2 (category_id), PRIMARY KEY(band_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concert (id INT AUTO_INCREMENT NOT NULL, band_id INT NOT NULL, client_name VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, zip_code VARCHAR(20) DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, date DATETIME NOT NULL, other_informations LONGTEXT DEFAULT NULL, is_confirmed TINYINT(1) NOT NULL, INDEX IDX_D57C02D249ABEB17 (band_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE band_category ADD CONSTRAINT FK_C60758CB49ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE band_category ADD CONSTRAINT FK_C60758CB12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE concert ADD CONSTRAINT FK_D57C02D249ABEB17 FOREIGN KEY (band_id) REFERENCES band (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE band_category DROP FOREIGN KEY FK_C60758CB49ABEB17');
        $this->addSql('ALTER TABLE band_category DROP FOREIGN KEY FK_C60758CB12469DE2');
        $this->addSql('ALTER TABLE concert DROP FOREIGN KEY FK_D57C02D249ABEB17');
        $this->addSql('DROP TABLE association');
        $this->addSql('DROP TABLE band');
        $this->addSql('DROP TABLE band_category');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE concert');
    }
}
