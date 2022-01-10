<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220110125635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'delete on cascade';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE internaute DROP FOREIGN KEY FK_6C8E97CCA76ED395');
        $this->addSql('ALTER TABLE internaute ADD CONSTRAINT FK_6C8E97CCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649CAF41882');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CAF41882 FOREIGN KEY (internaute_id) REFERENCES internaute (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE internaute DROP FOREIGN KEY FK_6C8E97CCA76ED395');
        $this->addSql('ALTER TABLE internaute ADD CONSTRAINT FK_6C8E97CCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649CAF41882');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CAF41882 FOREIGN KEY (internaute_id) REFERENCES internaute (id)');
    }
}
