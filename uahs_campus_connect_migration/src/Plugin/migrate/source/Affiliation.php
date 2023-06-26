<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for Affiliation.
 * See: https://healthsciences.arizona.edu/admin/structure/taxonomy/affiliation
 * See: sql/affiliation.sql for raw query
 *
 * @MigrateSource(id = "affiliation")
 */
class Affiliation extends SqlBase {

    const AFFILIATION_VID = 15;
    const UAHS_TID = 125;

    public function query() {
        $query = $this->select('taxonomy_term_data', 't')
            ->condition('t.vid', self::AFFILIATION_VID, '=')
            ->condition('t.tid', self::UAHS_TID, '!=') // exclude "University of Arizona Health Sciences
            ->fields('t', array(
                'tid',
                'vid',
                'name',
                'description',
                'format',
                'weight'
            ));
        return $query;
    }

    public function fields() {
        $fields = array(
            'tid' => $this->t('Term ID'),
            'vid' => $this->t('Vocabulary ID'),
            'name' => $this->t('Name'),
            'description' => $this->t('Description'),
            'format' => $this->t('Description Format'),
            'weight' => $this->t('Weight'),
        );
        return $fields;
    }

    public function getIds() {
        return [
            'name' => [
                'type' => 'string',
                'alias' => 't',
            ],
        ];
    }
}