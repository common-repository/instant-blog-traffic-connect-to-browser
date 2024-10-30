<?php
include 'class-chrome-notify.php';
include_once 'class-query-builder.php';

class WP2CRX_BROADCAST
{

	public function data($data=array())
	{
		$this->data = $data;
	}

	public function broadcast()
	{
		$notify = new ChromeNotify;

		$notify->setData($this->data);
		$notify->setIds($this->getRegistrationIds());
		//TODO - save API key in get options
		$apiKey = get_option('wp2crx_chrome_gcm_api_key');

		$notify->setApiKey($apiKey);

		$notify->notify();
/*print_r(get_defined_vars());
die()*/;
		print_r($notify);
	}

	public function getRegistrationIds()
	{
		$table = new wp2crx_action_php_builder('wp2crx_registration_table');

		$registrationIds = $table->get();

		$ids = array();

		foreach ($registrationIds as $id ) {

			if(!in_array($id->registrationID, $ids)){

				$ids[] = $id->registrationID;	
			}
		}

		return $ids;
	}
}