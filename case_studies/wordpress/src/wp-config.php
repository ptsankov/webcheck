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
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'asdLweMC0');

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
define('AUTH_KEY',         'HU70#8>l7f#$Fm0C:,$_@;[;u(~l)<[^(++Jo?GEhuu&#}r,o&0{%zJM91-c/qsD');
define('SECURE_AUTH_KEY',  '~Iz!iv#YnZ[dORPM-.rLV<5E9Q5qD1U|TD?<=Go+A+aE#-C`{;z9d_i%l3wiZ=zl');
define('LOGGED_IN_KEY',    'QCM0n[0[53w|]bXLqD~RjRB^,&,mG6nq]Zm>h{V;`^z<7]-~s0#N{(+FS|H,S!=l');
define('NONCE_KEY',        ']T6n(aUt6J<c`em%peMF+k}!Yze|&W>|@#j9=pLW9mgQ<bE_M+>b)s#*6c#ndv:@');
define('AUTH_SALT',        'O-^)#x[c]l0b<,lWgR+9UBeI>*~@H+^EgedD zYss>L2utHc3|k-B]J-9s=LcSLm');
define('SECURE_AUTH_SALT', 'D zee{_!KW`mOH /.9u@M:cZ9YjACJR!pH8+F!L&H,8(AR~J6C#Z*+<w#5d>ypaS');
define('LOGGED_IN_SALT',   '012c,2Y|UI>G+wgmM:GQxiI{ (/tzt@cz| F%D?}#YY+Ogez/=uT|)NeMO[L*}j<');
define('NONCE_SALT',       '<Jq|/Ax-jZ.]YlgVy32io+ifP,hsuR9IyfgylCc@CE`KI3{p;K.r=;,mZ5ZG`eit');

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
