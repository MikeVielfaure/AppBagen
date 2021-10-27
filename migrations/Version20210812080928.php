<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210812080928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE budget (id INT AUTO_INCREMENT NOT NULL, idcompte_id INT NOT NULL, montant DOUBLE PRECISION NOT NULL, date VARCHAR(255) DEFAULT NULL, INDEX IDX_73F2F77B8CDECFD5 (idcompte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE depense (id INT AUTO_INCREMENT NOT NULL, idcompte_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, montant DOUBLE PRECISION NOT NULL, date DATE NOT NULL, INDEX IDX_340597578CDECFD5 (idcompte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE budget ADD CONSTRAINT FK_73F2F77B8CDECFD5 FOREIGN KEY (idcompte_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE depense ADD CONSTRAINT FK_340597578CDECFD5 FOREIGN KEY (idcompte_id) REFERENCES compte (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE budget');
        $this->addSql('DROP TABLE depense');
    }
}
