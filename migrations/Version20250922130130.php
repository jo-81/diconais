<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250922130130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE kanji_vocabulary DROP FOREIGN KEY FK_2AA0CBC3AD0E05F6');
        $this->addSql('ALTER TABLE kanji_vocabulary DROP FOREIGN KEY FK_2AA0CBC3FB3081B8');
        $this->addSql('DROP TABLE kanji_vocabulary');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE kanji_vocabulary (kanji_id INT NOT NULL, vocabulary_id INT NOT NULL, INDEX IDX_2AA0CBC3FB3081B8 (kanji_id), INDEX IDX_2AA0CBC3AD0E05F6 (vocabulary_id), PRIMARY KEY(kanji_id, vocabulary_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE kanji_vocabulary ADD CONSTRAINT FK_2AA0CBC3AD0E05F6 FOREIGN KEY (vocabulary_id) REFERENCES vocabulary (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE kanji_vocabulary ADD CONSTRAINT FK_2AA0CBC3FB3081B8 FOREIGN KEY (kanji_id) REFERENCES kanji (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
