<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for Honors & Awards Image Tease field.
 * 
 * @MigrateSource(id = "honors_and_awards_image_tease")
 */
class HonorsAwardsImageTease extends SqlBase {

    function query() {
        $query = $this->select('node', 'n');
        $query->addField('fm', 'filename', 'image_tease_filename');
        $query->addField('fm', 'uri', 'image_tease_uri');
        $query->addField('fdfit', 'field_image_tease_alt', 'image_tease_alt');
        $query->addfield('fdfit', 'field_image_tease_title', 'image_tease_title');
        $query->addJoin('LEFT OUTER', 'field_data_field_image_tease', 'fdfit', 'fdfit.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'file_managed', 'fm', 'fm.fid = fdfit.field_image_tease_fid');
        $query->condition('n.type', 'honors_and_awards', '=');
        $query->condition('n.status', '1', '=');
        return $query;
    }

    function fields() {
        return [
            'image_tease_filename' => $this->t('Image Tease Filename'),
            'image_tease_uri' => $this->t('Image Tease URI'),
            'image_tease_alt' => $this->t('Image Tease Alt'),
            'image_tease_title' => $this->t('Image Tease Title')
        ];
    }

    public function getIds() {
        return [
            'image_tease_uri' => [
                'type' => 'string',
                'alias' => 'fm'
            ]
        ];
    }
}