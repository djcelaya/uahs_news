SELECT
	entity_id,
	field_contact_value

FROM field_data_field_contact AS fc

WHERE
	fc.bundle = 'tih_news_import'
--	AND entity_id = 8989

ORDER BY fc.entity_id DESC;