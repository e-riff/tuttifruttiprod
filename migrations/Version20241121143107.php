<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241121143107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE association (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(80) NOT NULL, phone VARCHAR(20) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, zip_code VARCHAR(20) DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, siret VARCHAR(20) DEFAULT NULL, created_at DATETIME DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE band (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, is_active TINYINT(1) NOT NULL, flash_information LONGTEXT DEFAULT NULL, tagline VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, is_on_homepage TINYINT(1) NOT NULL, updated_at DATETIME DEFAULT NULL, price_category VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concert (id INT AUTO_INCREMENT NOT NULL, band_id INT NOT NULL, client_name VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, zip_code VARCHAR(20) DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, date DATETIME NOT NULL, other_informations LONGTEXT DEFAULT NULL, is_confirmed TINYINT(1) NOT NULL, INDEX IDX_D57C02D249ABEB17 (band_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_band (event_id INT NOT NULL, band_id INT NOT NULL, INDEX IDX_5714EE4071F7E88B (event_id), INDEX IDX_5714EE4049ABEB17 (band_id), PRIMARY KEY(event_id, band_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, band_id INT NOT NULL, link VARCHAR(255) NOT NULL, media_type VARCHAR(80) NOT NULL, picture_size INT DEFAULT NULL, updated_at DATETIME DEFAULT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_6A2CA10C49ABEB17 (band_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE music_style (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE music_style_band (music_style_id INT NOT NULL, band_id INT NOT NULL, INDEX IDX_86508AF27DDE3C52 (music_style_id), INDEX IDX_86508AF249ABEB17 (band_id), PRIMARY KEY(music_style_id, band_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE musician (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(80) NOT NULL, lastname VARCHAR(80) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(20) DEFAULT NULL, is_active TINYINT(1) NOT NULL, picture VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE musician_band (musician_id INT NOT NULL, band_id INT NOT NULL, INDEX IDX_D6DD1B699523AA8A (musician_id), INDEX IDX_D6DD1B6949ABEB17 (band_id), PRIMARY KEY(musician_id, band_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE concert ADD CONSTRAINT FK_D57C02D249ABEB17 FOREIGN KEY (band_id) REFERENCES band (id)');
        $this->addSql('ALTER TABLE event_band ADD CONSTRAINT FK_5714EE4071F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_band ADD CONSTRAINT FK_5714EE4049ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C49ABEB17 FOREIGN KEY (band_id) REFERENCES band (id)');
        $this->addSql('ALTER TABLE music_style_band ADD CONSTRAINT FK_86508AF27DDE3C52 FOREIGN KEY (music_style_id) REFERENCES music_style (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE music_style_band ADD CONSTRAINT FK_86508AF249ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE musician_band ADD CONSTRAINT FK_D6DD1B699523AA8A FOREIGN KEY (musician_id) REFERENCES musician (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE musician_band ADD CONSTRAINT FK_D6DD1B6949ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concert DROP FOREIGN KEY FK_D57C02D249ABEB17');
        $this->addSql('ALTER TABLE event_band DROP FOREIGN KEY FK_5714EE4071F7E88B');
        $this->addSql('ALTER TABLE event_band DROP FOREIGN KEY FK_5714EE4049ABEB17');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C49ABEB17');
        $this->addSql('ALTER TABLE music_style_band DROP FOREIGN KEY FK_86508AF27DDE3C52');
        $this->addSql('ALTER TABLE music_style_band DROP FOREIGN KEY FK_86508AF249ABEB17');
        $this->addSql('ALTER TABLE musician_band DROP FOREIGN KEY FK_D6DD1B699523AA8A');
        $this->addSql('ALTER TABLE musician_band DROP FOREIGN KEY FK_D6DD1B6949ABEB17');
        $this->addSql('DROP TABLE association');
        $this->addSql('DROP TABLE band');
        $this->addSql('DROP TABLE concert');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_band');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE music_style');
        $this->addSql('DROP TABLE music_style_band');
        $this->addSql('DROP TABLE musician');
        $this->addSql('DROP TABLE musician_band');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
