SELECT
	t.tid,
	t.vid,
	t.name,
	t.description,
	t.format,
	t.weight

FROM taxonomy_term_data AS t

WHERE
	t.vid = 23
--	AND tid != 268 -- exclude "Newsroom"
--	AND tid != 270 -- exclude "Tomorrow is here"
	AND tid != 271 -- exclude "Strategic Initiatives"