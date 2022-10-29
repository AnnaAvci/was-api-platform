<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220918205425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE location_photo (id INT AUTO_INCREMENT NOT NULL, location_id INT NOT NULL, INDEX IDX_62EBC13D64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_photo (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, photo_name VARCHAR(255) NOT NULL, INDEX IDX_BDC569FFED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE location_photo ADD CONSTRAINT FK_62EBC13D64D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE service_photo ADD CONSTRAINT FK_BDC569FFED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location_photo DROP FOREIGN KEY FK_62EBC13D64D218E');
        $this->addSql('ALTER TABLE service_photo DROP FOREIGN KEY FK_BDC569FFED5CA9E6');
        $this->addSql('DROP TABLE location_photo');
        $this->addSql('DROP TABLE service_photo');
    }
}
