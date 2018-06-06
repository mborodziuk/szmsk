<?php
	$dbh=DBConnect($DBNAME1);


	if ($_GET[typ]=="sprzedaz")
		{
			$q1="	select  g.nr_gwar, a.id_abon, g.data_wyst 
					from gwarancje_sprzedaz g, abonenci a 
					where g.id_odb=a.id_abon and g.nr_gwar='$_GET[nr]' ";
			$q2="	select t.symbol, p.nr_fabr, t.okres_gwar 
					from pozycje_gwars p, towary_sprzedaz t 
					where p.id_tows=t.id_tows and p.nr_gwar='$_GEt[nr]";
		}
	else 
		{
			$q1="	select  g.nr_gwar, d.id_dost, g.data_wyst  
					from gwarancje_zakup g, dostawcy d 
					where d.id_dost=g.id_dost and g.nr_gwar='$_GET[nr]' ";
			$q2="	select t.symbol, p.nr_fabr, t.okres_gwar 
					from pozycje_gwarz p, towary_zakup t 
					where p.id_towz=t.id_towz  and p.nr_gwar='$_GET[nr]'";
		}
	$sth1=Query($dbh,$q1);
	$row1=$sth1->fetchRow();

	$_SESSION['gwar']=$gwar=array
	(
		'nr_gwar'		=> $_GET[nr], 		'id_k'			=>$row1[1], 	'data_wyst'	=>$row1[2]
	);

?>
<form method="POST" action="index.php?menu=updategwarwyslij&typ=<?php echo $_GET[typ]?>&nr=<?php echo $_GET[nr]?>">
<table style="width:600px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="4">
				Dane gwarancji
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Numer
		</td>
		<td class="klasa4">
				<input size="20" name="nr_gwar" value="<?php echo $gwar[nr_gwar] ?>">
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
					SelectWlasc("odbiorca");
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
				<input size="15" name="data_wyst"  value="<?php echo $gwar[data_wyst] ?>">
		</td>
	</tr>
	<tr>
		<td class="klasa4" colspan="4">
				<table style="text-align: left; width: 600px; height: 75px;" border="1" cellpadding="0" cellspacing="0">
				  <tbody>
    					<tr class="tr1">
					      <td style="width: 5px;">
      						L.p.
	      				</td>
					      <td style="width: 300px;">
      						Pełna nazwa towaru / usługi
	      				</td>
 					     <td style="width: 100px;">
      						Nr fabryczny
				       </td>
 					     <td style="width: 20px;">
      						Okres gwarancji
				       </td>
				      </td>
				    </tr>
						<?php
							ListaPozGwar($_GET[typ], $_GET[nr]);
						?>
				  </tbody>
				</table>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
		</td>
		<td colspan="4">
				<input type="submit" value="Uaktualnij" name="przycisk1">
		</td>
	</tr>

<tbody>
</table>
		
</form>
		
