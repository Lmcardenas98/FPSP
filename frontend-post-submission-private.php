<?php
/**
 * Plugin Name:  frontend-post-submission-private
 * Description:  A custom form to create post as draft
 * Version:      1.0.0
 * Author:       Lmcardenas
 * Text Domain: frontend-post-submission-private
 * Domain Path: languages/
 */

namespace Fpsp\space;

defined( 'ABSPATH' ) || die();

require_once( 'classes/Main_class.php' );

if ( ! class_exists( 'Launch_class' ) ) {
	class Launch_class extends Main_class
	{

		protected function __construct()
		{

			add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
			require_once( 'classes/Shortcode_form.php' );
			require_once( 'classes/Modify_the_selected_post.php' );
			require_once( 'classes/New_post.php' );
			require_once( 'classes/Received_id_link.php' );

		}

		function load_plugin_textdomain()
		{
			load_plugin_textdomain( 'frontend-post-submission-private', false, basename( dirname( __FILE__ ) ) . '/languages' );
		}
	}
}

Launch_class::getInstance();







