<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180113182313 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE statute_votes (contribution_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_602FCD1BFE5E5FBD (contribution_id), UNIQUE INDEX UNIQ_602FCD1BA76ED395 (user_id), PRIMARY KEY(contribution_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE statute_votes ADD CONSTRAINT FK_602FCD1BFE5E5FBD FOREIGN KEY (contribution_id) REFERENCES contributions (id)');
        $this->addSql('ALTER TABLE statute_votes ADD CONSTRAINT FK_602FCD1BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE statute_votes');
    }
}
