<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250922130419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vocabulary_kanji (vocabulary_id INT NOT NULL, kanji_id INT NOT NULL, INDEX IDX_70EC1036AD0E05F6 (vocabulary_id), INDEX IDX_70EC1036FB3081B8 (kanji_id), PRIMARY KEY(vocabulary_id, kanji_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vocabulary_kanji ADD CONSTRAINT FK_70EC1036AD0E05F6 FOREIGN KEY (vocabulary_id) REFERENCES vocabulary (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vocabulary_kanji ADD CONSTRAINT FK_70EC1036FB3081B8 FOREIGN KEY (kanji_id) REFERENCES kanji (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vocabulary_kanji DROP FOREIGN KEY FK_70EC1036AD0E05F6');
        $this->addSql('ALTER TABLE vocabulary_kanji DROP FOREIGN KEY FK_70EC1036FB3081B8');
        $this->addSql('DROP TABLE vocabulary_kanji');
    }
}
