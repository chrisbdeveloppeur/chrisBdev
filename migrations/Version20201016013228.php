<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201016013228 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE techno_projet (techno_id INT NOT NULL, projet_id INT NOT NULL, INDEX IDX_67EEB34051F3C1BC (techno_id), INDEX IDX_67EEB340C18272 (projet_id), PRIMARY KEY(techno_id, projet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE techno_projet ADD CONSTRAINT FK_67EEB34051F3C1BC FOREIGN KEY (techno_id) REFERENCES techno (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE techno_projet ADD CONSTRAINT FK_67EEB340C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE techno DROP FOREIGN KEY FK_3987EEDCC18272');
        $this->addSql('DROP INDEX IDX_3987EEDCC18272 ON techno');
        $this->addSql('ALTER TABLE techno DROP projet_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE techno_projet');
        $this->addSql('ALTER TABLE techno ADD projet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE techno ADD CONSTRAINT FK_3987EEDCC18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('CREATE INDEX IDX_3987EEDCC18272 ON techno (projet_id)');
    }
}
