SELECT
	pifd.id,
	pifd.revision_id,
	pifd.type,
	pifd.parent_id,
	pifd.parent_type,
	pifd.parent_field_name,
	GROUP_CONCAT(pfap.field_az_photos_target_id)

FROM paragraphs_item_field_data AS pifd

LEFT JOIN paragraph__field_az_photos AS pfap ON pfap.entity_id = pifd.id

WHERE
	pifd.type = 'az_photo_gallery'

GROUP BY pifd.id