<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for Photo Gallery Images.
 * 
 * @MigrateSource(id = "photo_gallery_images")
 */
class PhotoGalleryImages extends SqlBase {

    public function query() {
        $query = $this->select('node', 'n');
        $query->addField('n', 'nid', 'nid');
        $query->addField('fm', 'filename', 'filename');
        $query->addField('fm', 'uri', 'uri');
        $query->addField('fdfi', 'field_image_alt', 'alt');
        $query->addField('fdfi', 'field_image_title', 'title');
        $query->addField('fdfi', 'delta', 'delta');
        $query->addJoin('LEFT OUTER', 'field_data_field_images', 'fdfi', 'fdfi.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'file_managed', 'fm', 'fm.fid = fdfi.field_images_fid');
        $query->condition('n.type', 'photo_gallery', '=');
        $query->condition('n.status', '1', '=');
        $query->condition('fm.type', 'image', '=');
        return $query;
    }

    public function fields() {
        return [
            'nid' => $this->t('Node ID'),
            'filename' => $this->t('Filename'),
            'uri' => $this->t('URI'),
            'alt' => $this->t('Alt'),
            'title' => $this->t('Title'),
            'delta' => $this->t('Delta')
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