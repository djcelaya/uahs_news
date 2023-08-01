SELECT
	nid,
	fid,
	filename,
	uri

FROM node

LEFT JOIN field_data_field_card_image ON field_data_field_card_image.entity_id = node.nid
JOIN file_managed ON file_managed.fid = field_data_field_card_image.field_card_image_fid

WHERE
	node.type = 'health_dose_blog'
	AND node.status = 1
	AND file_managed.type = 'image'

GROUP BY file_managed.fid

ORDER BY nid DESC