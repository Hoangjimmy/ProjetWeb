<?php 
// Start a session and load class in file 
session_start();
require_once("config.php");
// If user try to get this page without nickname
if(!isset($_SESSION["user"]))
{
	header("Location: index.php?alert=". urlencode("Il faut un pseudo !"));
}
//If the status of user is disconnected
else if(isset($_SESSION["connected"]) && $_SESSION["connected"] === false)
{
	header("Location: index.php?alert=". urlencode("Tu es resté inactif trop longtemps..."));
}

?>

<!DOCTYPE html>
<html>
	<head>
		<!-- Define encoding code-->
		<meta charset="utf-8">
		
		<!-- Load Style and Javascript-->
		<link rel="stylesheet" href="css/Bootstrap/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
		
		<script src="js/jquery-2.1.1.min.js"></script>
		<script src="js/moment.min.js"></script>
		<script src="js/colors.js"></script>
		<script src="js/main.js"></script>
		<script src="js/langs/fr.js"></script>
		<script src="js/langs/eng.js"></script>
		
		<title>Bienvenue sur mon chat</title>
		<!-- Use javascript to define the session-->
		<script>
			var username = "<?= $_SESSION["user"] ?>";
		</script>	
	</head>
	<body background = "assets/Down.jpg">
		<!-- Define logout and languages flag images  -->
		<a href="process.php?action=disconnect">
			<img id = "logout" src = "assets/logout.png"/>
		</a>
		<a  onClick='setLang("eng")' src= "js/main.js">
			<img id = "eng" src = "assets/english_flag.gif"/>
		</a>
		<a  onClick='setLang("fr")' src= "js/main.js">
			<img id = "fr" src = "assets/frenchflag.jpg"/>
		</a>
		<div class="page-header">
			<h1><font color="white" id="title">Chat ZZ</font></h1>	
		</div>
		<!-- Left part of style-->
		<div id = "left">
			<div id="messagebox">
			</div>
		<!--  Define the text formating space-->
			<div id="options">
				<select id="style-font">   
					<option value="Arial" selected>Arial</option>
					<option value="Calibri">Calibri</option>
					<option value="Cambria">Cambria</option>
					<option value="Candara">Candara</option>
					<option value="Tahoma">Tahoma</option>
					<option value="Verdana">Verdana</option>
				</select>
				<button id="style-bold">
					<font color="white">
						<span class="glyphicon glyphicon-bold"></span>
					</font>
				</button>
				<button id="style-italic">
					<font color="white">
						<span class="glyphicon glyphicon-italic"></span>
					</font>
				</button>
				<div id="colors"></div>
			</div>
			<!-- Define the input box (where the user type his text)-->
			<div id="message-input">
				<form id="form-input" action="#" method="POST">
					<input id=textbox name=msg type="text" placeholder= "Ton message ici">
					<button id=butt type="button">  <font id="button1">Envoyer</font> </button>
				</form>
			</div>
		</div>
		<!-- Right side of the style contains the online users list-->
		<div id = "right">
			<div id="list">
			</div>
		</div>	
	</body>
</html>
