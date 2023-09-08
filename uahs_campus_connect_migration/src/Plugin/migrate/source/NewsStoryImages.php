<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for (HSC) Stories images.
 * See: https://healthsciences.arizona.edu/admin/structure/types/manage/newsstory
 *
 * This runs before the import of Stories so that the Stories migration can look up and link against
 * the image entities.
 *
 * @MigrateSource(id = "newsstory_images")
 */
class NewsStoryImages extends SqlBase {

    public function query() {
        $query = $this->select('node', 'n');
//        $query->addJoin('LEFT OUTER', 'field_data_field_banner_image', 'fbi', 'fbi.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_image', 'fi', 'fi.entity_id = n.nid');
        $query->addJoin('INNER', 'file_managed', 'fm', 'fm.fid = fi.field_image_fid');
        $query->condition('n.type', 'newsstory', '=');
        $query->condition('n.status', '1', '=');
        $query->condition('fm.type', 'image', '=');
        $query->addField('fm', 'filename', 'filename');
        $query->addField('fm', 'uri', 'uri');
        $query->addField('fi', 'field_image_alt', 'field_image_alt');
        $query->addField('fi', 'field_image_title', 'field_image_title');
//        $query->addField('fbi', 'field_banner_image_alt', 'field_banner_image_alt');
//        $query->addField('fbi', 'field_banner_image_title', 'field_banner_image_title');
        $query->groupBy('fm.fid');
        $query->orderBy('fm.timestamp', 'DESC');
        return $query;
    }

    public function fields() {
        $fields = array(
            'filename' => $this->t('Name'),
            'uri' => $this->t('URI'),
            'field_image_alt' => $this->t('Alternate Text'),
            'field_image_title' => $this->t('Title Text'),
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