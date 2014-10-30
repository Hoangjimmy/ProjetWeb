<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="css/style.css">
		<script src="js/jquery-2.1.1.min.js"></script>
		<script src="js/main.js"></script>
		<div class="page-header">
			<h1><font color=white>Chat ZZ</font><small>Prototype</small></h1>
		</div>
	</head>
	<body id= bodchat background = "assets/Down.jpg">
		<div id=messagebox>
		<text style = color:red><?php echo 'Bienvenue  ' .$_POST['Pseudo']; ?></text>
		</div>
		
		<div id=list>
			<?php echo $_POST['Pseudo']; ?>
		</div>
		
		<div id=message-input>
			<form id="form-input" action="#" method="POST">
				<input id=textbox type="text" placeholder="Ton message ici" >
				<button id=butt type="button">Envoyer</button>
			</form>
		</div>
	</body>

