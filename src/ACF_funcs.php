<?php


class CM_ACF_funcs{

    public static function create_field()
    {
      
        if (class_exists('acf')) {
          
                acf_add_local_field_group(array (
                    'key' => 'custom_menu_item_field',
                    'title' => 'Custom Menu Item Field',
                    'label_placement' => 'top',
                    'menu_order' => 0,
                    'style' => 'default',
                    'position' => 'normal',
                    'fields' => array (
                        array(
                            'key' => 'mega_menu_enabled',
                            'label' => '',
                            'name' => 'mega_menu_enabled',
                            'type' => 'checkbox',
                            'layout' => 'horizontal',
                            'toggle' => 0,
                            'return_format' => 'value',
                            'choices' => [
                                'true' => __('Mega Menu enabled', 'custommenu')
                            ],
                            'default_value' => ['false']
                        )
                    ),
                    'location' => array (
                        array(
                            array (
                                    'param' => 'nav_menu_item',
                                    'operator' => '==',
                                    'value' => 'all'
                            ),
                        )
                    )
                ));
        }
    }
}