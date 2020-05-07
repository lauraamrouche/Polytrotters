<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200506121639 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE poste ADD trotter_id INT NOT NULL');
        $this->addSql('ALTER TABLE poste ADD CONSTRAINT FK_7C890FAB4AC62337 FOREIGN KEY (trotter_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7C890FAB4AC62337 ON poste (trotter_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE poste DROP FOREIGN KEY FK_7C890FAB4AC62337');
        $this->addSql('DROP INDEX IDX_7C890FAB4AC62337 ON poste');
        $this->addSql('ALTER TABLE poste DROP trotter_id');
    }
}
