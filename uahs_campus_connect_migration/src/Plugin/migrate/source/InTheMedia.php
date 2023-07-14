<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for HSC In The Media.
 * See: https://healthsciences.arizona.edu/admin/structure/types/manage/in_the_media
 * 
 * @MigrateSource(id = "in_the_media")
 */
class InTheMedia extends SqlBase {

    public function query() {
        $query = $this->select('node', 'n');
        $query->addJoin('INNER', 'field_data_field_release_date', 'frd', 'frd.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_link_to_story', 'flts', 'flts.entity_id = n.nid');
        $query->addJoin('INNER', 'field_data_body', 'b', 'b.entity_id = n.nid');
        $query->condition('n.type', 'in_the_media', '=');
        $query->condition('n.status', '1', '=');
        $query->addField('n', 'nid', 'nid');
        $query->addField('n', 'title', 'title');
        $query->addField('frd', 'field_release_date_value', 'field_release_date');
        $query->addField('flts', 'field_link_to_story_title', 'field_link_to_story_title');
        $query->addField('flts', 'field_link_to_story_url', 'field_link_to_story_url');
        $query->addField('b', 'body_value', 'body');
        $query->orderBy('frd.field_release_date_value', 'DESC');
        return $query;
    }

    public function fields() {
        return [
            'nid' => $this->t('Node ID'),
            'title' => $this->t('Title'),
            'field_release_date' => $this->t('Release Date'),
            'field_link_to_story_title' => $this->t('Link to Story Title'),
            'field_link_to_story_url' => $this->t('Link to Story URL'),
            'body' => $this->t('Media Summary'),
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