<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220918212139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE location_book (id INT AUTO_INCREMENT NOT NULL, location_client_id INT NOT NULL, location_id INT NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, is_accepted INT NOT NULL, INDEX IDX_4BE11671573EBF57 (location_client_id), INDEX IDX_4BE1167164D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location_comment (id INT AUTO_INCREMENT NOT NULL, commenter_id INT NOT NULL, location_id INT NOT NULL, text LONGTEXT NOT NULL, posted_at DATETIME NOT NULL, INDEX IDX_7A3141C8B4D5A9E2 (commenter_id), INDEX IDX_7A3141C864D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_book (id INT AUTO_INCREMENT NOT NULL, service_client_id INT NOT NULL, service_id INT NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, is_accepted INT NOT NULL, INDEX IDX_5A617DD417A536B (service_client_id), INDEX IDX_5A617DDED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_comment (id INT AUTO_INCREMENT NOT NULL, commenter_id INT NOT NULL, service_id INT NOT NULL, text LONGTEXT NOT NULL, posted_at DATETIME NOT NULL, INDEX IDX_5BF000F0B4D5A9E2 (commenter_id), INDEX IDX_5BF000F0ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE location_book ADD CONSTRAINT FK_4BE11671573EBF57 FOREIGN KEY (location_client_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE location_book ADD CONSTRAINT FK_4BE1167164D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE location_comment ADD CONSTRAINT FK_7A3141C8B4D5A9E2 FOREIGN KEY (commenter_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE location_comment ADD CONSTRAINT FK_7A3141C864D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE service_book ADD CONSTRAINT FK_5A617DD417A536B FOREIGN KEY (service_client_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE service_book ADD CONSTRAINT FK_5A617DDED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE service_comment ADD CONSTRAINT FK_5BF000F0B4D5A9E2 FOREIGN KEY (commenter_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE service_comment ADD CONSTRAINT FK_5BF000F0ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location_book DROP FOREIGN KEY FK_4BE11671573EBF57');
        $this->addSql('ALTER TABLE location_book DROP FOREIGN KEY FK_4BE1167164D218E');
        $this->addSql('ALTER TABLE location_comment DROP FOREIGN KEY FK_7A3141C8B4D5A9E2');
        $this->addSql('ALTER TABLE location_comment DROP FOREIGN KEY FK_7A3141C864D218E');
        $this->addSql('ALTER TABLE service_book DROP FOREIGN KEY FK_5A617DD417A536B');
        $this->addSql('ALTER TABLE service_book DROP FOREIGN KEY FK_5A617DDED5CA9E6');
        $this->addSql('ALTER TABLE service_comment DROP FOREIGN KEY FK_5BF000F0B4D5A9E2');
        $this->addSql('ALTER TABLE service_comment DROP FOREIGN KEY FK_5BF000F0ED5CA9E6');
        $this->addSql('DROP TABLE location_book');
        $this->addSql('DROP TABLE location_comment');
        $this->addSql('DROP TABLE service_book');
        $this->addSql('DROP TABLE service_comment');
    }
}
