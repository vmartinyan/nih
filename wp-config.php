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
define('DB_NAME', 'nih');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'Temp1234');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'MNAZCiz|bz)k!X4q)k|~no$0}holNX,;mzd1,AwB<RTy!JM6369`d9xhFuFG5G1X');
define('SECURE_AUTH_KEY',  'v;y2T^qy>_,-#-`n[:-QXq>;ZVDs:[GD-Y_v& qbkW26_?G*GTKig+..{2^5BuE.');
define('LOGGED_IN_KEY',    'H)Kn#&Jl8`G|q63);?!h?SgOi/Nm8J[t^G[{2q5^A0v6U/JHYH[01`pk%lC{M5h-');
define('NONCE_KEY',        '])hp6H/kL5cakwLRfONzIiK89>E|SrV2pT| hX~4B~[wT}@}~R|!<*<-d!&R`Y!g');
define('AUTH_SALT',        '@:?~V;U9,t2wa)LZa7I=V1JH2NW?@Ur=1W!D2Ez,H4z;dv[duV{S>f^2-kyT>%_Z');
define('SECURE_AUTH_SALT', 'Aw,Z!l;KscfX9#*!b}zcjF3JM7d,X%~>.@Kwb&QT8.gt+3o9$?~37I0ua]o _)it');
define('LOGGED_IN_SALT',   ')3$x*^KX)zvRH8CIer&4$rV.N(}oH)C1pRgaT.rFzoEreHR(<qlfg6ILz+1MA4go');
define('NONCE_SALT',       'M0:!Z$zgeKzXxA~9#DWT02^l>Rw7g6ty~i-O;N+1i~=jd*26$=_QZWOF1?qn5Z(9');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
