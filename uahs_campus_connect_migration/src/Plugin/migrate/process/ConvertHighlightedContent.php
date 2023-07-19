<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * This plugin converts <p class="highlightedContent"> tags into a Arizona Bootstrap
 * callout component.
 * 
 * @MigrateProcessPlugin(id = "convert_highlighted_content")
 */
class ConvertHighlightedContent extends ProcessPluginBase {

    public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
        return $value;
    }
}