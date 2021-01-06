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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
if (file_exists(dirname(__FILE__). '/local.php')) {
	// Local mysql settings
	define('DB_NAME', 'fictional-university');
	define('DB_USER', 'homestead');
	define('DB_PASSWORD', 'secret');
	define('DB_HOST', 'localhost');
} else {
	// Live mysql settings
	define('DB_NAME', 'dbju0nxqt9kqxq');
	define('DB_USER', 'uvkymufvcjmyk');
	define('DB_PASSWORD', '3%e3#2d#+q{;');
	define('DB_HOST', 'localhost');
}

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'O}[1,j`~*22;Z(K2#MHxw%A| wn z|}SW3n%!.[Cxw/aQ(={_Phel+#$`g^SJK2e');
define('SECURE_AUTH_KEY',  'f}J3sIm[w6SSn4&A./-B?*~i{%=I5RA 4 I%ldc6BtPy2[n+m!K#c<gJ`:!vDS&J');
define('LOGGED_IN_KEY',    'jCpU2Qf_r2-V| wi2B10#BHb+hR+@Mj{e^tCN)eGl/dZ.^P98cVpC|)@]EdZr$5U');
define('NONCE_KEY',        'Gv1k /&Z%|D::)O8t&b@3)|.x}vM#S3<0/-?*&ijQnP&F0arJQz$8j(iz&x^e||4');
define('AUTH_SALT',        '*3+hN /7+$J1a#6sO%UR$Su17*BRGX6t-|]h/(5v,z<Pxv^Mubr8SwmC]5~Mel^8');
define('SECURE_AUTH_SALT', 'dZ>_pQh{rn4A0&0U#s>NM[YOYa{J<8.GJo5ODQ^*vO,IvWTq&X.ND?}rwU!-j?ht');
define('LOGGED_IN_SALT',   'ce?AjnQg!uPW%K;?|5mg9bav5_@{8_RZ6;`H-hWV{oB|VZZkm?r&<#XoP:*2Ohy(');
define('NONCE_SALT',       '2YcLX/e43ZzAc_#,~-bs0U?T$^r2FyLF>tv1az|=cyW&rI-62W-|6pIddy=S)Z,!');
/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
