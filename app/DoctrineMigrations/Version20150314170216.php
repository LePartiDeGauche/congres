<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150314170216 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE EventAdherentRegistration DROP FOREIGN KEY FK_844D41FD4C3A3BB');
        $this->addSql('DROP TABLE EventPayment');
        $this->addSql('ALTER TABLE EventAdherentRegistration ADD CONSTRAINT FK_844D41FD4C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id)');
        $this->addSql('ALTER TABLE payment ADD payment_type VARCHAR(255) NOT NULL, ADD attachedEvent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DB92D54A4 FOREIGN KEY (attachedEvent_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_6D28840DB92D54A4 ON payment (attachedEvent_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE EventPayment (id INT AUTO_INCREMENT NOT NULL, amount DOUBLE PRECISION NOT NULL, method VARCHAR(20) NOT NULL COLLATE utf8_unicode_ci, cashed TINYINT(1) NOT NULL, drawer VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, date DATETIME NOT NULL, account VARCHAR(20) NOT NULL COLLATE utf8_unicode_ci, attachedEvent_id INT DEFAULT NULL, INDEX IDX_710EF6B8B92D54A4 (attachedEvent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE EventPayment ADD CONSTRAINT FK_710EF6B8B92D54A4 FOREIGN KEY (attachedEvent_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE EventAdherentRegistration DROP FOREIGN KEY FK_844D41FD4C3A3BB');
        $this->addSql('ALTER TABLE EventAdherentRegistration ADD CONSTRAINT FK_844D41FD4C3A3BB FOREIGN KEY (payment_id) REFERENCES EventPayment (id)');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DB92D54A4');
        $this->addSql('DROP INDEX IDX_6D28840DB92D54A4 ON payment');
        $this->addSql('ALTER TABLE payment DROP payment_type, DROP attachedEvent_id');
    }
}
