<form method="POST" action="index.php?panel=inst&menu=updateabonwyslij&abon=<?php echo "$_GET[abon]" ?>">
<table style="width:500px" >
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
						<input size="2" name="nr_uma1"  value ="<?php echo "$nr_uma[0]"; ?>">
					</td>
					<td>
						/UMA/&nbsp; 
					</td>
					<td>
						<input size="2" name="nr_uma2"  value ="<?php echo "$nr_uma[2]"; ?>">
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
						<input size="2" name="dzien" value ="<?php echo "$data_zaw[2]"; ?>" >
					</td>
					<td>
						<input size="2" name="miesiac" value ="<?php echo "$data_zaw[1]"; ?>" >
					</td>
					<td>
						<input size="4" name="rok" value ="<?php echo "$data_zaw[0]"; ?>" >
					</td>
				</tr>
			</table>
			</td>
			</tr>
			<tr>
				<td class="klasa2">
					Okres obowiązywania umowy
				</td>
				<td class="klasa4">
					<select name="typ_um">
						<?php
						if ($umowy[typ_um]=="Niekrótszy niż 24 m-ce")
							{
								echo "<option selected>Niekrótszy niż 24 m-ce</option>";
								echo "<option>Czas nieokreślony</option>";
								echo "<option>Niekrótszy niż 12 m-cy</option>";
							}
						else
							{
								echo "<option>Niekrótszy niż 24 m-ce</option>";
								echo "<option>Niekrótszy niż 12 m-ce</option>";
								echo "<option selected>Czas nieokreślony</option>";
							}
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
						$status=array("Obowiązująca", "Rozwiązana", "Zawieszona", "windykowana");
						$www->SelectFromArray($status, "status_uma",$umowy[status])
					?>					
					</select>
				</td>
			</tr>
			</tr>
				<tr>
				<td class="klasa2">
					Książeczka abonamentowa ?
				</td>
				<td class="klasa4">
					<?php
						echo TableToCheckbox($umowy[ksiazeczka], "ksiazeczka");
					?>
				</td>
			</tr>
	