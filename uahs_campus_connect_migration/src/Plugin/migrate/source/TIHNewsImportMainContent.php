<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

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
            'field_extras' => $this->t('Extras Raw'),
            'extras_card_title' => $this->t('Extras Card Title'),
            'extras_card_body' => $this->t('Extras Card Body'),
            'extras_card_body_format' => $this->t('Extras Card Body Format'),
            'field_experts' => $this->t('Experts Raw'),
            'experts_card_title' => $this->t('Experts Card Title'),
            'experts_card_body' => $this->t('Experts Card Body'),
            'experts_card_body_format' => $this->t('Experts Card Body Format'),
            'field_contact' => $this->t('Contact Raw'),
            'contact_card_title' => $this->t('Contact Card Title'),
            'contact_card_body' => $this->t('Contact Card Body'),
            'contact_card_body_format' => $this->t('Contact Card Body Format'),
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

    public function prepareRow(Row $row) {
        $extras = $row->getSourceProperty('field_extras');
        $extras_card_title = $extras ? 'Extras' : NULL;
        $extras_card_body = $extras ? $extras : NULL;
        $extras_card_body_format = $extras ? 'az_standard' : NULL;
        $row->setSourceProperty('extras_card_title', $extras_card_title);
        $row->setSourceProperty('extras_card_body', $extras_card_body);
        $row->setSourceProperty('extras_card_body_format', $extras_card_body_format);

        $experts = $row->getSourceProperty('field_experts');
        $experts_card_title = $experts ? 'Our Experts' : NULL;
        $experts_card_body = $experts ? $experts : NULL;
        $experts_card_body_format = $experts ? 'az_standard' : NULL;
        $row->setSourceProperty('experts_card_title', $experts_card_title);
        $row->setSourceProperty('experts_card_body', $experts_card_body);
        $row->setSourceProperty('experts_card_body_format', $experts_card_body_format);

        $contact = $row->getSourceProperty('field_contact');
        $contact_card_title = $contact ? 'Contact' : NULL;
        $contact_card_body = $contact ? $contact : NULL;
        $contact_card_body_format = $contact ? 'az_standard' : NULL;
        $row->setSourceProperty('contact_card_title', $contact_card_title);
        $row->setSourceProperty('contact_card_body', $contact_card_body);
        $row->setSourceProperty('contact_card_body_format', $contact_card_body_format);

        return parent::prepareRow($row);
    }
}