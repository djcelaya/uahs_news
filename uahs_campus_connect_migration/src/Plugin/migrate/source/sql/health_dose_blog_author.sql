SELECT
	n.nid AS health_dose_blog_nid,
	fdfhba.field_hs_blog_author_target_id AS health_dose_blog_author_nid,
	n.title AS health_dose_blog_title,
--	fdtf.title_field_value AS title_field,
	n2.title AS health_dose_blog_author_title,
	fdb.body_value AS body
	

FROM node AS n

LEFT JOIN field_data_field_hs_blog_author AS fdfhba ON fdfhba.entity_id = n.nid
LEFT JOIN field_data_title_field AS fdtf ON fdtf.entity_id = fdfhba.field_hs_blog_author_target_id
LEFT JOIN node AS n2 ON n2.nid = fdfhba.field_hs_blog_author_target_id
LEFT JOIN field_data_body AS fdb ON fdb.entity_id = fdfhba.field_hs_blog_author_target_id

WHERE
	n.type = 'health_dose_blog'
	AND n.status = 1
	
ORDER BY health_dose_blog_nid