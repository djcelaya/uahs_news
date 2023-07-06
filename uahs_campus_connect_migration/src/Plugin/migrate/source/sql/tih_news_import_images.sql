SELECT
	n.nid,
	fm.filename AS filename,
	fm.uri AS uri,
	fi.field_image_alt AS field_image_alt,
	fi.field_image_title AS field_image_title

FROM node AS n

LEFT JOIN field_data_field_image AS fi ON fi.entity_id = n.nid
JOIN file_managed AS fm ON fm.fid = fi.field_image_fid

WHERE
	n.type = 'tih_news_import'
	AND n.status = 1
	AND fm.type = 'image'

GROUP BY fm.fid

ORDER BY fm.timestamp DESC