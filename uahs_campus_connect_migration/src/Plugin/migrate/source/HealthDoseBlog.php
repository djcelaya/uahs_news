<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for Healthy Dose Blog Posts.
 * See: https://healthsciences.arizona.edu/admin/structure/types/manage/health_dose_blog
 * 
 * @MigrateSource(id = "health_dose_blog")
 */
class HealthDoseBlog extends SqlBase {
    
    public function query() {
        $query = $this->select('node', 'n');
        $query->addJoin('LEFT OUTER', 'field_data_title_field', 'fdtf', 'fdtf.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_card_headline', 'fdfch', 'fdfch.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_teaser', 'fdft', 'fdft.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_card_image', 'fdfci', 'fdfci.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'file_managed', 'fm', 'fm.fid = fdfci.field_card_image_fid');
        $query->addJoin('LEFT OUTER', 'field_data_field_hs_blog_author', 'fdfhba', 'fdfhba.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'node', 'n2', 'n2.nid = fdfhba.field_hs_blog_author_target_id');
        $query->addJoin('LEFT OUTER', 'field_data_field_post_date', 'fdfpd', 'fdfpd.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_hs_blog_update', 'fdfhbu', 'fdfhbu.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_body', 'fdb', 'fdb.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_health_and_wellness_topics', 'fdfhawt', 'fdfhawt.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'taxonomy_term_data', 'ttd', 'ttd.tid = fdfhawt.field_health_and_wellness_topics_tid');
        $query->addJoin('LEFT OUTER', 'field_data_field_hs_blog_tags', 'fdfhbt', 'fdfhbt.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'taxonomy_term_data', 'ttd2', 'ttd2.tid = fdfhbt.field_hs_blog_tags_tid');
        $query->condition('n.type', 'health_dose_blog', '=');
        $query->condition('n.status', '1', '=');
        $query->addField('n', 'nid', 'nid');
        $query->addField('n', 'title', 'title');
        $query->addField('fdtf', 'title_field_value', 'title_field_value');
        $query->addField('fdfch', 'field_card_headline_value', 'field_card_headline');
        $query->addField('fdft', 'field_teaser_value', 'field_teaser');
        $query->addField('fm', 'uri', 'field_card_image');
        // $query->addField('fdfhba', 'field_hs_blog_author_target_id', 'hs_blog_author_target_id');
        $query->addField('n2', 'title', 'hs_blog_author');
        $query->addField('fdfpd', 'field_post_date_value', 'post_date');
        $query->addField('fdfhbu', 'field_hs_blog_update_value', 'hs_blog_update');
        $query->addField('fdb', 'body_value', 'body');
        $query->addExpression('GROUP_CONCAT(DISTINCT ttd.name)', 'health_and_wellness_topics');
        $query->addExpression('GROUP_CONCAT(DISTINCT ttd2.name)', 'hs_blog_tags');
        $query->groupBy('n.nid');
        $query->orderBy('fdfpd.field_post_date_value', 'DESC');
        return $query;
    }

    public function fields() {
        return [
            'nid' => $this->t('Node ID'),
            'title' => $this->t('Title'),
            'title_field_value' => $this->t('Title Field'),
            'field_card_headline' => $this->t('Card Headline'),
            'field_teaser' => $this->t('Teaser'),
            'field_card_image' => $this->t('Card Image'),
            // 'hs_blog_author_target_id' => $this->t('Author ID'),
            'hs_blog_author' => $this->t('Author'),
            'post_date' => $this->t('Post Date'),
            'hs_blog_update' => $this->t('Update Date'),
            'body' => $this->t('Body'),
            'health_and_wellness_topics' => $this->t('Health & Wellness Topics'),
            'hs_blog_tags' => $this->t('Tags')
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