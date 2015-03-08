<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150227182722 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE reservationnight_sleepingsite (reservationnight_id INT NOT NULL, sleepingsite_id INT NOT NULL, INDEX IDX_FBE4D1DD6C5E16A9 (reservationnight_id), INDEX IDX_FBE4D1DD33799886 (sleepingsite_id), PRIMARY KEY(reservationnight_id, sleepingsite_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservationnight_sleepingsite ADD CONSTRAINT FK_FBE4D1DD6C5E16A9 FOREIGN KEY (reservationnight_id) REFERENCES reservation_night (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservationnight_sleepingsite ADD CONSTRAINT FK_FBE4D1DD33799886 FOREIGN KEY (sleepingsite_id) REFERENCES sleeping_site (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE sleepingsite_reservationnight');
        $this->addSql('ALTER TABLE reservation_night CHANGE event event INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation_night ADD CONSTRAINT FK_52A5DF303BAE0AA7 FOREIGN KEY (event) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_52A5DF303BAE0AA7 ON reservation_night (event)');
        $this->addSql('ALTER TABLE sleeping_spot CHANGE sleeping_site sleeping_site INT NOT NULL');
        $this->addSql('ALTER TABLE sleeping_spot ADD CONSTRAINT FK_E0150F6530647CF2 FOREIGN KEY (sleeping_site) REFERENCES sleeping_site (id)');
        $this->addSql('CREATE INDEX IDX_E0150F6530647CF2 ON sleeping_spot (sleeping_site)');
        $this->addSql('ALTER TABLE sleeping_site CHANGE sleeping_facility sleeping_facility INT NOT NULL');
        $this->addSql('ALTER TABLE sleeping_site ADD CONSTRAINT FK_30647CF2FF636D7F FOREIGN KEY (sleeping_facility) REFERENCES sleeping_facility (id)');
        $this->addSql('CREATE INDEX IDX_30647CF2FF636D7F ON sleeping_site (sleeping_facility)');
        $this->addSql('ALTER TABLE sleeping_facility ADD event_id INT NOT NULL, DROP event');
        $this->addSql('ALTER TABLE sleeping_facility ADD CONSTRAINT FK_FF636D7F71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_FF636D7F71F7E88B ON sleeping_facility (event_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sleepingsite_reservationnight (sleepingsite_id INT NOT NULL, reservationnight_id INT NOT NULL, INDEX IDX_760A412333799886 (sleepingsite_id), INDEX IDX_760A41236C5E16A9 (reservationnight_id), PRIMARY KEY(sleepingsite_id, reservationnight_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sleepingsite_reservationnight ADD CONSTRAINT FK_760A412333799886 FOREIGN KEY (sleepingsite_id) REFERENCES sleeping_site (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sleepingsite_reservationnight ADD CONSTRAINT FK_760A41236C5E16A9 FOREIGN KEY (reservationnight_id) REFERENCES reservation_night (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE reservationnight_sleepingsite');
        $this->addSql('ALTER TABLE reservation_night DROP FOREIGN KEY FK_52A5DF303BAE0AA7');
        $this->addSql('DROP INDEX IDX_52A5DF303BAE0AA7 ON reservation_night');
        $this->addSql('ALTER TABLE reservation_night CHANGE event event VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE sleeping_facility DROP FOREIGN KEY FK_FF636D7F71F7E88B');
        $this->addSql('DROP INDEX IDX_FF636D7F71F7E88B ON sleeping_facility');
        $this->addSql('ALTER TABLE sleeping_facility ADD event VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP event_id');
        $this->addSql('ALTER TABLE sleeping_site DROP FOREIGN KEY FK_30647CF2FF636D7F');
        $this->addSql('DROP INDEX IDX_30647CF2FF636D7F ON sleeping_site');
        $this->addSql('ALTER TABLE sleeping_site CHANGE sleeping_facility sleeping_facility VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE sleeping_spot DROP FOREIGN KEY FK_E0150F6530647CF2');
        $this->addSql('DROP INDEX IDX_E0150F6530647CF2 ON sleeping_spot');
        $this->addSql('ALTER TABLE sleeping_spot CHANGE sleeping_site sleeping_site VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
