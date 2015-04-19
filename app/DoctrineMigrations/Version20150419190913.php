<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150419190913 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE individual_organ_text_vote_agregation (id INT AUTO_INCREMENT NOT NULL, text_id INT NOT NULL, voteFor INT NOT NULL, voteAgainst INT NOT NULL, voteAbstention INT NOT NULL, individualOrganTextVote_id INT NOT NULL, textGroup_id INT NOT NULL, INDEX IDX_EFE417B5F76F1BA5 (individualOrganTextVote_id), INDEX IDX_EFE417B5698D3548 (text_id), INDEX IDX_EFE417B557CB7553 (textGroup_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IndividualOrganTextVote (id INT AUTO_INCREMENT NOT NULL, organ_id INT DEFAULT NULL, author_id INT NOT NULL, voteAbstention INT NOT NULL, voteNotTakingPart INT NOT NULL, textGroup_id INT NOT NULL, INDEX IDX_780E838D57CB7553 (textGroup_id), INDEX IDX_780E838DE4445171 (organ_id), INDEX IDX_780E838DF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organvoterule_responsability (organvoterule_id INT NOT NULL, responsability_id INT NOT NULL, INDEX IDX_562EDA63E4C17495 (organvoterule_id), INDEX IDX_562EDA632B8DC843 (responsability_id), PRIMARY KEY(organvoterule_id, responsability_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organvoterule_organtype (organvoterule_id INT NOT NULL, organtype_id INT NOT NULL, INDEX IDX_F2A8709DE4C17495 (organvoterule_id), INDEX IDX_F2A8709D623FB5AE (organtype_id), PRIMARY KEY(organvoterule_id, organtype_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE individual_organ_text_vote_agregation ADD CONSTRAINT FK_EFE417B5F76F1BA5 FOREIGN KEY (individualOrganTextVote_id) REFERENCES IndividualOrganTextVote (id)');
        $this->addSql('ALTER TABLE individual_organ_text_vote_agregation ADD CONSTRAINT FK_EFE417B5698D3548 FOREIGN KEY (text_id) REFERENCES text (id)');
        $this->addSql('ALTER TABLE individual_organ_text_vote_agregation ADD CONSTRAINT FK_EFE417B557CB7553 FOREIGN KEY (textGroup_id) REFERENCES text_group (id)');
        $this->addSql('ALTER TABLE IndividualOrganTextVote ADD CONSTRAINT FK_780E838D57CB7553 FOREIGN KEY (textGroup_id) REFERENCES text_group (id)');
        $this->addSql('ALTER TABLE IndividualOrganTextVote ADD CONSTRAINT FK_780E838DE4445171 FOREIGN KEY (organ_id) REFERENCES organ (id)');
        $this->addSql('ALTER TABLE IndividualOrganTextVote ADD CONSTRAINT FK_780E838DF675F31B FOREIGN KEY (author_id) REFERENCES adherents (id)');
        $this->addSql('ALTER TABLE organvoterule_responsability ADD CONSTRAINT FK_562EDA63E4C17495 FOREIGN KEY (organvoterule_id) REFERENCES organ_voterule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organvoterule_responsability ADD CONSTRAINT FK_562EDA632B8DC843 FOREIGN KEY (responsability_id) REFERENCES instances (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organvoterule_organtype ADD CONSTRAINT FK_F2A8709DE4C17495 FOREIGN KEY (organvoterule_id) REFERENCES organ_voterule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organvoterule_organtype ADD CONSTRAINT FK_F2A8709D623FB5AE FOREIGN KEY (organtype_id) REFERENCES organ_type (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE event_participant');
        $this->addSql('DROP TABLE users_instances');
        $this->addSql('ALTER TABLE organ_voterule ADD name VARCHAR(255) NOT NULL, ADD rule_type VARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE individual_organ_text_vote_agregation DROP FOREIGN KEY FK_EFE417B5F76F1BA5');
        $this->addSql('CREATE TABLE event_participant (event_id INT NOT NULL, participant_id INT NOT NULL, UNIQUE INDEX UNIQ_7C16B8919D1C3019 (participant_id), INDEX IDX_7C16B89171F7E88B (event_id), PRIMARY KEY(event_id, participant_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_instances (adherent_id INT NOT NULL, instance_id INT NOT NULL, INDEX IDX_1C5A7A883A51721D (instance_id), INDEX IDX_1C5A7A8825F06C53 (adherent_id), PRIMARY KEY(adherent_id, instance_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_participant ADD CONSTRAINT FK_7C16B89171F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE event_participant ADD CONSTRAINT FK_7C16B8919D1C3019 FOREIGN KEY (participant_id) REFERENCES adherents (id)');
        $this->addSql('ALTER TABLE users_instances ADD CONSTRAINT FK_1C5A7A8825F06C53 FOREIGN KEY (adherent_id) REFERENCES adherents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_instances ADD CONSTRAINT FK_1C5A7A883A51721D FOREIGN KEY (instance_id) REFERENCES instances (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE individual_organ_text_vote_agregation');
        $this->addSql('DROP TABLE IndividualOrganTextVote');
        $this->addSql('DROP TABLE organvoterule_responsability');
        $this->addSql('DROP TABLE organvoterule_organtype');
        $this->addSql('ALTER TABLE organ_voterule DROP name, DROP rule_type');
    }
}
