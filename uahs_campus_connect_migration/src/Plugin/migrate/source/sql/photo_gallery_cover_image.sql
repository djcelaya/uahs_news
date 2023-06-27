SELECT
	n.nid AS nid,
	fm.filename AS field_cover_image_filename,
	fm.uri AS field_cover_image_uri,
	fdfci.field_cover_image_alt AS field_cover_image_alt,
	fdfci.field_cover_image_title AS field_cover_image_title,
	fdfcic.field_cover_image_caption_value AS field_cover_image_caption

FROM node AS n

LEFT JOIN field_data_field_cover_image AS fdfci ON fdfci.entity_id = n.nid
LEFT JOIN file_managed AS fm ON fm.fid = fdfci.field_cover_image_fid

LEFT JOIN field_data_field_cover_image_caption AS fdfcic ON fdfcic.entity_id = n.nid

LEFT JOIN field_data_field_post_date AS fdfpd ON fdfpd.entity_id = n.nid

WHERE
	n.type = 'photo_gallery'
	AND n.status = 1

GROUP BY n.nid

ORDER BY fdfpd.field_post_date_value DESC;