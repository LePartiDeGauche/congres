<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150615140552 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs

    }

    /**
     * @param Schema $schema
     */
    public function postUp(Schema $schema)
    {
        $this->addSql("INSERT INTO instances(name) VALUES ('Bureau du Congrès'), ('Commission de candidatures'), ('Bureau National ou Secrétariat exécutif national'), ('Commission de résolution des conflits'), ('Commission de contrôle financier'), ('Conseil national - part nationale');");

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
