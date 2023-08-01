<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for Healthy Dose Blog Topics.
 * See: https://healthsciences.arizona.edu/admin/structure/taxonomy/hs_blog_topics
 * See: sql/hs_blog_tags.sql for raw query
 * 
 * @MigrateSource(id = "health_dose_blog_topics")
 */
class HealthDoseBlogTopics extends SqlBase {

    const HS_BLOG_TOPICS_VID = 32;

    public function query() {
        $query = $this->select('taxonomy_term_data', 't');
        $query->addJoin('INNER', 'taxonomy_vocabulary', 'v', 'v.vid = t.vid');
        $query->condition('v.vid', self::HS_BLOG_TOPICS_VID, '=');
        $query->addField('t', 'tid', 'tid');
        $query->addField('t', 'name', 'name');
        return $query;
    }

    public function fields() {
        return [
            'name' => $this->t('Name'),
        ];
    }

    public function getIds() {
        return [
            'name' => [
                'type' => 'string',
                'alias' => 't'
            ]
        ];
    }
}