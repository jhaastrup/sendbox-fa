<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://m.sendbox.co/
 * @since             1.0.0
 * @package           Sendbox_Fa
 *
 * @wordpress-plugin
 * Plugin Name:       sendbox-forminator-addon
 * Plugin URI:        https://m.sendbox.co/
 * Description:       Sendbox Forminator Addon for Jand2Gidi
 * Version:           1.0.0
 * Author:            Sendbox
 * Author URI:        https://m.sendbox.co/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sendbox-fa
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SENDBOX_FA_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sendbox-fa-activator.php
 */
function activate_sendbox_fa() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sendbox-fa-activator.php';
	Sendbox_Fa_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sendbox-fa-deactivator.php
 */
function deactivate_sendbox_fa() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sendbox-fa-deactivator.php';
	Sendbox_Fa_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sendbox_fa' );
register_deactivation_hook( __FILE__, 'deactivate_sendbox_fa' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sendbox-fa.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sendbox_fa() {

	$plugin = new Sendbox_Fa();
	$plugin->run();

}
run_sendbox_fa();
