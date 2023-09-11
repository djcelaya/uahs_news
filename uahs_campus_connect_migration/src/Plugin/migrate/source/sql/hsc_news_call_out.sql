SELECT
    n.nid AS nid,
    n.title AS title,
    fdfpd.field_post_date_value AS field_post_date,
    fdb.body_value AS body,
    GROUP_CONCAT(fm.uri) AS field_images,
    fdfcns.field_connected_news_story_target_id AS field_connected_news_story

FROM node AS n

LEFT JOIN field_data_field_post_date AS fdfpd ON fdfpd.entity_id = n.nid
LEFT JOIN field_data_body AS fdb ON fdb.entity_id = n.nid
LEFT JOIN field_data_field_images AS fdfi ON fdfi.entity_id = n.nid
LEFT JOIN file_managed AS fm ON fm.fid = fdfi.field_images_fid
LEFT JOIN field_data_field_connected_news_story AS fdfcns ON fdfcns.entity_id = n.nid

WHERE
    n.type = 'hsc_news_call_out'
    AND n.status = 1

GROUP BY n.nid

ORDER BY n.nid;