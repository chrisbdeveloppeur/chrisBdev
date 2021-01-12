<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210112145307 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin ADD avi_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76DBD6CC98 FOREIGN KEY (avi_id) REFERENCES avi (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D76DBD6CC98 ON admin (avi_id)');
        $this->addSql('ALTER TABLE avi DROP FOREIGN KEY FK_FB5F7F89A76ED395');
        $this->addSql('DROP INDEX IDX_FB5F7F89A76ED395 ON avi');
        $this->addSql('ALTER TABLE avi DROP user_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76DBD6CC98');
        $this->addSql('DROP INDEX UNIQ_880E0D76DBD6CC98 ON admin');
        $this->addSql('ALTER TABLE admin DROP avi_id');
        $this->addSql('ALTER TABLE avi ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE avi ADD CONSTRAINT FK_FB5F7F89A76ED395 FOREIGN KEY (user_id) REFERENCES admin (id)');
        $this->addSql('CREATE INDEX IDX_FB5F7F89A76ED395 ON avi (user_id)');
    }
}
