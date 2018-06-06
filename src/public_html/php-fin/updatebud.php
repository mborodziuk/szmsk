<?php
	$dbh=DBConnect($DBNAME1);

   $Q1="	select a.symbol, a.id_inst, u.nazwa, u.miasto,u.id_ul,  b.numer, b.il_mieszk, b.przylacze, b.adres_ip 
			from budynki b, instytucje a, ulice u 
			where u.id_ul=b.id_ul and a.id_inst=b.id_adm and id_bud='$_GET[bud]'";
	$sth1=Query($dbh,$Q1);
	$row1 =$sth1->fetchRow();

	$_SESSION['bud']=$bud=array
	('id_bud' 	=> $_GET[bud], 	'symbol'		=>$row1[0], 	'id_inst'	=>$row1[1], 	'ulica'=>$row1[2],
	'miasto'		=>	$row1[3],		'id_ul'	=>$row1[4],		'nr_bud'	=>$row1[5],		'il_mieszk'	=>$row1[6],		
	'przylacze'	=>$row1[7],		'adres_ip'	=>$row1[8]);

?>

<form method="POST" action="index.php?panel=fin&menu=updatebudwyslij&bud=<?php echo $_GET[bud] ?>">
<table style="width:400px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane budynku 
				<?php echo $_GET[bud] ?>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Administracja / spółdzielnia
		</td>
		<td class="klasa4">
			<?php
				Select($QUERY8, "administracja", "$bud[id_inst]");
			?>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Ulica
		</td>
		<td class="klasa4">
			<?php
					Select($QUERY9, "ulica", "$bud[id_ul]", "Inna");
			?>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Inna ulica
		</td>
		<td class="klasa4">
				<input size="30" name="inna_ul" >
		</td>	
	</tr>
	<tr>
	<tr>
		<td class="klasa2">
				Numer budynku
		</td>
		<td class="klasa4">
				<input size="4" name="nr_bud" value="<?php echo $bud[nr_bud] ?>">
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Ilość mieszkańców
		</td>
		<td class="klasa4">
				<input size="2" name="il_mieszk"  value="<?php echo $bud[il_mieszk] ?>">
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Przyłącze
		</td>
		<td class="klasa4">
		<?php
			$s=array("1 Mbit/s", "2 Mbit/s", "10 Mbit/s", "100 Mbit/s", "1 Gbit/s");
			$www->SelectFromArray($s, "przylacze", $bud[przylacze]);
		?>
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
			Adresacja IP
		</td>
		<td class="klasa4">
				<input size="15" name="adres_ip"  value="<?php echo $bud[adres_ip] ?>">
	</td>	
	</tr>
	<tr>
		<td colspan="2">
			<input type="submit" value="Wyślij" name="przycisk1">
		</td>
	</tr>
<tbody>
</table>
		
</form>
		
