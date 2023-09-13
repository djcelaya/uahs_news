SELECT
	n.nid AS nid,
	fm.filename AS image_tease_filename,
	fm.uri AS image_tease_uri,
	fdfit.field_image_tease_alt AS image_tease_alt,
	fdfit.field_image_tease_title AS image_tease_title

FROM node AS n

LEFT JOIN field_data_field_image_tease AS fdfit ON fdfit.entity_id = n.nid
LEFT JOIN file_managed AS fm ON fm.fid = fdfit.field_image_tease_fid

WHERE
	n.type = 'honors_and_awards'
	AND n.status = 1