SELECT
	n.nid AS nid,
	n.title AS title,
	n.uid,
	n.created AS created,
	n.changed AS changed,
	fdtf.title_field_value AS title_field,
	fdfch.field_card_headline_value AS card_headline,
	fdft.field_teaser_value AS teaser,
	fm.uri AS card_image,
--	fdfhba.field_hs_blog_author_target_id AS hs_blog_author_target_id,
	n2.title AS hs_blog_author,
	fdfpd.field_post_date_value AS post_date,
	fdfhbu.field_hs_blog_update_value AS hs_blog_update,
	fdb.body_value AS body,
	GROUP_CONCAT(DISTINCT ttd.name) AS health_and_wellness_topics,
	GROUP_CONCAT(DISTINCT ttd2.name) AS hs_blog_tags


FROM node AS n

LEFT JOIN field_data_title_field AS fdtf ON fdtf.entity_id = n.nid
LEFT JOIN field_data_field_card_headline AS fdfch ON fdfch.entity_id = n.nid
LEFT JOIN field_data_field_teaser AS fdft ON fdft.entity_id = n.nid
LEFT JOIN field_data_field_card_image AS fdfci ON fdfci.entity_id = n.nid
LEFT JOIN file_managed AS fm ON fm.fid = fdfci.field_card_image_fid
LEFT JOIN field_data_field_hs_blog_author AS fdfhba ON fdfhba.entity_id = n.nid
LEFT JOIN field_data_field_post_date AS fdfpd ON fdfpd.entity_id = n.nid
LEFT JOIN field_data_field_hs_blog_update AS fdfhbu ON fdfhbu.entity_id = n.nid
LEFT JOIN field_data_body AS fdb ON fdb.entity_id = n.nid
LEFT JOIN field_data_field_health_and_wellness_topics AS fdfhawt ON fdfhawt.entity_id = n.nid
LEFT JOIN taxonomy_term_data AS ttd ON ttd.tid = fdfhawt.field_health_and_wellness_topics_tid
LEFT JOIN field_data_field_hs_blog_tags AS fdfhbt ON fdfhbt.entity_id = n.nid
LEFT JOIN taxonomy_term_data AS ttd2 ON ttd2.tid = fdfhbt.field_hs_blog_tags_tid

-- LEFT JOIN field_data_field_hs_blog_author AS fdfhba ON fdfhba.entity_id = n.nid
LEFT JOIN node AS n2 ON n2.nid = fdfhba.field_hs_blog_author_target_id

WHERE
	n.type = 'health_dose_blog'
	AND n.status = 1

GROUP BY n.nid

ORDER BY n.nid DESC;