<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201017125800 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comp_techno (comp_id INT NOT NULL, techno_id INT NOT NULL, INDEX IDX_DEF93F6A4D0D3BCB (comp_id), INDEX IDX_DEF93F6A51F3C1BC (techno_id), PRIMARY KEY(comp_id, techno_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comp_techno ADD CONSTRAINT FK_DEF93F6A4D0D3BCB FOREIGN KEY (comp_id) REFERENCES comp (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comp_techno ADD CONSTRAINT FK_DEF93F6A51F3C1BC FOREIGN KEY (techno_id) REFERENCES techno (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comp DROP techno_help');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE comp_techno');
        $this->addSql('ALTER TABLE comp ADD techno_help VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
