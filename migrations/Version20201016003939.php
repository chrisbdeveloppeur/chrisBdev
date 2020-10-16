<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201016003939 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE techno ADD projet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE techno ADD CONSTRAINT FK_3987EEDCC18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('CREATE INDEX IDX_3987EEDCC18272 ON techno (projet_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE techno DROP FOREIGN KEY FK_3987EEDCC18272');
        $this->addSql('DROP INDEX IDX_3987EEDCC18272 ON techno');
        $this->addSql('ALTER TABLE techno DROP projet_id');
    }
}
