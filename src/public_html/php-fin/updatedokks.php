<?php
	$dbh=DBConnect($DBNAME1);

	if ($_GET[typ]=="sprzedaz")
		{
			$q1="	select  d.nr_ds, k.id_abon, d.data_wyst, d.data_sprzed, d.term_plat, d.forma_plat, d.stan, d.miejsce_wyst 
					from dokumenty_sprzedaz d, abonenci k 
					where d.id_odb=k.id_abon and d.nr_ds='$_GET[nr]'";
			$q2=" select t.nazwa, p.ilosc 
					from pozycje_sprzedaz p, towary_sprzedaz t 
					where p.id_tows=t.id_tows and p.nr_ds='$_GET[nr]' order by t.nazwa";
		}
	else 
		{
			$q1="	select  d.nr_dz, k.id_dost, d.data_wyst, d.data_sprzed, d.term_plat, d.forma_plat, d.stan, d.miejsce_wyst 
					from dokumenty_zakup d, dostawcy k 
					where d.id_dost=k.id_dost and d.nr_dz='$_GET[nr]'";
			$q2=" select t.nazwa, p.ilosc 
					from pozycje_zakup p, towary_zakup t 
					where p.id_towz=t.id_towz  and p.nr_dz='$_GET[nr]' order by t.nazwa";
		}
	$sth1=Query($dbh,$q1);
	$row1=$sth1->fetchRow();

	$_SESSION['dokks']=$dokks=array
	(
		'nr_ds'			=> $_GET[nr], 		'id_odb'			=>$row1[1], 	'data_wyst'	=>$row1[2], 	'data_sprzed'		=>$row1[3],
		'term_plat'		=>	$row1[4],		'forma_plat'	=>$row1[5],		'stan'		=>$row1[6],		'miejsce_wyst'		=>$row1[7]
	);
	
?>
<form method="POST" action="index.php?panel=fin&menu=updatedokkswyslij&typ=<?php echo $_GET[typ]?>&nr=<?php echo $_GET[nr]?>">
<table style="width:800px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="4">
				Dane Faktury
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Numer
		</td>
		<td class="klasa4">
				<input size="20" name="nr_d" value="<?php echo $dokks[nr_ds] ?>">
		</td>
		<td class="klasa2">
		<?php
			if($_GET[typ]=="sprzedaz")
				echo "Odbiorca";
			else
				echo "Dostawca";
		?>
		</td>
		<td class="klasa4">
			<?php
				if($_GET[typ]=="sprzedaz")
					SelectWlasc("odbiorca",$dokks[id_odb]);
				else
					Select($QUERY10, "dostawca");
			?>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Data wystawienia
		</td>
		<td class="klasa4">
				<input size="15" name="data_wyst"  value="<?php echo $dokks[data_wyst] ?>">
		</td>
		<td class="klasa2">
				Data sprzedaży
		</td>
		<td class="klasa4">
				<input size="15" name="data_sprzed"  value="<?php echo $dokks[data_sprzed] ?>">
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Termin platności
		</td>
		<td class="klasa4">
				<input size="15" name="term_plat"  value="<?php echo $dokks[term_plat] ?>">
		</td>
		<td class="klasa2">
				Forma platności
		</td>
		<td class="klasa4">
			<?php
				$fp=array("przelew", "gotowka");
				$www->SelectFromArray($fp, "forma_plat", $dokks[forma_plat]);
			?>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Stan
		</td>
		<td class="klasa4">
			<?php
				$fp=array("nieuregulowana", "uregulowana");
				$www->SelectFromArray($fp, "stan", $dokks[stan]);
			?>

		</td>
		<td class="klasa2">
				Miejsce wystawienia
		</td>
		<td class="klasa4">
			<?php
				$fp=array("Mysłowice", "Katowice","Gliwice");
				$www->SelectFromArray($fp, "miejsce_wyst", $dokks[miejsce_wyst]);
			?>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
		</td>
		<td class="klasa2">
		</td>

	</tr>
		<br>
	<tr>

		<td class="klasa4" colspan="4">
				<table class="tbk1" style="text-align: left; width: 750px; height: 75px;" border="1" cellpadding="0" cellspacing="0">
				  <tbody>
    					<tr class="tr1">
					      <td style="width: 5px;">
      						L.p.
	      				</td>
					      <td style="width: 250px;">
      						Pełna nazwa towaru / usługi
	      				</td>
 					     <td style="width: 30px;">
      						PKWiU
				       </td>
 					     <td style="width: 15px;">
      						Ilość
				       </td>
 					     <td style="width: 15px;">
      						j.m.
				       </td>
				      <td style="width: 70px;">
      						Cena jedn. netto
				      </td>
				      <td style="width: 70px;">
      						Cena netto
				      </td>
      				<td style="width: 20px; ">
      					% VAT
      				</td>
      				<td style="width: 70px; ">
      					Kwota VAT
      				</td>
				      <td style="width: 70px;">
     						Cena brutto
				      </td>
							<td style="width: 5px; ">
								::
							</td>							
						</tr>
						<?php
							ListaPozDokks($_GET[typ], $_GET[nr]);
						?>
				  </tbody>
				</table>
		</td>
	</tr>
	<tr>
		<td>
					<br>
				 <a href="index.php?panel=fin&menu=updatedokks1">Dodaj pozycję >>></a>
			</td>
	</tr>
	<tr>
		<td class="klasa1" colspan="6">

				<input type="submit" class="button1" value="Uaktualnij >>>" name="przycisk">
		</td>
	</tr>

<tbody>
</table>
		
</form>
		
