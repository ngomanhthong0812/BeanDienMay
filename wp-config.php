<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'db_bean');

/** Database username */
define('DB_USER', 'root');

/** Database password */
define('DB_PASSWORD', '');

/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'K8=pWeB_&t>tfa1J%C}`.hKWbXE8BfX&(Y<_0F/*&$YZy5BHPRw!L->b{}4Z/c~O');
define('SECURE_AUTH_KEY',  'VU2ya3L)mlQNxFLP*Zh[IO[):&_~ Y5c0exqX/:bthgBc_NBK.xCT}z+!>G%R{#5');
define('LOGGED_IN_KEY',    '$Rw;Tj$> $C^gm&F/9M*4oGB/@U^g,iZ=gS4Fv]+>=hwmD8Fcq,yi*He,KjA3s7l');
define('NONCE_KEY',        'oJRiLF-N$cKY<vYxqp;L37W~+s-l}f(5};QBc)fY[tXwH(ia&MYD!}&:(G{#;UY+');
define('AUTH_SALT',        'kjdaT@_{jJ7x@=:dnm|of7{f~L,Y%/gmmKB<Q->4mDS%f)Dz(CiNGcb8kVV]gi)|');
define('SECURE_AUTH_SALT', '0}i(oIDU@PqsUj8La/7]KrI=y(_-Fx3PhHMe]f<w=Ji5(8 UmhzW?**)Jbc&%T)}');
define('LOGGED_IN_SALT',   'ND}*XrN^mnMWpgr-kA~a1tX0;7m-wd7.loq9,eCY5N#cddVh m;X!BC1IBp=VWnb');
define('NONCE_SALT',       'T4EDY$u#LtyePf6~~2a0f%dJ+^!LbA;3z1<BZ~K<6[]e#v/:}IoHznSs(td{P}mg');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define('WP_DEBUG', false);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (! defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
