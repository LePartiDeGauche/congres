<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150316020842 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE EventCost (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, cost INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE EventAdherentRegistration ADD cost_id INT NOT NULL');
        $this->addSql('ALTER TABLE EventAdherentRegistration ADD CONSTRAINT FK_844D41FD1DBF857F FOREIGN KEY (cost_id) REFERENCES EventCost (id)');
        $this->addSql('CREATE INDEX IDX_844D41FD1DBF857F ON EventAdherentRegistration (cost_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE EventAdherentRegistration DROP FOREIGN KEY FK_844D41FD1DBF857F');
        $this->addSql('DROP TABLE EventCost');
        $this->addSql('DROP INDEX IDX_844D41FD1DBF857F ON EventAdherentRegistration');
        $this->addSql('ALTER TABLE EventAdherentRegistration DROP cost_id');
    }
}
