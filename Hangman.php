<!DOCTYPE HTML>
<html>

<head>
	<title>Hangman</title>
	<link href="hangman.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<h1>Hangman</h1>
		<p>Klicken Sie auf "Neues Wort" um ein Wort zu generieren.<br>
		Geben sie dann einen Buchstaben in das Textfeld ein und klicken auf "Raten!"</p>

<form method="post" action="Hangman.php">

<?php
	session_start();

/*Buchstabe Raten*/
		if(isset($_POST['raten']))
		{
			$wort = $_SESSION['wort'];					//Das generierte Wort wird hier abgespeichert
			$falsch = $_SESSION['falsch'];				//Der Counter für Falsche Buchstaben, max. 6

			if(isset($_SESSION['notreset']))
			{
				$gefunden = $_SESSION['gefunden'];
			}
			else {
				$gefunden = $_SESSION['stern'];
			}

//			echo "Anzahl: ".$_SESSION['zz']."<br>";
//			echo "Wort: ".$wort."<br>";

/*Buchstaben suchen*/
			if(isset($_POST['buchstabe']))
			{
				$b = $_POST['buchstabe'];
				$var = 0;

				for($i = 0; $i < strlen($wort); $i++)
				{
					if(mb_strtolower($wort[$i]) == mb_strtolower($b))
					{
						$var++;
					}
				}
				echo "Anzahl der richtigen Buchstaben: ".$var."<br>";
				

/*Falls mindestens 1 gleicher Buchstabe gefunden wurde*/
				echo "Erraten: ";
				if($var > 0)
				{
					for($i = 0;$i < strlen($wort);$i++)
					{
						if($wort[$i] == $b)
						{
							$gefunden[$i] = $b;
						}
						echo $gefunden[$i];
					
						if(in_array("*", $gefunden) == false)
						{
							header('Location: gewonnen.php');
						}

					}

					$_SESSION['notreset'] = 1;
					$_SESSION['gefunden'] = $gefunden;
				}


/*Falsch geraten*/
				else {
/*					$falscha[] = array($falsch => $b);
					echo "Falsche Buchstaben: ";
					for($i = 0; $i < $falsch-1; $i++);
					{
						echo $falscha[$i];
					}
*/
/*Sterne*/
					for($i = 0; $i < strlen($wort); $i++)
					{
						echo $gefunden[$i];
					}

/*Falsch Eraten; Index Zahl wird erhöht und das Bild geladen*/
					$falsch++;
				}
				echo "<br>".$falsch."/6";
				if($falsch > 0 && $falsch <= 7)
				{
					echo "<br><img src='pic/hangman_".$falsch.".gif', id='hangman'>";
					
				}
				if($falsch >= 6) {
					header('Location: verloren.php');
				}
				$_SESSION['falsch'] = $falsch;
			}
		}


/*Neues zufälliges Wort suchen*/
		if(isset($_POST['neu']))
		{

/*Datei einlesen*/
			$h = @fopen("woerter.txt","r");
			if($h == false)
				echo "Die Datei woerter.txt wurde nicht gefunden!!";
			else {
				$arr = array();
				$zz = 0;
				while($wort = fgets ($h)){
					$zz++;
					//echo "$wort<br>";
					$arr[]=trim($wort);
				}
				fclose($h);
//				echo "Anzahl: ".$zz." <br>Wort: ";
			}
			$ii = rand(0,$zz);
			$wort = $arr[$ii];
//			echo $wort."<br>";

/*Sterne*/
			echo "Zu Erraten: ";
			for($i=0;$i < strlen($wort);$i++) 
			{
				$stern[$i] = "*";
				echo "*";
			}
			$_SESSION['stern'] = $stern;

/*Session Variablen Belegung*/
			$_SESSION['zz'] = $zz;
			$_SESSION['wort']= strtolower($wort);
			$_SESSION['falsch']= 0;
			$_SESSION['notreset']= null;
			$_SESSION['geraten']=0;
		}


/*ENDE der html seite*/
			echo "<br>Buchstabe: <input type='text' name='buchstabe'>";
			echo "<br><input type='submit' name='raten' value='Raten!'>";
			echo "<input type='submit' name='neu' value='Neues Wort'>";

?>

</form>
</body>
</html>
