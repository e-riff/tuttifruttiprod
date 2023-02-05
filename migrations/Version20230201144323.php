<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201144323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_band (event_id INT NOT NULL, band_id INT NOT NULL, INDEX IDX_5714EE4071F7E88B (event_id), INDEX IDX_5714EE4049ABEB17 (band_id), PRIMARY KEY(event_id, band_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, band_id INT NOT NULL, link VARCHAR(255) NOT NULL, INDEX IDX_6A2CA10C49ABEB17 (band_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE music_style (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE music_style_band (music_style_id INT NOT NULL, band_id INT NOT NULL, INDEX IDX_86508AF27DDE3C52 (music_style_id), INDEX IDX_86508AF249ABEB17 (band_id), PRIMARY KEY(music_style_id, band_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_band ADD CONSTRAINT FK_5714EE4071F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_band ADD CONSTRAINT FK_5714EE4049ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C49ABEB17 FOREIGN KEY (band_id) REFERENCES band (id)');
        $this->addSql('ALTER TABLE music_style_band ADD CONSTRAINT FK_86508AF27DDE3C52 FOREIGN KEY (music_style_id) REFERENCES music_style (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE music_style_band ADD CONSTRAINT FK_86508AF249ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE possible_occasion_band DROP FOREIGN KEY FK_EA9A4C5822EEFDE6');
        $this->addSql('ALTER TABLE possible_occasion_band DROP FOREIGN KEY FK_EA9A4C5849ABEB17');
        $this->addSql('ALTER TABLE prestation_style_band DROP FOREIGN KEY FK_F36CD4A933DDDD67');
        $this->addSql('ALTER TABLE prestation_style_band DROP FOREIGN KEY FK_F36CD4A949ABEB17');
        $this->addSql('DROP TABLE possible_occasion');
        $this->addSql('DROP TABLE possible_occasion_band');
        $this->addSql('DROP TABLE prestation_style_band');
        $this->addSql('DROP TABLE prestation_style');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE possible_occasion (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE possible_occasion_band (possible_occasion_id INT NOT NULL, band_id INT NOT NULL, INDEX IDX_EA9A4C5849ABEB17 (band_id), INDEX IDX_EA9A4C5822EEFDE6 (possible_occasion_id), PRIMARY KEY(possible_occasion_id, band_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE prestation_style_band (prestation_style_id INT NOT NULL, band_id INT NOT NULL, INDEX IDX_F36CD4A949ABEB17 (band_id), INDEX IDX_F36CD4A933DDDD67 (prestation_style_id), PRIMARY KEY(prestation_style_id, band_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE prestation_style (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE possible_occasion_band ADD CONSTRAINT FK_EA9A4C5822EEFDE6 FOREIGN KEY (possible_occasion_id) REFERENCES possible_occasion (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE possible_occasion_band ADD CONSTRAINT FK_EA9A4C5849ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prestation_style_band ADD CONSTRAINT FK_F36CD4A933DDDD67 FOREIGN KEY (prestation_style_id) REFERENCES prestation_style (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prestation_style_band ADD CONSTRAINT FK_F36CD4A949ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_band DROP FOREIGN KEY FK_5714EE4071F7E88B');
        $this->addSql('ALTER TABLE event_band DROP FOREIGN KEY FK_5714EE4049ABEB17');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C49ABEB17');
        $this->addSql('ALTER TABLE music_style_band DROP FOREIGN KEY FK_86508AF27DDE3C52');
        $this->addSql('ALTER TABLE music_style_band DROP FOREIGN KEY FK_86508AF249ABEB17');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_band');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE music_style');
        $this->addSql('DROP TABLE music_style_band');
    }
}
