SELECT
	n.nid AS nid,
	n.title AS title,
	n.created AS created,
	fdfyvi.field_youtube_video_id_value AS youtube_video_id

FROM node AS n

LEFT JOIN field_data_field_youtube_video_id AS fdfyvi ON fdfyvi.entity_id = n.nid

WHERE
	n.type = 'newsstory'
	AND n.status = 1
	AND fdfyvi.field_youtube_video_id_value IS NOT NULL

ORDER BY n.created DESC;