<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210112170414 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76DBD6CC98');
        $this->addSql('DROP INDEX UNIQ_880E0D76DBD6CC98 ON admin');
        $this->addSql('ALTER TABLE admin DROP avi_id');
        $this->addSql('ALTER TABLE avi ADD user VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin ADD avi_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76DBD6CC98 FOREIGN KEY (avi_id) REFERENCES avi (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D76DBD6CC98 ON admin (avi_id)');
        $this->addSql('ALTER TABLE avi DROP user');
    }
}
