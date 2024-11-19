<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'webavene_webave' );

/** Database username */
define( 'DB_USER', 'webavene_webave' );

/** Database password */
define( 'DB_PASSWORD', '8(SMc]p459' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',         '8m5qgqhticjgxpfzmk11nybbsfhbltwrftk2yaxenrnevymuinnvmsed6wu3atbe' );
define( 'SECURE_AUTH_KEY',  'x4lxrkutgiymiizsibgsclwutl4mzmtpmzlx9zonqypsdkei4uh9geyqepxibev1' );
define( 'LOGGED_IN_KEY',    'as1eraotseoxgon1tzfwlha4mnlx6hkztxvap4e5zthwgk42yhtsq3fxdzk9n9z8' );
define( 'NONCE_KEY',        'ijiprtxxlgzjyrplx1faha0jkybpchptm4ub7mkzhtupu0fk2xoxxcqe1keytvuc' );
define( 'AUTH_SALT',        'ro65kpno5zurwflyygjrssytszpy5sgfpdcjrfdqauga0juevc7guedzggslhqwp' );
define( 'SECURE_AUTH_SALT', 'jh1jzrom52pviryeu1yedlkenfeptxdfomlkuaiekubupb2qbofmwjcjitr9zsxn' );
define( 'LOGGED_IN_SALT',   'rcwmplzt5qucxj6ie6lvyvfitvbji8trp5my8lyidlsq7tephrltbha0aoywuqoz' );
define( 'NONCE_SALT',       'vyftd0ayndqq3okn8u9w4qnnrmskszewow4yumlasxyd3a09sybycpa5bza8szso' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wads_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
