SELECT
	fdfe.entity_id AS entity_id,
	fdfe.field_extras_value AS field_extras

FROM node AS n

LEFT JOIN field_data_field_extras AS fdfe ON n.nid = fdfe.entity_id
LEFT JOIN field_data_field_post_date AS fdfpd ON n.nid = fdfpd.entity_id

WHERE
--	n.type = 'tih_news_import'
	fdfe.entity_id IS NOT NULL
	AND n.status = 1

ORDER BY fdfpd.field_post_date_value DESC;