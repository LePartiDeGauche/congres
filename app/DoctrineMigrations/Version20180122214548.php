<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180122214548 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE general_votes_congres2015 DROP FOREIGN KEY FK_1D1AA981A76ED395');
        $this->addSql('ALTER TABLE general_votes_congres2015 DROP FOREIGN KEY FK_1D1AA981FE5E5FBD');
        $this->addSql('ALTER TABLE thematic_votes_congres2015 DROP FOREIGN KEY FK_D1D8AB02AD95775D');
        $this->addSql('ALTER TABLE thematic_votes_congres2015 DROP FOREIGN KEY FK_D1D8AB02A76ED395');
        $this->addSql('ALTER TABLE contributions_congres2015 DROP FOREIGN KEY FK_76391EFEF675F31B');
        $this->addSql('ALTER TABLE contributions ADD CONSTRAINT FK_76391EFEF675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE general_votes ADD CONSTRAINT FK_1D1AA981FE5E5FBD FOREIGN KEY (contribution_id) REFERENCES contributions (id)');
        $this->addSql('ALTER TABLE general_votes ADD CONSTRAINT FK_1D1AA981A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE thematic_votes ADD CONSTRAINT FK_D1D8AB02AD95775D FOREIGN KEY (thematiccontribution_id) REFERENCES contributions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE thematic_votes ADD CONSTRAINT FK_D1D8AB02A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE contributions DROP FOREIGN KEY FK_76391EFEF675F31B');
        $this->addSql('ALTER TABLE general_votes DROP FOREIGN KEY FK_1D1AA981FE5E5FBD');
        $this->addSql('ALTER TABLE general_votes DROP FOREIGN KEY FK_1D1AA981A76ED395');
        $this->addSql('ALTER TABLE thematic_votes DROP FOREIGN KEY FK_D1D8AB02AD95775D');
        $this->addSql('ALTER TABLE thematic_votes DROP FOREIGN KEY FK_D1D8AB02A76ED395');
        $this->addSql('ALTER TABLE contributions_congres2015 ADD CONSTRAINT FK_76391EFEF675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE general_votes_congres2015 ADD CONSTRAINT FK_1D1AA981A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE general_votes_congres2015 ADD CONSTRAINT FK_1D1AA981FE5E5FBD FOREIGN KEY (contribution_id) REFERENCES contributions_congres2015 (id)');
        $this->addSql('ALTER TABLE thematic_votes_congres2015 ADD CONSTRAINT FK_D1D8AB02A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE thematic_votes_congres2015 ADD CONSTRAINT FK_D1D8AB02AD95775D FOREIGN KEY (thematiccontribution_id) REFERENCES contributions_congres2015 (id) ON DELETE CASCADE');
    }
}
