SELECT
	n.nid AS nid,
	fm1.filename AS banner_image_filename,
	fm1.uri AS banner_image_uri,
	fm2.filename AS card_image_filename,
	fm2.uri AS card_image_uri,
	fcic.field_cover_image_caption_value AS field_cover_image_caption

FROM node AS n

LEFT JOIN field_data_field_banner_image AS fbi ON fbi.entity_id = n.nid
LEFT JOIN file_managed AS fm1 ON fm1.fid = fbi.field_banner_image_fid

LEFT JOIN field_data_field_cover_image_caption AS fcic ON fcic.entity_id = n.nid

LEFT JOIN field_data_field_card_image AS fci ON fci.entity_id = n.nid
LEFT JOIN file_managed AS fm2 ON fm2.fid = fci.field_card_image_fid

WHERE
	n.type = 'tih_news_import'
	AND n.status = 1

GROUP BY n.nid

ORDER BY n.created DESC