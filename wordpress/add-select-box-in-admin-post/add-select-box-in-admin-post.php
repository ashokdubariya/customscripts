<?php 
function dummy_auther_name_add_meta_box() {
	$screens = array( 'post', 'page' );
	foreach ( $screens as $screen ) {
		add_meta_box(
			'dummy_auther_name_sectionid',
			__( 'Dummy Auther Name', 'dummy_auther_name_textdomain' ),
			'dummy_auther_name_meta_box_callback',
			$screen
			);
	}
}
add_action( 'add_meta_boxes', 'dummy_auther_name_add_meta_box' );

function dummy_auther_name_meta_box_callback( $post ) {
	wp_nonce_field( 'dummy_auther_name_save_meta_box_data', 'dummy_auther_name_meta_box_nonce' );
	$value = get_post_meta( $post->ID, '_dummy_auther_name_id', true );	
	?>
	<select id="dummy_auther_name_field" name="dummy_auther_name_field">
		<option value="0" <?php echo esc_attr($value == "0") ? 'selected="selected"' : ''; ?>>-- Please Select --</option>
		<option value="1" <?php echo esc_attr($value == "1") ? 'selected="selected"' : ''; ?>>Admin</option>
		<option value="2" <?php echo esc_attr($value == "2") ? 'selected="selected"' : ''; ?>>Little Black Dress</option>
		<option value="3" <?php echo esc_attr($value == "3") ? 'selected="selected"' : ''; ?>>Testing Developer</option>
	</select>

	<p class="description"><?php _e('Select Auther'); ?></p>
	<?php
}

function dummy_auther_name_save_meta_box_data( $post_id ) {
	if ( ! isset( $_POST['dummy_auther_name_meta_box_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['dummy_auther_name_meta_box_nonce'], 'dummy_auther_name_save_meta_box_data' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	if ( ! isset( $_POST['dummy_auther_name_field'] ) ) {
		return;
	}

	$my_data = sanitize_text_field( $_POST['dummy_auther_name_field'] );

	update_post_meta( $post_id, '_dummy_auther_name_id', $my_data );
}
add_action( 'save_post', 'dummy_auther_name_save_meta_box_data' );