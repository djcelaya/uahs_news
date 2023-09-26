SELECT
	n.nid AS nid,
	n.title AS title,
	fdfpd.field_post_date_value AS field_post_date,
	fdfrd.field_release_date_value AS field_release_date,
	fm1.uri AS field_image_tease,
	fdb.body_value AS body,
	GROUP_CONCAT(fm2.uri) AS field_image,
	GROUP_CONCAT(DISTINCT ttd1.name) AS field_promote_this_content_to,
	GROUP_CONCAT(DISTINCT ttd2.name) AS field_affiliation,
	GROUP_CONCAT(DISTINCT ttd3.name) AS field_portal_category,
	GROUP_CONCAT(DISTINCT ttd4.name) AS field_downstream_sites

FROM node AS n

LEFT JOIN field_data_field_post_date AS fdfpd ON fdfpd.entity_id = n.nid
LEFT JOIN field_data_field_release_date AS fdfrd ON fdfrd.entity_id = n.nid

LEFT JOIN field_data_field_image_tease AS fdfit ON fdfit.entity_id = n.nid
LEFT JOIN file_managed AS fm1 ON fm1.fid = fdfit.field_image_tease_fid

LEFT JOIN field_data_body AS fdb ON fdb.entity_id = n.nid

LEFT JOIN field_data_field_image AS fdfi ON fdfi.entity_id = n.nid
LEFT JOIN file_managed AS fm2 ON fm2.fid = fdfi.field_image_fid

LEFT JOIN field_data_field_promote_this_content_to AS fdfptct ON fdfptct.entity_id = n.nid
LEFT JOIN taxonomy_term_data AS ttd1 ON ttd1.tid = fdfptct.field_promote_this_content_to_tid

LEFT JOIN field_data_field_affiliation AS fdfa ON fdfa.entity_id = n.nid
LEFT JOIN taxonomy_term_data AS ttd2 ON ttd2.tid = fdfa.field_affiliation_tid

LEFT JOIN field_data_field_portal_category AS fdfpc ON fdfpc.entity_id = n.nid
LEFT JOIN taxonomy_term_data AS ttd3 ON (
	ttd3.tid = fdfpc.field_portal_category_tid
	AND fdfpc.field_portal_category_tid != 318
)

LEFT JOIN field_data_field_downstream_sites AS fdfds ON fdfds.entity_id = n.nid
LEFT JOIN taxonomy_term_data AS ttd4 ON ttd4.tid = fdfds.field_downstream_sites_tid

WHERE
	n.type = 'honors_and_awards'
	AND n.status = 1

GROUP BY n.nid