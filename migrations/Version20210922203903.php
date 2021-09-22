<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210922203903 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, security_token VARCHAR(255) NOT NULL, is_confirmed TINYINT(1) NOT NULL, name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, birthday DATE DEFAULT NULL, news TINYINT(1) NOT NULL, agree_terms TINYINT(1) DEFAULT NULL, enable TINYINT(1) DEFAULT NULL, pseudo VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_880E0D76E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attribut (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, text LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attribut_projet (attribut_id INT NOT NULL, projet_id INT NOT NULL, INDEX IDX_3506699F51383AF3 (attribut_id), INDEX IDX_3506699FC18272 (projet_id), PRIMARY KEY(attribut_id, projet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avi (id INT AUTO_INCREMENT NOT NULL, note INT DEFAULT NULL, commentaire LONGTEXT DEFAULT NULL, date DATETIME NOT NULL, user VARCHAR(255) DEFAULT NULL, validated TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attribut_projet ADD CONSTRAINT FK_3506699F51383AF3 FOREIGN KEY (attribut_id) REFERENCES attribut (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attribut_projet ADD CONSTRAINT FK_3506699FC18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attribut_projet DROP FOREIGN KEY FK_3506699F51383AF3');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE attribut');
        $this->addSql('DROP TABLE attribut_projet');
        $this->addSql('DROP TABLE avi');
    }
}
