<?php 
/**
 * Plugin Name: Delete WooCommerce Product Images
 * Description: Quick and easy way to delete all WooCommerce Product Images
 * Plugin URI: 
 * Author: Code Den Ltd
 * Author URI: https://codeden.co.uk
 * Version: 1.0.0
 *
 */
add_action( 'admin_menu', 'cd_delete_woo_images_menu' );
function cd_delete_woo_images_menu() {
	add_submenu_page('woocommerce', 'Delete Product Images', 'Delete Product Images', 'manage_options', 'cd-delete-woo-images', 'cd_delete_woo_images_settings');
}

function cd_enqueue_dwpi($hook) {
    wp_enqueue_script('dwpi',  plugins_url('/dwpi.js', __FILE__), array('jquery')); 
}
add_action( 'admin_enqueue_scripts', 'cd_enqueue_dwpi' );

function cd_delete_woo_images_settings() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
		$todelete = array();
		echo '<h2>Delete WooCommerce Product Images</h2>'; 
		$howmany = 0;
		$args = array( 'post_type' => 'product', 'posts_per_page' => -1);
		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) { 
			$loop->the_post();
			$attachments = get_attached_media('image', get_the_id());
			foreach($attachments as $key => $val){
				$howmany++;
				$todelete[] = $key;
			}
		}
		if(isset($_POST['deleteimages'])){
			foreach($todelete as $delete){
				//echo $delete.'</br>';
				wp_delete_attachment( $delete, true );
			}
			echo '<div class="notice notice-success is-dismissible"><p>All images have been deleted!</p></div>';
			$howmany = 0;	
		}
		echo '<p>You currently have <strong>'.$howmany.'</strong> product images.</p>';
		echo '<form name="massDelete" action="" method="post" id="deleteallimages" >';
			echo '<button type="submit" name="deleteimages" style="margin-top:50px;" class="button button-primary button-large deleteAll">Delete ALL '.$howmany.' Product Images</button>';
		echo '</form>';
	echo '</div>'; 
}
