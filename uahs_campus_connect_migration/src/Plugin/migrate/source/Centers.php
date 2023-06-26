<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for Centers.
 * See: https://healthsciences.arizona.edu/admin/structure/taxonomy/centers
 *
 * @MigrateSource(id = "centers")
 */
class Centers extends SqlBase {

    const CENTERS_VID = 24;

    public function query() {
        $query = $this->select('taxonomy_term_data', 't')
            ->condition('t.vid', self::CENTERS_VID, '=')
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