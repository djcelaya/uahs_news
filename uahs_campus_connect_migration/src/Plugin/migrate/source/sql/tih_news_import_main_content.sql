SELECT
	n.nid AS nid,
	fdfe1.field_extras_value AS field_extras,
	fdfe2.field_experts_value AS field_experts,
	fdfc.field_contact_value AS field_contact

FROM node AS n

LEFT JOIN field_data_field_extras AS fdfe1 ON n.nid = fdfe1.entity_id
LEFT JOIN field_data_field_experts AS fdfe2 ON n.nid = fdfe2.entity_id
LEFT JOIN field_data_field_contact AS fdfc ON n.nid = fdfc.entity_id

WHERE
	n.type = 'tih_news_import'
	AND n.status = 1

GROUP BY n.nid