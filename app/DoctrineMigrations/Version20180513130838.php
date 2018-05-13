<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180513130838 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE election_result DROP FOREIGN KEY FK_1ED53AE7A708DAFF');
        $this->addSql('ALTER TABLE election_result ADD CONSTRAINT FK_1ED53AE7A708DAFF FOREIGN KEY (election_id) REFERENCES election (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE election_result DROP FOREIGN KEY FK_1ED53AE7A708DAFF');
        $this->addSql('ALTER TABLE election_result ADD CONSTRAINT FK_1ED53AE7A708DAFF FOREIGN KEY (election_id) REFERENCES election_result (id)');
    }
}
