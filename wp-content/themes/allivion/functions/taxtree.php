<?php
	
	//Create a Walker to change the way wp_list_categories displays the output
//Here I'm removing the links from the output
class MyWalker extends Walker_Category {
 
    function start_el(&$output, $category, $depth, $args) {
        extract($args);
        $cat_name = esc_attr( $category->name );
        $cat_name = apply_filters( 'list_cats', $cat_name, $category );
        $link = $cat_name;
        
            if ( !empty($current_category) ) {
                $_current_category = get_term( $current_category, $category->taxonomy );
                if ( $category->term_id == $current_category )
                    $class .=  'current-cat';
                elseif ( $category->term_id == $_current_category->parent )
                    $class .=  'current-cat-parent';   
            }
            $output .= '*' . $link . '*';//Using "*" as delimiter
        
    }
}


function wp_list_categories_array($taxonomy) {

    $orderby      = 'name';
    $show_count   = 0;      // 1 for yes, 0 for no
    $pad_counts   = 0;      // 1 for yes, 0 for no
    $hierarchical = 1;      // 1 for yes, 0 for no
    $title        = '';
    $empty        = 0;
    $output       = array();
    
    $MyWalker = new MyWalker(); // Create a new instance of MyWalker
    
//Prepare the argument for wp_list_categories
    $args = array(
      'taxonomy'     => $taxonomy,
      'orderby'      => $orderby,
      'show_count'   => $show_count,
      'pad_counts'   => $pad_counts,
      'hierarchical' => $hierarchical,
      'title_li'     => $title,
      'hide_empty'   => $empty,
      'walker'       => $MyWalker
    );
    
    ob_start(); // This will turn off output buffer
    
    wp_list_categories($args); //WordPress function to retrieve categories
    
    $output = ob_get_contents(); //Get the content of output buffer
    
    ob_end_clean(); // forbidden output buffer to echo content
    ob_end_flush(); // flush the buffer

        //Trim the content from delimiter using reg expression
    if(preg_match_all('/\*(.*?)\*/',$output,$match)) {            
            $output = $match[1];             
    }; 
    
    return $output; 

 
}