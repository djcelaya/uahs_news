SELECT
	n.nid AS nid,
	n.title AS title,
	fdfch.field_card_headline_value AS field_card_headline,
	fm1.uri AS field_card_image

FROM node AS n

LEFT JOIN field_data_field_card_headline AS fdfch ON fdfch.entity_id = n.nid
LEFT JOIN field_data_field_card_image AS fdfci ON fdfci.entity_id = n.nid
LEFT JOIN file_managed AS fm1 ON fm1.fid = fdfci.field_card_image_fid

WHERE
	n.type = 'photo_gallery'
	AND n.status = 1

GROUP BY n.nid