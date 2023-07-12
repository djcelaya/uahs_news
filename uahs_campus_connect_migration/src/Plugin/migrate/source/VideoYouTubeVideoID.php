<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for YouTube videos connected to the Video content type.
 * See: https://healthsciences.arizona.edu/admin/structure/types/manage/video
 * 
 * @MigrateSource(id = "video_youtube_video_id")
 */
class VideoYouTubeVideoID extends SqlBase {

    public function query() {
        $query = $this->select('node', 'n');
        $query->addField('n', 'nid', 'nid');
        $query->addField('n', 'title', 'title');
        $query->addField('n', 'created', 'created');
        $query->addField('fdfyvi', 'field_youtube_video_id_value', 'youtube_video_id');
        $query->addJoin('LEFT OUTER', 'field_data_field_youtube_video_id', 'fdfyvi', 'fdfyvi.entity_id = n.nid');
        $query->condition('n.type', 'video');
        $query->condition('n.status', '1', '=');
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