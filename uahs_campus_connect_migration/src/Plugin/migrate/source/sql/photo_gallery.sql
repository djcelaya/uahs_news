SELECT
	n.nid AS nid,
	n.title AS title,
	fdfch.field_card_headline_value AS field_card_headline,
	fm1.uri AS field_card_image,
	fdft.field_teaser_value AS field_teaser,
	fdfpd.field_post_date_value AS field_post_date,
	fdb.body_value AS body,
	fm2.uri AS field_cover_image,
	fdfci2.field_cover_image_alt AS field_cover_image_alt,
	fdfci2.field_cover_image_title AS field_cover_image_title,
	fdfcic.field_cover_image_caption_value AS field_cover_image_caption,
	GROUP_CONCAT(DISTINCT ttd1.name) AS field_promote_this_content_to,
	GROUP_CONCAT(DISTINCT ttd2.name) AS field_health_sciences_category_2,
	GROUP_CONCAT(DISTINCT ttd3.name) AS field_portal_category,
	GROUP_CONCAT(DISTINCT ttd4.name) AS field_affiliation,
	GROUP_CONCAT(DISTINCT ttd5.name) AS field_strategic_theme,
	GROUP_CONCAT(DISTINCT ttd6.name) AS field_health_sciences_centers,
	GROUP_CONCAT(DISTINCT ttd7.name) AS field_downstream_sites

FROM node AS n

LEFT JOIN field_data_field_card_headline AS fdfch ON fdfch.entity_id = n.nid

LEFT JOIN field_data_field_card_image AS fdfci ON fdfci.entity_id = n.nid
LEFT JOIN file_managed AS fm1 ON fm1.fid = fdfci.field_card_image_fid

LEFT JOIN field_data_field_teaser AS fdft ON fdft.entity_id = n.nid

LEFT JOIN field_data_field_post_date AS fdfpd ON fdfpd.entity_id = n.nid

LEFT JOIN field_data_body AS fdb ON fdb.entity_id = n.nid

LEFT JOIN field_data_field_cover_image AS fdfci2 ON fdfci2.entity_id = n.nid
LEFT JOIN file_managed AS fm2 ON fm2.fid = fdfci2.field_cover_image_fid

LEFT JOIN field_data_field_cover_image_caption AS fdfcic ON fdfcic.entity_id = n.nid

LEFT JOIN field_data_field_promote_this_content_to AS fdfptct ON fdfptct.entity_id = n.nid
LEFT JOIN taxonomy_term_data AS ttd1 ON ttd1.tid = fdfptct.field_promote_this_content_to_tid

LEFT JOIN field_data_field_health_sciences_category_2 AS fdfhsc2 ON fdfhsc2.entity_id = n.nid
LEFT JOIN taxonomy_term_data AS ttd2 ON ttd2.tid = fdfhsc2.field_health_sciences_category_2_tid

LEFT JOIN field_data_field_portal_category AS fdfpc ON fdfpc.entity_id = n.nid
LEFT JOIN taxonomy_term_data AS ttd3 ON ttd3.tid = fdfpc.field_portal_category_tid

LEFT JOIN field_data_field_affiliation AS fdfa ON fdfa.entity_id = n.nid
LEFT JOIN taxonomy_term_data AS ttd4 ON ttd4.tid = fdfa.field_affiliation_tid

LEFT JOIN field_data_field_strategic_theme AS fdfst ON fdfst.entity_id = n.nid
LEFT JOIN taxonomy_term_data AS ttd5 ON ttd5.tid = fdfst.field_strategic_theme_tid

LEFT JOIN field_data_field_health_sciences_centers AS fdfhsc ON fdfhsc.entity_id = n.nid
LEFT JOIN taxonomy_term_data AS ttd6 ON ttd6.tid = fdfhsc.field_health_sciences_centers_tid

LEFT JOIN field_data_field_downstream_sites AS fdfds ON fdfds.entity_id = n.nid
LEFT JOIN taxonomy_term_data AS ttd7 ON ttd7.tid = fdfds.field_downstream_sites_tid

WHERE
	n.type = 'photo_gallery'
	AND n.status = 1

GROUP BY n.nid

ORDER BY field_post_date_value DESC;