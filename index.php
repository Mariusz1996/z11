<?php
session_save_path('/zad 14.14/tmp');
session_start();
?>

<!DOCTYPE HTML> <!-- określa wersję HTML -->

<html lang="pl"> <!-- język strony www -->

<head> <!-- głowa strony, informacje zawarte tutaj nie są widoczne na stronie www jednak spełniają swoją funkcję wewnątrz strony -->


	<meta charset="utf-8" /> <!-- kodowanie strony w UTF-8 -->
	<title> Komis Samochodowy !</title> <!-- tytuł strony -->
	<meta name="description"  content="Komis Samochodowy" /> <!-- opis strony -->
	<meta name="keywords" content="Komis Samochodowy/> <!-- tagi określające dziedzinę strony pomaga wyszukiwarce znalesc strony z danego zakresu przez co strona jest wyzej w wyszukiwaniu -->
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
			<div class="bigtitle">Komis Samochodowy </div>
			</br>
				
				<center>1. Prowizja pracowników ze sprzedaży poszczególnych samochodów (5 % od prowizji komisu).</br></br></center>
				
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
						
						echo '<table align="center" border="1">';
							echo '<tr>';
								echo '<td>Nazwisko</td><td>Prowizja</td>';
							echo '</tr>';
							
								$sprzedaz = $connect->query("SELECT DISTINCT sprzedaz.idpracownik FROM sprzedaz ");
								while($row= mysqli_fetch_array($sprzedaz))
								{
									$id_pracownik = $row['idpracownik'];
									
									
									$nazwisko = $connect->query("SELECT pracownik.nazwisko FROM pracownik WHERE pracownik.idpracownik='$id_pracownik' ");
									$row= mysqli_fetch_array($nazwisko);
									
									echo '<tr>';
										echo '<td>';	
											echo $row['nazwisko'];
										echo '</td>';
									
									$sprzedane = $connect->query("SELECT SUM(sprzedaz.prowizja_pracownik) FROM sprzedaz WHERE sprzedaz.idpracownik='$id_pracownik' ");
									$row = mysqli_fetch_array($sprzedane);
									
									echo '<td>';	
										echo $row['0'];
									echo '</td>';
								}
								
							echo '</tr>';
						echo '</table>' . '</br></br>';
						
						
						echo '<center>2. Prowizje pracowników z podziałem na marki samochodów.</br></br></center>';
						
						echo '<table align="center" border="1">';
							echo '<tr>';
								echo '<td>Nazwisko</td><td>Marka</td><td>Prowizja</td>';
							echo '</tr>';
							
									$marka = $connect->query("SELECT DISTINCT sprzedaz.idmarka FROM sprzedaz ");
									while($row = mysqli_fetch_array($marka))
									{
										$id_marka = $row['idmarka'];
										
										
										$pracownik = $connect->query("SELECT DISTINCT sprzedaz.idpracownik FROM sprzedaz WHERE sprzedaz.idmarka='$id_marka' ");
										while($row = mysqli_fetch_array($pracownik))
										{
											$id_pracownik = $row['idpracownik'];
											
											
											$nazwisko_pracownik = $connect->query("SELECT pracownik.nazwisko FROM pracownik WHERE pracownik.idpracownik='$id_pracownik' ");
											$row= mysqli_fetch_array($nazwisko_pracownik);
											
											echo '<tr>';
												echo '<td>';	
													echo $row['nazwisko'];
												echo '</td>';
												
												
											$nazwa_marka = $connect->query("SELECT marka.nazwa FROM marka WHERE marka.idmarka='$id_marka' ");
											$row= mysqli_fetch_array($nazwa_marka);
											
												echo '<td>';	
													echo $row['nazwa'];
												echo '</td>';
												
												
											$wynik = $connect->query("SELECT SUM(sprzedaz.prowizja_pracownik) FROM sprzedaz WHERE sprzedaz.idpracownik='$id_pracownik' AND sprzedaz.idmarka='$id_marka' ");
											$row= mysqli_fetch_array($wynik);
											
												echo '<td>';	
													echo $row['0'];
												echo '</td>';
										}
									}
											echo '</tr>';
						echo '</table>' . '</br></br>';
						
						
						echo '<center>3. Prowizje pracowników z podziałem na roczniki samochodów.</br></br></center>';
						
						echo '<table align="center" border="1">';
							echo '<tr>';
								echo '<td>Nazwisko</td><td>Rocznik</td><td>Prowizja</td>';
							echo '</tr>';
							
								$sprzedaz_rocznik = $connect->query("SELECT DISTINCT sprzedaz.rocznik FROM sprzedaz ORDER BY sprzedaz.rocznik ASC ");
								while($row = mysqli_fetch_array($sprzedaz_rocznik))
								{
									$rocznik = $row['rocznik'];
										
										
									$pracownik = $connect->query("SELECT DISTINCT sprzedaz.idpracownik FROM sprzedaz WHERE sprzedaz.rocznik='$rocznik' ");
									while($row = mysqli_fetch_array($pracownik))
									{
										$id_pracownik = $row['idpracownik'];
											
											
										$nazwisko_pracownik = $connect->query("SELECT pracownik.nazwisko FROM pracownik WHERE pracownik.idpracownik='$id_pracownik' ");
										$row= mysqli_fetch_array($nazwisko_pracownik);
											
										echo '<tr>';
											echo '<td>';	
												echo $row['nazwisko'];
											echo '</td>';
												
												
										$nazwa_marka = $connect->query("SELECT sprzedaz.rocznik FROM sprzedaz WHERE sprzedaz.rocznik='$rocznik' ");
										$row= mysqli_fetch_array($nazwa_marka);
											
											echo '<td>';	
												echo $row['rocznik'];
											echo '</td>';
												
												
										$wynik = $connect->query("SELECT SUM(sprzedaz.prowizja_pracownik) FROM sprzedaz WHERE sprzedaz.idpracownik='$id_pracownik' AND sprzedaz.rocznik='$rocznik' ");
										$row= mysqli_fetch_array($wynik);
											
											echo '<td>';	
												echo $row['0'];
											echo '</td>';
									}
								}
										echo '</tr>';
						echo '</table>' . '</br></br>';
						
						
						echo '<center>4. Łączne prowizje poszczególnych pracowników.</br></br></center>';
						
						echo '<table align="center" border="1">';
							echo '<tr>';
								echo '<td>Nazwisko</td><td>Prowizja</td>';
							echo '</tr>';
							
								$sprzedaz_pracownik = $connect->query("SELECT DISTINCT sprzedaz.idpracownik FROM sprzedaz ");
								while($row = mysqli_fetch_array($sprzedaz_pracownik))
								{
									$id_pracownik = $row['idpracownik'];
									
									$pracownik_nazwisko = $connect->query("SELECT pracownik.nazwisko FROM pracownik WHERE pracownik.idpracownik='$id_pracownik' ");
									$row = mysqli_fetch_array($pracownik_nazwisko);
									
									echo '<tr>';
										echo '<td>';	
											echo $row['nazwisko'];
										echo '</td>';
										
										
									$sprzedaz = $connect->query("SELECT SUM(sprzedaz.prowizja_pracownik) FROM sprzedaz WHERE sprzedaz.idpracownik='$id_pracownik' ");
									$row = mysqli_fetch_array($sprzedaz);
									
										echo '<td>';	
											echo $row['0'];
										echo '</td>';
								}
									echo '</tr>';
						echo '</table>' . '</br></br>';	
						
						
						echo '<center>5. Łączna prowizja wszystkich pracowników.</br></br></center>';
						
						echo '<table align="center" border="1">';
							echo '<tr>';
								echo '<td>Prowizja</td>';
							echo '</tr>';
							
								$sprzedaz = $connect->query("SELECT SUM(sprzedaz.prowizja_pracownik) FROM sprzedaz ");
								while($row = mysqli_fetch_array($sprzedaz))
								{
									echo '<tr>';
										echo '<td>';	
											echo $row['0'];
										echo '</td>';
								}
									echo '</tr>';
						echo '</table>' . '</br></br>';
						
						
						echo '<center>6. Zysk komisu ze sprzedaży poszczególnych samochodów (zmniejszony o prowizję pracowników).</br></br></center>';
						
						echo '<table align="center" border="1">';
							echo '<tr>';
								echo '<td>Samochód</td><td>Rocznik</td><td>Cena</td><td>Zysk</td>';
							echo '</tr>';
							
								$sprzedaz = $connect->query("SELECT sprzedaz.prowizja_komis, sprzedaz.prowizja_pracownik, sprzedaz.idmarka, sprzedaz.idmodel, sprzedaz.rocznik, sprzedaz.cena FROM sprzedaz ");
								while($row = mysqli_fetch_array($sprzedaz))
								{
									$prowizja_komis = $row['prowizja_komis'];
									$prowizja_pracownik = $row['prowizja_pracownik'];
									$id_marka = $row['idmarka'];
									$id_model = $row['idmodel'];
									$rocznik = $row['rocznik'];
									$cena = $row['cena'];
									$faktyczna_prowizja_komis = ($prowizja_komis-$prowizja_pracownik);
									
									
									$marka = $connect->query(" SELECT marka.nazwa FROM marka WHERE marka.idmarka='$id_marka' ");
									$row = mysqli_fetch_array($marka);
									
									$nazwa_marka = $row['nazwa'];
									
									$model = $connect->query(" SELECT model.nazwa FROM model WHERE model.idmodel='$id_model' ");
									$row = mysqli_fetch_array($model);
									
									$nazwa_model = $row['nazwa'];
									
										echo '<tr>';
											echo '<td>';	
												echo $nazwa_marka . ' ' . $nazwa_model;
											echo '</td>';
											
											echo '<td>';	
												echo $rocznik;
											echo '</td>';
											
											echo '<td>';	
												echo $cena;
											echo '</td>';
											
											echo '<td>';	
												echo $faktyczna_prowizja_komis;
											echo '</td>';
								}
										echo '</tr>';
						echo '</table>' . '</br></br>';
						
						
						echo '<center>7. Zysk komisu z podziałem na marki samochodów (zmniejszony o prowizję pracowników).</br></br></center>';
						
						echo '<table align="center" border="1">';
							echo '<tr>';
								echo '<td>Marka</td><td>Zysk</td>';
							echo '</tr>';
							
								$marka = $connect->query("SELECT DISTINCT sprzedaz.idmarka FROM sprzedaz ");
								while($row = mysqli_fetch_array($marka))
								{
									$id_marka = $row['idmarka'];
													
									$nazwa_marka = $connect->query("SELECT marka.nazwa FROM marka WHERE marka.idmarka='$id_marka' ");
									$row= mysqli_fetch_array($nazwa_marka);
										
										echo '<tr>';
											echo '<td>';	
												echo $row['nazwa'];
											echo '</td>';
												
									$sprzedaz_prowizja_komis = $connect->query("SELECT SUM(sprzedaz.prowizja_komis) FROM sprzedaz WHERE sprzedaz.idmarka='$id_marka' ");
									$row= mysqli_fetch_array($sprzedaz_prowizja_komis);

										$suma_prowizja_komis = $row['0'];
									
									$sprzedaz_prowizja_pracownik = $connect->query("SELECT SUM(sprzedaz.prowizja_pracownik) FROM sprzedaz WHERE sprzedaz.idmarka='$id_marka' ");
									$row= mysqli_fetch_array($sprzedaz_prowizja_pracownik);
											
										$suma_prowizja_pracownik = $row['0'];
										
										$zysk_komis = ($suma_prowizja_komis-$suma_prowizja_pracownik);
										
											echo '<td>';	
												echo $zysk_komis;
											echo '</td>';
								}
										echo '</tr>';
						echo '</table>' . '</br></br>';
						
						
						echo '<center>8. Zysk komisu z podziałem na roczniki samochodów (zmniejszony o prowizję pracowników).</br></br></center>';
						
						echo '<table align="center" border="1">';
							echo '<tr>';
								echo '<td>Rocznik</td><td>Zysk</td>';
							echo '</tr>';
							
								$sprzedaz_rocznik = $connect->query("SELECT DISTINCT sprzedaz.rocznik FROM sprzedaz ORDER BY sprzedaz.rocznik ASC ");
								while($row = mysqli_fetch_array($sprzedaz_rocznik))
								{
									$rocznik = $row['rocznik'];
										
									echo '<tr>';
										echo '<td>';	
											echo $row['rocznik'];
										echo '</td>';
										
									$sprzedaz_prowizja_komis = $connect->query("SELECT SUM(sprzedaz.prowizja_komis) FROM sprzedaz WHERE sprzedaz.rocznik='$rocznik' ");
									$row= mysqli_fetch_array($sprzedaz_prowizja_komis);
									
										$suma_prowizja_komis = $row['0'];
										
									$sprzedaz_prowizja_pracownik = $connect->query("SELECT SUM(sprzedaz.prowizja_pracownik) FROM sprzedaz WHERE sprzedaz.rocznik='$rocznik' ");
									$row= mysqli_fetch_array($sprzedaz_prowizja_pracownik);
									
										$suma_prowizja_pracownik = $row['0'];
										
										$zysk_komis = ($suma_prowizja_komis-$suma_prowizja_pracownik);
									
										echo '<td>';	
											echo $zysk_komis;
										echo '</td>';
								}
									echo '</tr>';
						echo '</table>' . '</br></br>';
						
						
						echo '<center>9. Łączny zysk komisu (zmniejszony o łączną prowizję pracowników).</br></br></center>';
						
						echo '<table align="center" border="1">';
							echo '<tr>';
								echo '<td>Zysk</td>';
							echo '</tr>';
							
								$sprzedaz_prowizja_komis = $connect->query("SELECT SUM(sprzedaz.prowizja_komis) FROM sprzedaz ");
								$row= mysqli_fetch_array($sprzedaz_prowizja_komis);
									
									$suma_prowizja_komis = $row['0'];
										
								$sprzedaz_prowizja_pracownik = $connect->query("SELECT SUM(sprzedaz.prowizja_pracownik) FROM sprzedaz ");
								$row= mysqli_fetch_array($sprzedaz_prowizja_pracownik);
									
									$suma_prowizja_pracownik = $row['0'];
										
									$zysk_komis = ($suma_prowizja_komis-$suma_prowizja_pracownik);
									
									echo '<tr>';
										echo '<td>';	
											echo $zysk_komis;
										echo '</td>';
									echo '</tr>';
						echo '</table>' . '</br></br>';
					}
				?>
				
				
		</div>
		
		<div id="footer">
			Komis Samochodowy    &copy; Wszelkie prawa zastrzeżone!.    
			<b>Liczba wyświetleń: <?php include("licznik_wejsc.php"); ?> </b>
		</div>
	
	</div>

</body>

</html> <!-- koniec kodu HTML -->
