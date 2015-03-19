<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150319012944 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE individual_text_vote_agregation (id INT AUTO_INCREMENT NOT NULL, text_id INT NOT NULL, voteFor INT NOT NULL, voteAgainst INT NOT NULL, voteAbstention INT NOT NULL, voteRule_id INT NOT NULL, textGroup_id INT NOT NULL, INDEX IDX_6D130F0D4E27AF14 (voteRule_id), INDEX IDX_6D130F0D698D3548 (text_id), INDEX IDX_6D130F0D57CB7553 (textGroup_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE individual_text_vote_agregation ADD CONSTRAINT FK_6D130F0D4E27AF14 FOREIGN KEY (voteRule_id) REFERENCES vote_rule (id)');
        $this->addSql('ALTER TABLE individual_text_vote_agregation ADD CONSTRAINT FK_6D130F0D698D3548 FOREIGN KEY (text_id) REFERENCES text (id)');
        $this->addSql('ALTER TABLE individual_text_vote_agregation ADD CONSTRAINT FK_6D130F0D57CB7553 FOREIGN KEY (textGroup_id) REFERENCES text_group (id)');
        $this->addSql('ALTER TABLE text_group ADD voteFor INT NOT NULL');
        $this->addSql('ALTER TABLE vote_rule ADD name VARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE individual_text_vote_agregation');
        $this->addSql('ALTER TABLE text_group DROP voteFor');
        $this->addSql('ALTER TABLE vote_rule DROP name');
    }
}
