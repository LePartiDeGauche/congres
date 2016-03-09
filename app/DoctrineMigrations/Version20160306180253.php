<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160306180253 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE candidature_call (id INT AUTO_INCREMENT NOT NULL, responsability_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, openingDate DATETIME NOT NULL, closingDate DATETIME NOT NULL, vacancyNumber INT NOT NULL, gender VARCHAR(1) DEFAULT NULL, faithProfessionLength INT NOT NULL, faithProfessionDescription LONGTEXT NOT NULL, INDEX IDX_D890A0D92B8DC843 (responsability_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidature_call ADD CONSTRAINT FK_D890A0D92B8DC843 FOREIGN KEY (responsability_id) REFERENCES instances (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE candidature_call');
    }
}
