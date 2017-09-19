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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'word');

/** MySQL database password */
define('DB_PASSWORD', '123');

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
define('AUTH_KEY',         'q+~@ us*9omQzq!z+PQ/MGQ8*M]Kg~Fc#!]>6lzrv>-T Un(m47m4N&KSDT66L5V');
define('SECURE_AUTH_KEY',  '{TF[Tx%P_)JN7WxNXxvjsniVD0zczsj=+?H;^|heoi,-D]8+-+/$I<jfI:CYBj/E');
define('LOGGED_IN_KEY',    'wHfV8aw|Pb6GTzFLmXsEam-+j+26%R-G(%Q=a Z/|Kz6x)l5f,W]C_D6R5aTSKS(');
define('NONCE_KEY',        'm|oiJ1?9mjxdW|S{1b->b/q3|_$c:-x*H;#vebnVD;2yP8 ^nmz+;dJ>CF|.*iT~');
define('AUTH_SALT',        '{kx|L:?g;8-VGUh|R8!jSRw+JRk|S+~+L)t@D`iwIO]G}|P<*Gy,c~]53S0kHh^h');
define('SECURE_AUTH_SALT', '|Mh#W*gap<F*8BFAJ3(3 [&m>HMP|4+3w9vD&mNGC9XB-vdd-i:bevXE=RjLK*PP');
define('LOGGED_IN_SALT',   'x|-FsfC>(#*en)n[405AJu8=knam4tY,3fPOD&h Vw3(B+<Tvt`widPcS*~$AbTq');
define('NONCE_SALT',       'U-%E[3=C&k}^QVTOx6-`=kHHT%E(#Hw94Z7y!da@>A]_&|NMx]ypsN$`G|+3-B*K');

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
