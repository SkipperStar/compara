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
define('DB_NAME', 'compare_express');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'xbiasnyypn9rqo9jvln07wz6hlbmkqlujgawvb9hdugbfvcna64sfrfjgkfnaffx');
define('SECURE_AUTH_KEY',  'b0smwxqtkp0qzvoqvuesfd1msqhyj3fypdt1bjgdmeb6vjmozgc8lndv8kb5r7vr');
define('LOGGED_IN_KEY',    '1vbilvjymimn8wghxi1byfr07a2zqpxsor53jaqc593toa3sk4dr24dahfvxv6wi');
define('NONCE_KEY',        'vvabojjsjvh2q0cek1cogxslsrriekidtjpfhnxnnmeupgdb2qetqyzmreieu9ci');
define('AUTH_SALT',        's7ogamj93qmt5jk0wpagupyatnpmomccokicnucvmgt9xcf9mvtz03xcuxatqsg4');
define('SECURE_AUTH_SALT', 'rdx6lsglhc8zmyhu5at7xeq0dzbzqujrg7er7y1hwzdnfpq6eo4vnyuf7hyryqdn');
define('LOGGED_IN_SALT',   'vbrbktphqba4d632xr8mncvsmscsqfsq9lf8cquzyphh6pkjhjjkgm8kwuhhjoaj');
define('NONCE_SALT',       'peehazogexfpuign4tnvzz9u6isdusm4cj9zlwti3s2ma2nlpxcvqmhuon3rebfy');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpqe_';

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
