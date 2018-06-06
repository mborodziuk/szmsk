<?php
	if ( empty($_POST[od_rok]) && empty($_POST[od_miesiac]) && empty($_POST[od_dzien]) ) 
		{	
			$_POST[od_rok]=date("Y");
			$_POST[od_miesiac]=date("m");
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


		if (empty($_POST[zglaszajacy]) && !empty($_GET[abon]) )
		{
			$_POST[zglaszajacy]="$_GET[abon]";
			$_POST[od_rok]="2002";
			$_POST[od_miesiac]="01";
			$_POST[od_dzien]="01";
		}
		
		$p=array
		(	'usunieta' => $_POST[usunieta], 	'zglaszajacy' 		=> $_POST[zglaszajacy], 'usuwajacy' => $_POST[usuwajacy],
			'data_od' => "$_POST[od_rok]"."-"."$_POST[od_miesiac]"."-"."$_POST[od_dzien]",
		 	'data_do'	=> "$_POST[do_rok]"."-"."$_POST[do_miesiac]"."-"."$_POST[do_dzien]",
		);

?>

<a href="index.php?panel=inst&menu=dodajawarie&abon=<?php echo $_GET[abon] ?>"> Nowa awaria </a> &nbsp;
<br/>
<br/>

<form method="POST" action="index.php?panel=inst&menu=awarie">
<table style="text-align: left; width: <?php echo $conf[width2];?>; height:<?php echo $conf[height2];?>" class="tbk1">
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
      <td> Typ awarii </td>
      <td> Zgłaszający  </td>
      <td> Usuwający  </td>
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
				$usunieta=array("Nieusunięte", "Usunięte");
				$www->SelectFromArray($usunieta,"usunieta", $_POST[usunieta]); 
			?>
		</td>
		<td style="width: 200px;">
			<?php
				$www->SelectWlasc($dbh, "zglaszajacy", $_POST[zglaszajacy]); 
			?>
		</td>
		<td style="width: 200px;">
			<?php
				Select($QUERY12, "usuwajacy", $_POST[usuwajacy], $conf[select]);
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
	$_SESSION[del1]=array('awarie'=>'id_awr');
	$_SESSION[del2]=array();
	$_SESSION[del3]=array('usuwanie_awarii'=>'id_awr');
?>
<?php
if ($_POST[usunieta]=="Nieusunięte")
	print <<< HTML
		<table style="text-align: left; width: $conf[width2]; height: $conf[height2];" class="tbk1">
		<tbody>
			<tr class="tr1">
				<td style="width: 80px;">
					Id
				</td>
				<td style="width: 100px;">
					Czas zgłoszenia
				</td>
				<td style="width: 200px;">
					Zgłaszający
				</td>
				<td style="width: 400px;">
					Opis skrócony
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
		<table style="text-align: left; width: $conf[width2]; height: $conf[height2];" class="tbk1">
		<tbody>
			<tr class="tr1">
				<td style="width: 80px;">
					Id
				</td>
				<td style="width: 100px;">
					Czas zgłoszenia/usunięcia
				</td>
				<td style="width: 100px;">
					Zgłaszający
				</td>
				<td style="width: 300px;">
					Opis awarii
				</td>
				<td style="width: 300px;">
					Opis usunięcia
				</td>
				<td style="width: 40px;">
				Usuwający
				</td>
				<td style="width: 40px;">
					::
				</td>
			</tr>
HTML2;
   $failures->ListaAwarii($dbh, $p);
?>
	<tr>
		<td class="klasa1" colspan="10">
				<input type="submit" class="button1" value="Kasuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>
