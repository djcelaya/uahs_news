SELECT
	n.nid AS nid,
	GROUP_CONCAT(DISTINCT fm.uri) AS uris

FROM node AS n

LEFT JOIN field_data_field_images AS fdfi ON fdfi.entity_id = n.nid
LEFT JOIN file_managed AS fm ON fm.fid = fdfi.field_images_fid

LEFT JOIN field_data_field_post_date AS fdfpd ON fdfpd.entity_id = n.nid

WHERE
	n.type = 'photo_gallery'
	AND n.status = 1
	AND fm.type = 'image'

GROUP BY n.nid

ORDER BY fdfpd.field_post_date_value DESC;