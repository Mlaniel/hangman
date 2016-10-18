<!DOCTYPE html>
<head>
	<title>Verloren!</title>
	<link href="hangman.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<h1>DU HAST VERLOREN!</h1>
	<?php
	session_start();
	if(isset($_SESSION['wort']))
	{
		echo "Das Wort war: ".$_SESSION['wort']."<br>";
	}
	?>
	<a href="hangman.php">Neues Spiel</a>
</body>
</html>
