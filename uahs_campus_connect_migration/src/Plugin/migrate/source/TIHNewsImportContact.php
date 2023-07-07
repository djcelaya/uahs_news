<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for TIH News contact field.
 * See: https://healthsciences.arizona.edu/admin/structure/types/manage/tih_news_import
 * 
 * @MigrateSource(id = "tih_news_import_contact")
 */
class TIHNewsImportContact extends SqlBase {
    
    public function query() {
        $query = $this->select('field_data_field_contact', 'fc');
        $query->addField('fc', 'entity_id', 'entity_id');
        $query->addfield('fc', 'field_contact_value', 'field_contact');
        $query->condition('fc.bundle', 'tih_news_import');
        return $query;
    }

    public function fields() {
        return [
            'entity_id' => $this->t('Entity ID'),
            'field_contact' => $this->t('Contact'),
        ];
    }

    public function getIds() {
        return [
            'entity_id' => [
                'type' => 'integer',
                'alias' => 'fc',
            ]
        ];
    }
}