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

	if (empty($_POST[order]))
		$_POST[order]="Data wystawienia";
	if (empty($_POST[stan]))
		$_POST[stan]="Wszystkie";

		$param=array
		(	
			'typ' => $_GET[typ], 	'stan' 		=> $_POST[stan], 'forma' => $_POST[forma],
			'data_od' => "$_POST[od_rok]"."-"."$_POST[od_miesiac]"."-"."$_POST[od_dzien]",
		 	'data_do'	=> "$_POST[do_rok]"."-"."$_POST[do_miesiac]"."-"."$_POST[do_dzien]",
			'order' => $_POST[order], 'abon'	=> $_POST[abon] );
?>

<a href="index.php?panel=fin&menu=dodajfv&typ=<?php echo $_GET[typ] ?> ">Nowa FV </a> &nbsp;
<a href="index.php?panel=fin&menu=dodajfabon">FV abon.</a> &nbsp;

<a href="javascript&#058;displayWindow('pdf/mkpdf.php?dok=ks&data_od=
<?php echo $param[data_od] ?>&data_do=<?php echo $param[data_do]?>&abon=<?php echo $param[abon]?>',650,1000, '38')">
Książeczka abon.</a> &nbsp;

<a href="javascript&#058;displayWindow('pdf/mkpdf.php?dok=fyv&data_od=<?php echo $param[data_od] ?>&data_do=<?php echo $param[data_do]?>&order=<?php echo $param[order]?>',800,800, '38')">
Zestawienie FV</a> &nbsp;

<a href="javascript&#058;displayWindow('pdf/mkpdf.php?dok=fyv&data_od=<?php echo $param[data_od] ?>&data_do=<?php echo $param[data_do]?>&order=<?php echo $param[order]?>&comiesiac=true',800,800, '38')">
Zest. FV comiesiac</a> &nbsp;


<a href="javascript&#058;displayWindow('pdf/mkpdf.php?dok=rsp&data_od=<?php echo $param[data_od] ?>&data_do=<?php echo $param[data_do]?>',1100,800, '38')">
Rejestr sprzedazy </a> &nbsp;

<a href="index.php?panel=fin&menu=sendFV&data_od=<?php echo $param[data_od] ?>&data_do=<?php echo $param[data_do]?>">Wyslij FV</a> &nbsp;

<br/>
<br/>

<?php
	if ($_GET[typ]=="sprzedaz")
		{
			$TABLE1="dokumenty_sprzedaz";
			$TABLE2="pozycje_sprzedaz";
			$ID="nr_ds";
		}
	else
		{
			$TABLE1="dokumenty_zakup";
			$TABLE2="pozycje_zakup";
			$ID="nr_dz";
		}

	$_SESSION[del1]=array( $TABLE2=>$ID, $TABLE1=>$ID);
	$_SESSION[del2]=array();

?>
<form method="POST" action="index.php?panel=fin&menu=dokks&typ=sprzedaz">
<table style="text-align: left; width:1000px; height: 50px;" class="tbk1">
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
      <td> Typ dokumentow </td>
      <td> Sortowanie  </td>
      <td> Kontrahent  </td>
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
				$stan=array("Wszystkie", "Nieuregulowane", "Uregulowane");
				$www->SelectFromArray($stan,"stan", $_POST[stan]); 
			?>
		</td>
		<td style="width: 200px;">
			<?php
				$order=array("Data wystawienia", "Nazwa odbiorcy");
				$www->SelectFromArray($order,"order", $_POST[order]); 
			?>
		</td>
		 <td style="width: 200px;">
     <?php
	        $ida=SelectWlasc("abon", $_POST[abon]);
	    ?>
	  </td>
	 
		<td style="width: 200px;">
				<input type="submit" class="button1" value="Filtruj" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>


<form method="POST" action="index.php?panel=fin&menu=deletefv">
<table class="tbk1" style="text-align: left; width: 1000px; height: 75px;">
  <tbody>
    <tr class="tr1">
      <td style="width: 80px;">
      	Nr dokumentu
      </td>
      <td style="width: 235px;">
      	Dostawca/Odbiorca
       </td>
      <td style="width: 80px;">
      	Data wystawienia
      </td>
      <td style="width: 325px; ">
      	Pozycje
      </td>
      <td style="width: 30px; ">
      	Oryginał
      </td>
      <td style="width: 30px; ">
      	Kopia
      </td>
      <td style="width: 30px; ">
      	Duplikat
      </td>
      <td style="width: 5px; ">
      	::
      </td>
    </tr>
	<?php
		ListaDokKs($param);
	?>
    <tr class="tr1">
		<td class="klasa1" colspan="8">
			<input type="submit" class="button1" value="Kasuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>
<br/>