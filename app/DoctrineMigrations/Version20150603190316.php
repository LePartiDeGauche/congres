<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150603190316 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE result (id INT AUTO_INCREMENT NOT NULL, election_id INT DEFAULT NULL, result_id INT DEFAULT NULL, INDEX IDX_136AC113A708DAFF (election_id), INDEX IDX_136AC1137A7B643 (result_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE election (id INT AUTO_INCREMENT NOT NULL, group_id INT DEFAULT NULL, organ_id INT DEFAULT NULL, responsable_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, numberOfElected SMALLINT NOT NULL, INDEX IDX_DCA03800FE54D947 (group_id), INDEX IDX_DCA03800E4445171 (organ_id), INDEX IDX_DCA0380053C59D72 (responsable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE election_adherent (election_id INT NOT NULL, adherent_id INT NOT NULL, INDEX IDX_CA6CF2F2A708DAFF (election_id), INDEX IDX_CA6CF2F225F06C53 (adherent_id), PRIMARY KEY(election_id, adherent_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE election_group (id INT AUTO_INCREMENT NOT NULL, responsabilities_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, organType_id INT DEFAULT NULL, responsableResponsability_id INT DEFAULT NULL, INDEX IDX_BF518E4FAD828C32 (organType_id), INDEX IDX_BF518E4FE0F05AF (responsabilities_id), INDEX IDX_BF518E4FCC8C9E38 (responsableResponsability_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113A708DAFF FOREIGN KEY (election_id) REFERENCES election (id)');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC1137A7B643 FOREIGN KEY (result_id) REFERENCES election (id)');
        $this->addSql('ALTER TABLE election ADD CONSTRAINT FK_DCA03800FE54D947 FOREIGN KEY (group_id) REFERENCES election_group (id)');
        $this->addSql('ALTER TABLE election ADD CONSTRAINT FK_DCA03800E4445171 FOREIGN KEY (organ_id) REFERENCES organ (id)');
        $this->addSql('ALTER TABLE election ADD CONSTRAINT FK_DCA0380053C59D72 FOREIGN KEY (responsable_id) REFERENCES adherents (id)');
        $this->addSql('ALTER TABLE election_adherent ADD CONSTRAINT FK_CA6CF2F2A708DAFF FOREIGN KEY (election_id) REFERENCES election (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE election_adherent ADD CONSTRAINT FK_CA6CF2F225F06C53 FOREIGN KEY (adherent_id) REFERENCES adherents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE election_group ADD CONSTRAINT FK_BF518E4FAD828C32 FOREIGN KEY (organType_id) REFERENCES organ_type (id)');
        $this->addSql('ALTER TABLE election_group ADD CONSTRAINT FK_BF518E4FE0F05AF FOREIGN KEY (responsabilities_id) REFERENCES instances (id)');
        $this->addSql('ALTER TABLE election_group ADD CONSTRAINT FK_BF518E4FCC8C9E38 FOREIGN KEY (responsableResponsability_id) REFERENCES instances (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC113A708DAFF');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC1137A7B643');
        $this->addSql('ALTER TABLE election_adherent DROP FOREIGN KEY FK_CA6CF2F2A708DAFF');
        $this->addSql('ALTER TABLE election DROP FOREIGN KEY FK_DCA03800FE54D947');
        $this->addSql('DROP TABLE result');
        $this->addSql('DROP TABLE election');
        $this->addSql('DROP TABLE election_adherent');
        $this->addSql('DROP TABLE election_group');
    }
}
