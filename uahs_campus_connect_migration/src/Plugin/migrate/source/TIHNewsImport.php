<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for TIH News.
 * See: https://healthsciences.arizona.edu/admin/structure/types/manage/tih_news_import
 * 
 * @MigrateSource(id = "tih_news_import")
 */
class TIHNewsImport extends SqlBase {

    public function query() {
        $query = $this->select('node', 'n');
        $query->addField('n', 'nid', 'nid');
        $query->addField('n', 'title', 'title');
        $query->addField('fm', 'uri', 'field_card_image');
        $query->addField('ft', 'field_teaser_value', 'field_teaser');
        $query->addField('fdfyvi', 'field_youtube_video_id_value', 'field_youtube_video_id');
        $query->addField('fpd', 'field_post_date_value', 'field_post_date');
        $query->addField('fdb', 'body_value', 'body');
        $query->addfield('fc', 'field_contact_value', 'field_contact');

        $query->addExpression('GROUP_CONCAT(DISTINCT t_hsc2.name)', 'field_health_science_category_2');
        $query->addField('t_pc', 'name', 'field_portal_category');
        $query->addExpression('GROUP_CONCAT(DISTINCT t_a.name)', 'field_affiliation');
        $query->addExpression('GROUP_CONCAT(DISTINCT t_st.name)', 'field_strategic_theme');
        $query->addExpression('GROUP_CONCAT(DISTINCT t_hsc.name)', 'field_health_sciences_centers');
        $query->addExpression('GROUP_CONCAT(DISTINCT t_ds.name)', 'field_downstream_sites');
        $query->addExpression('GROUP_CONCAT(DISTINCT t_ptct.name)', 'field_promote_this_content_to');

        $query->addJoin('LEFT OUTER', 'field_data_field_card_image', 'fci', 'fci.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'file_managed', 'fm', 'fm.fid = fci.field_card_image_fid');

        $query->addJoin('LEFT OUTER', 'field_data_field_teaser', 'ft', 'ft.entity_id = n.nid');

        $query->addJoin('LEFT OUTER', 'field_data_field_youtube_video_id', 'fdfyvi', 'fdfyvi.entity_id = n.nid');

        $query->addJoin('INNER', 'field_data_field_post_date', 'fpd', 'fpd.entity_id = n.nid');

        $query->addJoin('LEFT OUTER', 'field_data_body', 'fdb', 'fdb.entity_id = n.nid');

        $query->addJoin('LEFT OUTER', 'field_data_field_contact', 'fc', 'fc.entity_id = n.nid');

        $query->addJoin('LEFT OUTER', 'field_data_field_health_sciences_category_2', 'fhsc2', 'fhsc2.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'taxonomy_term_data', 't_hsc2',
            't_hsc2.tid = fhsc2.field_health_sciences_category_2_tid AND fhsc2.field_health_sciences_category_2_tid != 318');
        $query->addJoin('LEFT OUTER', 'field_data_field_portal_category', 'fpc', 'fpc.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'taxonomy_term_data', 't_pc',
            't_pc.tid = fpc.field_portal_category_tid AND fpc.field_portal_category_tid != 318');
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

        $query->condition('n.type', 'tih_news_import');
        $query->condition('n.status', '1', '=');

        $query->groupBy('n.nid');
        $query->orderBy('fpd.field_post_date_value', 'DESC');
        return $query;
    }

    public function fields() {
        return [
            'nid' => $this->t('Node ID'),
            'title' => $this->t('Headline'),
            'field_teaser' => $this->t('Teaser'),
            // 'field_card_image' => $this->t('Hero Image'),
            // 'field_youtube_video_id' => $this->t('YouTube Video ID'),
            'hero_media' => $this->t('Hero Media'),
            'field_post_date' => $this->t('Release Date'),
            'body' => $this->t('Body'),
            'field_contact' => $this->t('Contact'),
            'field_health_science_category_2' => $this->t('Content Category'),
            'field_portal_category' => $this->t('Primary Category'),
            'field_affiliation' => $this->t('Affiliation'),
            'field_strategic_theme' => $this->t('Strategic Theme'),
            'field_health_sciences_centers' => $this->t('Health Sciences Centers'),
            'field_downstream_sites' => $this->t('Destination Sites'),
            'field_promote_this_content_to' => $this->t('Promote this content to'),

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

    public function prepareRow(Row $row) {
        $nid = $row->getSourceProperty('nid');
        $hero_image = $row->getSourceProperty('field_card_image');
        $hero_video = $row->getSourceProperty('field_youtube_video_id');
        $hero_media = $hero_video ? $hero_video : $hero_image;
        // print("Found $hero_media for NID $nid\n");
        $row->setSourceProperty('hero_media', $hero_media);
        return parent::prepareRow($row);
    }
}