<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240628183329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE materiel_reservation ADD mail_reservation VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE materiel_reservation ADD type_structure VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE materiel_reservation ADD nom_user_reservation VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE materiel_reservation ADD prenom_user_reservation VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE materiel_reservation DROP mail_reservation');
        $this->addSql('ALTER TABLE materiel_reservation DROP type_structure');
        $this->addSql('ALTER TABLE materiel_reservation DROP nom_user_reservation');
        $this->addSql('ALTER TABLE materiel_reservation DROP prenom_user_reservation');
    }
}
