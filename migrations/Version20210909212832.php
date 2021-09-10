<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210909212832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste DROP FOREIGN KEY FK_FCF22AF47E3C61F9');
        $this->addSql('DROP INDEX IDX_FCF22AF47E3C61F9 ON liste');
        $this->addSql('ALTER TABLE liste ADD owner VARCHAR(255) NOT NULL, DROP owner_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste ADD owner_id INT NOT NULL, DROP owner');
        $this->addSql('ALTER TABLE liste ADD CONSTRAINT FK_FCF22AF47E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_FCF22AF47E3C61F9 ON liste (owner_id)');
    }
}
