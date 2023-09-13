SELECT
	n.nid,
	fm.filename AS filename,
	fm.uri AS uri,
	fi.field_images_alt AS field_image_alt,
	fi.field_images_title AS field_image_title

FROM node AS n

LEFT JOIN field_data_field_images AS fi ON fi.entity_id = n.nid
JOIN file_managed AS fm ON fm.fid = fi.field_images_fid

WHERE
	n.type = 'svp_message'
	AND n.status = 1
	AND fm.type = 'image'

GROUP BY fm.fid

ORDER BY fm.timestamp DESC