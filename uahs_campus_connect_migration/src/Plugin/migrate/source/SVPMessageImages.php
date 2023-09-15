<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for SVP Message inline images.
 * 
 * @MigrateSource(id = "svp_message_images")
 */
class SVPMessageImages extends SqlBase {

    public function query() {
        $query = $this->select('node', 'n');
        $query->addField('fm', 'filename', 'filename');
        $query->addField('fm', 'uri', 'uri');
        $query->addField('fdfi', 'field_image_alt', 'field_image_alt');
        $query->addField('fdfi', 'field_image_title', 'field_image_title');
        $query->addJoin('LEFT OUTER', 'field_data_field_images', 'fdfi', 'fdfi.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'file_managed', 'fm', 'fm.fid = fdfi.field_images_fid');
        $query->condition('n.type', 'svp_message', '=');
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