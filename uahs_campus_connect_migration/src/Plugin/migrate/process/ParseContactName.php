<?php

namespace Drupal\uahs_campus_connect_migration\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * This process plugin attempts to extract a contact name from a HTML blob.
 * 
 * @MigrateProcessPlugin(id = "parse_contact_name")
 */
class ParseContactName extends ProcessPluginBase {
    public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
        if (preg_match('/<p>(<strong>)?([^<]+)(<\/strong>)?<br>/', $value, $matches)) {
            return $matches[2];
        }
        return 'UAHS Communications';
    }
}