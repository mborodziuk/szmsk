<?php

	$q1="	select  nr_nob, kwota, term_plat, forma_plat, stan, miejsce_wyst, data_wyst, wystawil, id_odb, opis 
					from noty_obciazeniowe
					where nr_nob='$_GET[no]'";

	$sth1=Query($dbh,$q1);
	$row1=$sth1->fetchRow();

		$_SESSION[$_GET[no].$_SESSION[login]]=$no=array
	(
		'nr_nop'			=> $_GET[no], 	'kwota'			=>$row1[1], 	'term_plat'	=>$row1[2], 	'forma_plat'		=>$row1[3],
		'stan'				=>	$row1[4],		'miejsce_wyst'	=>$row1[5],		'data_wyst'		=>$row1[6],		'wystawil'		=>$row1[7],
		'id_odb'		=>	$row1[8],		'opis'		=>$row1[9]
	);
	
?>

<form method="POST" action="index.php?panel=fin&menu=dbtntupdsnd&no=<?php echo $_GET[no]?>">
<table style="width:500px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane Noty Debetowej
		</td>
	</tr>
	<tr>
		<td class="klasa2">
		Obciążony
		</td>
		<td class="klasa4">
			<?php
					$www->SelectWlasc($dbh, "odbiorca", $no[id_odb]);
			?>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Kwota
		</td>
		<td class="klasa4">
				<input size="15" name="kwota"  value="<?php echo $no[kwota] ?>">
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Data wystawienia
		</td>
		<td class="klasa4">
				<input size="15" name="data_wyst"  value="<?php echo $no[data_wyst] ?>">
		</td>
	</tr>

	<tr>
		<td class="klasa2">
				Termin platności
		</td>
		<td class="klasa4">
				<input size="15" name="term_plat"  value="<?php echo $no[term_plat] ?>">
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Forma platności
		</td>
		<td class="klasa4">
			<?php
				$fp=array("przelew", "gotówka");
				$www->SelectFromArray($fp, "forma_plat", $no[forma_plat]);
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
				$www->SelectFromArray($fp, "stan", $no[stan]);
			?>

		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Miejsce wystawienia
		</td>
		<td class="klasa4">
			<?php
				$fp=array("Mysłowice", "Katowice","Gliwice");
				$www->SelectFromArray($fp, "miejsce_wyst", $no[miejsce_wyst]);
			?>
		</td>
		</tr>
		<tr>
	<tr>
		<td class="klasa2">
				Wystawił
		</td>		
				<td class="klasa4">
		   <?php
			 $wystawil=explode(";", $firma[wystawil]);
			$www->SelectFromArray($wystawil, 'wystawil', $no[wystawil]);
				?>
		</td>

	</tr>
		<tr>
				<td class="klasa2">
				Opis
		</td>

		<td class="klasa1" colspan="2">
			<textarea name="opis" cols="60" rows="10"><?php echo "$no[opis]"; ?></textarea>
		</td>	
	</tr>  	  

	<tr>
		<td class="klasa2">
		</td>
		<td colspan="2">
				<input type="submit" class="button1" value="Dalej >>>" name="przycisk1">
		</td>
	</tr>

<tbody>
</table>
		
</form>

	
