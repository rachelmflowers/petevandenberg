<?php
/**
 * Functions used to duplicate a slider
 *
 * Based on 'Duplicate Post' (http://www.lopo.it/duplicate-post-plugin/) by Enrico Battocchi
 *
 */
class A3_Responsive_Slider_Duplicate 
{
	
	public static function duplicate_action() {
		A3_Responsive_Slider_Duplicate::duplicate_item();	
	}
	
	public static function duplicate_link_row( $actions, $post ) {
	
		if ( function_exists( 'duplicate_post_plugin_activation' ) ) return $actions;
				
		if ( $post->post_type != 'a3_slider' ) return $actions;
		
		$actions['duplicate'] = '<a href="' . wp_nonce_url( admin_url( 'admin.php?action=duplicate_a3_slider&amp;post=' . $post->ID ), 'a3-duplicate-slider_' . $post->ID ) . '" title="' . __( "Make a duplicate from this slider", 'a3_responsive_slider' )
			. '" rel="permalink">' .  __( "Duplicate", 'a3_responsive_slider' ) . '</a>';
	
		return $actions;
	}
	
	public static function duplicate_post_button() {
		global $post;
		
		if ( function_exists( 'duplicate_post_plugin_activation' ) ) return;
				
		if( !is_object( $post ) ) return;
		
		if ( $post->post_type != 'a3_slider' ) return;
		
		if ( isset( $_GET['post'] ) ) :
			$notifyUrl = wp_nonce_url( admin_url( "admin.php?action=duplicate_a3_slider&post=" . $_GET['post'] ), 'a3-duplicate-slider_' . $_GET['post'] );
			?>
			<div id="duplicate-action"><a class="submitduplicate duplication" href="<?php echo esc_url( $notifyUrl ); ?>"><?php _e( 'Duplicate', 'a3_responsive_slider' ); ?></a></div>
			<?php
		endif;
	}

