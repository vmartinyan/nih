<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
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


// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
/* define('DB_NAME', 'u858866342_equby'); */
define('DB_NAME', 'nih');

/** MySQL database username */
/* define('DB_USER', 'u858866342_uqege'); */
define('DB_USER', 'root');

/** MySQL database password */
/* define('DB_PASSWORD', 'ASDqwe123'); */
define('DB_PASSWORD', '');

/** MySQL hostname */
/* define('DB_HOST', 'mysql.hostinger.ru'); */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'PgMlFDRat1S9Tm3pwo16F9XBml62MQRjFNlTCTB1rX3YcxYIRwnB3zWvZT4IdZo0');
define('SECURE_AUTH_KEY',  'Q3LWt3wlBybin1mqQt0MGHS7agMsOEHMIgU1YyMqV3dsrlFOWHK3D0m7PlbjHnYr');
define('LOGGED_IN_KEY',    '6DTAimEkBxF4OSzfcvUrbmB5Lg750XMAd3pgxttkbS9cw6fyP6EwS9SEMehiQwCe');
define('NONCE_KEY',        'NxbWzBzsWcR9T9q9Zg9dMqZeRBsVM2zMDyN5f3dYunJA2FS4nHCN6HNtYFevKvQp');
define('AUTH_SALT',        'v2XdfOwTjlOnb6kNRfolXTdk5zqGRbZ1mGnPtk2HfbX7bNu0j5EzxXmAFBqlyXf4');
define('SECURE_AUTH_SALT', 'nTcy7B7X4vh6q7ezPZmmJklFJXWTvrlYESCCvwjis9i3IVkveQeHfRmXER6kPEfB');
define('LOGGED_IN_SALT',   'IJRRyMhVvy1fOTRUswdaGW3K09m3lB6l7XMi9dGQPQNchTNJeRCug9WqsoNNknWv');
define('NONCE_SALT',       'bIM8eTxKNRrElvA0kvjh9ePLgzK033TU1rSwJofM639Y0nmRZHuYz4ih91oB6FgD');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed upstream.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 't4ha_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
