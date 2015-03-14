<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150314145601 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE eventadherentregistration_eventmeal (eventadherentregistration_id INT NOT NULL, eventmeal_id INT NOT NULL, INDEX IDX_9BE7984986CDF7F8 (eventadherentregistration_id), INDEX IDX_9BE79849A83CF607 (eventmeal_id), PRIMARY KEY(eventadherentregistration_id, eventmeal_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE EventMeal (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, mealTime DATETIME NOT NULL, INDEX IDX_E0917F2871F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eventadherentregistration_eventmeal ADD CONSTRAINT FK_9BE7984986CDF7F8 FOREIGN KEY (eventadherentregistration_id) REFERENCES EventAdherentRegistration (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eventadherentregistration_eventmeal ADD CONSTRAINT FK_9BE79849A83CF607 FOREIGN KEY (eventmeal_id) REFERENCES EventMeal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE EventMeal ADD CONSTRAINT FK_E0917F2871F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE eventadherentregistration_eventmeal DROP FOREIGN KEY FK_9BE79849A83CF607');
        $this->addSql('DROP TABLE eventadherentregistration_eventmeal');
        $this->addSql('DROP TABLE EventMeal');
    }
}
