<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for Honors & Awards inline images.
 * 
 * @MigrateSource(id = "honors_and_awards_images")
 */
class HonorsAwardsImages extends SqlBase {

    public function query() {
        $query = $this->select('node', 'n');
        $query->addField('fm', 'filename', 'filename');
        $query->addField('fm', 'uri', 'uri');
        $query->addField('fdfi', 'field_image_alt', 'field_image_alt');
        $query->addField('fdfi', 'field_image_title', 'field_image_title');
        $query->addJoin('LEFT OUTER', 'field_data_field_image', 'fdfi', 'fdfi.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'file_managed', 'fm', 'fm.fid = fdfi.field_image_fid');
        $query->condition('n.type', 'honors_and_awards', '=');
        $query->condition('n.status', '1', '=');
        $query->condition('fm.type', 'image', '=');
        return $query;
    }

    public function fields() {
        return [
            'filename' => $this->t('Name'),
            'uri' => $this->t('URI'),
            'field_image_alt' => $this->t('Alternate Text'),
            'field_image_title' => $this->t('Title Text'),
        ];
    }

    public function getIds() {
        return [
            'uri' => [
                'type' => 'string',
                'alias' => 'fm',
            ]
        ];
    }
}