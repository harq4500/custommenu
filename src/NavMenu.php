<?php
/**
 * Handles front end part
 */

namespace Antonbalyan\Custommenu;

class NavMenu{

    /**
     * Custom style to menu 
     */

    public function add_style() {
        wp_enqueue_style( 'custom-mega-menu-style',  CM_PLUGIN_URL . 'assets/css/megamenu.css', array(), '1.0', 'all' );
        // wp_enqueue_script( 'custom-mega-menu-script', CM_PLUGIN_URL . '/assets/megamenu.js', array('jquery'), '1.0', true);
    }

    /**
     * Checks on which menu item is enabled "mega menu" feature
     * Adds CSS  custom "custom-mega-menu" and built in "menu-item-has-children" classes to the menu item
     */
    
    public function add_classes($items) {
        if( class_exists('ACF') ) {

            foreach($items as $item){

                $mega_menu_enabled = get_field('mega_menu_enabled', $item);
                if($mega_menu_enabled){
                    if(count($mega_menu_enabled) > 0 && $mega_menu_enabled[0] == true){
                        array_push($item->classes, 'custom-mega-menu', 'menu-item-has-children');
                    }
                }
            }
        }
        return $items;
    }

    /**
     * Checks menu items for the custom (custom-mega-menu) class, and appends "Mega Menu" custom html into menu item
     */

    public function filter_menu($output, $item, $depth) {
        
        if ( 0 === $depth && in_array( 'custom-mega-menu', $item->classes, true ) ) {
          
            $output .= $this->menu_html();
        }
        return $output;
    }

    /**
     * Build custom html for List Item "Mege Menu" View
     */

    private function menu_html() {
        $product_cats =  $this->parse_taxonomies_arr();
      
        $output  = '<ul class="sub-menu">';
        $output  .=   '<div class="cm-container">';

        foreach($product_cats as $product_cat){
            $output  .= '<div class="cm-block">';
            $output  .= '<h3><a href="'.$product_cat->url.'">'.$product_cat->name.'</a></h3>';

            if(count($product_cat->children) > 0){
                foreach($product_cat->children as $child){
                    $output  .= '<p><a href="'.$child->url.'">'.$child->name.'</a></p>';
                }
            }

            $output  .= '</div>';
        }
        
        $output  .= '</div>';
        $output  .= '</ul>';
        
        return  $output;
    }

    /**
     * Parse product_cat taxonomy in a new array structure
     */

    private function parse_taxonomies_arr() {
        $product_cats =  get_terms(array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false
            ) );
        
        $product_cats_arr = [];

        foreach($product_cats as $product_cat){
            if($product_cat->parent == 0){
                $product_cat->children = array();
                $product_cat->url = get_term_link($product_cat);
                array_push($product_cats_arr, $product_cat);
            }
        }
      
        $product_cats_arr = $this->parse_children($product_cats,$product_cats_arr);
       
        return $product_cats_arr;
    }

    
    private function parse_children($product_cats,$product_cats_arr) {
        foreach($product_cats_arr as $product_cats_arr_item){
            foreach($product_cats as $product_cat){
                if($product_cats_arr_item->term_id == $product_cat->parent){
                    $product_cat->url = get_term_link($product_cat);
                    array_push($product_cats_arr_item->children,$product_cat);
                }
            }
        }
        return $product_cats_arr;
    }
}

