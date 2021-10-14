<?php

namespace Fpsp\space;

if ( ! class_exists( 'Fpsp_shortcode_form' ) ) {
	class Shortcode_form extends Main_class
	{

		protected function __construct()
		{
			add_shortcode( 'shortcode_test', array( $this, 'form_shortcode' ) );
		}

		public function asset()
		{
			add_action( 'wp_enqueue_scripts', 'style_fps' );
			wp_register_style( 'style_fps', plugins_url( '/../assets/css/stylesheet_fps.css', __FILE__ ) );
			wp_enqueue_style( 'style_fps' );
		}

		public function form_shortcode()
		{
			if ( is_user_logged_in() ) {
				ob_start();
				require_once dirname( __FILE__ ) . '/../views/form.php';
				self::asset();

				return ob_get_clean();
			} else {
				return '';
			}
		}
	}
}

Shortcode_form::getInstance();



