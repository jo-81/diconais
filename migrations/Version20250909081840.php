<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250909081840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return "Create Ideogramme, Kanji and Key entities.";
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ideogramme (id INT AUTO_INCREMENT NOT NULL, signification VARCHAR(255) NOT NULL, number_stroke VARCHAR(255) NOT NULL, kunyomi VARCHAR(255) DEFAULT NULL, ideogramme VARCHAR(255) NOT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kanji (id INT NOT NULL, onyomi VARCHAR(255) DEFAULT NULL, level VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kanji_key (kanji_id INT NOT NULL, key_id INT NOT NULL, INDEX IDX_2405C805FB3081B8 (kanji_id), INDEX IDX_2405C805D145533 (key_id), PRIMARY KEY(kanji_id, key_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kanji_kanji (kanji_source INT NOT NULL, kanji_target INT NOT NULL, INDEX IDX_9466F04E415D8476 (kanji_source), INDEX IDX_9466F04E58B8D4F9 (kanji_target), PRIMARY KEY(kanji_source, kanji_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `key` (id INT NOT NULL, number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE kanji ADD CONSTRAINT FK_426F9DDCBF396750 FOREIGN KEY (id) REFERENCES ideogramme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE kanji_key ADD CONSTRAINT FK_2405C805FB3081B8 FOREIGN KEY (kanji_id) REFERENCES kanji (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE kanji_key ADD CONSTRAINT FK_2405C805D145533 FOREIGN KEY (key_id) REFERENCES `key` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE kanji_kanji ADD CONSTRAINT FK_9466F04E415D8476 FOREIGN KEY (kanji_source) REFERENCES kanji (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE kanji_kanji ADD CONSTRAINT FK_9466F04E58B8D4F9 FOREIGN KEY (kanji_target) REFERENCES kanji (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `key` ADD CONSTRAINT FK_8A90ABA9BF396750 FOREIGN KEY (id) REFERENCES ideogramme (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE kanji DROP FOREIGN KEY FK_426F9DDCBF396750');
        $this->addSql('ALTER TABLE kanji_key DROP FOREIGN KEY FK_2405C805FB3081B8');
        $this->addSql('ALTER TABLE kanji_key DROP FOREIGN KEY FK_2405C805D145533');
        $this->addSql('ALTER TABLE kanji_kanji DROP FOREIGN KEY FK_9466F04E415D8476');
        $this->addSql('ALTER TABLE kanji_kanji DROP FOREIGN KEY FK_9466F04E58B8D4F9');
        $this->addSql('ALTER TABLE `key` DROP FOREIGN KEY FK_8A90ABA9BF396750');
        $this->addSql('DROP TABLE ideogramme');
        $this->addSql('DROP TABLE kanji');
        $this->addSql('DROP TABLE kanji_key');
        $this->addSql('DROP TABLE kanji_kanji');
        $this->addSql('DROP TABLE `key`');
    }
}
