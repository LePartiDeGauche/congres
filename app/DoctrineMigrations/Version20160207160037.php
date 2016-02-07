<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160207160037 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE eventpricescale_event (eventpricescale_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_40DA42045F1703B9 (eventpricescale_id), INDEX IDX_40DA420471F7E88B (event_id), PRIMARY KEY(eventpricescale_id, event_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eventpricescale_event ADD CONSTRAINT FK_40DA42045F1703B9 FOREIGN KEY (eventpricescale_id) REFERENCES event_price_scale (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eventpricescale_event ADD CONSTRAINT FK_40DA420471F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE eventpricescale_event');
    }
}
