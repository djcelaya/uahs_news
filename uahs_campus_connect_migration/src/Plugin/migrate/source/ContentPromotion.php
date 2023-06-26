<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for Content Promotion taxonomy terms.
 * See: https://healthsciences.arizona.edu/admin/structure/taxonomy/content_promotion
 *
 * @MigrateSource(id = "content_promotion")
 */
class ContentPromotion extends SqlBase {

    const CONTENT_PROMOTION_VID = 23;
    const NEWSROOM_TID = 268;
    const TIH_TID = 270;
    const SI_TID = 271;

    public function query() {
        $query = $this->select('taxonomy_term_data', 't')
            ->condition('t.vid', self::CONTENT_PROMOTION_VID, '=')
            // ->condition('t.tid', self::NEWSROOM_TID, '!=')
            // ->condition('t.tid', self::TIH_TID, '!=')
            ->condition('t.tid', self::SI_TID, '!=')
            ->fields('t', array(
                'tid',
                'vid',
                'name',
                'description',
                'format',
                'weight'
            ));
        return $query;
    }

    public function fields() {
        $fields = array(
            'tid' => $this->t('Term ID'),
            'vid' => $this->t('Vocabulary ID'),
            'name' => $this->t('Name'),
            'description' => $this->t('Description'),
            'format' => $this->t('Description Format'),
            'weight' => $this->t('Weight'),
        );
        return $fields;
    }

    public function getIds() {
        return [
            'name' => [
                'type' => 'string',
                'alias' => 't',
            ],
        ];
    }
}