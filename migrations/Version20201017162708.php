<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201017162708 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE techno DROP FOREIGN KEY FK_3987EEDC4D0D3BCB');
        $this->addSql('DROP INDEX IDX_3987EEDC4D0D3BCB ON techno');
        $this->addSql('ALTER TABLE techno DROP comp_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE techno ADD comp_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE techno ADD CONSTRAINT FK_3987EEDC4D0D3BCB FOREIGN KEY (comp_id) REFERENCES comp (id)');
        $this->addSql('CREATE INDEX IDX_3987EEDC4D0D3BCB ON techno (comp_id)');
    }
}
