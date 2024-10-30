<?php include 'wp2crx-option-values.php' ?>
<style type="text/css">
	form label {
		width: 320px;
		float: left;
	}

	li {
		padding: 10px;
	}

	li:hover {
		background-color: #FFFFEE;
	}
	.blue {
		color: #003366;
	}

	.overview {
		color: #303030;
		width: 560px;
	}
</style>

<div class="wrap" >
	<h2>Instant Blog Traffic - Connect to Browser</h2>
	<div ><h4>Help and support: <a href="mailto:projects@actionphp.com" target="_blank" >send an email.</a></h4>
	<div class="overview" >
		<h3>How it works</h3>
		<ol>
			<li><strong>This plugin allows you to instantly drive traffic to your blog by 
			notifying your readers as soon as you make a new post.</strong> It creates a 
			Chrome Browser extension, after you've filled the details below.</li>

			<li>You will then upload the automatically generated extension to the Google 
				Chrome Store</li>

			<li>All your readers have to do is to install the extension - and the plugin 
				takes care of the rest! Here is the best part:</li>
		</ol>

			<p><strong>Thanks to this plugin, you no longer have to worry about SPAM filters
				,</strong> and mailing out newsletters about your blog posts. You are reaching your readers
				directly in their browsers! <strong class="blue" >This has never been 
				possible before!</strong></p>

	</div>

	<div class="settings" >
		<h3>Extension Details</h3>

		<strong><p>Your Chrome extension will be generated for you after you have filled 
			the details below.</p></strong>
		<form>
		<ul>
			<li><label><strong>Author picture:</strong> <span class="description">( Size must be 190 x 107 )</span></label> <div class="uploader">
  <input type="text" name="author-picture" id="author-picture" value="<?php echo $author_picture; ?>" />
  <input class="button" type="button" id="author-picture-button"  value="Upload your photo"  />
</div></li>
			
			<li><label><strong>Sender ID: </strong><span class="description" >
				(You can get your Sender ID from here: (use the project number.) <a href="https://code.google.com/apis/console/" target="_blank" >https://code.google.com/apis/console/</a>)
				</span></label> <input type="text" name="sender-id" id="sender-id" 
				value="<?php echo $sender_id; ?>" class="regular-text"/>
			</li>
			<li style="margin-top: 15px;">
				<label><strong>Google GCM API KEY</strong>

				</label>
				<input type="text" name="chrome-gcm-api-key" id="chrome-gcm-api-key" value="<?php echo $chrome_gcm_api_key; ?>" class="regular-text"/>

			</li>
			
			<li style="display: none;"><label><strong>Icons:  </strong> <span class="description">(Size must be 128 x 128 )</span></label><input type="text" name="extension-icon" id="extension-icon" 
				value="<?php echo $extension_icon; ?>" />
  <input class="button" type="button" id="extension-icon-button"  value="Upload your icon"  /></li>
			
			<li><label><strong>Extension name: </strong></label> <input type="text" name="extension-name" id="extension-name" 
				value="<?php echo htmlentities( $extension_name ); ?>"  class="regular-text"/></li>
			
			<li><label><strong>Extension description: </strong></label><textarea name="extension-description" id="extension-description" 
				class="large-text" style="width: 50%; height: 75px;" ><?php echo htmlentities( $extension_description ); ?></textarea></li>
			
		</ul>
		<div >
			<input type="button" class="button-primary" name="save-changes" id="save-changes" value="Save Changes" /> 
		</div>
	</form>
		<div>
			<h3>Generate Extension</h3>

			<input type="button" class="button-secondary" name="generate-extension" id="generate-extension" value="
			Generate your extension!"/>

			<div id="extension-link" style="display: none" ><p><a class="extension-link" href="" target="_blank" >
				Click here to download your extension...</a></p>
				<p>Then upload it <a href="https://chrome.google.com/webstore/developer/dashboard" 
					target ="_blank" >here</a> <span class="description" >(Google Chrome 
					Developer Dashboard)</p>
			</div>
		</div>
	</div>
</div>
<pre>
	<?php

			
	?>
</pre>
<script type="text/javascript">

	(function(){
		var $ = jQuery;

		$('#save-changes').click(function(e){
			saveChanges();
		});
		var saveChanges = function(){


				var extension_name = $('#extension-name').val();
				var extension_description = $('#extension-description').val();
				var sender_id = $('#sender-id').val();
				var extension_icon = $('#extension-icon').val();
				var author_picture = $('#author-picture').val();
				var chrome_gcm_api_key = $('#chrome-gcm-api-key').val();

				var data = {

					extension_name : extension_name,
					extension_description: extension_description,
					sender_id: sender_id,
					extension_icon: extension_icon,
					author_picture: author_picture,
					chrome_gcm_api_key: chrome_gcm_api_key
				}

				var url = ajaxurl + '?action=wp2crx';

				$.post(
					url,

					data

					).done(function(response){

						alert('Your changes have been saved!');
						
					});

				}

	})();

	//Media upload
	
	jQuery(document).ready(function($){

	  var _custom_media = true,
	      _orig_send_attachment = wp.media.editor.send.attachment;

	  $('.button').click(function(e) {

	    var send_attachment_bkp = wp.media.editor.send.attachment;
	    var button = $(this);
	    var id = button.attr('id').replace('-button', '');
	    _custom_media = true;

	    wp.media.editor.send.attachment = function(props, attachment){
	      if ( _custom_media ) {
	        $("#"+id).val(attachment.url);
	      } else {
	        return _orig_send_attachment.apply( this, [props, attachment] );
	      };
	    }

	    wp.media.editor.open(button);
	    return false;

	  });

	  $('.add_media').on('click', function(){
	    _custom_media = false;
	  });
});


//Generate extension

	jQuery(document).ready(function($){

		$('#generate-extension').click(function(){

			var url = ajaxurl + '?action=wp2crx_generate';

			$.post( 

					url,

					function(response){

						var response = JSON.parse(response);
						$extension_link = $('#extension-link');
						$extension_link.find('.extension-link').attr('href', response.extension_link);

						$extension_link.show();
					}

				);
			
		});

	});
</script>