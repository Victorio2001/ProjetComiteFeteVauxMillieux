<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240701064917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lier DROP CONSTRAINT FK_B133E8FACD8E394E');
        $this->addSql('ALTER TABLE lier DROP CONSTRAINT FK_B133E8FAEFB9C8A5');
        $this->addSql('ALTER TABLE lier ADD CONSTRAINT FK_B133E8FACD8E394E FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lier ADD CONSTRAINT FK_B133E8FAEFB9C8A5 FOREIGN KEY (association_id) REFERENCES association (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE materiel ADD archiver BOOLEAN DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE lier DROP CONSTRAINT fk_b133e8facd8e394e');
        $this->addSql('ALTER TABLE lier DROP CONSTRAINT fk_b133e8faefb9c8a5');
        $this->addSql('ALTER TABLE lier ADD CONSTRAINT fk_b133e8facd8e394e FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lier ADD CONSTRAINT fk_b133e8faefb9c8a5 FOREIGN KEY (association_id) REFERENCES association (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE materiel DROP archiver');
    }
}
