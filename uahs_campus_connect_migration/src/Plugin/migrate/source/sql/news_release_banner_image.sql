SELECT
	n.nid AS nid,
	fm.filename AS filename,
	fm.uri AS uri,
	fcic.field_cover_image_caption_value AS field_cover_image_caption

FROM node AS n

LEFT JOIN field_data_field_banner_image AS fbi ON fbi.entity_id = n.nid
JOIN file_managed AS fm ON fm.fid = fbi.field_banner_image_fid
LEFT JOIN field_data_field_cover_image_caption AS fcic ON fcic.entity_id = n.nid

WHERE
	n.type = 'news_release'
	AND n.status = 1
	AND fm.type = 'image'

GROUP BY fm.fid

ORDER BY fm.`timestamp` DESC