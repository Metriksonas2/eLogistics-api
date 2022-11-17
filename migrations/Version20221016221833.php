<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221016221833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE item_cargo (item_id INT NOT NULL, cargo_id INT NOT NULL, INDEX IDX_11494CA1126F525E (item_id), INDEX IDX_11494CA1813AC380 (cargo_id), PRIMARY KEY(item_id, cargo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE item_cargo ADD CONSTRAINT FK_11494CA1126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_cargo ADD CONSTRAINT FK_11494CA1813AC380 FOREIGN KEY (cargo_id) REFERENCES cargo (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item_cargo DROP FOREIGN KEY FK_11494CA1126F525E');
        $this->addSql('ALTER TABLE item_cargo DROP FOREIGN KEY FK_11494CA1813AC380');
        $this->addSql('DROP TABLE item_cargo');
    }
}
