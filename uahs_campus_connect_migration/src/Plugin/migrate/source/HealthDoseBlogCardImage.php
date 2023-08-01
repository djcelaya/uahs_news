<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for Healthy Dose Blog card (hero) image.
 * 
 * @MigrateSource(id = "health_dose_blog_card_image")
 */
class HealthDoseBlogCardImage extends SqlBase {

    public function query() {
        $query = $this->select('node', 'n');
        $query->addJoin('LEFT OUTER', 'field_data_field_card_image', 'fci', 'fci.entity_id = n.nid');
        $query->addJoin('INNER', 'file_managed', 'fm', 'fm.fid = fci.field_card_image_fid');
        $query->condition('n.type', 'health_dose_blog', '=');
        $query->condition('n.status', '1', '=');
        $query->condition('fm.type', 'image', '=');
        $query->addField('fm', 'filename', 'filename');
        $query->addField('fm', 'uri', 'uri');
        $query->groupBy('fm.fid');
        return $query;
    }

    public function fields() {
        return [
            'filename' => $this->t('Name'),
            'uri' => $this->t('URI')
        ];
    }

    public function getIds() {
        return [
            'uri' => [
                'type' => 'string',
                'alias' => 'fm'
            ]
        ];
    }
}