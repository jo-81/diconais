<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231009193611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `admin` (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, color VARCHAR(10) NOT NULL, UNIQUE INDEX UNIQ_64C19C15E237E06 (name), UNIQUE INDEX UNIQ_64C19C1989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', edited_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_169E6FB92B36786B (title), UNIQUE INDEX UNIQ_169E6FB9989D9B62 (slug), INDEX IDX_169E6FB912469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forget_password (id INT AUTO_INCREMENT NOT NULL, person_id INT NOT NULL, token VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', limited_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_C816EDE2217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kanji (id INT AUTO_INCREMENT NOT NULL, file_id INT NOT NULL, key_id INT DEFAULT NULL, ideogramme VARCHAR(255) NOT NULL, number_key INT NOT NULL, level VARCHAR(20) NOT NULL, on_reading VARCHAR(255) DEFAULT NULL, kun_reading VARCHAR(255) DEFAULT NULL, number_stroke INT NOT NULL, published TINYINT(1) NOT NULL, similars JSON DEFAULT NULL, UNIQUE INDEX UNIQ_426F9DDC92FFC1D2 (ideogramme), UNIQUE INDEX UNIQ_426F9DDC93CB796C (file_id), UNIQUE INDEX UNIQ_426F9DDCD145533 (key_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kanji_vocabulary (id INT AUTO_INCREMENT NOT NULL, ideogramme_id INT NOT NULL, signification VARCHAR(255) NOT NULL, kana VARCHAR(255) NOT NULL, kanji VARCHAR(255) NOT NULL, INDEX IDX_2AA0CBC317AF2D7E (ideogramme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE link_resource (id INT AUTO_INCREMENT NOT NULL, course_id INT NOT NULL, resource_id INT NOT NULL, link VARCHAR(255) NOT NULL, INDEX IDX_713B94DF591CC992 (course_id), INDEX IDX_713B94DF89329D25 (resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resource (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_BC91F4165E237E06 (name), UNIQUE INDEX UNIQ_BC91F416989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resource_social (id INT AUTO_INCREMENT NOT NULL, social_id INT NOT NULL, resource_id INT NOT NULL, link VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B99D0B7D36AC99F1 (link), INDEX IDX_B99D0B7DFFEB5B27 (social_id), INDEX IDX_B99D0B7D89329D25 (resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(10) NOT NULL, icon VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_7161E1875E237E06 (name), UNIQUE INDEX UNIQ_7161E187659429DB (icon), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, avatar_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, edited_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', discr VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D64986383B10 (avatar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `admin` ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610BF396750 FOREIGN KEY (id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE forget_password ADD CONSTRAINT FK_C816EDE2217BBB47 FOREIGN KEY (person_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FBF396750 FOREIGN KEY (id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE kanji ADD CONSTRAINT FK_426F9DDC93CB796C FOREIGN KEY (file_id) REFERENCES file (id)');
        $this->addSql('ALTER TABLE kanji ADD CONSTRAINT FK_426F9DDCD145533 FOREIGN KEY (key_id) REFERENCES kanji (id)');
        $this->addSql('ALTER TABLE kanji_vocabulary ADD CONSTRAINT FK_2AA0CBC317AF2D7E FOREIGN KEY (ideogramme_id) REFERENCES kanji (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE link_resource ADD CONSTRAINT FK_713B94DF591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE link_resource ADD CONSTRAINT FK_713B94DF89329D25 FOREIGN KEY (resource_id) REFERENCES resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resource_social ADD CONSTRAINT FK_B99D0B7DFFEB5B27 FOREIGN KEY (social_id) REFERENCES social (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resource_social ADD CONSTRAINT FK_B99D0B7D89329D25 FOREIGN KEY (resource_id) REFERENCES resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D64986383B10 FOREIGN KEY (avatar_id) REFERENCES image (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `admin` DROP FOREIGN KEY FK_880E0D76BF396750');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB912469DE2');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610BF396750');
        $this->addSql('ALTER TABLE forget_password DROP FOREIGN KEY FK_C816EDE2217BBB47');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FBF396750');
        $this->addSql('ALTER TABLE kanji DROP FOREIGN KEY FK_426F9DDC93CB796C');
        $this->addSql('ALTER TABLE kanji DROP FOREIGN KEY FK_426F9DDCD145533');
        $this->addSql('ALTER TABLE kanji_vocabulary DROP FOREIGN KEY FK_2AA0CBC317AF2D7E');
        $this->addSql('ALTER TABLE link_resource DROP FOREIGN KEY FK_713B94DF591CC992');
        $this->addSql('ALTER TABLE link_resource DROP FOREIGN KEY FK_713B94DF89329D25');
        $this->addSql('ALTER TABLE resource_social DROP FOREIGN KEY FK_B99D0B7DFFEB5B27');
        $this->addSql('ALTER TABLE resource_social DROP FOREIGN KEY FK_B99D0B7D89329D25');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64986383B10');
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE forget_password');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE kanji');
        $this->addSql('DROP TABLE kanji_vocabulary');
        $this->addSql('DROP TABLE link_resource');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE resource');
        $this->addSql('DROP TABLE resource_social');
        $this->addSql('DROP TABLE social');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
