USE pantheon;

SELECT t.*

FROM taxonomy_term_data AS t

JOIN taxonomy_vocabulary AS v ON v.vid = t.vid

WHERE
	v.name = 'Healthy Dose Blog Tags'