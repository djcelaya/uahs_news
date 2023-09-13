<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for Honors and Awards.
 * See: https://healthsciences.arizona.edu/admin/structure/types/manage/honors_and_awards
 * 
 * @MigrateSource(id = "honors_and_awards")
 */
class HonorsAwards extends SqlBase {

    function query() {
        $query = $this->select('node', 'n');
        $query->addField('n', 'nid', 'nid');
        $query->addField('n', 'title', 'title');
        $query->addField('fdfpd', 'field_post_date_value', 'field_post_date');
        $query->addField('fdfrd', 'field_release_date_value', 'field_release_date');
        $query->addField('fm1', 'uri', 'field_image_tease');
        $query->addField('fdb', 'body_value', 'body');
        $query->addExpression('GROUP_CONCAT(fm2.uri)', 'field_image');
        $query->addExpression('GROUP_CONCAT(DISTINCT ttd1.name)', 'field_promote_this_content_to');
        $query->addExpression('GROUP_CONCAT(DISTINCT ttd2.name)', 'field_affiliation');
        $query->addExpression('GROUP_CONCAT(DISTINCT ttd3.name)', 'field_portal_category');
        $query->addExpression('GROUP_CONCAT(DISTINCT ttd4.name)', 'field_downstream_sites');
        $query->addJoin('LEFT OUTER', 'field_data_field_post_date', 'fdfpd', 'fdfpd.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_release_date', 'fdfrd', 'fdfrd.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_image_tease', 'fdfit', 'fdfit.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'file_managed', 'fm1', 'fm1.fid = fdfit.field_image_tease_fid');
        $query->addJoin('LEFT OUTER', 'field_data_body', 'fdb', 'fdb.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'field_data_field_image', 'fdfi', 'fdfi.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'file_managed', 'fm2', 'fm2.fid = fdfi.field_image_fid');
        $query->addJoin('LEFT OUTER', 'field_data_field_promote_this_content_to', 'fdfptct', 'fdfptct.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'taxonomy_term_data', 'ttd1', 'ttd1.tid = fdfptct.field_promote_this_content_to_tid');
        $query->addJoin('LEFT OUTER', 'field_data_field_affiliation', 'fdfa', 'fdfa.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'taxonomy_term_data', 'ttd2', 'ttd2.tid = fdfa.field_affiliation_tid');
        $query->addJoin('LEFT OUTER', 'field_data_field_portal_category', 'fdfpc', 'fdfpc.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'taxonomy_term_data', 'ttd3', 'ttd3.tid = fdfpc.field_portal_category_tid');
        $query->addJoin('LEFT OUTER', 'field_data_field_downstream_sites', 'fdfds', 'fdfds.entity_id = n.nid');
        $query->addJoin('LEFT OUTER', 'taxonomy_term_data', 'ttd4', 'ttd4.tid = fdfds.field_downstream_sites_tid');
        $query->condition('n.type', 'honors_and_awards');
        $query->condition('n.status', '1', '=');
        $query->groupBy('n.nid');
        return $query;
    }

    function fields() {
        return [
            'nid' => $this->t('Node ID'),
            'title' => $this->t('Title')
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