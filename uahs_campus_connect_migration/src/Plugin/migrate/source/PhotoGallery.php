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
        $query->addField('fdfcic', 'field_cover_image_caption_value', 'field_cover_image_caption');

        $query->addJoin('LEFT OUTER', 'field_data_field_card_headline', 'fdfch', 'fdfch.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_card_image', 'fdfci', 'fdfci.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'file_managed', 'fm1', 'fm1.fid = fdfci.field_card_image_fid');
        $query->addJoin('LEFT OUTER', 'field_data_field_teaser', 'fdft', 'fdft.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_post_date', 'fdfpd', 'fdfpd.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_body', 'fdb', 'fdb.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_cover_image', 'fdfci2', 'fdfci2.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'file_managed', 'fm2', 'fm2.fid = fdfci2.field_cover_image_fid');
        $query->addJoin('LEFT OUTER', 'field_data_field_cover_image_caption', 'fdfcic', 'fdfcic.entity_id = n.nid');

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
            'field_cover_image_caption' => $this->t('Cover Image Caption'),
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