<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for the photo gallery paragraph used in the AZ News content that 
 * succeeds the Photos content type in UAHS Campus Connect.
 * 
 * @MigrateSource(id = "photo_gallery_images_gallery")
 */
class PhotoGalleryImagesGallery extends SqlBase {

    public function query() {
        $query = $this->select('node', 'n');
        $query->addField('n', 'nid', 'nid');
        $query->addExpression('GROUP_CONCAT(DISTINCT fm.uri)', 'uris');
        $query->addJoin('LEFT OUTER', 'field_data_field_images', 'fdfi', 'fdfi.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'file_managed', 'fm', 'fm.fid = fdfi.field_images_fid');
        $query->condition('n.type', 'photo_gallery', '=');
        $query->condition('n.status', '1', '=');
        $query->groupBy('n.nid');
        return $query;
    }

    public function fields() {
        return [
            'nid' => $this->t('Node ID'),
            'uris' => $this->t('Image URIs')
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