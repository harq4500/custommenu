<?php
/**
 * Shows admin notice if ACF or Woocommerce plugins are not installed
 */
class CM_Notices{

    /**
     * Check if user has the right
     * make a check and show notice if needed
     */
    public static function show()
    {
        
        if ( current_user_can( 'activate_plugins' ) && current_user_can( 'install_plugins' ) &&  current_user_can( 'update_plugins' ) ) {
           
            if(self::check_plugins()){
                add_action( 'admin_notices', array('CM_Notices','admin_notice'));
            }
        }
    }

    /**
     * Build admin notice about required plugins
     */
    public static function admin_notice() 
    {
        
        $class = 'notice notice-warning  is-dismissible';
        $plugin_name = 'Custom Menu Plugin';
        $message = __( 'Requires the following plugin(s):', 'custommenu' );
        $plugins = self::check_plugins();
        printf( '<div class="%1$s"><p><strong>%2$s</strong> %3$s <strong><em>%4$s</em></strong></div>' , esc_attr( $class ),esc_html( $plugin_name ), esc_html( $message ),  $plugins  );
    }
    
    /**
     * Check if required plugins are installed
     * Build installation links.
     */
    private static function check_plugins()
    {
        $plugins = '';
        if(!is_plugin_active('advanced-custom-fields/acf.php')){
            $plugins .= '<a href="'.admin_url('plugin-install.php').'?tab=plugin-information&amp;plugin=advanced-custom-fields&amp;TB_iframe=true&amp;width=640&amp;height=500" class="thickbox">ACF Advanced Custom Fields</a>';
        }

        if(!is_plugin_active('woocommerce/woocommerce.php')){
            if(!empty( $plugins)){
                $plugins .= ' and ';
            }
            $plugins .= '<a href="'.admin_url('plugin-install.php').'?tab=plugin-information&amp;plugin=woocommerce&amp;TB_iframe=true&amp;width=640&amp;height=500" class="thickbox">Woocommerce</a>';
        }

        return  $plugins;
        
    }
}