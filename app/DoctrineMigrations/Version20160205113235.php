<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160205113235 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE IF EXISTS amendments');
        $this->addSql('CREATE TABLE amendments (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, organ_id INT NOT NULL, text_id INT DEFAULT NULL, start_line INT NOT NULL, end_line INT NOT NULL, nature VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, explanation LONGTEXT NOT NULL, meetingDate DATE DEFAULT NULL, number_present INT DEFAULT NULL, amendmentProcess_id INT NOT NULL, INDEX IDX_D287B73F675F31B (author_id), INDEX IDX_D287B73E4445171 (organ_id), INDEX IDX_D287B73698D3548 (text_id), INDEX IDX_D287B7351BAA214 (amendmentProcess_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amendments ADD CONSTRAINT FK_D287B73F675F31B FOREIGN KEY (author_id) REFERENCES adherents (id)');
        $this->addSql('ALTER TABLE amendments ADD CONSTRAINT FK_D287B73E4445171 FOREIGN KEY (organ_id) REFERENCES organ (id)');
        $this->addSql('ALTER TABLE amendments ADD CONSTRAINT FK_D287B73698D3548 FOREIGN KEY (text_id) REFERENCES text (id)');
        $this->addSql('ALTER TABLE amendments ADD CONSTRAINT FK_D287B7351BAA214 FOREIGN KEY (amendmentProcess_id) REFERENCES amendment_process (id)');
        $this->addSql('ALTER TABLE amendment_process DROP FOREIGN KEY FK_977AE423AEBD1705');
        $this->addSql('DROP INDEX idx_977ae423aebd1705 ON amendment_process');
        $this->addSql('CREATE INDEX IDX_977AE42357CB7553 ON amendment_process (textGroup_id)');
        $this->addSql('ALTER TABLE amendment_process ADD CONSTRAINT FK_977AE423AEBD1705 FOREIGN KEY (textgroup_id) REFERENCES text_group (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE amendments');
        $this->addSql('ALTER TABLE amendment_process DROP FOREIGN KEY FK_977AE42357CB7553');
        $this->addSql('DROP INDEX idx_977ae42357cb7553 ON amendment_process');
        $this->addSql('CREATE INDEX IDX_977AE423AEBD1705 ON amendment_process (textgroup_id)');
        $this->addSql('ALTER TABLE amendment_process ADD CONSTRAINT FK_977AE42357CB7553 FOREIGN KEY (textGroup_id) REFERENCES text_group (id)');
    }
}
