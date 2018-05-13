<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180513142611 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE result');
        $this->addSql('ALTER TABLE election_result ADD type VARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE result (id INT AUTO_INCREMENT NOT NULL, result_id INT DEFAULT NULL, election_id INT DEFAULT NULL, INDEX IDX_136AC113A708DAFF (election_id), INDEX IDX_136AC1137A7B643 (result_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC1137A7B643 FOREIGN KEY (result_id) REFERENCES election (id)');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113A708DAFF FOREIGN KEY (election_id) REFERENCES election (id)');
        $this->addSql('ALTER TABLE election_result DROP type');
    }
}
