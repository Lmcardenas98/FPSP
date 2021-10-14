<?php

namespace Fpsp\space;

if ( ! class_exists( 'Fpsp_received_id_link' ) ) {
	class Received_id_link extends Main_class
	{

		protected function __construct()
		{
			add_action( 'wp_ajax_received_id_link', array( $this, 'received_id_link' ) );
		}

		public function received_id_link()
		{
			parent::validate_nonce();

			$recive_id     = isset( $_POST['send_id_link'] ) ? intval( $_POST['send_id_link'] ) : die( 'invalid post' );
			$content_post  = apply_filters( 'the_content', get_post_field( 'post_content', $recive_id ) );
			$title_post    = apply_filters( 'the_title', get_post_field( 'post_title', $recive_id ) );
			$created_array = array(
				'name'    => $title_post,
				'content' => $content_post
			);
			echo json_encode( $created_array );
			die();
		}
	}
}


Received_id_link::getInstance();