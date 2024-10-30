<?php

class WP2CRX_EXTENSION
{	

	public function __construct()
	{
		
		include 'wp2crx-option-values.php';

		/*$extension_name = str_replace('"', '\\"', $extension_name);
		$extension_description = str_replace('"', '\\"', $extension_description);*/

		$this->extension_name = str_replace('"', '\\"', $extension_name);
		$this->extension_description = str_replace('"', '\\"', $extension_description);
		$this->extension_icon = $extension_icon;
		$this->sender_id = $sender_id;
		$this->dir_path = $this->dir_path(); //This gices us the path to the upload 
// directory where the extension will be stored.


		//We will need the ajax url for this WP site.
		$this->register_url = admin_url( 'admin-ajax.php' ) . '?action=wp2crx_register';
		

	}

	public function create()
	{	
		
		$crx_path = $this->dir_path; //Our destination path for the Chrome extension

		$src =  plugin_dir_path( __FILE__ ); //This is are the source files for our 
// extensions.
		$src .= 'wp2crx';

		//OK, so let's begin by copying all the files to our extension folder.
		$this->copy_dir($src, $crx_path);

		//Let's create the manifest
		$this->manifest();

		//And last but not the least, the config file.
		$this->config();

		//As the last step, we will generate the extension for you.
		$zipped = $this->zip($crx_path, $crx_path . '../wp_chrome_extension.zip');


		$this->extension_link = $this->dir_path ( '/wp_chrome_extension.zip');

	}

	public function config()
	{	

		//So let's create the content for our config file
		//This will allow us to inject all the necessary data
		//We get from our user on Wordpress

		$config = "window.WP2CRX = {

			register_url : '" . $this->register_url ."',
			sender_id: '" . $this->sender_id ."'
		}
		";

		//We are going to send the file straight to the upload directory where our 
// extension is stored.
		
		$path = $this->dir_path . 'js/config.js' ;

		file_put_contents($path, $config); 

	}

	public function manifest()
	{	
		//The path to our manifest file.
		$manifest = $this->dir_path ;
		$manifest .= 'manifest.json';

		$data = '{
		  "manifest_version": 2,
		
		  "name": "' . $this->extension_name . '",
		  "description": "' . $this->extension_description .'",
		  "version": "1.0",
		  "permissions": [
		    "http://*/*",
		    "https://*/*",
		    "<all_urls>",
		    "notifications",
		    "gcm",
		    "storage",
		    "tabs"
		  ],
		  "background": {
		    "scripts": ["js/jquery.js", "js/config.js", "js/bgscript.js"]
		  },
		   "content_scripts": [
		    {
		      "matches": ["<all_urls>", "http://*/*", "https://*/*"],
		      "css": ["css/style.css"],
		      "js": ["js/jquery.js", "js/jquery.velocity.min.js","js/script.js"]
		    }
		  ],
		  
		  "browser_action": {
		    "default_icon": "icon.png"
		  }
		}';

		
		file_put_contents($manifest, $data);
		
	}

	protected function dir_path($dir='/wp2crx/'){

		$upload_dir = wp_upload_dir();

		$path = $upload_dir['path'];
		//Path to where we want to store our exension
		
		$path  .=   $dir;

		if(!file_exists($path)){
			mkdir($path);
		}

		return $path;
	}

	public function copy_dir( $src, $dst ) { 
	   
	    $dir = opendir($src); 

	    	  

	    @mkdir($dst); 
	    while(false !== ( $file = readdir($dir)) ) { 

	        if (( $file != '.' ) && ( $file != '..' )) { 
	            if ( is_dir($src . '/' . $file) ) { 
	                $this->copy_dir($src . '/' . $file,$dst  . $file); 
	            } 
	            else { 
	                copy($src . '/' . $file,$dst . '/' . $file); 
	            } 
	        } 
	    } 
	    closedir($dir); 

	}

	public function zip($source, $destination)
{  
   /* if (!extension_loaded('zip') || !file_exists($source)) {
        return false;
    }*/
    $zip = new ZipArchive();
    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
        return false;
    }

    $source = str_replace('\\', '/', realpath($source));

    if (is_dir($source) === true)
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file)
        {
            $file = str_replace('\\', '/', $file);

            // Ignore "." and ".." folders
            if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
                continue;

            $file = realpath($file);

            if (is_dir($file) === true)
            {
                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
            }
            else if (is_file($file) === true)
            {
                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
            }
        }
    }
    else if (is_file($source) === true)
    {
        $zip->addFromString(basename($source), file_get_contents($source));
    }

    $zipped = $zip->close();

    return $zipped;
	}
	

	public function link()
	{	
		$extension_link = $this->extension_link;
		
		$extension_link = str_replace('\\', '', $extension_link);

		$extension_link = str_replace(ABSPATH, site_url() . '/', $extension_link);

		return $extension_link;

	}

	public function icon()
	{
		# code...
	}
}