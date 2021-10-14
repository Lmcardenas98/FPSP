<?php

namespace Fpsp\space;

if ( ! class_exists( 'Modify_the_selected_post' ) ) {
	class Modify_the_selected_post extends Main_class
	{

		protected function __construct()
		{
			add_action( 'wp_ajax_modify_the_selected_form', array( $this, 'modify_the_selected_form' ) );
		}

		public function modify_the_selected_form()
		{
			parent::validate_nonce();

			$title_to_edit   = isset( $_POST['input_title_edit'] ) ? sanitize_text_field( $_POST['input_title_edit'] ) : die( 'invalid title' );
			$content_to_edit = isset( $_POST['content_box_edit'] ) ? sanitize_textarea_field( $_POST['content_box_edit'] ) : die( 'invalid content' );
			$check_image     = isset ( $_FILES["image_box_edit"]["name"] ) ? sanitize_text_field( $_FILES["image_box_edit"]["name"] ) : '';
			$save_id         = isset( $_POST['send_id'] ) ? intval( $_POST['send_id'] ) : die( 'invalid id' );

			//creating the new post
			$id_to_edit = array(
				'ID'           => $save_id,
				'post_content' => $content_to_edit,
				'post_title'   => $title_to_edit,
			);

			$post_id = wp_update_post( $id_to_edit );

			if ( ! empty( $check_image ) ) {
				$upload_file = parent::id_attachment( 'image_box_edit' );
				$filetype    = wp_check_filetype( basename( $upload_file['file'] ), null );
				$w_u_d       = wp_upload_dir();

				$attachment = array(
					'guid'           => $w_u_d['baseurl'] . _wp_relative_upload_path( $upload_file['file'] ),
					'post_mime_type' => $filetype['type'],
					'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $upload_file['file'] ) ),
					'post_content'   => '',
					'post_status'    => 'inherit',
				);

				$attach_id = wp_insert_attachment( $attachment, $upload_file['file'], $post_id );

				require_once ABSPATH . 'wp-admin/includes/image.php';

				$attach_data = wp_generate_attachment_metadata( $attach_id, $upload_file['file'] );

				wp_update_attachment_metadata( $attach_id, $attach_data );

				update_post_meta( $post_id, '_thumbnail_id', $attach_id );
			}
			//loop
			parent::loop();

			wp_die();
		}
	}
}


Modify_the_selected_post::getInstance();