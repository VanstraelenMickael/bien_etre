<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220306105641 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout cascade img et prestataire';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images ADD prestataire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6ABE3DB2B7 FOREIGN KEY (prestataire_id) REFERENCES prestataire (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6ABE3DB2B7 ON images (prestataire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6ABE3DB2B7');
        $this->addSql('DROP INDEX IDX_E01FBE6ABE3DB2B7 ON images');
        $this->addSql('ALTER TABLE images DROP prestataire_id');
    }
}
