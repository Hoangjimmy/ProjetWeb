var $dom = {};

// Lorsque le chargement est terminé
$(function() {
	
	// Cache du DOM
	$dom.form = $("#form-input");
	$dom.input = $dom.form.find("> input");
	$dom.send = $dom.form.find("> button");
	$dom.msgs = $("#messages-input");
	
	$dom.send.on('click', function(event) {
		var msg = $dom.input.val();
		
		$.get("server.php", {"action": "send", "message": msg});
		
		$dom.msgs.append("<div class = msg'>"+ msg +"</div>");
		$dom.input.val("");
	});
	
	$dom.form.on('submit', function(event) {
		
		$dom.send.click();
		
		// On stoppe la propagation de l'évènement
		event.preventDefault();
	});
});