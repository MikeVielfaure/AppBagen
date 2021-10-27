<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210902191420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE budget (id INT AUTO_INCREMENT NOT NULL, idcompte_id INT NOT NULL, montant DOUBLE PRECISION NOT NULL, date VARCHAR(255) DEFAULT NULL, INDEX IDX_73F2F77B8CDECFD5 (idcompte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, idutilisateur_id INT NOT NULL, intitule VARCHAR(255) DEFAULT NULL, datecreation DATE NOT NULL, datecloture DATE DEFAULT NULL, datemodif DATE NOT NULL, INDEX IDX_CFF65260EAF07004 (idutilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE depense (id INT AUTO_INCREMENT NOT NULL, idcompte_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, montant DOUBLE PRECISION NOT NULL, date DATE NOT NULL, INDEX IDX_340597578CDECFD5 (idcompte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mdpoublie (id INT AUTO_INCREMENT NOT NULL, mail VARCHAR(50) NOT NULL, code VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, motdepasse VARCHAR(255) NOT NULL, nom VARCHAR(50) DEFAULT NULL, prenom VARCHAR(50) DEFAULT NULL, adresse VARCHAR(100) DEFAULT NULL, ville VARCHAR(100) DEFAULT NULL, codepostal VARCHAR(10) DEFAULT NULL, mail VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE budget ADD CONSTRAINT FK_73F2F77B8CDECFD5 FOREIGN KEY (idcompte_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF65260EAF07004 FOREIGN KEY (idutilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE depense ADD CONSTRAINT FK_340597578CDECFD5 FOREIGN KEY (idcompte_id) REFERENCES compte (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budget DROP FOREIGN KEY FK_73F2F77B8CDECFD5');
        $this->addSql('ALTER TABLE depense DROP FOREIGN KEY FK_340597578CDECFD5');
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF65260EAF07004');
        $this->addSql('DROP TABLE budget');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE depense');
        $this->addSql('DROP TABLE mdpoublie');
        $this->addSql('DROP TABLE utilisateur');
    }
}
