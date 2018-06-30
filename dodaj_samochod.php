<?php
session_save_path('/zad 14.14/tmp');
session_start();

require('function_samochody.php');
?>

<!DOCTYPE HTML> <!-- określa wersję HTML -->

<html lang="pl"> <!-- język strony www -->

<head> <!-- głowa strony, informacje zawarte tutaj nie są widoczne na stronie www jednak spełniają swoją funkcję wewnątrz strony -->


	<meta charset="utf-8" /> <!-- kodowanie strony w UTF-8 -->
	<title> Komis Samochodowy !</title> <!-- tytuł strony -->
	<meta name="description"  content="Komis Samochodowy" /> <!-- opis strony -->
	<meta name="keywords" content="Komis Samochodowy /> <!-- tagi określające dziedzinę strony pomaga wyszukiwarce znalesc strony z danego zakresu przez co strona jest wyzej w wyszukiwaniu -->
	<meta http-equiv="X-UA-Compatibile" content="IE=edge,chrome=1" /> <!-- wyświetlanie strony w IE w maksymalnych wielkościach -->
	<link rel="stylesheet" href="style.css" type="text/css" />
	
</head>

<body> <!-- ciało strony, wszystko co widoczne jest na stronie www. -->

	<div id="container">
	
		<div id="logo">
		<a href="index.php"><span style="color: #dd5849;"><i><center>Komis Samochodowy</center></span></i></a>
		</div>
		
		<div id="menu">
		
			<div class="option"><a class="linkmenu1" href="index.php">Strona Główna</a> </div>
			<div class="option"><a class="linkmenu1" href="dodaj_samochod.php">Dodaj samochod</a> </div>
			<div class="option"><a class="linkmenu1" href="kup_samochod.php">Kup samochod</a> </div>

			<div style="clear:both;"> </div>
			
		</div>
		
		<div id="topbar">
		
			<div class="topbarleft">
			</div>
			
			<div class="topbarright">
			
			</div>
			<div style="clear:both;"> </div>
		</div>
		
		<div id="sidebar">
			
		</div>
		
		<div id="content">
			<div class="bigtitle">Dodaj Samochod </div>
			</br>

				<?php
					// funkcja formularza
					function formularz()
					{
						?>
						<form action="" method="POST" ENCTYPE="multipart/form-data">
						Pracownik: <input name="pracownik" type="text"></br></br>
						Właściciel: <input name="wlasciciel" type="text"></br></br>
						Marka: <input name="marka" type="text"></br></br>
						Model: <input name="model" type="text"></br></br>
						Rok Produkcji: <input name="rok" type="text"></br></br>
						Cena: <input name="cena" type="number" min="1"></br></br>
						<input type="submit" name="submit" value="Dodaj Samochód">
						</br>
						</br>
						</form>
						<?php
					}
				?>
				
				<?php formularz() ?>
				
				
				<?php
				
				require_once ('/mysql/connection_zad15.php');
				
				$connect = @new mysqli($host, $db_user, $db_password, $db_name);
									
				if($connect->connect_errno!=0)
				{
					echo 'MySQL Error: ' . $connect->connect_errno;
				}
									
				else
				{
					mysqli_query($connect, "SET CHARSET utf8");
					mysqli_query($connect, "SET NAMES `utf8` COLLATE `utf8_polish_ci`");
					
					// zmienne
					$pracownik = ($_POST["pracownik"]);
					$wlasciciel = ($_POST["wlasciciel"]);
					$marka = ($_POST["marka"]);
					$model = ($_POST["model"]);
					$rok = ($_POST["rok"]);
					$cena = ($_POST["cena"]);
					
					
					if(isset($_POST["submit"]))
					{
						if(empty($_POST["pracownik"]) || empty($_POST["wlasciciel"]) || empty($_POST["marka"]) || empty($_POST["model"]) || empty($_POST["rok"])
						|| empty($_POST["cena"]))
						{
							echo "<p style=\"color:red\">Musisz wypełnić wszystkie pola !</p>";
						}
						
						else
						{
							$wynik_pracownik = $connect->query(" SELECT idpracownik, nazwisko FROM pracownik WHERE nazwisko='$pracownik' ");
							$pracownik_nazwisko = $wynik_pracownik->num_rows;
								
							if($pracownik_nazwisko!=1)
							{
								$wynik_pracownik = $connect->query(" INSERT INTO pracownik (idpracownik, nazwisko) VALUES ('NULL', '$pracownik') ");
								
								$wynik_pracownik = $connect->query(" SELECT idpracownik, nazwisko FROM pracownik WHERE nazwisko='$pracownik' ");
							}
							
							$row_pracownik = mysqli_fetch_array($wynik_pracownik);
							$idpracownik = $row_pracownik['idpracownik'];
							
							
							$wynik_wlasciciel = $connect->query(" SELECT idwlasciciel, nazwisko FROM wlasciciel WHERE nazwisko='$wlasciciel' ");
							$wlasciciel_nazwisko = $wynik_wlasciciel->num_rows;
							
							if($wlasciciel_nazwisko!=1)
							{
								$wynik = $connect->query(" INSERT INTO wlasciciel (idwlasciciel, nazwisko) VALUES ('NULL', '$wlasciciel') ");
								
								$wynik_wlasciciel = $connect->query(" SELECT idwlasciciel, nazwisko FROM wlasciciel WHERE nazwisko='$wlasciciel' ");
							}
							
							$row_wlasciciel = mysqli_fetch_array($wynik_wlasciciel);
							$idwlasciciel = $row_wlasciciel['idwlasciciel'];
							
							
							$wynik_marka = $connect->query(" SELECT idmarka, nazwa FROM marka WHERE nazwa='$marka' ");
							$marka_nazwa = $wynik_marka->num_rows;
							
							if($marka_nazwa!=1)
							{
								$wynik_marka = $connect->query(" INSERT INTO marka (idmarka, nazwa) VALUES ('NULL', '$marka') ");
								
								$wynik_marka = $connect->query(" SELECT idmarka, nazwa FROM marka WHERE nazwa='$marka' ");
							}
							
							$row_marka = mysqli_fetch_array($wynik_marka);
							$idmarka = $row_marka['idmarka'];
							
							
							$wynik_model = $connect->query(" SELECT idmodel, nazwa FROM model WHERE nazwa='$model' ");
							$model_nazwa = $wynik_model->num_rows;
							
							if($model_nazwa!=1)
							{
								$wynik = $connect->query(" INSERT INTO model (idmodel, idmarka, nazwa) VALUES ('NULL', '$idmarka', '$model') ");
								
								$wynik_model = $connect->query(" SELECT idmodel, nazwa FROM model WHERE nazwa='$model' ");
							}
							
							$row_model = mysqli_fetch_array($wynik_model);
							$idmodel = $row_model['idmodel'];
							$data = date("Y-m-d");
							
							
							$wynik_samochod = $connect->query(" INSERT INTO samochod (idsamochod, data, idpracownik, idwlasciciel, idmarka, idmodel, rocznik, cena)
							VALUES ('NULL', '$data', '$idpracownik', '$idwlasciciel', '$idmarka', '$idmodel', '$rok', '$cena') ");
							
							echo "<p style=\"color:green\">Samochód został pomyślnie dodany !</p></br></br>";
							samochody();
						}
					}
				}
				
				?>
				
		</div>
		
		<div id="footer">
			Komis Samochodowy   &copy; Wszelkie prawa zastrzeżone!.    
			<b>Liczba wyświetleń: <?php include("licznik_wejsc.php"); ?> </b>
		</div>
	
	</div>

</body>

</html> <!-- koniec kodu HTML -->
