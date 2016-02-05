<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160205120744 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amendment_topic (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amendments ADD amendmentTopic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE amendments ADD CONSTRAINT FK_D287B73830C5FA3 FOREIGN KEY (amendmentTopic_id) REFERENCES amendment_topic (id)');
        $this->addSql('CREATE INDEX IDX_D287B73830C5FA3 ON amendments (amendmentTopic_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amendments DROP FOREIGN KEY FK_D287B73830C5FA3');
        $this->addSql('DROP TABLE amendment_topic');
        $this->addSql('DROP INDEX IDX_D287B73830C5FA3 ON amendments');
        $this->addSql('ALTER TABLE amendments DROP amendmentTopic_id');
    }
}
