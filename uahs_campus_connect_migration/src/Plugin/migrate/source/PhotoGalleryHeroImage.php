<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for Photo Gallery Hero Images.
 * 
 * @MigrateSource(id = "photo_gallery_cover_image")
 */
class PhotoGalleryHeroImage extends SqlBase {

    public function query() {
        $query = $this->select('node', 'n');
        $query->addField('n', 'nid', 'nid');
        $query->addField('fm', 'filename', 'field_cover_image_filename');
        $query->addField('fm', 'uri', 'field_cover_image_uri');
        $query->addField('fdfci', 'field_cover_image_alt', 'field_cover_image_alt');
        $query->addField('fdfci', 'field_cover_image_title', 'field_cover_image_title');
        $query->addField('fdfcic', 'field_cover_image_caption_value', 'field_cover_image_caption');
        $query->addJoin('LEFT OUTER', 'field_data_field_cover_image', 'fdfci', 'fdfci.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'file_managed', 'fm', 'fm.fid = fdfci.field_cover_image_fid');
        $query->addJoin('LEFT OUTER', 'field_data_field_cover_image_caption', 'fdfcic', 'fdfcic.entity_id = n.nid');
        $query->condition('n.type', 'photo_gallery', '=');
        $query->condition('n.status', '1', '=');
        $query->groupBy('n.nid');
        return $query;
    }

    public function fields() {
        return [
            'nid' => $this->t('Node ID'),
            'field_cover_image_filename' => $this->t('Hero Image Filename'),
            'field_cover_image_uri' => $this->t('Hero Image URI'),
            'field_cover_image_alt' => $this->t('Hero Image Alt'),
            'field_cover_image_title' => $this-t('Hero Image Title'),
            'field_cover_image_caption' => $this->t('Cover Image Caption')
        ];
    }

    public function getIds() {
        return [
            'field_cover_image_uri' => [
                'type' => 'string',
                'alias' => 'fm'
            ]
        ];
    }
}