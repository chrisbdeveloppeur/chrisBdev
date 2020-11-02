<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201102104211 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin ADD news TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE projet ADD img_1_name VARCHAR(255) DEFAULT NULL, ADD img_2_name VARCHAR(255) DEFAULT NULL, ADD img_3_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin DROP news');
        $this->addSql('ALTER TABLE projet DROP img_1_name, DROP img_2_name, DROP img_3_name');
    }
}
