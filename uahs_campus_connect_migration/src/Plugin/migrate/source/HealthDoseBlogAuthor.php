<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for a Healthy Dose Blog Author.
 * 
 * @MigrateSource(id = "uahs_health_dose_blog_author")
 */
class HealthDoseBlogAuthor extends SqlBase {

    public function query() {
        $query = $this->select('node', 'n');
        $query->addField('n', 'nid', 'nid');
        $query->addField('n2', 'title', 'title');
        $query->addField('fdb', 'body_value', 'body');
        $query->addJoin('LEFT OUTER', 'field_data_field_hs_blog_author', 'fdfhba', 'fdfhba.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'node', 'n2', 'n2.nid = fdfhba.field_hs_blog_author_target_id');
        $query->addJoin('LEFT OUTER', 'field_data_body', 'fdb', 'fdb.entity_id = fdfhba.field_hs_blog_author_target_id');
        $query->condition('n.type', 'health_dose_blog', '=');
        $query->condition('n.status', '1', '=');
        return $query;
    }

    public function fields() {
        return [
            
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