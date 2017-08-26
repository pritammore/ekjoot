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
define('DB_NAME', 'ekjoot_prod');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'sclass@123');

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
define('AUTH_KEY',         ',-B$E>;,+]l#BlwJytaUU8a,.<U%O6f@d8MzY!IhVE~^#@qa08dzsBWtUIS!5g-g');
define('SECURE_AUTH_KEY',  'p,/5uSVw1qv)q2SO#n*0a)=QNRw3?i!}fa-%~fhVp3L6Ek5=7N`tIMq.[G#~8(>o');
define('LOGGED_IN_KEY',    's<Q{/<]L|?eTdu5P*&CH.82/qSIRL!<(IDZ rkN[}0kagoSdeRI@}lI61@)l[T/V');
define('NONCE_KEY',        'U[alv~neYIUz72xZIE%JOqzgI:O5TWlzT->72_f.}AFC.kwiZ|yhx A}I=r[9+7,');
define('AUTH_SALT',        'I.QWU} C9I3:aX6#oXSooI2q`Z&:v4k6XpH7n:uWagsWr:&:U,/Igv/=(4a,}2iC');
define('SECURE_AUTH_SALT', 'jP:p:IgQlr(;aEXx3pww_pdV?/YIF*kl#r2El_t]`Gv,R+;Nn,GB+luM:;E+3i`,');
define('LOGGED_IN_SALT',   '1r~^2;0>/dgojL6R*2}LW0-5JGMnufoLQ;H6jPj9:Me5LO|iMLg&PJIB~*s;#zd|');
define('NONCE_SALT',       'T(3bA,oP{j*(ZBt:-Zrnz4Z:{V2&gT@a6eg3$!!]uI$ffS9~|{~|rNFzl4,o9zjv');

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
