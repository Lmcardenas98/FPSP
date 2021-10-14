<?php

namespace Fpsp\space;

if ( ! class_exists( 'Fpsp_new_post' ) ) {
	class New_post extends Main_class
	{

		protected function __construct()
		{
			add_action( 'wp_ajax_new_post_as_draft', array( $this, 'new_post_as_draft' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'my_script' ) );
		}

		public function my_script()
		{
			wp_register_script( 'script_js', plugins_url( '/../assets/js/script_fps.js', __FILE__ ), array( 'jquery' ), '1', true );
			wp_localize_script( 'script_js', 'ajax_var', array(
				'url'   => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'form_nonce' )
			) );
			wp_enqueue_script( 'script_js' );
		}

		public function new_post_as_draft()
		{
			parent::validate_nonce();

			$title   = isset( $_POST['input_title_send'] ) ? sanitize_text_field( $_POST['input_title_send'] ) : die( 'invalid title' );
			$content = isset ( $_POST['content_box_send'] ) ? sanitize_textarea_field( $_POST['content_box_send'] ) : die( 'invalid content' );

			$current_user = get_current_user_id();

			if ( ! empty( $title ) ) {
				$post_id = wp_insert_post( array(
					                           'post_title'   => $title,
					                           'post_content' => $content,
					                           'post_status'  => 'draft',
					                           'post_author'  => $current_user,
				                           ) );

				$upload_file = parent::id_attachment( 'image_choice_send' );
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

				parent::loop();


			}
			wp_die( 'Error' );
		}
	}
}

New_post::getInstance();