<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160204124029 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE process_participation_rule (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amendment_process (id INT AUTO_INCREMENT NOT NULL, textgroup_id INT NOT NULL, name VARCHAR(255) NOT NULL, begin DATETIME NOT NULL, end DATETIME NOT NULL, participationRule_id INT DEFAULT NULL, INDEX IDX_977AE423AEBD1705 (textgroup_id), INDEX IDX_977AE42338A55B6B (participationRule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE process_participation_rule_term (id INT AUTO_INCREMENT NOT NULL, responsability_id INT DEFAULT NULL, organType_id INT DEFAULT NULL, participationRule_id INT DEFAULT NULL, INDEX IDX_EF18E83D2B8DC843 (responsability_id), INDEX IDX_EF18E83DAD828C32 (organType_id), INDEX IDX_EF18E83D38A55B6B (participationRule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amendment_process ADD CONSTRAINT FK_977AE423AEBD1705 FOREIGN KEY (textgroup_id) REFERENCES text_group (id)');
        $this->addSql('ALTER TABLE amendment_process ADD CONSTRAINT FK_977AE42338A55B6B FOREIGN KEY (participationRule_id) REFERENCES process_participation_rule (id)');
        $this->addSql('ALTER TABLE process_participation_rule_term ADD CONSTRAINT FK_EF18E83D2B8DC843 FOREIGN KEY (responsability_id) REFERENCES instances (id)');
        $this->addSql('ALTER TABLE process_participation_rule_term ADD CONSTRAINT FK_EF18E83DAD828C32 FOREIGN KEY (organType_id) REFERENCES organ_type (id)');
        $this->addSql('ALTER TABLE process_participation_rule_term ADD CONSTRAINT FK_EF18E83D38A55B6B FOREIGN KEY (participationRule_id) REFERENCES process_participation_rule (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amendment_process DROP FOREIGN KEY FK_977AE42338A55B6B');
        $this->addSql('ALTER TABLE process_participation_rule_term DROP FOREIGN KEY FK_EF18E83D38A55B6B');
        $this->addSql('DROP TABLE process_participation_rule');
        $this->addSql('DROP TABLE amendment_process');
        $this->addSql('DROP TABLE process_participation_rule_term');
    }
}
