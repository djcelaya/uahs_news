SELECT
	n.nid,
	n.title,
	fm1.uri AS field_banner_image,
	fm2.uri AS field_card_image,
	fdfyvi.field_youtube_video_id_value AS field_youtube_video_id,
	ft.field_teaser_value AS field_teaser,
	fpd.field_post_date_value AS field_post_date,
	b.body_value AS body,
	fc.field_contact_value AS field_contact

FROM node AS n

LEFT JOIN field_data_field_teaser AS ft ON ft.entity_id = n.nid
JOIN field_data_field_post_date AS fpd ON fpd.entity_id = n.nid
LEFT JOIN field_data_body AS b ON b.entity_id = n.nid

LEFT JOIN field_data_field_banner_image AS fbi ON fbi.entity_id = n.nid
LEFT JOIN file_managed AS fm1 ON fm1.fid = fbi.field_banner_image_fid

LEFT JOIN field_data_field_card_image AS fci ON fci.entity_id = n.nid
LEFT JOIN file_managed AS fm2 ON fm2.fid = fci.field_card_image_fid

LEFT JOIN field_data_field_youtube_video_id AS fdfyvi ON fdfyvi.entity_id = n.nid

LEFT JOIN field_data_field_contact AS fc ON fc.entity_id = n.nid

WHERE
	n.type = 'tih_news_import'
	AND n.status = 1

GROUP BY n.nid

ORDER BY fpd.field_post_date_value DESC;