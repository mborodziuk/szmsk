<?php
	$dbh=DBConnect($DBNAME1);

   $Q1="select v.id_vhw,  v.nazwa,  v.domena,  v.katalog,  v.data_utw, v.aktywny, k.id_konta, k.login 
			from vhost_www v, konta k where v.id_konta=k.id_konta and id_vhw='$_GET[vhwww]'";

	$sth1=Query($dbh, $Q1);
	$row1 =$sth1->fetchRow();

	$_SESSION['vhwww']=$vhwww=array
	(
		'id_vhw'		=>$_GET[vhwww],		'nazwa'		=>$row1[1], 	'domena'		=>$row1[2],
		'katalog'	=>$row1[3],		'data_utw'	=>$row1[4],		'id_konta'		=>$row1[6],
		'login'		=>$row1[7],		'aktywny'	=>TableToCheckBox($row1[5], "aktywny")
	);
?>

<form method="POST" action="index.php?menu=updatevhwwyslij&vhwww=<?php echo "$_GET[vhwww]" ?>">
<table style="align=center">
  <tbody>
    <tr>
      <td> Konto </td>
      <td>
		<select name= "konto">
			<?php
				echo "<option> $vhwww[login] $vhwww[id_konta]  </option>";
				Select($QA6);
			?>
		</select>
		</td>
    </tr>
	 <tr>
		 <td> Host aktywny ? </td>
		 <td>
			<?php
				echo "$vhwww[aktywny]";
			?>
		 </td>
	 </tr>
    <tr>
      <td> Nazwa </td>
      <td>
			<input type="text" name="nazwa" size="30" value="<?php echo "$vhwww[nazwa]";?>"/>
		</td>
    </tr>
    <tr>
      <td> Domena </td>
      <td>
			<select name="domena">
			 <?php
				echo "<option> $vhwww[domena] </option>";
				 Select($QA7);
			 ?>
			</select>
		 </td>
	 </tr>
    <tr>
      <td> Katalog </td>
      <td>
			<input type="text" name="katalog" size="30" value="<?php echo "$vhwww[katalog]";?>"/>
		</td>
    </tr>
    <tr>
      <td> Data utworzenia </td>
      <td>
			<input type="text" name="data_utw" size="10" value="<?php echo "$vhwww[data_utw]";?>"/>
		</td>
    </tr>
	<tr>
	 <td> 
  	 </td>
  	  <td>
  	  	<INPUT type="submit" name="wyslij" value="Załóż" size="30"> 
	 </td>
	 </tr>
  </tbody>
</table>

</form>