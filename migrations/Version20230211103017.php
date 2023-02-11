<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230211103017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE musician (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(80) NOT NULL, lastname VARCHAR(80) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(20) DEFAULT NULL, is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_31714127E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE musician_band (musician_id INT NOT NULL, band_id INT NOT NULL, INDEX IDX_D6DD1B699523AA8A (musician_id), INDEX IDX_D6DD1B6949ABEB17 (band_id), PRIMARY KEY(musician_id, band_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE musician_band ADD CONSTRAINT FK_D6DD1B699523AA8A FOREIGN KEY (musician_id) REFERENCES musician (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE musician_band ADD CONSTRAINT FK_D6DD1B6949ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE band ADD is_on_homepage TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE musician_band DROP FOREIGN KEY FK_D6DD1B699523AA8A');
        $this->addSql('ALTER TABLE musician_band DROP FOREIGN KEY FK_D6DD1B6949ABEB17');
        $this->addSql('DROP TABLE musician');
        $this->addSql('DROP TABLE musician_band');
        $this->addSql('ALTER TABLE band DROP is_on_homepage');
    }
}
