<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for Destination websites for Content.
 * See: https://healthsciences.arizona.edu/admin/structure/taxonomy/downstream_news_releases
 *
 * Excludes importing the "Cancer Center" term as it is unused in the source and repeated in
 * the Centers taxonomy.
 *
 * @MigrateSource(id = "downstream_news_releases")
 */
class DownstreamNewsReleases extends SqlBase {

    const DOWNSTREAM_NEWS_RELEASES_VID = 25;
    const UAHS_TID = 307;

    public function query() {
        $query = $this->select('taxonomy_term_data', 't')
            ->condition('t.vid', self::DOWNSTREAM_NEWS_RELEASES_VID, '=')
            ->condition('t.name', 'Cancer Center', '!=')
            ->condition('t.tid', self::UAHS_TID, '!=')
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