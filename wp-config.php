<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'motanathalie' );

/** Database username */
define( 'DB_USER', 'Sylla' );

/** Database password */
define( 'DB_PASSWORD', 'Ayana2020@' );

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
define( 'AUTH_KEY',         'U]X]qjEy aR(ox]{BwB# D8ko`M2Lif7R148Ci-^.ii%JenJ*tzN)?Zo*XUwX&R<' );
define( 'SECURE_AUTH_KEY',  'GA:F<VqE(4yeA)Ze63-#<HP#Ehh$p;iJ<V$Qf]Mks^AT>;(CVkcX}VdkZH$G3i/3' );
define( 'LOGGED_IN_KEY',    '9oL?tMgGK ;s[v7im@>fHj0RS&M#ItP8jWoT9(O/SZ8*0-%=XU}%;&#Kn<>adCP.' );
define( 'NONCE_KEY',        'nEC{pO{lo5HXLCq.XSvs$e,1;39h%MO/~dSHheN54Ky4p 48u2eA=XAGt{QF2gR6' );
define( 'AUTH_SALT',        'Ii&ImJsRVWON~zE4}}h@-lvkK&wkls)%&UYaQFvIG{{w(LT2(,8wLy(wd?IHD<Em' );
define( 'SECURE_AUTH_SALT', ')KDyL[:uV$W$$&Y]wP2urZ^w/i`mib4.@|56)W8Yg#45tCD$cV-qR0:5C9${$}4<' );
define( 'LOGGED_IN_SALT',   '4M!??3-#F,1uHM1w_bwNJ<yD2r+D}phcww`@~UF_mgyc1i*r]GYogU eJffKPsgo' );
define( 'NONCE_SALT',       ' U+?aK[)HtwLD:Bj3J6SOO;}QyjoA&N$7Vn,.((M&3g=|RE4IrsTx(mr%FA@Dtdj' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);


/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

