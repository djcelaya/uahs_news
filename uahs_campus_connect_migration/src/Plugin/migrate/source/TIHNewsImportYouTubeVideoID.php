<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for YouTube videos connected to the TIH News content type.
 * See: https://healthsciences.arizona.edu/admin/structure/types/manage/tih_news_import
 * 
 * @MigrateSource(id = "tih_news_import_youtube_video_id")
 */
class TIHNewsImportYouTubeVideoID extends SqlBase {

    public function query() {
        $query = $this->select('node', 'n');
        $query->addField('n', 'nid', 'nid');
        $query->addField('n', 'title', 'title');
        $query->addField('n', 'created', 'created');
        $query->addField('fdfyvi', 'field_youtube_video_id_value', 'youtube_video_id');
        $query->addJoin('LEFT OUTER', 'field_data_field_youtube_video_id', 'fdfyvi', 'fdfyvi.entity_id = n.nid');
        $query->condition('n.type', 'tih_news_import');
        $query->condition('n.status', '1', '=');
        $query->isNotNull('fdfyvi.field_youtube_video_id_value');
        $query->orderBy('n.created', 'DESC');
        return $query;
    }

    public function fields() {
        return [
            'nid' => $this->t('Node ID'),
            'title' => $this->t('Title'),
            'created' => $this->t('Created'),
            'youtube_video_id' => $this->t('YouTube Video ID')
        ];
    }

    public function getIds() {
        return [
            'youtube_video_id' => [
                'type' => 'string',
                'alias' => 'fdfyvi'
            ]
        ];
    }
}