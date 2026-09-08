<?php
define( 'WP_CACHE', true ); // Added by WP Rocket

/**
 * The base configuration for WordPress
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

/* DotEnv */
define('DIR_VENDOR', __DIR__.'/vendor/');
require_once DIR_VENDOR . 'autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

define('DISABLE_WP_CRON', TRUE);

define('DB_NAME',     $_ENV['DB_NAME']);
define('DB_USER',     $_ENV['DB_USER']);
define('DB_PASSWORD',     $_ENV['DB_PASSWORD']);
define('DB_HOST',     $_ENV['DB_HOST']);
define('WP_HOME',     $_ENV['WP_HOME']);
define('WP_SITEURL',  $_ENV['WP_HOME']);
define('WP_DEBUG',    (int)$_ENV['WP_DEBUG']);
define('WP_DEBUG_DISPLAY', false);
ini_set('display_errors', 0);

define('DB_CHARSET',  $_ENV['DB_CHARSET']);
define('DB_COLLATE',  $_ENV['DB_COLLATE']);
define('FS_METHOD',   $_ENV['FS_METHOD']);
define('ENV',         $_ENV['ENV']);
define( 'WPCACHEHOME', '/opt/bitnami/apps/DiggityJr.com/wp-content/plugins/wp-super-cache/' );
define('WP_TEMP_DIR', $_ENV['WP_TEMP_DIR']);
$table_prefix =       $_ENV['TABLE_PREFIX'];


define('AUTH_KEY', $_ENV['AUTH_KEY']);
define('SECURE_AUTH_KEY', $_ENV['SECURE_AUTH_KEY']);
define('LOGGED_IN_KEY', $_ENV['LOGGED_IN_KEY']);
define('NONCE_KEY', $_ENV['NONCE_KEY']);
define('AUTH_SALT', $_ENV['AUTH_SALT']);
define('SECURE_AUTH_SALT', $_ENV['SECURE_AUTH_SALT']);
define('LOGGED_IN_SALT', $_ENV['LOGGED_IN_SALT']);
define('NONCE_SALT', $_ENV['NONCE_SALT']);

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
define( 'DISALLOW_FILE_EDIT', true );
define( 'DISALLOW_FILE_MODS', true );
define( 'AUTOMATIC_UPDATER_DISABLED', true );
require_once ABSPATH . 'wp-settings.php';
