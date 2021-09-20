<?php
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


define('DB_NAME',     $_ENV['DB_NAME']);
define('DB_USER',     $_ENV['DB_USER']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
define('DB_HOST',     $_ENV['DB_HOST']);
define('WP_HOME',     $_ENV['WP_HOME']);
define('WP_SITEURL',  $_ENV['WP_HOME']);
define('WP_DEBUG',    (int)$_ENV['WP_DEBUG']);

define('DB_CHARSET',  $_ENV['DB_CHARSET']);
define('DB_COLLATE',  $_ENV['DB_COLLATE']);
define('FS_METHOD',   $_ENV['FS_METHOD']);
define('ENV',         $_ENV['ENV']);
define('WP_CACHE',    (bool)$_ENV['WP_CACHE']);
define('WPCACHEHOME', $_ENV['WPCACHEHOME']);
define('WP_TEMP_DIR', $_ENV['WP_TEMP_DIR']);
$table_prefix =       $_ENV['TABLE_PREFIX'];


define('AUTH_KEY',         ':&S*M~t29ocay2i<ERGXM0iwPG+X9-b(LSn$x896}+;2-bjxtqO~4-&i$_@Ddu=n');
define('SECURE_AUTH_KEY',  '>[x5!hBiFAl]RzDc#ka|I;zy,g|=$lOHh9}K{_cN(/WJ6 iudg}Oz2Pgw#lsaLk-');
define('LOGGED_IN_KEY',    '>&-Q1EFkS+j&6F+/jaK^hiA;i2k59)Uu-rw(py6->6(c(~9H=Z,E-JncJMKGO}V~');
define('NONCE_KEY',        '|47QMUm~XRHLpO#5sL>.]{&uCi:okwxGBBRULkOVWL6DlT2@V8yt$_&B=sG/<Z-N');
define('AUTH_SALT',        '|KcyeH8oDUf%$%S}b8X-gFNZR$<--[C5t-R}}69)izpQ+plw-|?Nt[-=Z>DB5x4k');
define('SECURE_AUTH_SALT', '6~RFs;/<RoIS=&AeBeDY?b~smz_vBji|e?s4*=@EcON%(Jq0zRP|4+q]ur0:]<^q');
define('LOGGED_IN_SALT',   'LTD^`lL be+l:2f&3&2kEv|w0TRsh1*Z]*SPv;EffW.Xio.g4*]U&tF?|#`;/->@');
define('NONCE_SALT',       '^/kgxPGVn>TIh!NW|!8]`q-nOwc7.AraCf}4mLgcmmPNZ&p+)?sh%~VR,,{07~:9');

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
