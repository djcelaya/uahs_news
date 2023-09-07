<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for (HSC) Stories.
 * See: https://healthsciences.arizona.edu/admin/structure/types/manage/newsstory
 *
 * @MigrateSource(id = "newsstory")
 */
class NewsStory extends SqlBase {

    public function query() {
        $query = $this->select('node', 'n');
//        $query->addJoin('INNER', 'field_data_field_card_headline', 'fch', 'fch.entity_id = n.nid');
        $query->addJoin('INNER', 'field_data_field_teaser', 'ft', 'ft.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_banner_image', 'fbi', 'fbi.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'file_managed', 'fm', 'fm.fid = fbi.field_banner_image_fid');
        $query->addJoin('INNER', 'field_data_field_post_date', 'fpd', 'fpd.entity_id = n.nid');
        $query->addJoin('INNER', 'field_data_body', 'fdb', 'fdb.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_health_sciences_category_2', 'fhsc2', 'fhsc2.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'taxonomy_term_data', 't_hsc2', 't_hsc2.tid = fhsc2.field_health_sciences_category_2_tid');
        $query->addJoin('LEFT OUTER', 'field_data_field_portal_category', 'fpc', 'fpc.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'taxonomy_term_data', 't_pc', 't_pc.tid = fpc.field_portal_category_tid');
        $query->addJoin('LEFT OUTER', 'field_data_field_affiliation', 'fa', 'fa.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'taxonomy_term_data', 't_a', 't_a.tid = fa.field_affiliation_tid');
        $query->addJoin('LEFT OUTER', 'field_data_field_strategic_theme', 'fst', 'fst.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'taxonomy_term_data', 't_st', 't_st.tid = fst.field_strategic_theme_tid');
        $query->addJoin('LEFT OUTER', 'field_data_field_health_sciences_centers', 'fhsc', 'fhsc.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'taxonomy_term_data', 't_hsc', 't_hsc.tid = fhsc.field_health_sciences_centers_tid');
        $query->addJoin('LEFT OUTER', 'field_data_field_downstream_sites', 'fds', 'fds.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'taxonomy_term_data', 't_ds', 't_ds.tid = fds.field_downstream_sites_tid');
        $query->addJoin('LEFT OUTER', 'field_data_field_promote_this_content_to', 'fptct', 'fptct.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'taxonomy_term_data', 't_ptct', 't_ptct.tid = fptct.field_promote_this_content_to_tid');
        //$query->addJoin('INNER', 'url_alias', 'u_a', "u_a.source = CONCAT('node/', n.nid)");
        $query->condition('n.type', 'newsstory', '=');
        $query->condition('n.status', '1', '=');
        $query->addField('n', 'nid', 'nid');
        $query->addField('n', 'title', 'title');
//        $query->addField('fch', 'field_card_headline_value', 'field_card_headline');
        $query->addField('ft', 'field_teaser_value', 'field_teaser');
        $query->addField('fm', 'uri', 'field_banner_image');
        $query->addField('fpd', 'field_post_date_value', 'field_post_date');
        $query->addField('fdb', 'body_value', 'body');
        $query->addExpression('GROUP_CONCAT(DISTINCT t_hsc2.name)', 'field_health_science_category_2');
        $query->addField('t_pc', 'name', 'field_portal_category');
        $query->addExpression('GROUP_CONCAT(DISTINCT t_a.name)', 'field_affiliation');
        $query->addExpression('GROUP_CONCAT(DISTINCT t_st.name)', 'field_strategic_theme');
        $query->addExpression('GROUP_CONCAT(DISTINCT t_hsc.name)', 'field_health_sciences_centers');
        $query->addExpression('GROUP_CONCAT(DISTINCT t_ds.name)', 'field_downstream_sites');
        $query->addExpression('GROUP_CONCAT(DISTINCT t_ptct.name)', 'field_promote_this_content_to');
        //$query->addField('u_a', 'alias', 'alias');
        $query->groupBy('n.nid');
        $query->orderBy('fpd.field_post_date_value', 'DESC');
        return $query;
    }

    public function fields() {
        $fields = array(
            'nid' => $this->t('Node ID'),
            'title' => $this->t('Headline'),
//            'field_card_headline' => $this->t('Card Headline'),
            'field_teaser' => $this->t('Teaser'),
            'field_banner_image' => $this->t('Hero Image'),
            'field_post_date' => $this->t('Release Date'),
            'body' => $this->t('Body'),
            'field_health_science_category_2' => $this->t('Content Category'),
            'field_portal_category' => $this->t('Primary Category'),
            'field_affiliation' => $this->t('Affiliation'),
            'field_strategic_theme' => $this->t('Strategic Theme'),
            'field_health_sciences_centers' => $this->t('Health Sciences Centers'),
            'field_downstream_sites' => $this->t('Destination Sites'),
            'field_promote_this_content_to' => $this->t('Promote this content to'),
            'alias' => $this->t('URL alias'),
        );
        return $fields;
    }

    public function getIds() {
        return [
            'nid' => [
                'type' => 'integer',
                'alias' => 'n',
            ],
        ];
    }
}