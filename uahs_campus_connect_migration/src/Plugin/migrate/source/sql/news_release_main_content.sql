SELECT
	n.nid AS nid,
	fdfe2.field_experts_value AS field_experts,
	fdfc.field_contact_value AS field_contact,
	fdfepkl.field_electronic_press_kit_link_url AS field_electronic_press_kit_link,
	GROUP_CONCAT(fdfrns.field_related_news_stories_title) AS field_related_news_stories_title,
	GROUP_CONCAT(fdfrns.field_related_news_stories_url) AS field_related_news_stories_url

FROM node AS n

LEFT JOIN field_data_field_experts AS fdfe2 ON n.nid = fdfe2.entity_id
LEFT JOIN field_data_field_contact AS fdfc ON n.nid = fdfc.entity_id
LEFT JOIN field_data_field_electronic_press_kit_link AS fdfepkl ON n.nid = fdfepkl.entity_id
LEFT JOIN field_data_field_related_news_stories AS fdfrns ON n.nid = fdfrns.entity_id

WHERE
	n.type = 'news_release'
	AND n.status = 1

GROUP BY n.nid