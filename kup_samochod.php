<?php
session_save_path('/zad 14.14/tmp');
session_start();

require('function_samochody.php');
require('function_sprzedane.php');
?>

<!DOCTYPE HTML> <!-- określa wersję HTML -->

<html lang="pl"> <!-- język strony www -->

<head> <!-- głowa strony, informacje zawarte tutaj nie są widoczne na stronie www jednak spełniają swoją funkcję wewnątrz strony -->


	<meta charset="utf-8" /> <!-- kodowanie strony w UTF-8 -->
	<title> Strona Firmy !</title> <!-- tytuł strony -->
	<meta name="description"  content="Strona Firmy" /> <!-- opis strony -->
	<meta name="keywords" content="Strona Firmy, temat, post /> <!-- tagi określające dziedzinę strony pomaga wyszukiwarce znalesc strony z danego zakresu przez co strona jest wyzej w wyszukiwaniu -->
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
			<div class="bigtitle">Sprzedaj Samochod </div>
			</br>
			
				<?php
					// funkcja formularza
					function formularz()
					{
						?>
						<form action="" method="POST" ENCTYPE="multipart/form-data">
						ID Samochodu: <input name="idsamochodu" type="number" min="1"></br></br>
						Kupiec: <input name="kupiec" type="text"></br></br>
						<input type="submit" name="submit" value="Sprzedaj Samochód">
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
						
						$idsamochod = ($_POST['idsamochodu']);
						$kupiec = ($_POST['kupiec']);

						if(isset($_POST["submit"]))
						{
							if(empty($_POST["idsamochodu"]) || empty($_POST["kupiec"]))
							{
								echo "<p style=\"color:red\">Musisz wypełnić wszystkie pola !</p>";
							}
							
							else
							{
								$wynik = $connect->query(" SELECT samochod.idsamochod FROM samochod WHERE samochod.idsamochod='$idsamochod' ");
								$wynik_idsamochod = $wynik->num_rows;
								
								if($wynik_idsamochod!=1)
								{
									echo "<p style=\"color:red\">Nie ma samochodu z takim ID !</p>";
								}
								
								else
								{
									$id_kupiec = $connect->query("SELECT kupiec.nazwisko FROM kupiec WHERE kupiec.nazwisko='$kupiec' ");
									$wynik_idkupiec = $id_kupiec->num_rows;
									
									if($wynik_idkupiec!=1)
									{
										$wynik = $connect->query(" INSERT INTO kupiec (idkupiec, nazwisko) VALUES ('NULL', '$kupiec') ");
									}
									
									$id_kupiec = $connect->query("SELECT kupiec.idkupiec FROM kupiec WHERE kupiec.nazwisko='$kupiec' ");
									$row = mysqli_fetch_array($id_kupiec);
									
									$idkupiec = $row['idkupiec'];
									
									$wynik = $connect->query("SELECT * FROM samochod WHERE samochod.idsamochod='$idsamochod' ");
									$row = mysqli_fetch_array($wynik);
									
									$idpracownik = $row['idpracownik'];
									$idwlasciciel = $row['idwlasciciel'];
									$idmarka = $row['idmarka'];
									$idmodel = $row['idmodel'];
									$rocznik = $row['rocznik'];
									$cena = $row['cena'];
									$data = date("Y-m-d"); 
									$procent = '0.05';
									$prowizja_komis = ($cena*$procent);
									$prowizja_pracownik = ($prowizja_komis*$procent);
									
									
									$wynik = $connect->query("INSERT INTO sprzedaz (idsprzedaz, data, idpracownik, idwlasciciel, idkupiec, idmarka, idmodel, rocznik, cena, prowizja_komis, prowizja_pracownik) 
									VALUES ('NULL', '$data', '$idpracownik', '$idwlasciciel', '$idkupiec', '$idmarka', '$idmodel', '$rocznik', '$cena', '$prowizja_komis', '$prowizja_pracownik') ");
									
									$wynik = $connect->query(" DELETE FROM samochod WHERE samochod.idsamochod='$idsamochod' ");

								}
							}
						}
					}
					
					echo '<h4><center>Samochody do sprzedania</center></h4>';
					samochody();
					
					echo '</br></br>';
					
					echo '<h4><center>Samochody sprzedane</center></h4>';
					sprzedane();
					$wynik = $connect->query(" SELECT FROM sprzedaz * ");
					
				?>
						
			
			
		</div>
		
		<div id="footer">
			Komis Samochodowy    &copy; Wszelkie prawa zastrzeżone!.    
			<b>Liczba wyświetleń: <?php include("licznik_wejsc.php"); ?> </b>
		</div>
	
	</div>

</body>

</html> <!-- koniec kodu HTML -->
