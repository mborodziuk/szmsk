<?php

	$Q1="(select nr_um, data_zaw, typ_um, status, miejsce, siedziba, id_prac, szablon, data_zycie, ulga from UMOWY_ABONENCKIE where nr_um='$_GET[um]')
			 union
			 (select nr_um, data_zaw, typ_um, status, miejsce, siedziba, id_prac, szablon, data_zycie, ulga from UMOWY_SERWISOWE where nr_um='$_GET[um]')";
	
	$row1=Query2($Q1, $dbh);
	
	$nr_um=explode("/", $row1[0]);
	$data_zaw=explode("-", $row1[1]);
	$data_zycie=explode("-", $row1[8]);
	
	$um="umowa"."$_GET[um]";
	$_SESSION['$um']=$umowy=array(	
	'nr_um'	=> $row1[0],		'data_zaw'	=> $row1[1], 	'typ_um'   => $row1[2], 	
	'status'	=> $row1[3], 	'miejsce'	  => $row1[4], 	'siedziba' => $row1[5],
	'id_prac' => $row1[6], 	'szablon' 	=> $row1[7], 	'data_zycie' => $row1[8],
	'ulga'		=> $row1[9]);
	
/*	$q2="select nr_um, data_zaw from umowy_abonenckie order by nr_um";
	$sth2=Query($dbh,$q2);
	$q3="";
	while ($row2=$sth2->fetchRow())
	{
		$q3.="update umowy_abonenckie set data_zycie='$row2[1]' where nr_um='$row2[0]';";

		}
				WyswietlSql($q3);*/

?>



<form method="POST" action="index.php?panel=inst&menu=cntrupdsend&um=<?php echo "$_GET[um]" ?>&abon=<?php echo "$_GET[abon]" ?>">
<table style="width:500px" class="tbk3">
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
			<b> Dane umowy abonenckiej</b>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
			Numer umowy
		</td>
		<td class="klasa4">
			<table class="klasa3">
				<tr>
					<td>
						<input size="2" name="nr_um1"  value ="<?php echo "$nr_um[0]"; ?>">
					</td>
					<td>
					<?php
						$rodzaj=array("UMA", "UMR", "UMS");
						$www->SelectFromArray($rodzaj, "rodzaj",$nr_um[1]);
					?>					
					</select>					
					</td>
					<td>
						<input size="2" name="nr_um2"  value ="<?php echo "$nr_um[2]"; ?>">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Data zawarcia umowy (dzień/miesiąc/rok)
		</td>
		<td class="klasa4">
			<table class="klasa3">
				<tr>
					<td>
						<input size="2" name="dzien" 		value ="<?php echo "$data_zaw[2]"; ?>" >
					</td>
					<td>
						<input size="2" name="miesiac" 	value ="<?php echo "$data_zaw[1]"; ?>" >
					</td>
					<td>
						<input size="4" name="rok" 			value ="<?php echo "$data_zaw[0]"; ?>" >
					</td>
				</tr>
			</table>
			</td>
			</tr>

	<tr>
		<td class="klasa2">
				Data wejścia w życie, data uruchomienia usługi (dzień/miesiąc/rok)
		</td>
		<td class="klasa4">
			<table class="klasa3">
				<tr>
					<td>
						<input size="2" name="dzienz" 		value ="<?php echo "$data_zycie[2]"; ?>" >
					</td>
					<td>
						<input size="2" name="miesiacz" 	value ="<?php echo "$data_zycie[1]"; ?>" >
					</td>
					<td>
						<input size="4" name="rokz" 			value ="<?php echo "$data_zycie[0]"; ?>" >
					</td>
				</tr>
			</table>
			</td>
			</tr>
			<tr>
				<td class="klasa2">
					Ulga w zł
				</td>
				<td class="klasa4">
					<input size="10" name="ulga" 		value ="<?php echo "$umowy[ulga]"; ?>" >
					</select>
				</td>
			</tr>
						<tr>
				<td class="klasa2">
					Okres obowiązywania umowy
				</td>
				<td class="klasa4">
					<?php
						$typ=array("36", "30", "24", "18", "12", "9", "0");
						$www->SelectFromArray($typ, "typ_um",$umowy[typ_um])
					?>					
					</select>
				</td>
			</tr>
			

			<tr>
				<td class="klasa2">
					Status
				</td>
				<td class="klasa4">
					<?php
						$status=array("Obowiązująca", "Rozwiązana", "Odstąpiona", "Zawieszona", "windykowana", "Przedłużana", 'Nie podpisana');
						$www->SelectFromArray($status, "status_uma",$umowy[status])
					?>					
					</select>
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Miejsce
				</td>
				<td class="klasa4">
					<?php
						$miejsce=array("Mysłowice", "Oświęcim", "Katowice", "Babice", "Bieruń", "Sosnowiec");
						$www->SelectFromArray($miejsce, "miejsce",$umowy[miejsce])
					?>					
					</select>
				</td>
			</tr>
			<tr>
			<td class="klasa2">
				Zawarta w siedzibie </td>
		 <td>
			<?php
				echo TableToCheckbox($umowy[siedziba], "siedziba");
			?>
		 </td>
	 </tr>

		<tr>
			<td class="klasa2">
				Szablon </td>
		 <td>
			<?php
						$szablon=array("Dom2016", "Dom2015", "Dom2014", "Dom2013", "Biznes2013", "Transmisja", "DzierzawaWlokien");
						$www->SelectFromArray($szablon, "szablon", $umowy[szablon])
			?>
		 </td>
	 </tr>

		<tr>
				<td class="klasa2">
					Zawarta przez 
			</td>

				<td style="width: 200px;">
			<?php
				Select($QUERY12, "id_prac", $umowy[id_prac]);
			?>
		</td>

		</tr>
			<tr>
			<td>
			<a href="index.php?panel=inst&menu=ctrprl&ctr=<?php echo "$_GET[um]" ?>"> Przedłuż >>> </a>
			</td>
			</tr>	
		<tr>
				<td colspan="2">
					<input type="submit" value="Wyślij" name="przycisk1"  class="button1">
				</td>
			</tr>
<tbody>
</table>
		
</form>
		
