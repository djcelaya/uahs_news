SELECT
	n.nid,
	n.title,
	fdfch.field_card_headline_value AS field_card_headline,
	ft.field_teaser_value AS field_teaser,
	fm.uri AS field_banner_image,
	fdfcic.field_cover_image_caption_value AS field_cover_image_caption,
	fdfyvi.field_youtube_video_id_value AS field_youtube_video_id,
	fdfv.field_video_video_url AS field_video,
	fpd.field_post_date_value AS field_post_date,
	fesl.field_external_story_link_url AS field_external_story_link_url,
	fesl.field_external_story_link_title AS field_external_story_link_title,
	b.body_value AS body,
	GROUP_CONCAT(DISTINCT fm2.uri) AS field_image,
	GROUP_CONCAT(DISTINCT fm3.uri) AS field_files,
	fdfrpg.field_related_photo_gallery_target_id AS field_related_photo_gallery,
	fdfrv.field_related_video_target_id AS field_related_video,
	fe.field_experts_value AS field_experts,
	fc.field_contact_value AS field_contact,
	fdfepkl.field_electronic_press_kit_link_title AS field_electronic_press_kit_link_title,
	fdfepkl.field_electronic_press_kit_link_url AS field_electronic_press_kit_link_url,
	fdfrns.field_related_news_stories_title AS field_related_news_stories_title,
	fdfrns.field_related_news_stories_url AS field_related_news_stories_url,
	fdfab.field_additional_boilerplates_value AS field_additional_boilerplates,
	fdfrvr.field_related_video_release_target_id AS field_related_video_release,
	GROUP_CONCAT(DISTINCT t_hsc2.name) AS field_health_sciences_category_2,
	t_pc.name AS portal_category,
	GROUP_CONCAT(DISTINCT t_a.name) AS field_affiliation,
	GROUP_CONCAT(DISTINCT t_st.name) AS field_strategic_theme,
	GROUP_CONCAT(DISTINCT t_hsc.name) AS field_centers,
	GROUP_CONCAT(DISTINCT t_ds.name) AS field_downstream_sites,
	GROUP_CONCAT(DISTINCT t_ptct.name) AS field_promote_this_content_to

FROM node AS n

LEFT JOIN field_data_field_card_headline AS fdfch ON fdfch.entity_id = n.nid
JOIN field_data_field_teaser AS ft ON ft.entity_id = n.nid

LEFT JOIN field_data_field_banner_image AS fbi ON fbi.entity_id = n.nid
LEFT JOIN file_managed AS fm ON fm.fid = fbi.field_banner_image_fid

LEFT JOIN field_data_field_cover_image_caption AS fdfcic ON fdfcic.entity_id = n.nid
LEFT JOIN field_data_field_youtube_video_id AS fdfyvi ON fdfyvi.entity_id = n.nid
LEFT JOIN field_data_field_video AS fdfv ON fdfv.entity_id = n.nid

JOIN field_data_field_post_date AS fpd ON fpd.entity_id = n.nid
LEFT JOIN field_data_field_external_story_link AS fesl ON fesl.entity_id = n.nid
LEFT JOIN field_data_body AS b ON b.entity_id = n.nid

LEFT JOIN field_data_field_image AS fi ON fi.entity_id = n.nid
LEFT JOIN file_managed AS fm2 ON fm2.fid = fi.field_image_fid

LEFT JOIN field_data_field_files AS ff ON ff.entity_id = n.nid
LEFT JOIN file_managed AS fm3 ON fm3.fid = ff.field_files_fid

LEFT JOIN field_data_field_related_photo_gallery AS fdfrpg ON fdfrpg.entity_id = n.nid
LEFT JOIN field_data_field_related_video AS fdfrv ON fdfrv.entity_id = n.nid
LEFT JOIN field_data_field_experts AS fe ON fe.entity_id = n.nid
LEFT JOIN field_data_field_contact AS fc ON fc.entity_id = n.nid
LEFT JOIN field_data_field_electronic_press_kit_link AS fdfepkl ON fdfepkl.entity_id = n.nid
LEFT JOIN field_data_field_related_news_stories AS fdfrns ON fdfrns.entity_id = n.nid
LEFT JOIN field_data_field_additional_boilerplates AS fdfab ON fdfab.entity_id = n.nid
LEFT JOIN field_data_field_related_video_release AS fdfrvr ON fdfrvr.entity_id = n.nid

LEFT JOIN field_data_field_health_sciences_category_2 AS fhsc2 ON fhsc2.entity_id = n.nid
LEFT JOIN taxonomy_term_data AS t_hsc2 ON t_hsc2.tid = fhsc2.field_health_sciences_category_2_tid

LEFT JOIN field_data_field_portal_category AS fpc ON fpc.entity_id = n.nid
LEFT JOIN taxonomy_term_data AS t_pc ON t_pc.tid = fpc.field_portal_category_tid

LEFT JOIN field_data_field_affiliation AS fa ON fa.entity_id = n.nid
LEFT JOIN taxonomy_term_data AS t_a ON t_a.tid = fa.field_affiliation_tid

LEFT JOIN field_data_field_strategic_theme AS fst ON fst.entity_id = n.nid
LEFT JOIN taxonomy_term_data AS t_st ON t_st.tid = fst.field_strategic_theme_tid

LEFT JOIN field_data_field_health_sciences_centers AS fhsc ON fhsc.entity_id = n.nid
LEFT JOIN taxonomy_term_data AS t_hsc ON t_hsc.tid = fhsc.field_health_sciences_centers_tid

LEFT JOIN field_data_field_downstream_sites AS fds ON fds.entity_id = n.nid
LEFT JOIN taxonomy_term_data AS t_ds ON t_ds.tid = fds.field_downstream_sites_tid

LEFT JOIN field_data_field_promote_this_content_to AS fptct ON fptct.entity_id = n.nid
LEFT JOIN taxonomy_term_data AS t_ptct ON t_ptct.tid = fptct.field_promote_this_content_to_tid

WHERE
	n.type = 'news_release'
	AND n.status = 1

GROUP BY n.nid

ORDER BY field_post_date DESC;