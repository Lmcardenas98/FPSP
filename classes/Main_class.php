<?php

namespace Fpsp\space;

class Main_class
{

	public static function validate_nonce()
	{
		$nonce = isset( $_POST['_wpnonce'] ) ? $_POST['_wpnonce'] : die( 'invalid nonce' );
		if ( ! wp_verify_nonce( $nonce, 'form_nonce' ) ) {
			die( 'invalid nonce' );
		}
	}

	public static function id_attachment( $arg )
	{
		$file = isset( $_FILES[ $arg ] ) ? $_FILES[ $arg ] : '';

		return wp_upload_bits( sanitize_text_field( $file["name"] ), null, file_get_contents( sanitize_text_field( $file["tmp_name"] ) ) );
	}

	public static function loop()
	{
		$current_user = get_current_user_id();

		$query = new \WP_Query( array(
			                        'post_status' => 'draft',
			                        'author'      => $current_user,
		                        ) );

		if ( $query->have_posts() ) {
			echo '<ul>';
			while ( $query->have_posts() ) {
				$query->the_post();
				echo sprintf( "<li id='fpsp_post_list'><a class=\"def_link\" href=\"%s\" a>%s</li>", esc_url( get_permalink( get_the_ID() ) ), get_the_title() );
			}
			echo '</ul>';
		} else {
			echo 'no posts found';
		}
		wp_reset_postdata();
	}

	public static function getInstance()
	{
		static $instance = null;
		if ( null === $instance ) {
			$instance = new static();
		} else {
			wp_die();
		}

		return $instance;
	}
}
