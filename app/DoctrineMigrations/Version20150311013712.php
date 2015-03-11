<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150311013712 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE payment ADD recipient_id INT DEFAULT NULL, ADD author_id INT DEFAULT NULL, ADD account VARCHAR(20) NOT NULL, DROP recipient, DROP author, CHANGE amount amount DOUBLE PRECISION NOT NULL, CHANGE method method VARCHAR(20) NOT NULL, CHANGE drawer drawer VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DE92F8F78 FOREIGN KEY (recipient_id) REFERENCES adherents (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DF675F31B FOREIGN KEY (author_id) REFERENCES adherents (id)');
        $this->addSql('CREATE INDEX IDX_6D28840DE92F8F78 ON payment (recipient_id)');
        $this->addSql('CREATE INDEX IDX_6D28840DF675F31B ON payment (author_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DE92F8F78');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DF675F31B');
        $this->addSql('DROP INDEX IDX_6D28840DE92F8F78 ON payment');
        $this->addSql('DROP INDEX IDX_6D28840DF675F31B ON payment');
        $this->addSql('ALTER TABLE payment ADD recipient LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:object)\', ADD author LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:object)\', DROP recipient_id, DROP author_id, DROP account, CHANGE amount amount INT NOT NULL, CHANGE method method LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:object)\', CHANGE drawer drawer LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:object)\'');
    }
}
