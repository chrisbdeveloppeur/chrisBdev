<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201017220528 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D76E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attribut (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, text LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attribut_projet (attribut_id INT NOT NULL, projet_id INT NOT NULL, INDEX IDX_3506699F51383AF3 (attribut_id), INDEX IDX_3506699FC18272 (projet_id), PRIMARY KEY(attribut_id, projet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comp (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, value INT DEFAULT NULL, color VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, objet VARCHAR(255) DEFAULT NULL, text LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE presentation (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, sub_title VARCHAR(255) DEFAULT NULL, text LONGTEXT DEFAULT NULL, button_link VARCHAR(255) DEFAULT NULL, img_presentation_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, text LONGTEXT DEFAULT NULL, date_real VARCHAR(255) DEFAULT NULL, img_projet_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, typedev VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet_techno (projet_id INT NOT NULL, techno_id INT NOT NULL, INDEX IDX_1B2E5E8AC18272 (projet_id), INDEX IDX_1B2E5E8A51F3C1BC (techno_id), PRIMARY KEY(projet_id, techno_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE techno (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, help VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attribut_projet ADD CONSTRAINT FK_3506699F51383AF3 FOREIGN KEY (attribut_id) REFERENCES attribut (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attribut_projet ADD CONSTRAINT FK_3506699FC18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_techno ADD CONSTRAINT FK_1B2E5E8AC18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_techno ADD CONSTRAINT FK_1B2E5E8A51F3C1BC FOREIGN KEY (techno_id) REFERENCES techno (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attribut_projet DROP FOREIGN KEY FK_3506699F51383AF3');
        $this->addSql('ALTER TABLE attribut_projet DROP FOREIGN KEY FK_3506699FC18272');
        $this->addSql('ALTER TABLE projet_techno DROP FOREIGN KEY FK_1B2E5E8AC18272');
        $this->addSql('ALTER TABLE projet_techno DROP FOREIGN KEY FK_1B2E5E8A51F3C1BC');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE attribut');
        $this->addSql('DROP TABLE attribut_projet');
        $this->addSql('DROP TABLE comp');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE presentation');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE projet_techno');
        $this->addSql('DROP TABLE techno');
    }
}
