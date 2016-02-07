<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160207162737 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE eventsleepingtype_event (eventsleepingtype_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_C43844383B5E9AF (eventsleepingtype_id), INDEX IDX_C438443871F7E88B (event_id), PRIMARY KEY(eventsleepingtype_id, event_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eventsleepingtype_event ADD CONSTRAINT FK_C43844383B5E9AF FOREIGN KEY (eventsleepingtype_id) REFERENCES event_sleeping_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eventsleepingtype_event ADD CONSTRAINT FK_C438443871F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE eventsleepingtype_event');
    }
}
