<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150316231027 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE EventAdherentRegistration DROP FOREIGN KEY FK_844D41FD4C3A3BB');
        $this->addSql('DROP INDEX UNIQ_844D41FD4C3A3BB ON EventAdherentRegistration');
        $this->addSql('ALTER TABLE EventAdherentRegistration DROP payment_id');
        $this->addSql('ALTER TABLE payment ADD status VARCHAR(20) NOT NULL, ADD attachedRegistration_id INT DEFAULT NULL, DROP cashed');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DA77CB429 FOREIGN KEY (attachedRegistration_id) REFERENCES EventAdherentRegistration (id)');
        $this->addSql('CREATE INDEX IDX_6D28840DA77CB429 ON payment (attachedRegistration_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE EventAdherentRegistration ADD payment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE EventAdherentRegistration ADD CONSTRAINT FK_844D41FD4C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_844D41FD4C3A3BB ON EventAdherentRegistration (payment_id)');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DA77CB429');
        $this->addSql('DROP INDEX IDX_6D28840DA77CB429 ON payment');
        $this->addSql('ALTER TABLE payment ADD cashed TINYINT(1) NOT NULL, DROP status, DROP attachedRegistration_id');
    }
}
