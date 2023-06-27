SELECT
	n.nid AS nid,
	fm.filename AS filename,
	fm.uri AS uri,
	fdfi.field_images_alt AS alt,
	fdfi.field_images_title AS title,
	fdfi.delta AS delta

FROM node AS n

LEFT JOIN field_data_field_images AS fdfi ON fdfi.entity_id = n.nid
LEFT JOIN file_managed AS fm ON fm.fid = fdfi.field_images_fid

WHERE
	n.type = 'photo_gallery'
	AND n.status = 1
	AND fm.type = 'image'

-- GROUP BY n.nid