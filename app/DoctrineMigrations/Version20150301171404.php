<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150301171404 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE adherent_responsability (id INT AUTO_INCREMENT NOT NULL, adherent_id INT NOT NULL, responsability_id INT NOT NULL, start DATE NOT NULL, end DATE NOT NULL, isActive TINYINT(1) NOT NULL, designatedByOrgan_id INT DEFAULT NULL, INDEX IDX_D50F7C1025F06C53 (adherent_id), INDEX IDX_D50F7C102B8DC843 (responsability_id), INDEX IDX_D50F7C10E44EED60 (designatedByOrgan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adherentresponsability_organparticipation (adherentresponsability_id INT NOT NULL, organparticipation_id INT NOT NULL, INDEX IDX_EB87393EF516CDE (adherentresponsability_id), INDEX IDX_EB87393F6ABBF40 (organparticipation_id), PRIMARY KEY(adherentresponsability_id, organparticipation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE text (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, organ_id INT NOT NULL, title LONGTEXT NOT NULL, content LONGTEXT NOT NULL, status VARCHAR(255) NOT NULL, organ_vote LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\', textGroup_id INT NOT NULL, INDEX IDX_3B8BA7C7F675F31B (author_id), INDEX IDX_3B8BA7C7E4445171 (organ_id), INDEX IDX_3B8BA7C757CB7553 (textGroup_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE text_group (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, submission_opening DATETIME NOT NULL, submission_closing DATETIME NOT NULL, vote_opening DATETIME NOT NULL, vote_closing DATETIME NOT NULL, vote_type VARCHAR(255) NOT NULL, vote_modality VARCHAR(255) NOT NULL, INDEX IDX_3B74FE98F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organ_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(64) NOT NULL, isUnique TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organ (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, organType_id INT NOT NULL, INDEX IDX_8702B48AAD828C32 (organType_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organ_organ (organ_source INT NOT NULL, organ_target INT NOT NULL, INDEX IDX_192504F21CAA1CD (organ_source), INDEX IDX_192504F2182FF142 (organ_target), PRIMARY KEY(organ_source, organ_target)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organ_participation (id INT AUTO_INCREMENT NOT NULL, adherent_id INT NOT NULL, organ_id INT NOT NULL, start DATE NOT NULL, end DATE NOT NULL, isActive TINYINT(1) NOT NULL, INDEX IDX_800A8B3525F06C53 (adherent_id), INDEX IDX_800A8B35E4445171 (organ_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eventrole_responsability (eventrole_id INT NOT NULL, responsability_id INT NOT NULL, INDEX IDX_A9CE78031DA9B27D (eventrole_id), INDEX IDX_A9CE78032B8DC843 (responsability_id), PRIMARY KEY(eventrole_id, responsability_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote_rule (id INT AUTO_INCREMENT NOT NULL, concernedResponsability LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\', textGroup_id INT NOT NULL, INDEX IDX_F1BA5DFD57CB7553 (textGroup_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE individual_text_vote (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, text_id INT NOT NULL, date DATETIME NOT NULL, vote VARCHAR(50) NOT NULL, INDEX IDX_49FC973DF675F31B (author_id), INDEX IDX_49FC973D698D3548 (text_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organ_voterule (id INT AUTO_INCREMENT NOT NULL, textGroup_id INT NOT NULL, INDEX IDX_CF339DED57CB7553 (textGroup_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE threshold_voterule (id INT AUTO_INCREMENT NOT NULL, threshold INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE responsability_organtype (responsability_id INT NOT NULL, organtype_id INT NOT NULL, INDEX IDX_E49EDEF42B8DC843 (responsability_id), INDEX IDX_E49EDEF4623FB5AE (organtype_id), PRIMARY KEY(responsability_id, organtype_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adherent_responsability ADD CONSTRAINT FK_D50F7C1025F06C53 FOREIGN KEY (adherent_id) REFERENCES adherents (id)');
        $this->addSql('ALTER TABLE adherent_responsability ADD CONSTRAINT FK_D50F7C102B8DC843 FOREIGN KEY (responsability_id) REFERENCES instances (id)');
        $this->addSql('ALTER TABLE adherent_responsability ADD CONSTRAINT FK_D50F7C10E44EED60 FOREIGN KEY (designatedByOrgan_id) REFERENCES organ (id)');
        $this->addSql('ALTER TABLE adherentresponsability_organparticipation ADD CONSTRAINT FK_EB87393EF516CDE FOREIGN KEY (adherentresponsability_id) REFERENCES adherent_responsability (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE adherentresponsability_organparticipation ADD CONSTRAINT FK_EB87393F6ABBF40 FOREIGN KEY (organparticipation_id) REFERENCES organ_participation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE text ADD CONSTRAINT FK_3B8BA7C7F675F31B FOREIGN KEY (author_id) REFERENCES adherents (id)');
        $this->addSql('ALTER TABLE text ADD CONSTRAINT FK_3B8BA7C7E4445171 FOREIGN KEY (organ_id) REFERENCES organ (id)');
        $this->addSql('ALTER TABLE text ADD CONSTRAINT FK_3B8BA7C757CB7553 FOREIGN KEY (textGroup_id) REFERENCES text_group (id)');
        $this->addSql('ALTER TABLE text_group ADD CONSTRAINT FK_3B74FE98F675F31B FOREIGN KEY (author_id) REFERENCES adherents (id)');
        $this->addSql('ALTER TABLE organ ADD CONSTRAINT FK_8702B48AAD828C32 FOREIGN KEY (organType_id) REFERENCES organ_type (id)');
        $this->addSql('ALTER TABLE organ_organ ADD CONSTRAINT FK_192504F21CAA1CD FOREIGN KEY (organ_source) REFERENCES organ (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organ_organ ADD CONSTRAINT FK_192504F2182FF142 FOREIGN KEY (organ_target) REFERENCES organ (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organ_participation ADD CONSTRAINT FK_800A8B3525F06C53 FOREIGN KEY (adherent_id) REFERENCES adherents (id)');
        $this->addSql('ALTER TABLE organ_participation ADD CONSTRAINT FK_800A8B35E4445171 FOREIGN KEY (organ_id) REFERENCES organ (id)');
        $this->addSql('ALTER TABLE eventrole_responsability ADD CONSTRAINT FK_A9CE78031DA9B27D FOREIGN KEY (eventrole_id) REFERENCES event_role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eventrole_responsability ADD CONSTRAINT FK_A9CE78032B8DC843 FOREIGN KEY (responsability_id) REFERENCES instances (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote_rule ADD CONSTRAINT FK_F1BA5DFD57CB7553 FOREIGN KEY (textGroup_id) REFERENCES text_group (id)');
        $this->addSql('ALTER TABLE individual_text_vote ADD CONSTRAINT FK_49FC973DF675F31B FOREIGN KEY (author_id) REFERENCES adherents (id)');
        $this->addSql('ALTER TABLE individual_text_vote ADD CONSTRAINT FK_49FC973D698D3548 FOREIGN KEY (text_id) REFERENCES text (id)');
        $this->addSql('ALTER TABLE organ_voterule ADD CONSTRAINT FK_CF339DED57CB7553 FOREIGN KEY (textGroup_id) REFERENCES text_group (id)');
        $this->addSql('ALTER TABLE responsability_organtype ADD CONSTRAINT FK_E49EDEF42B8DC843 FOREIGN KEY (responsability_id) REFERENCES instances (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE responsability_organtype ADD CONSTRAINT FK_E49EDEF4623FB5AE FOREIGN KEY (organtype_id) REFERENCES organ_type (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE eventrole_instance');

    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE adherentresponsability_organparticipation DROP FOREIGN KEY FK_EB87393EF516CDE');
        $this->addSql('ALTER TABLE individual_text_vote DROP FOREIGN KEY FK_49FC973D698D3548');
        $this->addSql('ALTER TABLE text DROP FOREIGN KEY FK_3B8BA7C757CB7553');
        $this->addSql('ALTER TABLE vote_rule DROP FOREIGN KEY FK_F1BA5DFD57CB7553');
        $this->addSql('ALTER TABLE organ_voterule DROP FOREIGN KEY FK_CF339DED57CB7553');
        $this->addSql('ALTER TABLE organ DROP FOREIGN KEY FK_8702B48AAD828C32');
        $this->addSql('ALTER TABLE responsability_organtype DROP FOREIGN KEY FK_E49EDEF4623FB5AE');
        $this->addSql('ALTER TABLE adherent_responsability DROP FOREIGN KEY FK_D50F7C10E44EED60');
        $this->addSql('ALTER TABLE text DROP FOREIGN KEY FK_3B8BA7C7E4445171');
        $this->addSql('ALTER TABLE organ_organ DROP FOREIGN KEY FK_192504F21CAA1CD');
        $this->addSql('ALTER TABLE organ_organ DROP FOREIGN KEY FK_192504F2182FF142');
        $this->addSql('ALTER TABLE organ_participation DROP FOREIGN KEY FK_800A8B35E4445171');
        $this->addSql('ALTER TABLE adherentresponsability_organparticipation DROP FOREIGN KEY FK_EB87393F6ABBF40');
        $this->addSql('CREATE TABLE eventrole_instance (eventrole_id INT NOT NULL, instance_id INT NOT NULL, INDEX IDX_DFAB3FB51DA9B27D (eventrole_id), INDEX IDX_DFAB3FB53A51721D (instance_id), PRIMARY KEY(eventrole_id, instance_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_instances (adherent_id INT NOT NULL, instance_id INT NOT NULL, INDEX IDX_1C5A7A883A51721D (instance_id), INDEX IDX_1C5A7A8825F06C53 (adherent_id), PRIMARY KEY(adherent_id, instance_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eventrole_instance ADD CONSTRAINT FK_DFAB3FB51DA9B27D FOREIGN KEY (eventrole_id) REFERENCES event_role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eventrole_instance ADD CONSTRAINT FK_DFAB3FB53A51721D FOREIGN KEY (instance_id) REFERENCES instances (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_instances ADD CONSTRAINT FK_1C5A7A8825F06C53 FOREIGN KEY (adherent_id) REFERENCES adherents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_instances ADD CONSTRAINT FK_1C5A7A883A51721D FOREIGN KEY (instance_id) REFERENCES instances (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE adherent_responsability');
        $this->addSql('DROP TABLE adherentresponsability_organparticipation');
        $this->addSql('DROP TABLE text');
        $this->addSql('DROP TABLE text_group');
        $this->addSql('DROP TABLE organ_type');
        $this->addSql('DROP TABLE organ');
        $this->addSql('DROP TABLE organ_organ');
        $this->addSql('DROP TABLE organ_participation');
        $this->addSql('DROP TABLE eventrole_responsability');
        $this->addSql('DROP TABLE vote_rule');
        $this->addSql('DROP TABLE individual_text_vote');
        $this->addSql('DROP TABLE organ_voterule');
        $this->addSql('DROP TABLE threshold_voterule');
        $this->addSql('DROP TABLE responsability_organtype');
    }
    public function postUp(Schema $schema) {
        $conn = $this->connection;
        $sql = "SELECT * FROM users_instances";
        $stmt = $conn->query($sql);
        while ($row = $stmt->fetch()) {
            $conn->executeQuery("INSERT INTO adherent_responsability (adherent_id, responsability_id,isActive) VALUES (".$row['adherent_id'].", ".$row['instance_id'].", True)");
        }

        $conn->executeQuery('DROP TABLE users_instances');
    }
}
