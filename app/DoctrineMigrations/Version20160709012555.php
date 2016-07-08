<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160709012555 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE election_adherent');
        $this->addSql('DROP TABLE sleeping_facility');
        $this->addSql('DROP TABLE sleeping_spot');
        $this->addSql('ALTER TABLE EventAdherentRegistration ADD is_joining_young_event TINYINT(1) DEFAULT \'0\' NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE election_adherent (election_id INT NOT NULL, adherent_id INT NOT NULL, INDEX IDX_CA6CF2F2A708DAFF (election_id), INDEX IDX_CA6CF2F225F06C53 (adherent_id), PRIMARY KEY(election_id, adherent_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sleeping_facility (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, address_id INT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description LONGTEXT NOT NULL COLLATE utf8_unicode_ci, positionDescription LONGTEXT NOT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_FF636D7FF5B7AF75 (address_id), INDEX IDX_FF636D7F71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sleeping_spot (id INT AUTO_INCREMENT NOT NULL, sleeping_site INT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description LONGTEXT NOT NULL COLLATE utf8_unicode_ci, INDEX IDX_E0150F6530647CF2 (sleeping_site), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE election_adherent ADD CONSTRAINT FK_CA6CF2F225F06C53 FOREIGN KEY (adherent_id) REFERENCES adherents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE election_adherent ADD CONSTRAINT FK_CA6CF2F2A708DAFF FOREIGN KEY (election_id) REFERENCES election (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sleeping_facility ADD CONSTRAINT FK_FF636D7F71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE sleeping_facility ADD CONSTRAINT FK_FF636D7FF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE sleeping_spot ADD CONSTRAINT FK_E0150F6530647CF2 FOREIGN KEY (sleeping_site) REFERENCES sleeping_site (id)');
        $this->addSql('ALTER TABLE EventAdherentRegistration DROP is_joining_young_event');
    }
}
