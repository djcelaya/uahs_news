# UAHS Campus Connect Migrations

Useful commands
- drush migrate:status
- drush migrate:import migration
- drush migrate:import --all
- drush migrate:rollback migration
- drush migrate:reset migration
- drush migrate:import --execute-dependencies

**Remember** to precede drush commands with `lando` when using in a local environment.