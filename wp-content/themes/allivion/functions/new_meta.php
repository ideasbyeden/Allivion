<?php

add_action( 'add_meta_boxes', 'newmeta_add' );
add_action( 'save_post', 'newmeta_save' );


// register new meta panel  
function newmeta_add()  {
	add_meta_box( 'newmeta_control', 'New Meta', 'newmeta_cb', 'page', 'normal', 'high' );
}


// render meta panel
function newmeta_cb($post) {

	global $post, $post_id; $post_id = get_the_ID(); 
	$values = get_post_custom( $post->ID );
	$newmeta = isset( $values['_newmeta'] ) ? esc_attr( $values['_newmeta'][0] ) :'';		
	
	wp_nonce_field( 'newmeta_nonce', 'newmeta_meta_box_nonce' ); ?>
	
	<p>   
		<input type="text" name="newmeta" id="newmeta" value="<?php echo $newmeta; ?>" />
	</p>   
    
<?php } 


// save meta panel input
function newmeta_save($post_id) {

    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
    if( !isset( $_POST['newmeta_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['newmeta_meta_box_nonce'], 'newmeta_nonce' ) ) return; 
    if( !current_user_can( 'edit_post' ) ) return;
    
    if( isset( $_POST['newmeta'] ) )  
    update_post_meta( $post_id, '_newmeta', $_POST['newmeta'] );
}

?>