<?php
include 'class-query-builder.php';
	class WP2CRX_AJAX
	{
		public function save()
		{
			$extension_name = trim(stripslashes($_POST['extension_name']));
			$extension_icon = trim($_POST['extension_icon']);
			$extension_description = trim(stripslashes($_POST['extension_description']));
			$sender_id = trim($_POST['sender_id']);
			$author_picture = trim($_POST['author_picture']);
			$chrome_gcm_api_key = trim($_POST['chrome_gcm_api_key']);
			
			if(!empty($extension_name)){

				update_option('wp2crx_extension_name', $extension_name);
			}

			if(!empty($extension_description)){

				update_option('wp2crx_extension_description', $extension_description);
			}

			if(!empty($extension_icon)){

				update_option('wp2crx_extension_icon', $extension_icon);
			}

			if(!empty($author_picture)){

				update_option('wp2crx_author_picture', $author_picture);
			}

			if(!empty($chrome_gcm_api_key)){
				update_option('wp2crx_chrome_gcm_api_key', $chrome_gcm_api_key);
			}

			if(!empty($sender_id)){

				update_option('wp2crx_sender_id', $sender_id);
			}

			$response = array(
					"status" => 'saved'
				);

			echo json_encode($_POST);

			die();
		}

		public function register()
		{
			echo "\n Got your id, it's cool!";
			$registrationId = $_POST['registrationId'];
			//Insert ID into table
			$table = new wp2crx_action_php_builder('wp2crx_registration_table');

			$table->create( $registrationId, 'registrationId'  );

			die();
		}
		/**
		 * Generates the chrome extension zip file, ready to be uploaded to the Chrome
		 * store.
		 * @return [type] [description]
		 */
		public function generate()
		{
			
				$WP2CRX_EXTENSION = new WP2CRX_EXTENSION;
				$WP2CRX_EXTENSION->create();
				$extension_link = $WP2CRX_EXTENSION->link();

				$response = array (

						'extension_link' => $extension_link,
					);

				echo stripslashes(json_encode($response));

			die();
		}
	}