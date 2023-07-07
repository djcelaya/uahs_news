<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * This process plugin attempts to extract a contact phone number from a HTML blob.
 * 
 * @MigrateProcessPlugin(id = "parse_contact_phone")
 */
class ParseContactPhone extends ProcessPluginBase {
    public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
        if (preg_match('/\d{3}-\d{3}-\d{4}/', $value, $matches)) {
            return $matches[0];
        }
        return '520-626-1197';
    }
}