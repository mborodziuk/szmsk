<?php
	if ( empty($_POST[od_rok]) && empty($_POST[od_miesiac]) && empty($_POST[od_dzien]) ) 
		{	
			$_POST[od_rok]=date("Y");
			$_POST[od_miesiac]=date("01");
			$_POST[od_dzien]=date("01");
		}

	if ( empty($_POST[do_rok]) && empty($_POST[do_miesiac]) && empty($_POST[do_dzien]) ) 
		{	
			$_POST[do_rok]=date("Y");
			$_POST[do_miesiac]=date("m");
			$_POST[do_dzien]=date("d");
		}

	if (empty($_POST[usunieta]))
		$_POST[usunieta]="Nieusunięte";
	if (empty($_POST[stan]))
		$_POST[stan]="Wszystkie";


		$p=array
		(	'stary_abon' 		=> $_POST[stary_abon], 'nowy_abon' => $_POST[nowy_abon],
			'data_od' => "$_POST[od_rok]"."-"."$_POST[od_miesiac]"."-"."$_POST[od_dzien]",
		 	'data_do'	=> "$_POST[do_rok]"."-"."$_POST[do_miesiac]"."-"."$_POST[do_dzien]",
		);

?>

<a href="index.php?panel=fin&menu=dodajcesje"> Nowa cesja </a> &nbsp;
<br/>
<br/>

<form method="POST" action="index.php?panel=fin&menu=cesje">
<table style="text-align: center; width: <?php echo $conf[width2];?>; height:<?php echo $conf[height2];?>" class="tbk1">
  <tbody>
    <tr class="tr1">
      <td style="width: 80px;"> 
			Od dnia 
		</td>
      <td>
			<?php
				$lata=array($_POST[od_rok]);
				for ($i=1; $i<=10; ++$i)
					{
						$rok1=$_POST[od_rok]+$i;
						$rok2=$_POST[od_rok]-$i;
						array_push($lata, $rok1);
						array_unshift($lata, $rok2);
					}
				$www->SelectFromArray($lata,"od_rok", $_POST[od_rok]); 
			?>
		</td> 
	   <td style="width: 20px;">
			<?php
				$miesiace=array("01","02","03","04","05","06","07","08","09","10","11","12");
				$www->SelectFromArray($miesiace,"od_miesiac", $_POST[od_miesiac]); 
			?>
		</td>
	   <td style="width: 20px;">
			<?php
				$dni=array("01","02","03","04","05","06","07","08","09","10","11","12", "13","14","15",
								"16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
				$www->SelectFromArray($dni,"od_dzien", $_POST[od_dzien]); 
			?>
		</td>
      <td> Stary Abonent  </td>
      <td> Nowy Abonent  </td>
      <td> Wyślij  </td>
    </tr>
    <tr class="tr1">
      <td style="width: 80px;">Do dnia</td>
      <td>
			<?php
				$lata=array($_POST[od_rok]);
				for ($i=1; $i<=10; ++$i)
				{
					$rok1=$_POST[od_rok]+$i;
					$rok2=$_POST[od_rok]-$i;
					array_push($lata, $rok1);
					array_unshift($lata, $rok2);
				}
				$www->SelectFromArray($lata,"do_rok", $_POST[do_rok]); 
			?>
		</td> 
	   <td style="width: 20px;">
			<?php
				$www->SelectFromArray($miesiace,"do_miesiac", $_POST[do_miesiac]); 
			?>
		</td>
	   <td style="width: 20px;">
			<?php
				$www->SelectFromArray($dni,"do_dzien", $_POST[do_dzien]); 
			?>
		</td>
		<td style="width: 200px;">
			<?php
				$www->SelectWlasc($dbh, "stary_abon", $_POST[stary_abon]); 
			?>
		</td>
		<td style="width: 200px;">
			<?php
				$www->SelectWlasc($dbh, "nowy_abon", $_POST[nowy_abon]); 			?>
		</td>
		<td style="width: 200px;">
				<input type="submit" class="button1" value="Filtruj" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>


<form method="POST" action="index.php?panel=inst&menu=delete">
<?php
	$_SESSION[del1]=array('cesje'=>'id_csj');
?>
		<table style="text-align: center; width: <?php echo $conf[width2];?>; height:<?php echo $conf[height2];?>" class="tbk1">
		<tbody>
			<tr class="tr1">
				<td style="width: 80px;">
					Nr Cesji
				</td>
				<td style="width: 100px;">
					Data
				</td>
				<td style="width: 400px;">
					Stary Abonent
				</td>
				<td style="width: 400px;">
					Nowy Abonent
				</td>

				<td style="width: 10px;">
					::
				</td>
			</tr>
<?php
  $cesje->ListaCesji($p);
?>
	<tr>
		<td class="klasa1" colspan="10">
				<input type="submit" class="button1" value="Kasuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>
