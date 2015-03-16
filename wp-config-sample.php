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
define('AUTH_KEY',         '^Io=/Dt36Kzl_=E|`sUoMzV=qRNcuSoBw)L4jn+|)PDdxX]|zR9$yt6vlAgmjcCP');
define('SECURE_AUTH_KEY',  '7jfi}7+ iIr^4PlrXg1vjRkz[Bc#k3K]?#|uNM59/~3i|<l1Hqn|O,+`X/sSOzOs');
define('LOGGED_IN_KEY',    '$J_TVFM^X|>wBo/Z6ro#AVm_F]ceQU:,(jx-o=xZ~5n%L:+aN*KoWALyT5M0Z~$N');
define('NONCE_KEY',        '{`Gy`TQa_j*NswPj9dBpt+9--<-OPV;[YWri0rfkY[1m{$d1u<frhkoyu|aUT;ID');
define('AUTH_SALT',        '#aMyXega:oLSLk;o&A<:_<IEuh)Uezj>3:Sc=|zS3xaIn(=o%+(+.eA5qlwGk8)m');
define('SECURE_AUTH_SALT', 'f^GL?n.>{iIbVCBzg<sm7-$/5,+SN=2Sl]>.kE3Q*{UlEfJ+)sF@HW&arZIqA=v5');
define('LOGGED_IN_SALT',   'Y/u5}Jm:I!P]CZ;3~[u5sUAH_&E (H57-C{H;T-3),x82-T5G8Q-yk@exLI$,P!h');
define('NONCE_SALT',       '36rE9w@AEFY6rmg6tc8r+@>}/IL}bf|1Jem`I->/6@Ohcft3/Pcc;SAlhZO`h~ai');

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
