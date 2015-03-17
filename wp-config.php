<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'alliv_mamp');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
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
define('AUTH_KEY',         'guM8+Y-A~p+{H!a{X^?q,b0 K[`=$FCUpviyqB^WC(;>-l[8USjtrK6!{B4{k|bs');
define('SECURE_AUTH_KEY',  'J(cwwSQ2=b~Pm-:b.@T,!=xF-je|7EtWi#GzqTNH/dP,JK(#8+tA Z6zSY?#!m{T');
define('LOGGED_IN_KEY',    '5Nbyc0PsrJBIX~b=Jt$3u,x=`:+(B=}3#zx%c$BsWX@Na2zX:2bF.Ti[yV|? BNA');
define('NONCE_KEY',        'Vjh?J@P-To@S1W#)aG;}CV9gB)P9r2w@Z7Eb}+14K`[7qFr}1iG+4!Pr=SWSV WM');
define('AUTH_SALT',        'H^6|oiMJ=_TIf f+li5@H?hG`FD-B LMn._|sl!6v3W&P}E84yZ{;y:$MV?E& /v');
define('SECURE_AUTH_SALT', 'jC+c0>lc{`w6,b,-ZI*{voK+B-YL,pj8f^Nb<S5.}?E+H7;aCq8m^BxEr2rYi%zY');
define('LOGGED_IN_SALT',   'p0}Xs;[E`s>0iU9&HoV+.{8:8ZpH+/k=,@azJ0u+ ]:Mgh*R.rKd>_!6]%vta(|$');
define('NONCE_SALT',       '|hvQF>sPLe,$eJ-@/7mIG`Ls#j#N*a%XNWm`Gy{[ro~cU93/jR(P|Ks/Bp|Yv*6B');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
