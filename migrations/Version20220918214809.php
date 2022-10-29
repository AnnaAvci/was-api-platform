<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220918214809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location ADD owner_id INT NOT NULL, DROP date_start, DROP date_end');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5E9E89CB7E3C61F9 ON location (owner_id)');
        $this->addSql('ALTER TABLE service ADD owner_id INT NOT NULL, DROP date_start, DROP date_end');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD27E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD27E3C61F9 ON service (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB7E3C61F9');
        $this->addSql('DROP INDEX IDX_5E9E89CB7E3C61F9 ON location');
        $this->addSql('ALTER TABLE location ADD date_start DATETIME DEFAULT NULL, ADD date_end DATETIME DEFAULT NULL, DROP owner_id');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD27E3C61F9');
        $this->addSql('DROP INDEX IDX_E19D9AD27E3C61F9 ON service');
        $this->addSql('ALTER TABLE service ADD date_start DATETIME DEFAULT NULL, ADD date_end DATETIME DEFAULT NULL, DROP owner_id');
    }
}
