<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230131214520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE possible_occasion (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE possible_occasion_band (possible_occasion_id INT NOT NULL, band_id INT NOT NULL, INDEX IDX_EA9A4C5822EEFDE6 (possible_occasion_id), INDEX IDX_EA9A4C5849ABEB17 (band_id), PRIMARY KEY(possible_occasion_id, band_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestation_style (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestation_style_band (prestation_style_id INT NOT NULL, band_id INT NOT NULL, INDEX IDX_F36CD4A933DDDD67 (prestation_style_id), INDEX IDX_F36CD4A949ABEB17 (band_id), PRIMARY KEY(prestation_style_id, band_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE possible_occasion_band ADD CONSTRAINT FK_EA9A4C5822EEFDE6 FOREIGN KEY (possible_occasion_id) REFERENCES possible_occasion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE possible_occasion_band ADD CONSTRAINT FK_EA9A4C5849ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prestation_style_band ADD CONSTRAINT FK_F36CD4A933DDDD67 FOREIGN KEY (prestation_style_id) REFERENCES prestation_style (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prestation_style_band ADD CONSTRAINT FK_F36CD4A949ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE band_category DROP FOREIGN KEY FK_C60758CB12469DE2');
        $this->addSql('ALTER TABLE band_category DROP FOREIGN KEY FK_C60758CB49ABEB17');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE band_category');
        $this->addSql('ALTER TABLE association ADD email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE band ADD flash_information LONGTEXT DEFAULT NULL, ADD tagline VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE band_category (band_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_C60758CB12469DE2 (category_id), INDEX IDX_C60758CB49ABEB17 (band_id), PRIMARY KEY(band_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE band_category ADD CONSTRAINT FK_C60758CB12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE band_category ADD CONSTRAINT FK_C60758CB49ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE possible_occasion_band DROP FOREIGN KEY FK_EA9A4C5822EEFDE6');
        $this->addSql('ALTER TABLE possible_occasion_band DROP FOREIGN KEY FK_EA9A4C5849ABEB17');
        $this->addSql('ALTER TABLE prestation_style_band DROP FOREIGN KEY FK_F36CD4A933DDDD67');
        $this->addSql('ALTER TABLE prestation_style_band DROP FOREIGN KEY FK_F36CD4A949ABEB17');
        $this->addSql('DROP TABLE possible_occasion');
        $this->addSql('DROP TABLE possible_occasion_band');
        $this->addSql('DROP TABLE prestation_style');
        $this->addSql('DROP TABLE prestation_style_band');
        $this->addSql('ALTER TABLE association DROP email');
        $this->addSql('ALTER TABLE band DROP flash_information, DROP tagline');
    }
}
