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
/** The name of the database for WordPress */
define( 'DB_NAME', 'rescribe_blog' );

/** MySQL database username */
define( 'DB_USER', 'rescribe_blog' );

/** MySQL database password */
define( 'DB_PASSWORD', '1Ik1ulnCOK0qape9' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'f5,c%kO$=TZJwqNeSRvMtLcdhFIw6ir(9zcB)Fi4:l2.}<a:ly:VYHq(^#7I~at,' );
define( 'SECURE_AUTH_KEY',  'ah=X+s:jpQa|$&i`V|^M)(0Zv?ksGvc`lY!{Tf1k7Pn+ ik,lvItd9v&^Wvr-P5C' );
define( 'LOGGED_IN_KEY',    ',jY+{tzwA5s+B(e73mj@A3nQqQk!e_jB)Fd1WUd8.#G!?lV?FNC`$_A3Q 6YDkQN' );
define( 'NONCE_KEY',        '9ZY3?iCQo9jC5TNPTz|_P<j82HHJ;Y)VZnJwrKyR:5Q!H@6t]S)qbF2iBcF}&N<U' );
define( 'AUTH_SALT',        '-A*1osIX~;#Yw2}PPA[mxpg|$|/h|7P=/k}Ah[{vo6|`EO?U6gh#7y5-EKg~l`o*' );
define( 'SECURE_AUTH_SALT', 'vJ[ |~+j.cNk-476OC,^&~ChQuwT*^g{:Qf*aME$J=EydGr]^dwbXF,aMjf4Vl%,' );
define( 'LOGGED_IN_SALT',   '/G(6P_+6W4{P^oT(`B:SdP*}~v``>b]L2nlmOZ8c#M[wQ[7z]W)#xa3859 X+uq>' );
define( 'NONCE_SALT',       '.2*zASlq{68D-kPj5pLt$:L95w~z+Tykr?f0*.?+BC0kCWuR_Tu;I]J!:!H/zAX+' );

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

