<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * This plugin converts <img> tags to the corresponding Media embed tag for images.
 *
 * @MigrateProcessPlugin(
 *     id = "replace_img_tags"
 * )
 */
class ReplaceImgTags extends ProcessPluginBase {

    /**
     * { @inheritdoc }
     */
    public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
        // Do value transformation here ...
        $new_value = preg_replace_callback(
          "(<img[\w\W]+?>)",
          array($this, "replace_img_tag"),
          $value
        );
        return $new_value;
    }

    function replace_img_tag($matches) {
        $align = $this->get_alignment($matches[0]);
        $view_mode = $this->get_view_mode($matches[0]);
        $entity_uuid = $this->get_entity_uuid($matches[0]);
        return '<drupal-media ' . $align . ' data-entity-type="media" data-entity-uuid="' .
            $entity_uuid . '" data-view-mode="' . $view_mode . '"></drupal-media>';
    }

    /** Translates "data-picture-align" property to "data-align" property with values
     * left, right, center, or null.
     */
    function get_alignment($match): string {
        if (preg_match('/data-picture-align="([\w]*)"/', $match, $matches)) {
            return 'data-align="' . $matches[1] . '"';
        }
        return "";
    }

    /**
     * @param $match
     * @return string
     *
     * Translates source filename to destination UUID for use within the drupal-media tag.
     */
    function get_entity_uuid($match): string {
        if (preg_match('/src="[^"]*\/(.+\.(jpg|jpeg|png|gif))[^"]*"/', $match, $matches)) {
            $filename = $matches[1];
            $database = \Drupal::database();
            $query = $database->select('media', 'm');
            $query->addJoin('INNER', 'media_field_data', 'mfd', 'mfd.mid = m.mid');
            $query->condition('mfd.name', $filename, '=');
            $query->addField('m', 'uuid');
            $result = $query->execute();
            $record = $result->fetchAssoc();
//            echo $filename . '-> ' . $record['uuid'] . '\n';
            if ($record['uuid']) {
                return $record['uuid'];
            } else {
                print('FAILURE: ' . $filename . ' -> ' . $record['uuid'] . '\n');
                return '';
            }
            return $record['uuid'] ?? '';
        }
        return "";
    }

    /**
     * @param $match
     * @return string
     *
     * Translates the image size "class" property to "data-view-mode" property.
     * Mappings:
     * - "image-large_image" (Large Image) > "az_large" (Large)
     * - "image-medium_image" (Medium Image) > "az_medium" (Medium)
     * - "image-small_image" (Small Image) > "az_small" (Small)
     * - "image-very_small_image" (Very Small Image) > "az_square" (Square) ??????
     * - "" (Automatic) > "az_natural_size" (Natural)
     */
    function get_view_mode($match): string {
        if (preg_match('/class="image-([\w]+)_image[^"]*"/', $match, $matches)) {
            // temporary until we can add a "az_very_small" view mode
            if ($matches[1] == "very_small") {
                return "az_square";
            }
            return 'az_' . $matches[1];
        }
        return "az_natural_size";
    }
}