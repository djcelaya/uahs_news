<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for Photo Galleries.
 * 
 * @MigrateSource(id = "photo_gallery")
 */
class PhotoGallery extends SqlBase {
    
    public function query() {
        $query = $this->select('node', 'n');

        $query->addField('n', 'nid', 'nid');
        $query->addField('n', 'title', 'title');
        $query->addField('fdfch', 'field_card_headline_value', 'field_card_headline');
        $query->addField('fm1', 'uri', 'field_card_image');
        $query->addField('fdft', 'field_teaser_value', 'field_teaser');
        $query->addField('fdfpd', 'field_post_date_value', 'field_post_date');
        $query->addField('fdb', 'body_value', 'body');
        $query->addField('fm2', 'uri', 'field_cover_image');
        $query->addField('fdfci2', 'field_cover_image_alt', 'field_cover_image_alt');
        $query->addField('fdfci2', 'field_cover_image_title', 'field_cover_image_title');
        $query->addField('fdfcic', 'field_cover_image_caption_value', 'field_cover_image_caption');
        $query->addExpression('GROUP_CONCAT(DISTINCT ttd1.name)', 'field_promote_this_content_to');
        $query->addExpression('GROUP_CONCAT(DISTINCT ttd2.name)', 'field_health_sciences_category_2');
        $query->addExpression('GROUP_CONCAT(DISTINCT ttd3.name)', 'field_portal_category');
        $query->addExpression('GROUP_CONCAT(DISTINCT ttd4.name)', 'field_affiliation');
        $query->addExpression('GROUP_CONCAT(DISTINCT ttd5.name)', 'field_strategic_theme');
        $query->addExpression('GROUP_CONCAT(DISTINCT ttd6.name)', 'field_health_sciences_centers');
        $query->addExpression('GROUP_CONCAT(DISTINCT ttd7.name)', 'field_downstream_sites');

        $query->addJoin('LEFT OUTER', 'field_data_field_card_headline', 'fdfch', 'fdfch.entity_id = n.nid');

        $query->addJoin('LEFT OUTER', 'field_data_field_card_image', 'fdfci', 'fdfci.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'file_managed', 'fm1', 'fm1.fid = fdfci.field_card_image_fid');

        $query->addJoin('LEFT OUTER', 'field_data_field_teaser', 'fdft', 'fdft.entity_id = n.nid');

        $query->addJoin('LEFT OUTER', 'field_data_field_post_date', 'fdfpd', 'fdfpd.entity_id = n.nid');

        $query->addJoin('LEFT OUTER', 'field_data_body', 'fdb', 'fdb.entity_id = n.nid');

        $query->addJoin('LEFT OUTER', 'field_data_field_cover_image', 'fdfci2', 'fdfci2.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'file_managed', 'fm2', 'fm2.fid = fdfci2.field_cover_image_fid');

        $query->addJoin('LEFT OUTER', 'field_data_field_cover_image_caption', 'fdfcic', 'fdfcic.entity_id = n.nid');

        $query->addJoin('LEFT OUTER', 'field_data_field_promote_this_content_to', 'fdfptct', 'fdfptct.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'taxonomy_term_data', 'ttd1', 'ttd1.tid = fdfptct.field_promote_this_content_to_tid');

        $query->addJoin('LEFT OUTER', 'field_data_field_health_sciences_category_2', 'fdfhsc2', 'fdfhsc2.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'taxonomy_term_data', 'ttd2', 'ttd2.tid = fdfhsc2.field_health_sciences_category_2_tid AND fdfhsc2.field_health_sciences_category_2_tid != 318');

        $query->addJoin('LEFT OUTER', 'field_data_field_portal_category', 'fdfpc', 'fdfpc.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'taxonomy_term_data', 'ttd3', 'ttd3.tid = fdfpc.field_portal_category_tid AND fdfpc.field_portal_category_tid != 318');

        $query->addJoin('LEFT OUTER', 'field_data_field_affiliation', 'fdfa', 'fdfa.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'taxonomy_term_data', 'ttd4', 'ttd4.tid = fdfa.field_affiliation_tid');

        $query->addJoin('LEFT OUTER', 'field_data_field_strategic_theme', 'fdfst', 'fdfst.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'taxonomy_term_data', 'ttd5', 'ttd5.tid = fdfst.field_strategic_theme_tid');

        $query->addJoin('LEFT OUTER', 'field_data_field_health_sciences_centers', 'fdfhsc', 'fdfhsc.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'taxonomy_term_data', 'ttd6', 'ttd6.tid = fdfhsc.field_health_sciences_centers_tid');

        $query->addJoin('LEFT OUTER', 'field_data_field_downstream_sites', 'fdfds', 'fdfds.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'taxonomy_term_data', 'ttd7', 'ttd7.tid = fdfds.field_downstream_sites_tid');

        $query->condition('n.type', 'photo_gallery', '=');
        $query->condition('n.status', '1', '=');

        $query->groupBy('n.nid');
        $query->orderBy('fdfpd.field_post_date_value', 'DESC');

        return $query;
    }

    public function fields() {
        return [
            'nid' => $this->t('Node ID'),
            'title' => $this->t('Headline'),
            'field_card_headline' => $this->t('Card Headline'),
            'field_card_image' => $this->t('Card Image'),
            'field_teaser' => $this->t('Teaser'),
            'field_post_date' => $this->t('Release Date'),
            'body' => $this->t('Description'),
            'field_cover_image' => $this->t('Hero Image'),
            'field_cover_image_alt' => $this->t('Hero Image Alt'),
            'field_cover_image_title' => $this->t('Hero Image Title'),
            'field_cover_image_caption' => $this->t('Cover Image Caption'),
            'field_promote_this_content_to' => $this->t('Promote this content to'),
            'field_health_sciences_category_2' => $this->t('Content Category'),
            'field_portal_category' => $this->t('Primary Category'),
            'field_affiliation' => $this->t('Affiliation'),
            'field_strategic_theme' => $this->t('Strategic Theme'),
            'field_health_sciences_centers' => $this->t('Health Sciences Centers'),
            'field_downstream_sites' => $this->t('Destination Sites')
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