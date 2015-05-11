<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150507172748 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amendments (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, text_id INT DEFAULT NULL, start_line INT NOT NULL, type VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_D287B73F675F31B (author_id), INDEX IDX_D287B73698D3548 (text_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amendments ADD CONSTRAINT FK_D287B73F675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE amendments ADD CONSTRAINT FK_D287B73698D3548 FOREIGN KEY (text_id) REFERENCES text (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE amendments');
    }
}
