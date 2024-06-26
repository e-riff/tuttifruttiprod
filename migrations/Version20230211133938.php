<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230211133938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE media_type (id INT AUTO_INCREMENT NOT NULL, type_name VARCHAR(80) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE media ADD media_type_id INT NOT NULL, DROP nature');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CA49B0ADA FOREIGN KEY (media_type_id) REFERENCES media_type (id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10CA49B0ADA ON media (media_type_id)');
        $this->addSql('ALTER TABLE musician ADD picture VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CA49B0ADA');
        $this->addSql('DROP TABLE media_type');
        $this->addSql('DROP INDEX IDX_6A2CA10CA49B0ADA ON media');
        $this->addSql('ALTER TABLE media ADD nature VARCHAR(255) DEFAULT NULL, DROP media_type_id');
        $this->addSql('ALTER TABLE musician DROP picture');
    }
}
