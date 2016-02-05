<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160205153650 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO amendment_topic (name) VALUES
            ('6ème République'),
            ('Agriculture'),
            ('Antiracisme'),
            ('Culture'),
            ('Défense'),
            ('Écologie'),
            ('Économie'),
            ('Éducation'),
            ('Égalité-Laïcité'),
            ('Émancipation-Féminisme'),
            ('Enfance'),
            ('Ens. Sup. Rech.'),
            ('Genre LGBTI'),
            ('Habitat/Logement'),
            ('Handicap'),
            ('International'),
            ('Jeunesse'),
            ('Justice'),
            ('Migrations'),
            ('Numérique'),
            ('Outre-mer'),
            ('Santé'),
            ('Services publics'),
            ('Sport'),
            ('Sûreté'),
            ('Transport Amngt. ter. Mer'),
            ('Autres')
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("DELETE FROM amendment_topic WHERE name IN (
            '6ème République',
            'Agriculture',
            'Antiracisme',
            'Culture',
            'Défense',
            'Écologie',
            'Économie',
            'Éducation',
            'Égalité-Laïcité',
            'Émancipation-Féminisme',
            'Enfance',
            'Ens. Sup. Rech.',
            'Genre LGBTI',
            'Habitat/Logement',
            'Handicap',
            'International',
            'Jeunesse',
            'Justice',
            'Migrations',
            'Numérique',
            'Outre-mer',
            'Santé',
            'Services publics',
            'Sport',
            'Sûreté',
            'Transport Amngt. ter. Mer',
            'Autres'
        );");
    }
}
