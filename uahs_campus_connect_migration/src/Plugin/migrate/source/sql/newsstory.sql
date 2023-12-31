SELECT
	node.nid AS nid,
	node.title AS title,
--	field_data_field_card_headline.field_card_headline_value AS field_card_headline,
	field_data_field_teaser.field_teaser_value AS field_teaser,
	file_managed.uri AS field_banner_image,
	fdfyvi.field_youtube_video_id_value AS field_youtube_video_id,
	fdfv.field_video_video_url AS vimeo_video_url,
	field_data_field_post_date.field_post_date_value AS field_post_date,
	field_data_body.body_value AS body,
	GROUP_CONCAT(DISTINCT taxonomy_health_sciences_category_2.name) AS field_health_sciences_category_2,
	taxonomy_portal_category.name AS portal_category,
	GROUP_CONCAT(DISTINCT taxonomy_affiliation.name) AS field_affiliation,
	GROUP_CONCAT(DISTINCT taxonomy_strategic_theme.name) AS field_strategic_theme,
	GROUP_CONCAT(DISTINCT taxonomy_centers.name) AS field_centers,
	GROUP_CONCAT(DISTINCT taxonomy_downstream_sites.name) AS field_downstream_sites,
	GROUP_CONCAT(DISTINCT taxonomy_promote_this_content_to.name) AS field_promote_this_content_to,
	fdfhc.field_highlight_content_value AS field_highlight_content
	
FROM node

-- JOIN field_data_field_card_headline ON field_data_field_card_headline.entity_id = node.nid
JOIN field_data_field_teaser ON field_data_field_teaser.entity_id = node.nid
JOIN field_data_field_post_date ON field_data_field_post_date.entity_id = node.nid
LEFT JOIN field_data_field_youtube_video_id AS fdfyvi ON fdfyvi.entity_id = node.nid
LEFT JOIN field_data_field_video AS fdfv ON fdfv.entity_id = node.nid
JOIN field_data_body ON field_data_body.entity_id = node.nid

LEFT JOIN field_data_field_health_sciences_category_2 ON field_data_field_health_sciences_category_2.entity_id = node.nid
LEFT JOIN taxonomy_term_data AS taxonomy_health_sciences_category_2 ON (
	taxonomy_health_sciences_category_2.tid = field_data_field_health_sciences_category_2.field_health_sciences_category_2_tid
	AND field_data_field_health_sciences_category_2.field_health_sciences_category_2_tid != 318
)

LEFT JOIN field_data_field_portal_category ON field_data_field_portal_category.entity_id = node.nid
LEFT JOIN taxonomy_term_data AS taxonomy_portal_category ON (
	taxonomy_portal_category.tid = field_data_field_portal_category.field_portal_category_tid
	AND field_data_field_portal_category.field_portal_category_tid != 318
)

LEFT JOIN field_data_field_affiliation ON field_data_field_affiliation.entity_id = node.nid
LEFT JOIN taxonomy_term_data AS taxonomy_affiliation ON taxonomy_affiliation.tid = field_data_field_affiliation.field_affiliation_tid

LEFT JOIN field_data_field_strategic_theme ON field_data_field_strategic_theme.entity_id = node.nid
LEFT JOIN taxonomy_term_data AS taxonomy_strategic_theme ON taxonomy_strategic_theme.tid = field_data_field_strategic_theme.field_strategic_theme_tid

LEFT JOIN field_data_field_health_sciences_centers ON field_data_field_health_sciences_centers.entity_id = node.nid
LEFT JOIN taxonomy_term_data AS taxonomy_centers ON taxonomy_centers.tid = field_data_field_health_sciences_centers.field_health_sciences_centers_tid

LEFT JOIN field_data_field_downstream_sites ON field_data_field_downstream_sites.entity_id = node.nid
LEFT JOIN taxonomy_term_data AS taxonomy_downstream_sites ON taxonomy_downstream_sites.tid = field_data_field_downstream_sites.field_downstream_sites_tid

LEFT JOIN field_data_field_promote_this_content_to ON field_data_field_promote_this_content_to.entity_id = node.nid
LEFT JOIN taxonomy_term_data AS taxonomy_promote_this_content_to ON taxonomy_promote_this_content_to.tid = field_data_field_promote_this_content_to.field_promote_this_content_to_tid

LEFT JOIN field_data_field_banner_image ON field_data_field_banner_image.entity_id = node.nid
LEFT JOIN file_managed ON file_managed.fid = field_data_field_banner_image.field_banner_image_fid

LEFT JOIN field_data_field_highlight_content AS fdfhc ON fdfhc.entity_id = node.nid

WHERE
	node.type = 'newsstory'
	AND node.status = 1
--	AND fdfyvi.field_youtube_video_id_value IS NOT NULL

GROUP BY node.nid

ORDER BY
	field_post_date DESC;