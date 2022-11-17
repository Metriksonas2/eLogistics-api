<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221016205936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cargo ADD vehicle_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cargo ADD CONSTRAINT FK_3BEE5771545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('CREATE INDEX IDX_3BEE5771545317D1 ON cargo (vehicle_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cargo DROP FOREIGN KEY FK_3BEE5771545317D1');
        $this->addSql('DROP INDEX IDX_3BEE5771545317D1 ON cargo');
        $this->addSql('ALTER TABLE cargo DROP vehicle_id');
    }
}
