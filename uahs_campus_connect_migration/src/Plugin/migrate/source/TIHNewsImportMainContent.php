<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for TIH News extras, experts, and contact fields.
 * 
 * @MigrateSource(id = "uahs_tih_news_import_main_content")
 */
class TIHNewsImportMainContent extends SqlBase {

    public function query() {
        $query = $this->select('node', 'n');
        $query->addField('n', 'nid', 'nid');
        $query->addField('fdfe1', 'field_extras_value', 'field_extras');
        $query->addField('fdfe2', 'field_experts_value', 'field_experts');
        $query->addField('fdfc', 'field_contact_value', 'field_contact');
        $query->addJoin('LEFT OUTER', 'field_data_field_extras', 'fdfe1', 'fdfe1.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_experts', 'fdfe2', 'fdfe2.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_contact', 'fdfc', 'fdfc.entity_id = n.nid');
        $query->condition('n.type', 'tih_news_import', '=');
        $query->condition('n.status', '1', '=');
        return $query;
    }

    public function fields() {
        return [
            'nid' => $this->t('Node ID'),
            'field_extras' => $this->t('Extras'),
            'field_experts' => $this->t('Our Experts'),
            'field_contact' => $this->t('Contact')
        ];
    }

    public function getIds() {
        return [
            'nid' => [
                'type' => 'integer',
                'alias' => 'n'
            ]
        ];
    }
}