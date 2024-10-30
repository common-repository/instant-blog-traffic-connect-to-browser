
(function(){
	
	chrome.runtime.onMessage.addListener(function(msg, sender, sendResponse) {
		
				console.log('extension message listener!');
	
	
			var content = msg.content;
	
			var link = content.link;
			var img  = content.img;
			var description = content.description;
			var title = content.title;
	
			var html = '<div id="fresh-content" style="font-size: 11px !important; width: 200px !important; max-width: 200px !important; max-height: 400px !important; padding: 5px !important; border: 1px #ccc solid !important; bottom: 10px !important; right: 10px !important; display: none; background-color: #fff !important; z-index: 9999999 !important; position: fixed !important; ">'
	
			+
	
			'<div id="img-box" ><a id="image-link" ><div id="content-image" style="	height: 107px !important; width: 190px !important; max-height: 107px !important; max-width: 190px !important; padding: 3px !important; border: 1px #eee solid !important;"></div></a></div>'
			
			+
			
			'<div id="title" style="width: 190px !important; margin:5px auto !important;" ><a id="title-link" style="color: #191919 !important; font-size: 16px !important; font-weight: bold !important; text-decoration: none !important; line-height: 20px !important; text-align: center !important; font-family: "Times New Roman" !important; margin: 5px 0 !important; letter-spacing: 1.1 !important;"></a></div>'
	
			+
	
			'<div id="description" style="font-family: "lucida grande", tahoma, verdana, arial, sans-serif !important; text-align: left !important; margin: 5px 0 !important; color: #333 !important; font-size: 11px !important; line-height: 19px !important;"></div>'
	
			+
	
			'</div>';
	
			var $html = $(html);
	
			$image_link = $html.find('#image-link');
			$image = $html.find('#content-image');
			$title_link = $html.find('#title-link');
			$description = $html.find('#description');
		
			$image_link.attr( "href", link );
			$image.css( "background-image", "url(" + img + ")" );
			$description.text( description );
			$title_link.text( title );
			$title_link.attr("href", link );
	
			$('body').append($html);
			$html.velocity("fadeIn", { duration: 800 });
	
	sendResponse({status: 'received'});
	
		/*	$ = $html.find('#')  ;
			$ = $html.find('#')  ;
			$ = $html.find('#')  ;*/
		});
	
	})();