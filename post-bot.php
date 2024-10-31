<?php
/**
 * Plugin Name: Post Bot
 * Plugin URI: http://aasthasolutions.com/about-us/
 * Description: Post Bot is the fastest and simplest way to create posts to your website from frontend, convert more leads and engage your customers, even after they’ve left your website.
 * Version: 1.0.2
 * Author: Aastha Solutions
 * Author URI: http://aasthasolutions.com/
 * Requires at least: 4.4
 * Tested up to: 6.0.3
 * License: GPL2 or later
 * Text Domain: post-bot
 *
 * @package Post Bot
 * @category Core
 * @author Aasthasolutions
 */
/*This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
define( 'ASPC_VERSION', '1.0' );
define( 'ASPC_FILE_DIR', __FILE__  );
define( 'ASPC_PLUGIN_URL', plugin_dir_url( ASPC_FILE_DIR ) );
define( 'ASPC_IMG_URL', plugin_dir_url( ASPC_FILE_DIR ).'/assets/images/' );
define( 'ASPC_PLUGIN_PATH', plugin_dir_path( ASPC_FILE_DIR ) );


require_once( ASPC_PLUGIN_PATH.'includes/functions.php' );



if ( ! function_exists( 'aspc_add_post_scripts' ) ) {
    /**
     * Insert front js and css
     */
    function aspc_add_post_scripts() {

        wp_enqueue_script('aspc_add_post_scripts',ASPC_PLUGIN_URL.'assets/js/script.js', array( 'jquery' ),'',true);
        wp_localize_script( 'aspc_add_post_scripts', 'ajax', array(
    	    'url' => admin_url( 'admin-ajax.php' ),
    	    'image' => ASPC_IMG_URL,
    	) );
    	
        wp_register_style( 'aspc_add_post_style',ASPC_PLUGIN_URL.'assets/css/style.css' );
        wp_enqueue_style( 'aspc_add_post_style' );
    }
    add_action('wp_enqueue_scripts','aspc_add_post_scripts');
}
if ( ! function_exists( 'aspc_add_post_admin_script' ) ) {
    /**
     * Insert admin js and css
     */
    function aspc_add_post_admin_script( $hook ) {
        if ( 'toplevel_page_aspc_add_post' != $hook ) {
            return;
        }
        wp_register_style( 'aspc_add_post_style_admin',ASPC_PLUGIN_URL.'assets/css/style-admin.css' );
        wp_enqueue_style( 'aspc_add_post_style_admin' );
    }
    add_action( 'admin_enqueue_scripts', 'aspc_add_post_admin_script' );
}