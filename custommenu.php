<?php
/**
 * @package custommenu
 * @version 1.0.0
 */
/*
Plugin Name: Custom Menu
Plugin URI:  
Description: This is a testing custom menu plugin
Author: Anton Balyan
Version: 1.0.0
Author URI: 
Text Domain: custommenu
*/

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'CustomMenu' ) ) {

    define("CM_PLUGIN_URL", plugin_dir_url( __FILE__ ));

    require_once  __DIR__ ."/src/Notices.php";
    require_once  __DIR__ ."/src/ACF_funcs.php";
    require_once  __DIR__ ."/src/Nav_menu.php";

    class CustomMenu{

        public static function init()
        {
            /**
             * Check if ACF and/or Woocommerce plugins are installed and activated
             * Show required notice
             */
            CM_Notices::show();
            /**
             * CM_Nav_menu Object to handle front (menu) part
             */
            $CM_Nav_menu =  new CM_Nav_menu();


            //Add plugin's custom styles and scripts
            add_action( 'wp_enqueue_scripts', array($CM_Nav_menu,'add_style' ));

            //Add custom class to nav item
            add_filter('wp_nav_menu_objects', array($CM_Nav_menu,'add_classes'), 10, 2);
            
            //Filter and append mega menu html into nav item 
            add_filter( 'walker_nav_menu_start_el',  array($CM_Nav_menu,'filter_menu'), 10, 4 );

            /**
             * Creates ACF local Field Group and field
             */
            CM_ACF_funcs::create_field();
        }
        
    }

    add_action( 'init', array( 'CustomMenu', 'init' ) );

}