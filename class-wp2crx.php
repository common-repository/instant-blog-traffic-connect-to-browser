<?php
require_once 'class-wp2crx-ajax.php';
class WP2CRX
{	
	public function run()
	{	
		//Let's add the settings link to the plugin menu page as well
		$plugin = plugin_basename('wp2crx/wp2crx.php'); 
		add_filter("plugin_action_links_$plugin", array( $this, 'plugin_settings_link') );
		
		add_action('admin_menu', array( $this, 'admin_menu'));

		//Let's add the code to receive AJAX requests. We will use another class for 
		// that purpose.
		
		$ajaxClass = new WP2CRX_AJAX;
		add_action('wp_ajax_wp2crx', array($ajaxClass, 'save'));
		//add_action('wp_ajax_no_priv_wp2crx', array($ajaxClass, 'save'));
		add_action('wp_ajax_wp2crx_register', array($ajaxClass, 'register'));
		add_action('wp_ajax_no_priv_wp2crx_register', array($ajaxClass, 'register'));
		add_action('wp_ajax_wp2crx_generate', array($ajaxClass, 'generate'));
		//add_action('wp_ajax_no_priv_wp2crx_generate', array($ajaxClass, 'generate'));
		add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );

		add_action( 'publish_post', array( $this, 'broadcast' ), 10, 2 );

		//Install tables
		$this->installTables();

	}
	public function plugin_settings_link($links) {
		  $settings_link = '<a href="admin.php?page=wp2crx">Settings</a>'; 
		  array_unshift($links, $settings_link); 
		  return $links; 
	}
 

	public function admin_menu()
	{
		$page_title = 'Instant Blog Traffic';
		$menu_title = 'Blog Traffic';
		$capability = 'manage_options';
		$menu_slug = 'wp2crx';
		$function = array( $this, 'admin_menu_page');
		$icon_url = '';
		$position = '';

		add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position ); 
	}

	public function admin_menu_page()
	{
		include_once 'admin-menu.php';
	}

	public function admin_menu_chrome_api()
	{
		# code...
	}

	public function installTables()
	{	
		global $wpdb;

			$table_name = $wpdb->prefix . "wp2crx_registration_table";

			$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (

			id mediumint(9) NOT NULL AUTO_INCREMENT,

			name varchar(256) NOT NULL,
			      
			registrationID VARBINARY(4096) NOT NULL,

			Status varchar(10) NOT NULL DEFAULT 'fresh',

			UNIQUE KEY id (id)

			);";
      
	      	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    		dbDelta($sql); 
    	}
		
		public function broadcast($ID, $post)
		{
			    $link = get_permalink( $ID );
			    $image = get_option('wp2crx_author_picture');
		        $title = $post->post_title;

		        setup_postdata( $post );
				$description = the_excerpt(140);
			    include 'class-broadcast.php';

				$broadcast = new WP2CRX_BROADCAST;

				$data = array (
						'link' => $link,
						'img'  => $image,
						'title'=> $title,
						'description' => $description
					);
				$broadcast->data($data);
				$broadcast->broadcast();
		}
}