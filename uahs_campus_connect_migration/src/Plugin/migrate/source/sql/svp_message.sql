SELECT
    n.nid AS nid,
    n.title AS title,
    fdfch.field_card_headline_value AS field_card_headline,
    GROUP_CONCAT(fm1.uri) AS field_card_image,
    fdb.body_value AS body,
    GROUP_CONCAT(fm2.uri) AS field_images,
    fdfrd.field_release_date_value AS field_release_date

FROM node AS n

LEFT JOIN field_data_field_card_headline AS fdfch ON fdfch.entity_id = n.nid

LEFT JOIN field_data_field_card_image AS fdfci ON fdfci.entity_id = n.nid
LEFT JOIN file_managed AS fm1 ON fm1.fid = fdfci.field_card_image_fid

LEFT JOIN field_data_body AS fdb ON fdb.entity_id = n.nid

LEFT JOIN field_data_field_images AS fdfi2 ON fdfi2.entity_id = n.nid
LEFT JOIN file_managed AS fm2 ON fm2.fid = fdfi2.field_images_fid

LEFT JOIN field_data_field_release_date AS fdfrd ON fdfrd.entity_id = n.nid

WHERE
    n.type = 'svp_message'
    AND n.status = 1

GROUP BY n.nid