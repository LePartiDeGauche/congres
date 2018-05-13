<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180510090925 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE election_result (id INT AUTO_INCREMENT NOT NULL, election_id INT DEFAULT NULL, elected_id INT DEFAULT NULL, numberOfVote INT NOT NULL, INDEX IDX_1ED53AE7A708DAFF (election_id), INDEX IDX_1ED53AE7A063E6C9 (elected_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE election_result ADD CONSTRAINT FK_1ED53AE7A708DAFF FOREIGN KEY (election_id) REFERENCES election_result (id)');
        $this->addSql('ALTER TABLE election_result ADD CONSTRAINT FK_1ED53AE7A063E6C9 FOREIGN KEY (elected_id) REFERENCES adherents (id)');
        $this->addSql('DROP TABLE election_adherent');
        $this->addSql('DROP TABLE election_adherentresponsability');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE election_result DROP FOREIGN KEY FK_1ED53AE7A708DAFF');
        $this->addSql('CREATE TABLE election_adherent (election_id INT NOT NULL, adherent_id INT NOT NULL, INDEX IDX_CA6CF2F2A708DAFF (election_id), INDEX IDX_CA6CF2F225F06C53 (adherent_id), PRIMARY KEY(election_id, adherent_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE election_adherentresponsability (election_id INT NOT NULL, adherentresponsability_id INT NOT NULL, INDEX IDX_C64FE5C0A708DAFF (election_id), INDEX IDX_C64FE5C0EF516CDE (adherentresponsability_id), PRIMARY KEY(election_id, adherentresponsability_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE election_adherent ADD CONSTRAINT FK_CA6CF2F225F06C53 FOREIGN KEY (adherent_id) REFERENCES adherents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE election_adherent ADD CONSTRAINT FK_CA6CF2F2A708DAFF FOREIGN KEY (election_id) REFERENCES election (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE election_adherentresponsability ADD CONSTRAINT FK_C64FE5C0A708DAFF FOREIGN KEY (election_id) REFERENCES election (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE election_adherentresponsability ADD CONSTRAINT FK_C64FE5C0EF516CDE FOREIGN KEY (adherentresponsability_id) REFERENCES adherent_responsability (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE election_result');
    }
}
