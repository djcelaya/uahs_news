<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for HSC News Call-out images.
 * See: https://healthsciences.arizona.edu/admin/structure/types/manage/hsc_news_call_out
 * 
 * @MigrateSource(id = "newsstory_call_out_images")
 */
class NewsStoryCallOutImages extends SqlBase {

    public function query() {
        $query = $this->select('node', 'n');
        $query->addJoin('LEFT OUTER', 'field_data_field_images', 'fi', 'fi.entity_id = n.nid');
        $query->addJoin('INNER', 'file_managed', 'fm', 'fm.fid = fi.field_images_fid');
        $query->condition('n.type', 'hsc_news_call_out', '=');
        $query->condition('n.status', '1', '=');
        $query->condition('fm.type', 'image', '=');
        $query->addField('fm', 'filename', 'filename');
        $query->addField('fm', 'uri', 'uri');
        $query->addField('fi', 'field_images_alt', 'field_images_alt');
        $query->addField('fi', 'field_images_title', 'field_images_title');
        $query->groupBy('fm.fid');
        return $query;
    }

    public function fields() {
        return [
            'filename' => $this->t('Name'),
            'uri' => $this->t('URI'),
            'field_images_alt' => $this->t('Alternate Text'),
            'field_images_title' => $this->t('Title Text'),
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