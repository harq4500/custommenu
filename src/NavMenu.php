<?php
/**
 * Handles front end part
 */

namespace Antonbalyan\Custommenu;

class NavMenu{

    /**
     * Custom style to menu 
     */

    public function add_style() 
    {
        wp_enqueue_style( 'custom-mega-menu-style',  CM_PLUGIN_URL . 'assets/css/megamenu.css', array(), '1.0', 'all' );
    }

    /**
     * Checks on which menu item is enabled "mega menu" feature
     * Adds CSS  custom "custom-mega-menu" and built in "menu-item-has-children" classes to the menu item
     */
    
    public function add_classes($items) 
    {
        if( class_exists('ACF') ) {

            foreach($items as $item){

                $mega_menu_enabled = get_field('mega_menu_enabled', $item);
                
                if(!empty($mega_menu_enabled)){
                    array_push($item->classes, 'custom-mega-menu', 'menu-item-has-children');
                }
            }
        }
        return $items;
    }

    /**
     * Checks menu items for the custom (custom-mega-menu) class, and appends "Mega Menu" custom html into menu item
     */

    public function filter_menu($output, $item, $depth) 
    {
        
        if ( 0 === $depth && in_array( 'custom-mega-menu', $item->classes, true ) ) {
            
            $output .=  $this->menu_html();
        }
        return $output;
    }

    /**
     * Build custom html for List Item "Mege Menu" View
     */

    private function menu_html() 
    {
        $product_cats =  $this->parse_taxonomies_arr();
        ob_start();
        include CM_PLUGIN_DIR.'/templates/mega_menu.php';
        return ob_get_clean();
    }

    /**
     * Parse product_cat taxonomy in a new array structure
     */
    private function parse_taxonomies_arr() 
    {
        $product_cats =  get_terms(array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
            'hierarchical'=>true,
            'orderby' => 'parent',
            'order' =>'ASC'
            ) );
       
        $product_cats_arr = [];
       
        if(!isset($product_cats->errors)){
            foreach($product_cats as $product_cat){

                $product_cat->url = get_term_link($product_cat);

                if($product_cat->parent == 0){
                    $product_cat->children = array();
                    foreach($product_cats as $product_cat_sub){
                        if($product_cat->term_id == $product_cat_sub->parent){

                            $product_cat_sub->url = get_term_link($product_cat_sub);

                            array_push($product_cat->children, $product_cat_sub);
                        }
                    }

                    array_push($product_cats_arr, $product_cat);
                }
            }
        }

        return $product_cats_arr;
    }
}

