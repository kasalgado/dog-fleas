<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240123075254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flea ADD dog_id INT DEFAULT NULL, ADD removed TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE flea ADD CONSTRAINT FK_FCC92495634DFEB FOREIGN KEY (dog_id) REFERENCES Dog (id)');
        $this->addSql('CREATE INDEX IDX_FCC92495634DFEB ON flea (dog_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Flea DROP FOREIGN KEY FK_FCC92495634DFEB');
        $this->addSql('DROP INDEX IDX_FCC92495634DFEB ON Flea');
        $this->addSql('ALTER TABLE Flea DROP dog_id, DROP removed');
    }
}
