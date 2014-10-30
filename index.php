<!DOCTYPE html>
	<head>
	
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="css/style.css">
		<script src="js/jquery-2.1.1.min.js"></script>
		<script src="js/main.js"></script>
		<title>
		Bienvenue sur mon chat
		</title>
		<div class="page-header">
			<h1><font color=white>Chat ZZ</font><small>Prototype</small></h1>
		</div>
	</head>
	<body id=bodchat background = "assets/Down.jpg">
	
		<form id="pure-form" action="chat.php" method="post">
			<fieldset>
				<input id=pseudo type="text" name="Pseudo" placeholder="Pseudo"><br/>
				<label for="remember">
					<input id="remember" name ="remember" type="checkbox"> <text style = color:white> Se souvenir de moi</text>
				</label>
				
				<button  type="submit" class="pure-button pure-button-primary">Se connecter</button>
			</fieldset>
		</form>
	</body>
</html>

 
