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

namespace Antonbalyan\Custommenu;

defined( 'ABSPATH' ) || exit;

define("CM_PLUGIN_URL", plugin_dir_url( __FILE__ ));
define("CM_PLUGIN_DIR", __DIR__);

if ( file_exists( CM_PLUGIN_DIR . '/vendor/autoload.php' ) ) {
	require_once CM_PLUGIN_DIR . '/vendor/autoload.php';
}

use Antonbalyan\Custommenu\Notices;
use Antonbalyan\Custommenu\NavMenu;
use Antonbalyan\Custommenu\AcfFuncs;

if ( ! class_exists( 'CustomMenu' ) ) {

    class CustomMenu{
       
        /**
         * Class initializer.
         */
        public function plugins_loaded() {
          
            load_plugin_textdomain(
                'custommenu',
                false,
                basename( dirname( __FILE__ ) ) . '/languages'
            );

            /**
             * Creates ACF local Field Group and field
             */
           
            $AcfFuncs = new AcfFuncs();

            add_filter('acf/settings/load_json', array($AcfFuncs, 'load_json'));

            // Run plugin initial code here.
            add_action( 'init', array( $this, 'init' ) );
        }

        /**
         * Init plugin functionality.
         */
        public function init(){
            /**
             * Check if ACF and/or Woocommerce plugins are installed and activated
             * Show required notice
             */
            add_action('admin_init', array(new Notices, 'show'));

            /**
             * NavMenu Object to handle front (menu) part
             */
            $NavMenu =  new NavMenu();

            //Add plugin's custom styles and scripts
            add_action( 'wp_enqueue_scripts', array($NavMenu,'add_style' ));

            //Add custom class to nav item
            add_filter('wp_nav_menu_objects', array($NavMenu,'add_classes'), 10, 2);
            
            //Filter and append mega menu html into nav item
            add_filter( 'walker_nav_menu_start_el',  array($NavMenu,'filter_menu'), 10, 4 );
        }
        
    }

    $CustomMenu =  new CustomMenu();

    add_action( 'plugins_loaded', array($CustomMenu,'plugins_loaded'));

   
}