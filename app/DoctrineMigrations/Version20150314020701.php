<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150314020701 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE EventAdherentRegistration (id INT AUTO_INCREMENT NOT NULL, adherent_id INT NOT NULL, payment_id INT DEFAULT NULL, role_id INT NOT NULL, event_id INT NOT NULL, need_hosting TINYINT(1) NOT NULL, paymentMode VARCHAR(255) NOT NULL, registrationDate DATETIME NOT NULL, INDEX IDX_844D41FD25F06C53 (adherent_id), UNIQUE INDEX UNIQ_844D41FD4C3A3BB (payment_id), INDEX IDX_844D41FDD60322AC (role_id), INDEX IDX_844D41FD71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE EventPayment (id INT AUTO_INCREMENT NOT NULL, amount DOUBLE PRECISION NOT NULL, method VARCHAR(20) NOT NULL, cashed TINYINT(1) NOT NULL, drawer VARCHAR(255) NOT NULL, date DATETIME NOT NULL, account VARCHAR(20) NOT NULL, attachedEvent_id INT DEFAULT NULL, INDEX IDX_710EF6B8B92D54A4 (attachedEvent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE EventAdherentRegistration ADD CONSTRAINT FK_844D41FD25F06C53 FOREIGN KEY (adherent_id) REFERENCES adherents (id)');
        $this->addSql('ALTER TABLE EventAdherentRegistration ADD CONSTRAINT FK_844D41FD4C3A3BB FOREIGN KEY (payment_id) REFERENCES EventPayment (id)');
        $this->addSql('ALTER TABLE EventAdherentRegistration ADD CONSTRAINT FK_844D41FDD60322AC FOREIGN KEY (role_id) REFERENCES event_role (id)');
        $this->addSql('ALTER TABLE EventAdherentRegistration ADD CONSTRAINT FK_844D41FD71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE EventPayment ADD CONSTRAINT FK_710EF6B8B92D54A4 FOREIGN KEY (attachedEvent_id) REFERENCES event (id)');
        $this->addSql('DROP TABLE event_participant');
        $this->addSql('ALTER TABLE event DROP payments');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE EventAdherentRegistration DROP FOREIGN KEY FK_844D41FD4C3A3BB');
        $this->addSql('CREATE TABLE event_participant (event_id INT NOT NULL, participant_id INT NOT NULL, UNIQUE INDEX UNIQ_7C16B8919D1C3019 (participant_id), INDEX IDX_7C16B89171F7E88B (event_id), PRIMARY KEY(event_id, participant_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_participant ADD CONSTRAINT FK_7C16B89171F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE event_participant ADD CONSTRAINT FK_7C16B8919D1C3019 FOREIGN KEY (participant_id) REFERENCES adherents (id)');
        $this->addSql('DROP TABLE EventAdherentRegistration');
        $this->addSql('DROP TABLE EventPayment');
        $this->addSql('ALTER TABLE event ADD payments LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:object)\'');
    }
}
