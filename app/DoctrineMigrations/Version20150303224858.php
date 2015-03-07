<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150303224858 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE voterule_responsability (voterule_id INT NOT NULL, responsability_id INT NOT NULL, INDEX IDX_ECC09543819A9688 (voterule_id), INDEX IDX_ECC095432B8DC843 (responsability_id), PRIMARY KEY(voterule_id, responsability_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE voterule_responsability ADD CONSTRAINT FK_ECC09543819A9688 FOREIGN KEY (voterule_id) REFERENCES vote_rule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voterule_responsability ADD CONSTRAINT FK_ECC095432B8DC843 FOREIGN KEY (responsability_id) REFERENCES instances (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote_rule DROP concernedResponsability');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE voterule_responsability');
        $this->addSql('ALTER TABLE vote_rule ADD concernedResponsability LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:object)\'');
    }
}
