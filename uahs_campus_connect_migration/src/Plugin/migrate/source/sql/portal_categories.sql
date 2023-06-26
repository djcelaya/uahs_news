SELECT
	t.tid,
	t.vid,
	t.name,
	t.description,
	t.format,
	t.weight

FROM taxonomy_term_data AS t

WHERE
	t.vid = 4