-- This should run against uahs_news

SELECT
	n.nid AS nid,
	n.vid AS vid,
	nfd.title,
	nfamc.*

FROM node AS n

LEFT JOIN node_field_data AS nfd ON nfd.nid = n.nid
LEFT JOIN node__field_az_published AS nfap ON nfap.entity_id = n.nid
LEFT JOIN node__field_az_news_tags AS nfant ON nfant.entity_id = n.nid
LEFT JOIN node__field_az_main_content AS nfamc ON nfamc.entity_id = n.nid

WHERE
	n.type = 'az_news'
	AND nfant.field_az_news_tags_target_id = 188
-- 	AND n.nid = 723

ORDER BY
	nfap.field_az_published_value DESC;