<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150314144215 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event ADD registration_begin DATETIME NOT NULL, ADD registration_end DATETIME NOT NULL');
        $this->addSql('ALTER TABLE EventAdherentRegistration ADD author_id INT NOT NULL');
        $this->addSql('ALTER TABLE EventAdherentRegistration ADD CONSTRAINT FK_844D41FDF675F31B FOREIGN KEY (author_id) REFERENCES adherents (id)');
        $this->addSql('CREATE INDEX IDX_844D41FDF675F31B ON EventAdherentRegistration (author_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE EventAdherentRegistration DROP FOREIGN KEY FK_844D41FDF675F31B');
        $this->addSql('DROP INDEX IDX_844D41FDF675F31B ON EventAdherentRegistration');
        $this->addSql('ALTER TABLE EventAdherentRegistration DROP author_id');
        $this->addSql('ALTER TABLE event DROP registration_begin, DROP registration_end');
    }
}
