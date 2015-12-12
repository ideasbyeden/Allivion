<?php
/** 
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information by
 * visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress_c');

/** MySQL database username */
define('DB_USER', 'wordpress_6');

/** MySQL database password */
define('DB_PASSWORD', 'W6c2x7O_Mq');

/** MySQL hostname */
define('DB_HOST', '185.17.180.134');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link http://api.wordpress.org/secret-key/1.1/ WordPress.org secret-key service}
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'pqyP2G*1Ge^!NaRKFQR0Ao2AGBaqusVdB82of&a*^Keud7G%$h%D(hqQbTIOLc0u');
define('SECURE_AUTH_KEY',  '^LM6!JxNI9Wiy9^4Tqv3hfki%QGUZ*Y51$Cbt9zKAqYRv1thgbmSHeP)4YAW77yn');
define('LOGGED_IN_KEY',    '(Nx&d^a2C65XCXsHiss0j2!9X2%D$VAaAHc#QezDkFG#DXT#ut!pmW8R36JrvQhy');
define('NONCE_KEY',        'Aw7pA4R^JArl5B#Z$@6)q&gx2jae0v!#Qb&wd0nUBJa@!e7DX!M5nozK!(M^P)UW');
define('AUTH_SALT',        'dn93u#MDwr5zxC!pE2&bx)%gHy!ZGtEJYlw*mtLPLlCWNdeKB$&EVzf4EHLR%l^o');
define('SECURE_AUTH_SALT', 'J)@^tgYn$0TD!YCpk6vF#yRc03ncw!Z8UMif@ZpOlNXU4ictfC9kEhgxWRQD6c*P');
define('LOGGED_IN_SALT',   'n%vIsEh140ALTuskuGiVXQL)KIf7@fo6@n(!kskp$yn1PH6%EhQQqG(ogD5s2ZBl');
define('NONCE_SALT',       'KK@XRheIiq2Lc9m6n$2ZGRwbzn4FNff0tcN7Fn079t9cSNf1rn)7ZV5udn7hOhkl');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', 'en_US');

define ('FS_METHOD', 'direct');

define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

//--- disable auto upgrade
define( 'AUTOMATIC_UPDATER_DISABLED', true );



?>
