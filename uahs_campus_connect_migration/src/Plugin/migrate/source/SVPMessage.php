<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for SVP Messages.
 * See: https://healthsciences.arizona.edu/admin/structure/types/manage/svp_message
 * 
 * @MigrateSource(id = "svp_message")
 */
class SVPMessage extends SqlBase {

    function query() {
        $query = $this->select('node', 'n');
        $query->addField('n', 'nid', 'nid');
        $query->addField('n', 'title', 'title');
        $query->addField('fdfch', 'field_card_headline_value', 'field_card_headline');
        $query->addField('fm1', 'uri', 'field_card_image');
        $query->addField('fdb', 'body_value', 'body');
        // $query->addExpression('GROUP_CONCAT(fm2.uri)', 'field_images');
        $query->addField('fdfrd', 'field_release_date_value', 'field_release_date');
        $query->addJoin('LEFT OUTER', 'field_data_field_card_headline', 'fdfch', 'fdfch.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_card_image', 'fdfci', 'fdfci.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'file_managed', 'fm1', 'fm1.fid = fdfci.field_card_image_fid');
        $query->addJoin('LEFT OUTER', 'field_data_body', 'fdb', 'fdb.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_release_date', 'fdfrd', 'fdfrd.entity_id = n.nid');
        $query->condition('n.type', 'svp_message');
        $query->condition('n.status', '1');
        return $query;
    }

    function fields() {
        return [
            'nid' => $this->t('Node ID'),
            'title' => $this->t('Title'),
            'field_card_headline' => $this->t('Card Headline'),
            'field_card_image' => $this->t('Card Image'),
            'body' => $this->t('Body'),
            'field_release_date' => $this->t('Release Date')
        ];
    }

    function getIds() {
        return [
            'nid' => [
                'type' => 'integer',
                'alias' => 'n'
            ]
        ];
    }
}