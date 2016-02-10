<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160210151556 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE EventAdherentRegistration ADD sleepingType_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE EventAdherentRegistration ADD CONSTRAINT FK_844D41FDCF353BCF FOREIGN KEY (sleepingType_id) REFERENCES event_sleeping_type (id)');
        $this->addSql('CREATE INDEX IDX_844D41FDCF353BCF ON EventAdherentRegistration (sleepingType_id)');
        $this->addSql('ALTER TABLE EventAdherentRegistration ADD priceScale_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE EventAdherentRegistration ADD CONSTRAINT FK_844D41FD112909B5 FOREIGN KEY (priceScale_id) REFERENCES event_price_scale (id)');
        $this->addSql('CREATE INDEX IDX_844D41FD112909B5 ON EventAdherentRegistration (priceScale_id)');
        $this->addSql('ALTER TABLE EventAdherentRegistration DROP needHosting, CHANGE paymentMode paymentMode VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE EventAdherentRegistration CHANGE cost_id cost_id INT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE EventAdherentRegistration CHANGE cost_id cost_id INT NOT NULL');
        $this->addSql('ALTER TABLE EventAdherentRegistration ADD needHosting TINYINT(1) NOT NULL, CHANGE paymentMode paymentMode VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE EventAdherentRegistration DROP FOREIGN KEY FK_844D41FD112909B5');
        $this->addSql('DROP INDEX IDX_844D41FD112909B5 ON EventAdherentRegistration');
        $this->addSql('ALTER TABLE EventAdherentRegistration DROP priceScale_id');
        $this->addSql('ALTER TABLE EventAdherentRegistration DROP FOREIGN KEY FK_844D41FDCF353BCF');
        $this->addSql('DROP INDEX IDX_844D41FDCF353BCF ON EventAdherentRegistration');
        $this->addSql('ALTER TABLE EventAdherentRegistration DROP sleepingType_id');

    }
}
