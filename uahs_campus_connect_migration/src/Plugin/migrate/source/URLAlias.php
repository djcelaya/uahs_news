<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for news URL aliases.
 *
 * @MigrateSource(id = "url_alias")
 */
class URLAlias extends SqlBase {

    const TYPES = [
        'newsstory',
        'hsc_news_call_out'
    ];

    public function query() {
        $query = $this->select('node', 'n');
        $query->addField('u_a', 'pid');
        $query->addField('u_a', 'source');
        $query->addField('u_a', 'alias');
        $query->addField('n', 'nid');
//        $query->addField('r', 'redirect');
        $query->addJoin('LEFT OUTER', 'url_alias', 'u_a', "u_a.source = CONCAT('node/', n.nid)");
//        $query->addJoin('LEFT OUTER', 'redirect', 'r', "r.redirect = CONCAT('node/', n.nid)");
        // $query->condition('n.type', 'newsstory', '=');
        $query->condition('n.type', self::TYPES, 'IN');
        $query->condition('n.status', '1', '=');
        return $query;
    }

    public function fields() {
        $fields = array(
            'pid' => $this->t('PID'),
            'source' => $this->t('Source'),
            'alias' => $this->t('URL alias'),
//            'redirect' => $this->t('URL redirects'),
            'nid' => $this->t('Node ID'),
        );
        return $fields;
    }

    public function getIds() {
        return [
            'pid' => [
                'type' => 'integer',
                'alias', 'u_a',
            ],
        ];
    }
}