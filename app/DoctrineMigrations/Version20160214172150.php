<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160214172150 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE EventAdherentRegistration DROP FOREIGN KEY FK_844D41FD1DBF857F');
        $this->addSql('ALTER TABLE EventAdherentRegistration ADD CONSTRAINT FK_844D41FD1DBF857F FOREIGN KEY (cost_id) REFERENCES EventCost (id) ON DELETE SET NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE EventAdherentRegistration DROP FOREIGN KEY FK_844D41FD1DBF857F');
        $this->addSql('ALTER TABLE EventAdherentRegistration ADD CONSTRAINT FK_844D41FD1DBF857F FOREIGN KEY (cost_id) REFERENCES EventCost (id)');
    }
}
