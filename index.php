<?php 
session_start();

if(isset($_SESSION["user"], $_SESSION["connected"]) && $_SESSION["connected"] === true)
{
	header("Location: chat.php");
}
?>
<!DOCTYPE html>
<html>
	<head>
		<!-- Define the encoding code-->
		<meta charset="utf-8">
		<!-- Load style and javascript-->
		<link rel="stylesheet" href="css/Bootstrap/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
		<script src="js/jquery-2.1.1.min.js"></script>
		<title>Bienvenue sur mon chat</title>
		
		<?php
		if(isset($_REQUEST["alert"]))
		{
			echo "alert('". $_REQUEST["alert"] ."');";
		}
		?>
		</script>
	</head>
	<!-- Define form to enter in the chat -->
	<div class="page-header">
		<h1><font color=white id = "title">Chat ZZ</font></h1>
	</div>
	<body id=bodchat background = "assets/Down.jpg">
	<!-- Send information to the next page with post method-->
		<form id="pure-form" action="process.php?action=enterChat" method="POST">
			<fieldset>
				<input id=pseudo type="text" name="pseudo" placeholder="Pseudo"><br/>
				<button  type="submit" class="pure-button pure-button-primary" id = "butt-index">Se connecter</button>
			</fieldset>
		</form>
	</body>
</html>
