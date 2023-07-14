SELECT
	n.nid,
	n.title,
	frd.field_release_date_value AS field_release_date,
	flts.field_link_to_story_title AS field_link_to_story_title,
	flts.field_link_to_story_url AS field_link_to_story_url,
	b.body_value AS body

FROM node AS n

JOIN field_data_field_release_date AS frd ON frd.entity_id = n.nid
LEFT JOIN field_data_field_link_to_story AS flts ON flts.entity_id = n.nid
JOIN field_data_body AS b ON b.entity_id = n.nid

WHERE
	n.type = 'in_the_media'
	AND n.status = 1 

ORDER BY frd.field_release_date_value DESC;