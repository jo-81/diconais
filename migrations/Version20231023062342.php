<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231023062342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Suppression de l\'entité Social';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE resource_social DROP FOREIGN KEY FK_B99D0B7DFFEB5B27');
        $this->addSql('DROP TABLE social');
        $this->addSql('DROP INDEX IDX_B99D0B7DFFEB5B27 ON resource_social');
        $this->addSql('ALTER TABLE resource_social DROP social_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE social (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, color VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, icon VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_7161E187659429DB (icon), UNIQUE INDEX UNIQ_7161E1875E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE resource_social ADD social_id INT NOT NULL');
        $this->addSql('ALTER TABLE resource_social ADD CONSTRAINT FK_B99D0B7DFFEB5B27 FOREIGN KEY (social_id) REFERENCES social (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_B99D0B7DFFEB5B27 ON resource_social (social_id)');
    }
}