	public static function duplicate_item() {
		if ( ! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'duplicate_post_save_as_new_page' == $_REQUEST['action'] ) ) ) {
			wp_die( __( 'No slider to duplicate has been supplied!', 'a3_responsive_slider' ) );
		}
	
		// Get the original page
		$id = ( isset( $_GET['post'] ) ? $_GET['post'] : $_POST['post'] );
		check_admin_referer( 'a3-duplicate-slider_' . $id );
		$post = A3_Responsive_Slider_Duplicate::get_item_to_duplicate( $id );
	
		// Copy the page and insert it
		if ( isset( $post ) && $post != null ) {
			$new_id = A3_Responsive_Slider_Duplicate::create_duplicate_from_item( $post );
	
			// If you have written a plugin which uses non-WP database tables to save
			// information about a page you can hook this action to dupe that data.
			do_action( 'duplicate_item', $new_id, $post );
	
			// Redirect to the edit screen for the new draft page
			wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_id ) );
			exit;
		} else {
			wp_die( __( 'Slider creation failed, could not find original slider:', 'a3_responsive_slider' ) . ' ' . $id);
		}
	}
	
	/**
	 * Get a product from the database
	 */
	public static function get_item_to_duplicate( $id ) {
		global $wpdb;
		$post = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE ID=$id");
		if ( isset( $post->post_type ) && $post->post_type == "revision" ){
			$id = $post->post_parent;
			$post = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE ID=$id");
		}
		return $post[0];
	}
	
	/**
	 * Function to create the duplicate
	 */
	public static function create_duplicate_from_item( $post, $parent = 0, $post_status = '' ) {
		global $wpdb;
	
		$new_post_author 	= wp_get_current_user();
		$new_post_date 		= current_time('mysql');
		$new_post_date_gmt 	= get_gmt_from_date($new_post_date);
		
		if ( $parent > 0 ) {
			$post_parent		= $parent;
			$post_status 		= $post_status ? $post_status : 'publish';
			$suffix 			= '';
		} else {
			$post_parent		= $post->post_parent;
			$post_status 		= $post_status ? $post_status : 'publish';
			$suffix 			= ' ' . __("(Copy)", 'a3_responsive_slider');
		}
		
		$new_post_type 			= $post->post_type;
		$post_content    		= str_replace("'", "''", $post->post_content);
		$post_content_filtered 	= str_replace("'", "''", $post->post_content_filtered);
		$post_excerpt    		= str_replace("'", "''", $post->post_excerpt);
		$post_title      		= str_replace("'", "''", $post->post_title).$suffix;
		$post_name       		= str_replace("'", "''", $post->post_name);
		$comment_status  		= str_replace("'", "''", $post->comment_status);
		$ping_status     		= str_replace("'", "''", $post->ping_status);
	
		// Insert the new template in the post table
		$wpdb->query(
				"INSERT INTO $wpdb->posts
				(post_author, post_date, post_date_gmt, post_content, post_content_filtered, post_title, post_excerpt,  post_status, post_type, comment_status, ping_status, post_password, to_ping, pinged, post_modified, post_modified_gmt, post_parent, menu_order, post_mime_type)
				VALUES
				('$new_post_author->ID', '$new_post_date', '$new_post_date_gmt', '$post_content', '$post_content_filtered', '$post_title', '$post_excerpt', '$post_status', '$new_post_type', '$comment_status', '$ping_status', '$post->post_password', '$post->to_ping', '$post->pinged', '$new_post_date', '$new_post_date_gmt', '$post_parent', '$post->menu_order', '$post->post_mime_type')");
	
		$new_post_id = $wpdb->insert_id;
	
		// Copy the taxonomies
		A3_Responsive_Slider_Duplicate::duplicate_post_taxonomies( $post->ID, $new_post_id, $post->post_type );
	
		// Copy the meta information
		A3_Responsive_Slider_Duplicate::duplicate_post_meta( $post->ID, $new_post_id );
		
		// Update the slider id meta
		A3_Responsive_Slider_Duplicate::update_slider_id_meta( $post->ID, $new_post_id );
		
		// Copy the images for slider
		A3_Responsive_Slider_Duplicate::duplicate_post_images( $post->ID, $new_post_id );
	
		return $new_post_id;
	}
	
	/**
	 * Copy the taxonomies of a post to another post
	 */
	public static function duplicate_post_taxonomies( $id, $new_id, $post_type ) {
		global $wpdb;
		$taxonomies = get_object_taxonomies( $post_type ); //array("category", "post_tag");
		foreach ( $taxonomies as $taxonomy ) {
			$post_terms = wp_get_object_terms($id, $taxonomy);
			$post_terms_count = sizeof( $post_terms );
			for ( $i=0; $i < $post_terms_count; $i++ ) {
				wp_set_object_terms( $new_id, $post_terms[$i]->slug, $taxonomy, true);
			}
		}
	}
	
	/**
	 * Copy the meta information of a post to another post
	 */
	public static function duplicate_post_meta( $id, $new_id ) {
		$all_custom_keys = get_post_custom_keys( $id );
		foreach ( $all_custom_keys as $key ) {
			$value = get_post_meta( $id, $key, true );
			add_post_meta( $new_id, $key, $value );
		}
	}
	
	/**
	 * Update the slider id meta
	 */
	public static function update_slider_id_meta( $id, $new_id ) {
		update_post_meta( $new_id, '_a3_slider_id', $new_id );
	}
	
	
	/**
	 * Copy the images of original slider to another post
	 */
	public static function duplicate_post_images( $id, $new_id ) {
		$all_images = A3_Responsive_Slider_Data::get_all_images_from_slider( $id );
		if ( is_array( $all_images ) && count( $all_images ) > 0 ) {
			foreach ( $all_images as $a_image ) {
				if ( $a_image->is_video == 0 ) 
					A3_Responsive_Slider_Data::insert_row_image( $new_id, $a_image->img_url, $a_image->img_link, $a_image->img_title, $a_image->img_description, $a_image->img_order );
			}
		}
	}

}