<?php
	
/* 
Plugin Name: Template Limiter
Description: 
Version: 1.0 
Author: IBE Creative 
*/

function remove_page_attributes() {
	remove_meta_box( 'pageparentdiv' , 'page' , 'side' );
}

add_action( 'admin_menu' , 'remove_page_attributes' );

function add_post_custom_fields() {
	add_meta_box('pageparentdiv', 'Page Attributes', 'my_page_attributes_meta_box', 'page', 'side');
}

add_action( 'admin_menu' , 'add_post_custom_fields' );

function my_page_attributes_meta_box($post) {
    $post_type_object = get_post_type_object($post->post_type);
    if ( $post_type_object->hierarchical ) {
        $dropdown_args = array(
            'post_type'        => $post->post_type,
            'exclude_tree'     => $post->ID,
            'selected'         => $post->post_parent,
            'name'             => 'parent_id',
            'show_option_none' => __('(no parent)'),
            'sort_column'      => 'menu_order, post_title',
            'echo'             => 0,
        );
        $dropdown_args = apply_filters( 'page_attributes_dropdown_pages_args',   $dropdown_args, $post );
        $pages = wp_dropdown_pages( $dropdown_args );
        if ( ! empty($pages) ) {
    ?>
    <p><strong><?php _e('Parent') ?></strong></p>
    <label class="screen-reader-text" for="parent_id"><?php _e('Parent') ?></label>
    <?php echo $pages; ?>
    <?php
        } // end empty pages check
    } // end hierarchical check.
    if ( 'page' == $post->post_type && 0 != count( get_page_templates() ) ) {
        $template = !empty($post->page_template) ? $post->page_template : false;
        ?>
        
    <div id="pagetemplatediv">
        <p><strong><?php _e('Template') ?></strong></p>
        <label class="screen-reader-text" for="page_template"><?php _e('Page Template') ?></label>
        <select name="page_template" id="page_template">
            <option value='default'><?php _e('Default Template'); ?></option>
            <?php page_template_dropdown($template); ?>
        </select>
     <?php } ?>
     
    </div>
    <div id="pageorderdiv">
        <p><strong><?php _e('Order') ?></strong></p>
        <p><label class="screen-reader-text" for="menu_order"><?php _e('Order') ?></label>
        <input name="menu_order" type="text" size="4" id="menu_order" value="<?php echo esc_attr($post->menu_order) ?>" /></p>
    </div>
    <p><?php if ( 'page' == $post->post_type ) _e( 'Need Help? Use the Help tab in the upper right of your screen.' ); ?></p>
    <?php } ?>