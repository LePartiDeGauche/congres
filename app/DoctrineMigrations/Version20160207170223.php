<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160207170223 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE EventCost ADD priceScale_id INT DEFAULT NULL, ADD sleepingType_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE EventCost ADD CONSTRAINT FK_66416548112909B5 FOREIGN KEY (priceScale_id) REFERENCES event_price_scale (id)');
        $this->addSql('ALTER TABLE EventCost ADD CONSTRAINT FK_66416548CF353BCF FOREIGN KEY (sleepingType_id) REFERENCES event_sleeping_type (id)');
        $this->addSql('CREATE INDEX IDX_66416548112909B5 ON EventCost (priceScale_id)');
        $this->addSql('CREATE INDEX IDX_66416548CF353BCF ON EventCost (sleepingType_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE EventCost DROP FOREIGN KEY FK_66416548112909B5');
        $this->addSql('ALTER TABLE EventCost DROP FOREIGN KEY FK_66416548CF353BCF');
        $this->addSql('DROP INDEX IDX_66416548112909B5 ON EventCost');
        $this->addSql('DROP INDEX IDX_66416548CF353BCF ON EventCost');
        $this->addSql('ALTER TABLE EventCost DROP priceScale_id, DROP sleepingType_id');
    }
}
