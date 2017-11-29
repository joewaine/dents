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
define('DB_USER', 'wordpress');

/** MySQL database password */
define('DB_PASSWORD', '6d2e9bb47a3227568592010c95fd009736786903ae71b858');

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
define('AUTH_KEY',         'ta+mA+JjmLv-2J>xOuC9_*K`#p_M6xWwwXS}]lM>I#d_G}:!WS{Z=JX^`u`XK6/:');
define('SECURE_AUTH_KEY',  'FwS.)si#n?z`:99::HTBQ#8DxFGEXsiGsGBh><3C1eBAyMSaNz:MmI3DRD- .RP[');
define('LOGGED_IN_KEY',    'P&AK2#YXEV!xqxAJ0A&hh0AbfqS_)a*oRs1yoz,]c9cO*d7)W.&H`~S@i6*|sz(F');
define('NONCE_KEY',        'nYfUW,7=;iL.+Eu{Hm3Aik8-LD(<u]?Cs hO-exL +n}4@x[:Wq(>v575y,=^f=M');
define('AUTH_SALT',        '.8gbl6f*y0/Kr,Ohf)[WWUdQ23IlbwTR5F o&l<)D>^`C~bo;0!xIzSb5ld^&jG{');
define('SECURE_AUTH_SALT', '<T~,+A&>0rI]f<G~F/2_}sFm^_mm7W|;1rK,iSt^UmFWUa~Ss<6.8J~>x<zJCm*.');
define('LOGGED_IN_SALT',   '2=@JGr55$^GfSPCs2#PnM]nNmZ#n;c3/Xav!AfdS8(uvI`p~i|W/^ELz|U%xJ+E*');
define('NONCE_SALT',       'dO8!4%Y($|ei r>f^uv4];Ui9B*u$S8f5px}yl$3#hnLo(MYiF!Cp#!1w. 9Q^l|');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp2_';

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
/* Multisite added by kb */

define('MULTISITE', false);
define('DOMAIN_CURRENT_SITE', 'http://www.donuts.domains');
/*define('SUBDOMAIN_INSTALL', false);

define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);*/


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
define('FS_METHOD','direct');


define('WP_MEMORY_LIMIT', '3000M');
