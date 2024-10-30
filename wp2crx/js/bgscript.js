(function(){
	chrome.gcm.onMessage.addListener(messageReceived);

	chrome.tabs.query({}, function(tabs) {
	  for(var i in tabs) {
	    // filter by url if needed; that would require "tabs" permission
	   // chrome.tabs.executeScript(tabs[i].id, {file: "js/script.js"});
	  }
	});

	var senderID = WP2CRX.sender_id; //OK, so we're getting this from sender_id.js, which 
// must be included earlier
	var idArray = [ senderID ];
	var registrationId = '';
	var register_url = WP2CRX.register_url;


	
	function registerCallback(registrationId) {

		registrationId = registrationId;

		
	  if (chrome.runtime.lastError) {
	    // When the registration fails, handle the error and retry the
	    // registration later.
	    return;
	  }

	  // Send the registration ID to your application server.
	 	  $.post(register_url,
	  		 {
	  		registrationId: registrationId
	  		}).done(function(response){
	  			//alert(response);
	  			console.log(response);

	  		});/**/


	    // Once the registration ID is received by your server,
	    // set the flag such that register will not be invoked
	    // next time when the app starts up.
	   
	 
	}
	function markAsRegistered(){
		 chrome.storage.local.set({registered: true});
	}

		
	  chrome.storage.local.get("registered", function(result) {
	    // If already registered, bail out.
	   // if (result["registered"])
	    //  return;
	    //  
	    //  
	
	    // Up to 100 senders are allowed.
	    var senderIds = [senderID];
	    console.log(senderIds);
	    chrome.gcm.register(senderIds, registerCallback);
	  });


	  function messageReceived(message){
	  	
	  	var content = message["data"];

	  		chrome.tabs.query({active: true, currentWindow: true}, function(tabs){
	  			var tab_id = tabs[0].id;

    				chrome.tabs.executeScript(tabs[0].id, {  file: 'js/notification.js' }, 
		    			function() {

		    			chrome.tabs.executeScript(tabs[0].id, { code:	'notify_me("pizda"); '    	});

		    		});
    			chrome.tabs.sendMessage(tabs[0].id, {content: content}, function(response) {
    				console.log(response); console.log('after sending message!');
    			});  
		
			});
	  }

	  function objectContent(theObject){
	  	return JSON.stringify(theObject, null, 4)
	  }
	})();