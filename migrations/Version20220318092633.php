<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220318092633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE serie_or_run');
        $this->addSql('ALTER TABLE run ADD exercice_id INT NOT NULL');
        $this->addSql('ALTER TABLE run ADD CONSTRAINT FK_5076A4C089D40298 FOREIGN KEY (exercice_id) REFERENCES exercice (id)');
        $this->addSql('CREATE INDEX IDX_5076A4C089D40298 ON run (exercice_id)');
        $this->addSql('ALTER TABLE serie ADD exercice_id INT NOT NULL');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A933489D40298 FOREIGN KEY (exercice_id) REFERENCES exercice (id)');
        $this->addSql('CREATE INDEX IDX_AA3A933489D40298 ON serie (exercice_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE serie_or_run (id INT AUTO_INCREMENT NOT NULL, exercice_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8196CC89D40298 (exercice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE serie_or_run ADD CONSTRAINT FK_8196CC89D40298 FOREIGN KEY (exercice_id) REFERENCES exercice (id)');
        $this->addSql('ALTER TABLE exercice CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE run DROP FOREIGN KEY FK_5076A4C089D40298');
        $this->addSql('DROP INDEX IDX_5076A4C089D40298 ON run');
        $this->addSql('ALTER TABLE run DROP exercice_id');
        $this->addSql('ALTER TABLE serie DROP FOREIGN KEY FK_AA3A933489D40298');
        $this->addSql('DROP INDEX IDX_AA3A933489D40298 ON serie');
        $this->addSql('ALTER TABLE serie DROP exercice_id');
    }
}
