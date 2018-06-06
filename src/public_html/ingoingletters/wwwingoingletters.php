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

<a href="index.php?panel=fin&menu=inltradd"> Nowe pismo przych. </a> &nbsp;
<br/>
<br/>

<form method="POST" action="index.php?panel=fin&menu=ingoingletters">
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
      <td> Instytucje </td>
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
			<td style="width: 300px;">
			<?php
				$www->Select2($dbh, $QUERY8, "instytucje"); 
			?>
		</td>	
 		<td style="width: 300px;">
			<?php
				$www->SelectWlasc($dbh, "abonent", $_POST[abonent]); 
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
	$_SESSION[del1]=array('pisma_przychodzace'=>'id_psp');
	$_SESSION[del2]=array();
?>
		<table style="text-align: center; width: <?php echo $conf[width2];?>; height:<?php echo $conf[height2];?>" class="tbk1">
		<tbody>
			<tr class="tr1">
				<td style="width: 80px;">
					Id
				</td>
				<td style="width: 200px;">
					Instytucja / Abonent 
				</td>
				<td style="width: 70px;">
					Data wpływu
				</td>
				<td style="width: 80px;">
					Data na piśmie
				</td>
				<td style="width: 390px;">
					Uwagi
				</td>			
				<td style="width: 50px;">
					::
				</td>
				<td style="width: 10px;">
					::
				</td>

			</tr>
<?php

   $ingoingletter->InLtrList($dbh, $p);
?>
	<tr>
		<td class="klasa1" colspan="10">
				<input type="submit" class="button1" value="Kasuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>
