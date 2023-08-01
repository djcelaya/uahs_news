<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for Health Dose Blog inline images.
 * See: https://healthsciences.arizona.edu/admin/structure/types/manage/health_dose_blog
 * 
 * @MigrateSource(id = "health_dose_blog_images")
 */
class HealthDoseBlogImages extends SqlBase {

    public function query() {
        $query = $this->select('node', 'n');
        $query->addJoin('LEFT OUTER', 'field_data_field_hs_blog_images', 'fdfhbi', 'fdfhbi.entity_id = n.nid');
        $query->addJoin('INNER', 'file_managed', 'fm', 'fm.fid = fdfhbi.field_hs_blog_images_fid');
        $query->condition('n.type', 'health_dose_blog', '=');
        $query->condition('n.status', '1', '=');
        $query->condition('fm.type', 'image', '=');
        $query->addField('fm', 'filename', 'filename');
        $query->addField('fm', 'uri', 'uri');
        $query->addField('fdfhbi', 'field_hs_blog_images_alt', 'field_image_alt');
        $query->addField('fdfhbi', 'field_hs_blog_images_title', 'field_image_title');
        $query->groupBy('fm.fid');
        $query->orderBy('fm.timestamp', 'DESC');
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
                'alias' => 'fm'
            ]
        ];
    }
}