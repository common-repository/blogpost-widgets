<?php
/**
 * Plugin Name: BlogPost Widgets - Amazing Blog Layouts
 * Description: You can create amazing blog layouts by using supported page builder with any theme of your choice. All the widgets are highly customizable with pre-designed layouts. Just drag and drop the widgets and play with the settings and make cool layouts.
 * Plugin URI:  https://wordpress.org/plugins/blogpost-widgets
 * Version:     1.0.0
 * Author:      Asad Chaudhary
 * Author URI:  https://innvosol.com
 * tested up to: 6.1.1
 * Text Domain: blogpost-widgets
 * @package BlogPost Widgets
 * @category Core 
 * 
 */

if(!defined('BLOGPOST_WIDGETS')) {
    define( 'BLOGPOST_WIDGETS', __FILE__ );
}
if(!defined('BLOGPOST_PLUGIN_PATH')) {
    define( "BLOGPOST_PLUGIN_PATH", plugin_dir_path(__FILE__) );
}
if(!defined('BLOGPOST_ASSETS_PATH')) {
    define( "BLOGPOST_ASSETS_PATH", plugins_url( 'assets/', __FILE__ ) );
}
if(!defined('BLOGPOST_WIDGET_ASSETS_PATH')) {
    define( "BLOGPOST_WIDGET_ASSETS_PATH", plugins_url( 'widgets/', __FILE__ ) );
}

/**
 * Include helper functions class.
 */
require BLOGPOST_PLUGIN_PATH . 'include/helper.php';

/**
 * Include the plugin loader class.
 */
require BLOGPOST_PLUGIN_PATH . 'plugin-loader.php';


/**
 * Include Admin helper functions.
 */
include BLOGPOST_PLUGIN_PATH .'admin/helper.php';

/**
 * Include Registered Settings and Sections.
 */
include BLOGPOST_PLUGIN_PATH .'admin/settings.php';

/**
 * Include Fields callback functions.
 */
include BLOGPOST_PLUGIN_PATH .'admin/fields.php';

/**
 * Include Admin menus.
 */
include BLOGPOST_PLUGIN_PATH .'admin/menus.php';

/**
 * Settings Panel HTML
 */
include BLOGPOST_PLUGIN_PATH .'admin/panel-html.php';


/**
 * Register default settings
 */
require BLOGPOST_PLUGIN_PATH . 'include/default-settings.php';
register_activation_hook( BLOGPOST_WIDGETS, 'coneblod_set_default_settings' );