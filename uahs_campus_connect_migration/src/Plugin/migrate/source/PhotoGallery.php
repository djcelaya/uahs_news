<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for Photo Galleries.
 * 
 * @MigrateSource(id = "photo_gallery")
 */
class PhotoGallery extends SqlBase {
    
    public function query() {
        $query = $this->select('node', 'n');
        $query->addField('n', 'nid', 'nid');
        $query->addField('n', 'title', 'title');
        return $query;
    }

    public function fields() {
        return [
            'nid' => $this->t('Node ID'),
            'title' => $this->t('Title')
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