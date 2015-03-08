<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150227165037 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, streetNumber VARCHAR(20) NOT NULL, streetType VARCHAR(255) NOT NULL, streetName VARCHAR(255) NOT NULL, cityCode VARCHAR(255) NOT NULL, cityName VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bednights (id INT AUTO_INCREMENT NOT NULL, sleepingSpot LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\', night LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\', payment LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\', notes LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_night (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, event VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, payments LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_participant (event_id INT NOT NULL, participant_id INT NOT NULL, INDEX IDX_7C16B89171F7E88B (event_id), UNIQUE INDEX UNIQ_7C16B8919D1C3019 (participant_id), PRIMARY KEY(event_id, participant_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sleeping_spot (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, sleeping_site VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sleeping_site (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, sleeping_facility VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sleepingsite_reservationnight (sleepingsite_id INT NOT NULL, reservationnight_id INT NOT NULL, INDEX IDX_760A412333799886 (sleepingsite_id), INDEX IDX_760A41236C5E16A9 (reservationnight_id), PRIMARY KEY(sleepingsite_id, reservationnight_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_role (id INT AUTO_INCREMENT NOT NULL, event INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_48A2C6C13BAE0AA7 (event), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eventrole_instance (eventrole_id INT NOT NULL, instance_id INT NOT NULL, INDEX IDX_DFAB3FB51DA9B27D (eventrole_id), INDEX IDX_DFAB3FB53A51721D (instance_id), PRIMARY KEY(eventrole_id, instance_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sleeping_facility (id INT AUTO_INCREMENT NOT NULL, address_id INT NOT NULL, event VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, positionDescription LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_FF636D7FF5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, amount INT NOT NULL, method LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\', cashed TINYINT(1) NOT NULL, drawer LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\', recipient LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\', author LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\', date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_participant ADD CONSTRAINT FK_7C16B89171F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE event_participant ADD CONSTRAINT FK_7C16B8919D1C3019 FOREIGN KEY (participant_id) REFERENCES adherents (id)');
        $this->addSql('ALTER TABLE sleepingsite_reservationnight ADD CONSTRAINT FK_760A412333799886 FOREIGN KEY (sleepingsite_id) REFERENCES sleeping_site (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sleepingsite_reservationnight ADD CONSTRAINT FK_760A41236C5E16A9 FOREIGN KEY (reservationnight_id) REFERENCES reservation_night (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_role ADD CONSTRAINT FK_48A2C6C13BAE0AA7 FOREIGN KEY (event) REFERENCES event (id)');
        $this->addSql('ALTER TABLE eventrole_instance ADD CONSTRAINT FK_DFAB3FB51DA9B27D FOREIGN KEY (eventrole_id) REFERENCES event_role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eventrole_instance ADD CONSTRAINT FK_DFAB3FB53A51721D FOREIGN KEY (instance_id) REFERENCES instances (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sleeping_facility ADD CONSTRAINT FK_FF636D7FF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sleeping_facility DROP FOREIGN KEY FK_FF636D7FF5B7AF75');
        $this->addSql('ALTER TABLE sleepingsite_reservationnight DROP FOREIGN KEY FK_760A41236C5E16A9');
        $this->addSql('ALTER TABLE event_participant DROP FOREIGN KEY FK_7C16B89171F7E88B');
        $this->addSql('ALTER TABLE event_role DROP FOREIGN KEY FK_48A2C6C13BAE0AA7');
        $this->addSql('ALTER TABLE sleepingsite_reservationnight DROP FOREIGN KEY FK_760A412333799886');
        $this->addSql('ALTER TABLE eventrole_instance DROP FOREIGN KEY FK_DFAB3FB51DA9B27D');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE bednights');
        $this->addSql('DROP TABLE reservation_night');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_participant');
        $this->addSql('DROP TABLE sleeping_spot');
        $this->addSql('DROP TABLE sleeping_site');
        $this->addSql('DROP TABLE sleepingsite_reservationnight');
        $this->addSql('DROP TABLE event_role');
        $this->addSql('DROP TABLE eventrole_instance');
        $this->addSql('DROP TABLE sleeping_facility');
        $this->addSql('DROP TABLE payment');
    }
}
