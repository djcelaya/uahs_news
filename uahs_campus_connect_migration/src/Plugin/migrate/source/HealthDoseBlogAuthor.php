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
        // $query->addField('n2', 'title', 'title');
        $query->addExpression("GROUP_CONCAT(n2.title SEPARATOR '|')", 'title');
        // $query->addField('fdb', 'body_value', 'body');
        $query->addExpression("GROUP_CONCAT(fdb.body_value SEPARATOR '|')", 'body');
        $query->addJoin('LEFT OUTER', 'field_data_field_hs_blog_author', 'fdfhba', 'fdfhba.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'node', 'n2', 'n2.nid = fdfhba.field_hs_blog_author_target_id');
        $query->addJoin('LEFT OUTER', 'field_data_body', 'fdb', 'fdb.entity_id = fdfhba.field_hs_blog_author_target_id');
        $query->condition('n.type', 'health_dose_blog', '=');
        $query->condition('n.status', '1', '=');
        $query->groupBy('n.nid');
        return $query;
    }

    public function fields() {
        return [
            'nid' => $this->t('Node ID'),
            'title' => $this->t('Title'),
            'body' => $this->t('Body')
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

    /**
     * If two authors exist, put them in separate fields so the paragraph import is easier.
     */
    public function prepareRow(Row $row) {
        $title = $row->getSourceProperty('title');
        $author_titles = explode('|', $title);
        $body = $row->getSourceProperty('body');
        $author_bios = explode('|', $body);

        $first_author_card_title = NULL;
        $first_author_card_body = NULL;
        $first_author_card_body_format = NULL;
        $second_author_card_title = NULL;
        $second_author_card_body = NULL;
        $second_author_card_body_format = NULL;

        if (count($author_titles) > 0) {
            // $first_author_card_title = $author_titles[0];
            $first_author_card_title = 'About the Author';
            $first_author_card_body = $author_bios[0];
            $first_author_card_body_format = 'az_standard';
        }

        if (count($author_titles) > 1) {
            // $second_author_card_title = $author_titles[1];
            $second_author_card_title = 'About the Author';
            $second_author_card_body = $author_bios[1];
            $second_author_card_body_format = 'az_standard';
        }

        $row->setSourceProperty('first_author_card_title', $first_author_card_title);
        $row->setSourceProperty('first_author_card_body', $first_author_card_body);
        $row->setSourceProperty('first_author_card_body_format', $first_author_card_body_format);
        $row->setSourceProperty('second_author_card_title', $second_author_card_title);
        $row->setSourceProperty('second_author_card_body', $second_author_card_body);
        $row->setSourceProperty('second_author_card_body_format', $second_author_card_body_format);

        return parent::prepareRow($row);
    }
}