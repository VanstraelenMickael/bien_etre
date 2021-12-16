<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211216124228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création de la relation entre les prestaraires et les services';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE prestataire_categorie_de_services (prestataire_id INT NOT NULL, categorie_de_services_id INT NOT NULL, INDEX IDX_603DD9ABBE3DB2B7 (prestataire_id), INDEX IDX_603DD9AB4A81A587 (categorie_de_services_id), PRIMARY KEY(prestataire_id, categorie_de_services_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE prestataire_categorie_de_services ADD CONSTRAINT FK_603DD9ABBE3DB2B7 FOREIGN KEY (prestataire_id) REFERENCES prestataire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prestataire_categorie_de_services ADD CONSTRAINT FK_603DD9AB4A81A587 FOREIGN KEY (categorie_de_services_id) REFERENCES categorie_de_services (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE prestataire_categorie_de_services');
    }
}
