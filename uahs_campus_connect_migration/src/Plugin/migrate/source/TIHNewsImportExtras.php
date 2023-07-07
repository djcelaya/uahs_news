<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for TIH News extras field.
 * See: https://healthsciences.arizona.edu/admin/structure/types/manage/tih_news_import
 * 
 * @MigrateSource(id = "tih_news_import_extras")
 */
class TIHNewsImportExtras extends SqlBase {

    public function query() {
        $query = $this->select('node', 'n');
        $query->addField('fdfe', 'entity_id', 'entity_id');
        $query->addField('fdfe', 'field_extras_value', 'field_extras');
        $query->addJoin('LEFT OUTER', 'field_data_field_extras', 'fdfe', 'fdfe.entity_id = n.nid');
        $query->isNotNull('fdfe.entity_id');
        $query->condition('n.status', '1', '=');
        return $query;
    }

    public function fields() {
        return [
            'entity_id' => $this->t('Entity ID'),
            'field_extras' => $this->t('Extras')
        ];
    }

    public function getIds() {
        return [
            'entity_id' => [
                'type' => 'integer',
                'alias' => 'fdfe'
            ]
        ];
    }
}