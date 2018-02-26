<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180226001147 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE text ADD depositor_id INT NOT NULL, ADD author_info VARCHAR(255) DEFAULT NULL');
        $this->addSql('UPDATE text SET depositor_id=author_id');
        $this->addSql('ALTER TABLE text ADD CONSTRAINT FK_3B8BA7C7EB8724B4 FOREIGN KEY (depositor_id) REFERENCES adherents (id)');
        $this->addSql('CREATE INDEX IDX_3B8BA7C7EB8724B4 ON text (depositor_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE text DROP FOREIGN KEY FK_3B8BA7C7EB8724B4');
        $this->addSql('DROP INDEX IDX_3B8BA7C7EB8724B4 ON text');
        $this->addSql('ALTER TABLE text DROP depositor_id, DROP author_info');
    }
}
