<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210124214204 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comp (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, value INT DEFAULT NULL, color VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, objet VARCHAR(255) DEFAULT NULL, text LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE presentation (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, sub_title VARCHAR(255) DEFAULT NULL, text LONGTEXT DEFAULT NULL, button_link VARCHAR(255) DEFAULT NULL, img_presentation_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, position INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, text LONGTEXT DEFAULT NULL, date_real VARCHAR(255) DEFAULT NULL, img_projet_name VARCHAR(255) DEFAULT NULL, img_1_name VARCHAR(255) DEFAULT NULL, img_2_name VARCHAR(255) DEFAULT NULL, img_3_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, typedev VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet_techno (projet_id INT NOT NULL, techno_id INT NOT NULL, INDEX IDX_1B2E5E8AC18272 (projet_id), INDEX IDX_1B2E5E8A51F3C1BC (techno_id), PRIMARY KEY(projet_id, techno_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE techno (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, help VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projet_techno ADD CONSTRAINT FK_1B2E5E8AC18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_techno ADD CONSTRAINT FK_1B2E5E8A51F3C1BC FOREIGN KEY (techno_id) REFERENCES techno (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attribut_projet ADD CONSTRAINT FK_3506699F51383AF3 FOREIGN KEY (attribut_id) REFERENCES attribut (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attribut_projet ADD CONSTRAINT FK_3506699FC18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('DROP INDEX IDX_FB5F7F89A76ED395 ON avi');
        $this->addSql('ALTER TABLE avi ADD user VARCHAR(255) DEFAULT NULL, ADD validated TINYINT(1) NOT NULL, DROP user_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attribut_projet DROP FOREIGN KEY FK_3506699FC18272');
        $this->addSql('ALTER TABLE projet_techno DROP FOREIGN KEY FK_1B2E5E8AC18272');
        $this->addSql('ALTER TABLE projet_techno DROP FOREIGN KEY FK_1B2E5E8A51F3C1BC');
        $this->addSql('DROP TABLE comp');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE presentation');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE projet_techno');
        $this->addSql('DROP TABLE techno');
        $this->addSql('ALTER TABLE attribut_projet DROP FOREIGN KEY FK_3506699F51383AF3');
        $this->addSql('ALTER TABLE avi ADD user_id INT DEFAULT NULL, DROP user, DROP validated');
        $this->addSql('CREATE INDEX IDX_FB5F7F89A76ED395 ON avi (user_id)');
    }
}
