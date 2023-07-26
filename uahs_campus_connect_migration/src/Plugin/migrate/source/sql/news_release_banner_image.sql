SELECT
	n.nid AS nid,
--	fm.filename AS filename,
--	fm.uri AS uri,
	fm2.uri AS field_card_image_uri,
	fcic.field_cover_image_caption_value AS field_cover_image_caption

FROM node AS n

-- LEFT JOIN field_data_field_banner_image AS fbi ON fbi.entity_id = n.nid
-- LEFT JOIN file_managed AS fm ON fm.fid = fbi.field_banner_image_fid

LEFT JOIN field_data_field_card_image AS fdfci ON fdfci.entity_id = n.nid
LEFT JOIN file_managed AS fm2 ON fm2.fid = fdfci.field_card_image_fid

LEFT JOIN field_data_field_cover_image_caption AS fcic ON fcic.entity_id = n.nid

WHERE
	n.type = 'news_release'
	AND n.status = 1
--	AND fm.type = 'image'

GROUP BY n.nid

-- ORDER BY fm.`timestamp` DESC