
// Initialisation global var
var $dom = {},
	langs = {},
	messages = {},
	color = "#000000",
	bold = false,
	italic = false,
	lastCheck = null;

// Function which set language of chat
function setLang(lang) {
	if(!langs[lang]) return;
	
	var $el, id;
//For element in dictionnary modify 	
	for(id in langs[lang]) {
		$el = $("#"+ id);
		$el.html( langs[lang][id] );
	}
//Modification of placeholder
	if(lang == "eng")
	{
		$('#textbox').attr('placeholder','Your text here');
	}else{
		$('#textbox').attr('placeholder','Ton texte ici');
		}
}
//Initialisation of color picker
function initColorPicker() {
	var $colors = $("#colors"),
		$html;
//for each color in colors.js attribute hexcode to a name
	for(var name in colors) {
		$html = $('<span style="background-color:'+ colors[name] +'" title="'+ name +'"></span>');
// Event when you click on color of color picker
		$html.on('click', function() {
			var hex = $(this).css('background-color');
			color = hex;
			$dom.input.css('color', hex);
		});
		
		$colors.append($html);
	}
}

// Get the message in chatbox
function updateMessages() {
	//Ajax request to get message from json file
	$.ajax({
		url: "ajax.php",
		cache : false,
		data: {"action": "getMessages", "fromDate" : lastCheck},
		success: function(json) {
			var msg;
			// Browse the message from server (ajax.php)
			for(var i=0; i<json.length; i++) {
				msg = json[i];
				
				if(messages[msg.id]) continue;
				// Add message to list
				messages[msg.id] = msg;
				delete messages[msg.id]["id"];
				
				//Style editing from the json
				var style = "color:"+ msg.style.color +";font-weight:"+ (msg.style.bold == "true" ? "bold" : "normal") +";";
				style += "font-style:"+ (msg.style.italic == "true" ? "italic" : "normal") +";font-family:"+ msg.style.font +";";
				
				// Display messages from the list
				$line = $("<div class='msg'><span class='pseudo'>"+ msg.user_name +" :</span></div>");
				$msg = $("<span style='"+ style +"'>"+ msg.content +"</span>");
				
				$dom.msgs.append($line.append($msg));
			}
			
			// Scroll to the bottom of windows
			$dom.msgs.scrollTop( $dom.msgs[0].scrollHeight );
			
			// register the last request
			lastCheck = moment().format("YYYY-MM-DD HH:mm:ss");
			
			// Define the time before the next check
			setTimeout(updateMessages, 2000);
		},
		// Catch the error from the request
		error : function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus +" => "+ errorThrown);
		},		
		dataType: "json"
	});
}

//
function updateUsers() {
	$.ajax({
		url: "ajax.php",
		cache : false,
		data: {"action": "updateUsers"},
		success: function(json) {
			// If user has been disconnected from server redirect him to the log page
			if(!json.connected) {
				document.location.href = "/~hoangjim/ProjetWeb/index.php?alert="+ encodeURI("Tu es resté inactif trop longtemps...");
			}
			// We flush list of user
			$dom.userList.html("");
			
			// We fill list with connected users
			for(var idx in json.users) {
				$dom.userList.append("<div>"+ json.users[idx].name +"</div>");
			}
			// Define the next update of user
			setTimeout(updateUsers, 2000);
		},
		//Catch exception from request
		error : function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus +" => "+ errorThrown);
		},		
		dataType: "json"
	});
}

// Windows on load
$(function() {
	setLang("fr");
	
	// DOM Cache
	$dom.form = $("#form-input");
	$dom.input = $dom.form.find("> input");
	$dom.send = $dom.form.find("> button");
	$dom.msgs = $("#messagebox");
	$dom.userList = $("#list");
	$dom.styleBold = $("#style-bold");
	$dom.styleItalic = $("#style-italic");
	$dom.styleColor = $("#style-color");
	$dom.styleFont = $("#style-font");
	
	$dom.send.on('click', function(event) {
		// Store the content from input frame
		var msg = $dom.input.val();
		
		//Ajax request
		$.get("ajax.php", {
			"action": "send", 
			"message": msg, 
			"color" : color,
			"bold" : bold,
			"italic" : italic,
			"font" : $dom.styleFont.val()
		});

		// Initialisation of the input frame
		$dom.input.val("");
		
		// Scroll to the bottom of chat box
		$dom.msgs.scrollTop( $dom.msgs[0].scrollHeight );
	});
	
	$dom.form.on('submit', function(event) {
		
		$dom.send.click();
		// Stop the event's spread
		// On stoppe la propagation de l'évènement
		event.preventDefault();
	});
	// Text formatting event 
	$dom.styleBold.on('click', function() {
		bold = !bold;
		
		$dom.input.css('font-weight', bold ? "bold" : "normal");
	});
	
	$dom.styleItalic.on('click', function() {
		italic = !italic;
		
		$dom.input.css('font-style', italic ? "italic" : "normal");
	});
	
	$dom.styleFont.on('click', function() {
		$dom.input.css('font-family', $(this).val());
	});
	//Check messages and users
	updateMessages();
	updateUsers();
	
	initColorPicker();
});
