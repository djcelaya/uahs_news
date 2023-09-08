<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for (HSC) Stories hero image.
 * See: https://healthsciences.arizona.edu/admin/structure/types/manage/newsstory
 *
 * This runs before the import of Stories so that the Stories migration can look up and link against
 * the image entity.
 *
 * This source plugin is distinct of NewsStoryImages because the image caption data is stored with the
 * story entity and not the image file in HSC Campus Connect.
 *
 * @MigrateSource(
 *     id = "newsstory_banner_image"
 * )
 */
class NewsStoryBannerImage extends SqlBase {

    public function query() {
        $query = $this->select('node', 'n');
        $query->addJoin('LEFT OUTER', 'field_data_field_banner_image', 'fbi', 'fbi.entity_id = n.nid');
        $query->addJoin('INNER', 'file_managed', 'fm', 'fm.fid = fbi.field_banner_image_fid');
        $query->addJoin('LEFT OUTER', 'field_data_field_cover_image_caption', 'fcic', 'fcic.entity_id = n.nid');
        $query->condition('n.type', 'newsstory', '=');
        $query->condition('n.status', '1', '=');
        $query->condition('fm.type', 'image', '=');
        $query->addField('fm', 'filename', 'filename');
        $query->addField('fm', 'uri', 'uri');
        $query->addField('fcic', 'field_cover_image_caption_value', 'field_cover_image_caption');
        $query->groupBy('fm.fid');
        //$query->orderBy('fm.timestamp', 'DESC');
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