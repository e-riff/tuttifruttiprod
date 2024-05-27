<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230215214108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CA49B0ADA');
        $this->addSql('DROP TABLE media_type');
        $this->addSql('DROP INDEX IDX_6A2CA10CA49B0ADA ON media');
        $this->addSql('ALTER TABLE media ADD media_type VARCHAR(80) NOT NULL, DROP media_type_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE media_type (id INT AUTO_INCREMENT NOT NULL, type_name VARCHAR(80) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE media ADD media_type_id INT NOT NULL, DROP media_type');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CA49B0ADA FOREIGN KEY (media_type_id) REFERENCES media_type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6A2CA10CA49B0ADA ON media (media_type_id)');
    }
}
