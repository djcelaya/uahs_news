SELECT
	nid,
	fid,
	filename,
	uri,
	field_data_field_image.field_image_alt,
	field_data_field_image.field_image_title
--	field_data_field_banner_image.field_banner_image_alt,
--	field_data_field_banner_image.field_banner_image_title,
--	GROUP_CONCAT(field_data_field_image.field_image_alt, field_data_field_banner_image.field_banner_image_alt)

FROM node

-- Use LEFT JOIN to determine which Stories do not have a hero image...usually in the case of a video taking the
-- place of the image
-- LEFT JOIN field_data_field_banner_image ON field_data_field_banner_image.entity_id = node.nid
-- LEFT JOIN file_managed ON file_managed.fid = field_data_field_banner_image.field_banner_image_fid
-- LEFT JOIN field_data_field_banner_image ON field_data_field_banner_image.entity_id = node.nid
LEFT JOIN field_data_field_image ON field_data_field_image.entity_id = node.nid
-- LEFT JOIN field_data_field_attached_files ON field_data_field_attached_files.entity_id = node.nid

-- JOIN file_managed AS file_managed_banner_image ON file_managed_banner_image.fid = field_data_field_banner_image.field_banner_image_fid
JOIN file_managed ON (
--	file_managed.fid = field_data_field_banner_image.field_banner_image_fid
	file_managed.fid = field_data_field_image.field_image_fid
--	OR file_managed.fid = field_data_field_attached_files.field_attached_files_fid
)


-- JOIN field_data_field_image ON field_data_field_image.entity_id = node.nid
-- JOIN file_managed AS file_managed_image ON file_managed_image.fid = field_data_field_image.field_image_fid

WHERE
	node.type = 'newsstory'
	AND node.status = 1
	AND file_managed.type = 'image'
--	AND nid = 8381
--	AND file_managed.filemime = 'application/pdf'
--	AND filename = 'nhg-012820-porreca_1231-inline_1.54.56_pm.jpg';
--	AND uri LIKE 'public://%'
--	AND field_banner_image_alt = 'Wellness Wednesdays'
--	AND (
--		filename = '101922-cori-michael-daines-nhg_0207-hero.jpg'
--		OR filename = '101922-cori-michael-daines-nhg_0226-hero.jpg'
--	)
--	AND nid = 8369

GROUP BY file_managed.fid