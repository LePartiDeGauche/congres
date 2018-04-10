<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180408194219 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amendments DROP FOREIGN KEY FK_D287B7351BAA214, DROP FOREIGN KEY FK_D287B73698D3548, DROP FOREIGN KEY FK_D287B73830C5FA3, DROP FOREIGN KEY FK_D287B73E4445171, DROP FOREIGN KEY FK_D287B73F675F31B');
        $this->addSql('CREATE TABLE amendment_deposits (id INT AUTO_INCREMENT NOT NULL, mandatary_id INT NOT NULL, depositor_id INT NOT NULL, mandatary_info VARCHAR(255) NOT NULL, origin VARCHAR(255) NOT NULL, origin_info VARCHAR(255) DEFAULT NULL, meetingDate DATE NOT NULL, meeting_place VARCHAR(255) NOT NULL, number_present INT NOT NULL, amendmentProcess_id INT NOT NULL, INDEX IDX_FF84BC615938CE63 (mandatary_id), INDEX IDX_FF84BC61EB8724B4 (depositor_id), INDEX IDX_FF84BC6151BAA214 (amendmentProcess_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amendment_items (id INT AUTO_INCREMENT NOT NULL, text_id INT DEFAULT NULL, start_line INT NOT NULL, end_line INT NOT NULL, type VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, explanation LONGTEXT NOT NULL, for_vote INT NOT NULL, against_vote INT NOT NULL, abstention_vote INT NOT NULL, dtpv_vote INT NOT NULL, amendmentDeposit_id INT DEFAULT NULL, INDEX IDX_10CCF897B76DB3D1 (amendmentDeposit_id), INDEX IDX_10CCF897698D3548 (text_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amendment_deposits ADD CONSTRAINT FK_FF84BC615938CE63 FOREIGN KEY (mandatary_id) REFERENCES adherents (id)');
        $this->addSql('ALTER TABLE amendment_deposits ADD CONSTRAINT FK_FF84BC61EB8724B4 FOREIGN KEY (depositor_id) REFERENCES adherents (id)');
        $this->addSql('ALTER TABLE amendment_deposits ADD CONSTRAINT FK_FF84BC6151BAA214 FOREIGN KEY (amendmentProcess_id) REFERENCES amendment_process (id)');
        $this->addSql('ALTER TABLE amendment_items ADD CONSTRAINT FK_10CCF897B76DB3D1 FOREIGN KEY (amendmentDeposit_id) REFERENCES amendment_deposits (id)');
        $this->addSql('ALTER TABLE amendment_items ADD CONSTRAINT FK_10CCF897698D3548 FOREIGN KEY (text_id) REFERENCES text (id)');
        $this->addSql('RENAME TABLE amendment_topic TO archive_amendment_topic');
        $this->addSql('RENAME TABLE amendments TO archive_amendments');
        $this->addSql('ALTER TABLE amendment_process ADD description LONGTEXT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amendment_items DROP FOREIGN KEY FK_10CCF897B76DB3D1');
        $this->addSql('CREATE TABLE amendment_topic (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description LONGTEXT NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amendments (id INT AUTO_INCREMENT NOT NULL, text_id INT DEFAULT NULL, organ_id INT NOT NULL, author_id INT NOT NULL, start_line INT NOT NULL, end_line INT NOT NULL, nature VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, type VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, content LONGTEXT NOT NULL COLLATE utf8_unicode_ci, explanation LONGTEXT NOT NULL COLLATE utf8_unicode_ci, meetingDate DATE DEFAULT NULL, number_present INT DEFAULT NULL, amendmentProcess_id INT NOT NULL, amendmentTopic_id INT DEFAULT NULL, INDEX IDX_D287B73F675F31B (author_id), INDEX IDX_D287B73698D3548 (text_id), INDEX IDX_D287B7351BAA214 (amendmentProcess_id), INDEX IDX_D287B73830C5FA3 (amendmentTopic_id), INDEX IDX_D287B73E4445171 (organ_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amendments ADD CONSTRAINT FK_D287B7351BAA214 FOREIGN KEY (amendmentProcess_id) REFERENCES amendment_process (id)');
        $this->addSql('ALTER TABLE amendments ADD CONSTRAINT FK_D287B73698D3548 FOREIGN KEY (text_id) REFERENCES text (id)');
        $this->addSql('ALTER TABLE amendments ADD CONSTRAINT FK_D287B73830C5FA3 FOREIGN KEY (amendmentTopic_id) REFERENCES amendment_topic (id)');
        $this->addSql('ALTER TABLE amendments ADD CONSTRAINT FK_D287B73E4445171 FOREIGN KEY (organ_id) REFERENCES organ (id)');
        $this->addSql('ALTER TABLE amendments ADD CONSTRAINT FK_D287B73F675F31B FOREIGN KEY (author_id) REFERENCES adherents (id)');
        $this->addSql('DROP TABLE amendment_deposits');
        $this->addSql('DROP TABLE amendment_items');
    }
}
