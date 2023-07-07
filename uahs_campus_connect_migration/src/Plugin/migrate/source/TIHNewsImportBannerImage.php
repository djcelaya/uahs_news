<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for TIH News hero image.
 * See: https://healthsciences.arizona.edu/admin/structure/types/manage/tih_news_import
 *
 * This runs before the import of TIH News so that the TIH News migration can look up and link against
 * the image entity.
 *
 * This source plugin is distinct of TIHNewsImportImages because the image caption data is stored with the
 * news entity and not the image file in HSC Campus Connect.
 * 
 * This plugin queries both field_banner_image AND field_card_image and returns field_banner_image if set or
 * filed_card_image by default. Some TIH News items do not have a banner image because an accompanying video is used
 * instead. However, AZ News requires an image for both the Card and Default displays.
 * 
 * As an example, see: https://healthsciences.arizona.edu/tomorrow/0223/service-learning-course-opens-doors-bilingual-students
 *
 * @MigrateSource(id = "tih_news_import_banner_image")
 */
class TIHNewsImportBannerImage extends SqlBase {

    public function query() {
        $query = $this->select('node', 'n');
        //$query->addJoin('LEFT OUTER', 'field_data_field_banner_image', 'fbi', 'fbi.entity_id = n.nid');
        //$query->addJoin('LEFT OUTER', 'file_managed', 'fm1', 'fm1.fid = fbi.field_banner_image_fid');
        $query->addJoin('LEFT OUTER', 'field_data_field_cover_image_caption', 'fcic', 'fcic.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_card_image', 'fci', 'fci.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'file_managed', 'fm2', 'fm2.fid = fci.field_card_image_fid');
        $query->condition('n.type', 'tih_news_import', '=');
        $query->condition('n.status', '1', '=');
        // $query->condition('fm.type', 'image', '=');
        //$query->addField('fm1', 'filename', 'banner_image_filename');
        //$query->addField('fm1', 'uri', 'banner_image_uri');
        $query->addField('fcic', 'field_cover_image_caption_value', 'field_cover_image_caption');
        $query->addField('fm2', 'filename', 'card_image_filename');
        $query->addField('fm2', 'uri', 'card_image_uri');
        $query->groupBy('n.nid');
        return $query;
    }

    public function fields() {
        $fields = array(
            // 'banner_image_filename' => $this->t('Banner Image Filename'),
            // 'banner_image_uri' => $this->t('Banner Image URI'),
            'field_cover_image_caption' => $this->t('Cover Image Caption'),
            'card_image_filename' => $this->t('Card Image Filename'),
            'card_image_uri' => $this->t('Card Image URI'),
        );
        return $fields;
    }

    public function getIds() {
        return [
            'card_image_uri' => [
                'type' => 'string',
                'alias' => 'fm2', // Every story has a card image, but only some have a hero image
            ],
        ];
    }
}