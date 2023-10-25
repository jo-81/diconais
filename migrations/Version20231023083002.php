<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231023083002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE resource DROP FOREIGN KEY FK_BC91F4164284E315');
        $this->addSql('DROP INDEX IDX_BC91F4164284E315 ON resource');
        $this->addSql('ALTER TABLE resource DROP socials_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE resource ADD socials_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE resource ADD CONSTRAINT FK_BC91F4164284E315 FOREIGN KEY (socials_id) REFERENCES resource_social (id)');
        $this->addSql('CREATE INDEX IDX_BC91F4164284E315 ON resource (socials_id)');
    }
}
