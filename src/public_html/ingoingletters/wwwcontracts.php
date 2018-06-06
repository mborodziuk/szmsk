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

	if (empty($_POST[dokonane]))
		$_POST[dokonane]="niedokonane";
	if (empty($_POST[stan]))
		$_POST[stan]="Wszystkie";


		$p=array
		(	'dokonane' => $_POST[dokonane], 	'abonent' 		=> $_POST[abonent], 'wykonawca' => $_POST[wykonawca],
			'data_od' => "$_POST[od_rok]"."-"."$_POST[od_miesiac]"."-"."$_POST[od_dzien]",
		 	'data_do'	=> "$_POST[do_rok]"."-"."$_POST[do_miesiac]"."-"."$_POST[do_dzien]",
		);

?>

<a href="index.php?panel=inst&menu=dodajwypowiedzenie"> Nowe wypowiedzenie </a> &nbsp;
<br/>
<br/>

<form method="POST" action="index.php?panel=fin&menu=wypowiedzenia">
<table style="text-align: left; width: 800px; height: 50px;" class="tbk1">
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
      <td> Wypowiedzenia </td>
      <td> Abonent  </td>
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
				$dokonane=array("dokonane", "niedokonane");
				$www->SelectFromArray($dokonane,"dokonane", $_POST[dokonane]); 
			?>
		</td>
		<td style="width: 200px;">
			<?php
				$www->SelectWlasc("abonent", $_POST[abonent]); 
			?>
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
	$_SESSION[del1]=array('zlecenia'=>'id_zlc');
	$_SESSION[del2]=array();
	$_SESSION[del3]=array('wykonywanie_zlecenia'=>'id_wzc');
?>
<?php
if ($_POST[dokonane]=="niedokonane")
	print <<< HTML
		<table style="text-align: left; width: 800px; height: 50px;" class="tbk1">
		<tbody>
			<tr class="tr1">
				<td style="width: 80px;">
					Id
				</td>
				<td style="width: 70px;">
					Data wpływu
				</td>
				<td style="width: 190px;">
					Abonent
				</td>
				<td style="width: 390px;">
					Treść 
				</td>			
				<td style="width: 80px;">
					Wchodzi w życie
				</td>
				<td style="width: 50px;">
					::
				</td>
				<td style="width: 10px;">
					::
				</td>
			</tr>
HTML;
else 
	print <<< HTML2
		<table style="text-align: left; width: 800px; height: 50px;" class="tbk1">
		<tbody>
			<tr class="tr1">
				<td style="width: 80px;">
					Id
				</td>
				<td style="width: 70px;">
					Data zgłoszenia/wykonania
				</td>
				<td style="width: 100px;">
					Zlecający
				</td>
				<td style="width: 300px;">
					Opis 
				</td>
				<td style="width: 300px;">
					Opis wykonania
				</td>
				<td style="width: 40px;">
				Wykonawca
				</td>
				<td style="width: 40px;">
					::
				</td>
			</tr>
HTML2;
   $contracts->TerminationContractList($dbh, $p);
?>
	<tr>
		<td class="klasa1" colspan="10">
				<input type="submit" class="button1" value="Kasuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>
