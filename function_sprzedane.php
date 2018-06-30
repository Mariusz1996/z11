<?php
	
	function sprzedane()
	{
		require('/mysql/connection_zad15.php');
				
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
					echo '<td>ID Samochodu</td><td>Data</td><td>Pracownik</td><td>Właściciel</td><td>Kupiec</td><td>Marka</td><td>Model</td><td>Rocznik</td><td>Cena</td>';
				echo '</tr>';
			
			$wynik = $connect->query("SELECT * FROM sprzedaz ORDER BY idsprzedaz ASC");
			while($row = mysqli_fetch_array($wynik))
			{

				$idpracownik = $row['idpracownik'];
				$idwlasciciciel = $row['idwlasciciel'];
				$idkupiec = $row['idkupiec'];
				$idmarka = $row['idmarka'];
				$idmodel = $row['idmodel'];
				$rocznik = $row['rocznik'];
				$cena = $row['cena'];
				
				echo '<tr>';
					echo '<td>';	
						echo $row['idsprzedaz'];
					echo '</td>';
					
					echo '<td>';	
						echo $row['data'];
					echo '</td>';
					
					$pracownik_nazwisko = $connect->query("SELECT pracownik.nazwisko FROM pracownik WHERE pracownik.idpracownik='$idpracownik' ");
					$row = mysqli_fetch_array($pracownik_nazwisko);
				
					echo '<td>';	
						echo $row['nazwisko'];
					echo '</td>';
					
					$wlasciciel_nazwisko = $connect->query("SELECT wlasciciel.nazwisko FROM wlasciciel WHERE wlasciciel.idwlasciciel='$idwlasciciciel' ");
					$row = mysqli_fetch_array($wlasciciel_nazwisko);
					
					echo '<td>';	
						echo $row['nazwisko'];
					echo '</td>';
					
					$kupiec_nazwisko = $connect->query("SELECT kupiec.nazwisko FROM kupiec WHERE kupiec.idkupiec='$idkupiec' ");
					$row = mysqli_fetch_array($kupiec_nazwisko);
					
					echo '<td>';	
						echo $row['nazwisko'];
					echo '</td>';
					
					$marka_nazwa = $connect->query("SELECT marka.nazwa FROM marka WHERE marka.idmarka='$idmarka' ");
					$row = mysqli_fetch_array($marka_nazwa);
					
					echo '<td>';	
						echo $row['nazwa'];
					echo '</td>';
					
					$model_nazwa = $connect->query("SELECT model.nazwa FROM model WHERE model.idmodel='$idmodel' ");
					$row = mysqli_fetch_array($model_nazwa);
					
					echo '<td>';	
						echo $row['nazwa'];
					echo '</td>';
					
					echo '<td>';	
						echo $rocznik;
					echo '</td>';
						
					echo '<td>';	
						echo $cena;
					echo '</td>';
				echo '</tr>';
			}
			
			echo "</table>";
		}
	}
	
?>
