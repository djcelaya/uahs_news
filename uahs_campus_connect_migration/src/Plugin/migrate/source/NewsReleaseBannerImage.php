<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for News Release hero image.
 * 
 * @MigrateSource(id = "news_release_banner_image")
 */
class NewsReleaseBannerImage extends SqlBase {

    public function query() {
        $query = $this->select('node', 'n');
        $query->addJoin('LEFT OUTER', 'field_data_field_banner_image', 'fbi', 'fbi.entity_id = n.nid');
        $query->addJoin('INNER', 'file_managed', 'fm', 'fm.fid = fbi.field_banner_image_fid');
        $query->addJoin('LEFT OUTER', 'field_data_field_cover_image_caption', 'fcic', 'fcic.entity_id = n.nid');
        $query->condition('n.type', 'news_release', '=');
        $query->condition('n.status', '1', '=');
        $query->condition('fm.type', 'image', '=');
        $query->addField('fm', 'filename', 'filename');
        $query->addField('fm', 'uri', 'uri');
        $query->addField('fcic', 'field_cover_image_caption_value', 'field_cover_image_caption');
        $query->groupBy('fm.fid');
        return $query;
    }

    public function fields() {
        $fields = array(
            'filename' => $this->t('Name'),
            'uri' => $this->t('URI'),
            'field_cover_image_caption' => $this->t('Cover Image Caption'),
        );
        return $fields;
    }

    public function getIds() {
        return [
            'uri' => [
                'type' => 'string',
                'alias' => 'fm',
            ],
        ];
    }
}