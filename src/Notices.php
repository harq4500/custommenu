<?php
namespace Antonbalyan\Custommenu;

/**
 * Shows admin notice if ACF or Woocommerce plugins are not installed
 */
class Notices{

    private $required_plugins = [
        [
            'name'=>'Advanced Custom Fields (ACF)',
            'slug'=>'advanced-custom-fields',
            'file'=>'advanced-custom-fields/acf.php',
            'pro'=>'advanced-custom-fields-pro/acf.php',
        ],
        [
            'name'=>'WooCommerce',
            'slug'=>'woocommerce',
            'file'=>'woocommerce/woocommerce.php',
            'pro'=>null
        ]
    ];

    /**
     * Check if user has the right
     * make a check and show notice if needed
     */
    public function show() 
    {
        
        if ( current_user_can( 'activate_plugins' ) && current_user_can( 'install_plugins' ) &&  current_user_can( 'update_plugins' ) ) {
           
            if($this->check_plugins()){
                add_action( 'admin_notices', array($this,'admin_notice'));
            }
        }
    }

    /**
     * Build admin notice about required plugins
     */
    public function admin_notice() 
    {
        
        $class = 'notice notice-warning  is-dismissible';
        $plugin_name = 'Custom Menu Plugin';
        $message = __( 'Requires the following plugin(s):', 'custommenu' );
        $plugins = $this->check_plugins();
        printf( '<div class="%1$s"><p><strong>%2$s</strong> %3$s <strong><em>%4$s</em></strong></div>' , esc_attr( $class ),esc_html( $plugin_name ), esc_html( $message ),  $plugins  );
    }
    
    /**
     * Check if required plugins are installed
     * Build installation links.
     */
    private function check_plugins() 
    {
        $plugins = '';

        foreach($this->required_plugins as $key => $required_plugin){
          
            if( !is_plugin_active($required_plugin['file']) ){

                if($key > 0 && !empty($plugins)){
                    $plugins .= ' and ';
                }

                if(!empty($required_plugin['pro']) && is_plugin_active($required_plugin['pro'])){
                    continue;
                }

                $plugins .= sprintf(
                    '<a href="'.admin_url('plugin-install.php').'?tab=plugin-information&amp;plugin=%1$s&amp;TB_iframe=true&amp;width=640&amp;height=500" class="thickbox">%2$s</a>',
                    $required_plugin['slug'],
                    $required_plugin['name']
                );
            }
        }
      
        return  $plugins;
        
    }
}