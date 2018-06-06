<?php
	$dbh=DBConnect($DBNAME1);

   $Q1="select a.symbol, a.nazwa,  a.id_abon, k.login, k.haslo, k.data_utw, g.id_gr, g.antyspam, g.antywir, g.pojemnosc, k.aktywne
			from konta k, abonenci a, grupy g where a.id_abon=k.id_abon and g.id_gr=k.id_gr and id_konta='$_GET[konto]'";
	$Q2="select alias from aliasy_email where id_konta='$_GET[konto]'";

	$sth1=Query($dbh, $Q1);
	$row1 =$sth1->fetchRow();

	$aliasy=array();
	$sth2=Query($dbh, $Q2);
	while ($row2 =$sth2->fetchRow() )
	array_push($aliasy, "$row2[0]");
	$_SESSION['aliasy']=$aliasy;
	
	$_SESSION['konta']=$konta=array
	(
		'nazwa'		=>Choose($row1[0],$row1[1]),						'id_abon'	=>$row1[2], 	'login'		=>$row1[3],
		'haslo'		=>$row1[4],												'data_utw'	=>$row1[5],		'id_gr'		=>$row1[6],
		'antyspam'	=>TableToCheckBox($row1[7], "antyspam"),		'antywir'	=>TableToCheckBox($row1[8], "antywir"),
		'pojemnosc'	=>$row1[9],												'aktywne'	=>TableToCheckBox($row1[10], "aktywne")
	);


?>


<form method="POST" action="index.php?panel=inst&menu=updatekontowyslij&konto=<?php echo "$_GET[konto]"; ?>">
<table style="align=center">
  <tbody>
    <tr>
      <td class="klasa1">
			 <strong>Id konta</strong> 
		</td>
      <td class="klasa1">
			<?php	
				echo "$_GET[konto]";	
			?>
		</td>
    </tr>
    <tr>
      <td> Właściciel </td>
      <td>
				<?php
					echo "$konta[nazwa] $konta[id_abon]";
				?>
		</select>
		</td>
    </tr>
	 <tr>
		 <td> Konto aktywne ? </td>
		 <td>
			 <?php	echo "$konta[aktywne]";	?>
		 </td>
	 </tr>
    <tr>
      <td> Login </td>
      <td>
			<?php	echo "$konta[login]";	?>
		</td>
    </tr>
    <tr>
      <td> Hasło </td>
      <td>
		<input type="password" name="haslo1" size="30" value="<?php	echo "$konta[haslo]";	?>"/>
		</td>
    </tr>
	 <tr>
      <td> Powtórz hasło </td>
      <td>
		<input type="password" name="haslo2" size="30" value="<?php	echo "$konta[haslo]";	?>"/>
		</td>
    </tr>
    <tr>
      <td> Data utworzenia </td>
      <td>
			<?php	
				echo "$konta[data_utw]";	
			?>
		</td>
    </tr>
	 <tr>
		 <td> Filtr antyspamowy </td>
		 <td>
			<?php	echo "$konta[antyspam]";	?>
		 </td>
	 </tr>
	 <tr>
		 <td> Filtr antywirusowy </td>
		 <td>
			 <?php	echo "$konta[antywir]";	?>
		 </td>
	 </tr>
	 <tr>
		<td> Pojemność </td>
		<td>
			 <?php
				echo "$konta[pojemnosc] MB";
			 ?>
		 </td>
	 </tr>
    <tr>
      <td> 
			 Aliasy  
		</td>
      <td>
			<table class="tbk1">
			  <tbody>
  				  <tr>
					<td>
						<input type="text" name="alias0" size="20" value="<?php	echo "$aliasy[0]";	?>"/>
					</td>
				</tr>
  				  <tr>
					<td>
						<input type="text" name="alias1" size="20" value="<?php	echo "$aliasy[1]";	?>"/>
					</td>
				</tr>
  				  <tr>
					<td>
						<input type="text" name="alias2" size="20" value="<?php	echo "$aliasy[2]";	?>"/>
					</td>
				</tr>
				</tbody>
			</table>
		</td>
    </tr>
	<tr>
	 <td> 
  	 </td>
  	  <td>
  	  	<INPUT type="submit" name="wyslij" value="Uaktualnij" size="30"> 
	 </td>
	 </tr>
  </tbody>
</table>

</form>