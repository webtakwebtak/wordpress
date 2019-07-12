<?php

$dotenv = Dotenv\Dotenv::create(dirname(__DIR__));
$dotenv->load();

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', $_ENV['DB_NAME']);

/** MySQL database username */
define( 'DB_USER', $_ENV['DB_USER'] );

/** MySQL database password */
define( 'DB_PASSWORD', $_ENV['DB_PASSWORD'] );

/** MySQL hostname */
define( 'DB_HOST', $_ENV['DB_HOST'] );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', $_ENV['DB_CHARSET'] );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE',$_ENV['DB_COLLATE']);

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         $_ENV['AUTH_KEY'] );
define( 'SECURE_AUTH_KEY',  $_ENV['SECURE_AUTH_KEY'] );
define( 'LOGGED_IN_KEY',    $_ENV['LOGGED_IN_KEY'] );
define( 'NONCE_KEY',        $_ENV['NONCE_KEY'] );
define( 'AUTH_SALT',        $_ENV['AUTH_SALT'] );
define( 'SECURE_AUTH_SALT', $_ENV['SECURE_AUTH_SALT'] );
define( 'LOGGED_IN_SALT',   $_ENV['LOGGED_IN_SALT'] );
define( 'NONCE_SALT',       $_ENV['NONCE_SALT'] );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = $_ENV['DB_PREFIX'];


/**
 * Debugging Settings
 */
define( 'WP_DEBUG', false );
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', false);
ini_set('display_errors', 0);

/**
 * Custom settings
 *
 */
define('AUTOMATIC_UPDATER_DISABLED', true);
define('DISABLE_WP_CRON', true);
define('DISALLOW_FILE_EDIT', true);
define('DISALLOW_FILE_MODS', true);

/**
 * Custom folders
 *
 */
define( 'WP_SITEURL',       $_ENV['WP_SITEURL'] );
define( 'WP_HOME',          $_ENV['WP_HOME'] );
define( 'WP_CONTENT_DIR',  dirname(ABSPATH).'/app' );
define( 'WP_CONTENT_URL',  $_ENV['WP_HOME'] .'/app' );

/**
 * Additional application variables
 *
 */
switch ($_ENV['WP_ENV']) {
    case "production":
        require_once 'environments/production.php';
        break;
    case "staging":
        require_once 'environments/staging.php';
        break;
    case "development":
        require_once 'environments/development.php';
        break;
}

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
