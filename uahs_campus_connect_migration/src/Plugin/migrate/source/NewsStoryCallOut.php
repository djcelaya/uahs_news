<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for HSC News Call-out.
 * See: https://healthsciences.arizona.edu/admin/structure/types/manage/hsc_news_call_out
 * 
 * @MigrateSource(id = "hsc_news_call_out")
 */
class NewsStoryCallOut extends SqlBase {

    public function query() {
        $query = $this->select('node', 'n');
        $query->addField('n', 'nid', 'nid');
        $query->addField('n', 'title', 'title');
        $query->addField('fdfpd', 'field_post_date_value', 'field_post_date');
        $query->addField('fdb', 'body_value', 'body');
        $query->addExpression('GROUP_CONCAT(fm.uri)', 'field_images');
        $query->addField('fdfcns', 'field_connected_news_story_target_id', 'field_connected_news_story');
        $query->addJoin('LEFT OUTER', 'field_data_field_post_date', 'fdfpd', 'fdfpd.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_body', 'fdb', 'fdb.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_connected_news_story', 'fdfcns', 'fdfcns.entity_id = n.nid');
        $query->condition('n.type', 'hsc_news_call_out', '=');
        $query->condition('n.status', '1', '=');
        return $query;
    }

    public function fields() {
        return [
            'nid' => $this->t('Node ID'),
            'title' => $this->t('Title'),
            'field_post_date' => $this->t('Release Date'),
            'body' => $this->t('Body'),
        ];
    }

    public function getIds() {
        return [
            'nid' => [
                'type' => 'intger',
                'alias' => 'n'
            ]
        ];
    }
}