<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
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
define('DB_NAME', 'petevandenberg');

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
define('AUTH_KEY',         'Iz0>Y?{nWkoNg^ZmY[<+Ld7zUTDP`oge+lW?hB&qWxbR<ijb;-~>qM1Tx(/jn&d`');
define('SECURE_AUTH_KEY',  '%:cNI}2``8sTkBml7(KZ+S;ZSZzb 1e4K{eZ.w(?$AV.+;+5O4nJoEzc~b<xBfwl');
define('LOGGED_IN_KEY',    ')a4]:, pqz5;d%k?3~XP8.~+>U,BF/q7 ~cz$`nOlwzO}~N;Wy5A,O,ICwZJI>|l');
define('NONCE_KEY',        'SUU+}P)2o@mQ)E4qF3vMz0<9g|s9_$L.pcsG~4%)Bb<:ajz}*ZxgqlH!1r(_yz@S');
define('AUTH_SALT',        ']o!M]s+[OmB_mr`c<S[;@*S_Xn[d9V/+w>XZ9Vc$=A9S+)jP*!OKzg<Zc%!*0,Pk');
define('SECURE_AUTH_SALT', '+--lU $t/%_ilVk|NnnWE,~+S^3C}!eS$UjXy1:s41AAS_*.O8lWmLA:0x~ s&FI');
define('LOGGED_IN_SALT',   'EKsp7(jMf/^6|HO:},{ZR^tc:gx]H#?<kpHL$q9lQh_|1gq,5>Pqx{]+d-mt6URJ');
define('NONCE_SALT',       'v009m;zj2B/Y^ #q,];4|hI{kM_]f/_ev#@ihlBy?&z26s5&ml1Ea|YAH>!{pSlH');

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
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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
