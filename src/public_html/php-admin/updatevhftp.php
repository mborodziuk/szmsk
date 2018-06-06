<?php
	$dbh=DBConnect($DBNAME1);

   $Q1="select v.id_vhf,  v.nazwa,  v.domena,  v.katalog, v.port,  v.data_utw, v.aktywny, k.id_konta, k.login 
			from vhost_ftp v, konta k where v.id_konta=k.id_konta and id_vhf='$_GET[vhf]'";

	$sth1=Query($dbh, $Q1);
	$row1 =$sth1->fetchRow();

	$_SESSION['vhftp']=$vhftp=array
	(
		'id_vhf'		=>$_GET[vhf],'nazwa'	=>$row1[1],		 	'domena'		=>$row1[2], 'katalog'	=>$row1[3],
		'port'	=>$row1[4],			'data_utw'	=>$row1[5],		'id_konta'	=>$row1[7],	'login'		=>$row1[8],
		'aktywny'	=>TableToCheckBox($row1[6], "aktywny")
	);
?>

<form method="POST" action="index.php?menu=updatevhfwyslij&vhftp=<?php echo "$_GET[vhf]" ?>">
<table style="align=center">
  <tbody>
    <tr>
      <td> Konto </td>
      <td>
		<select name= "konto">
			<?php
				echo "<option> $vhftp[login] $vhftp[id_konta]  </option>";
				Select($QA6);
			?>
		</select>
		</td>
    </tr>
	 <tr>
		 <td> Host aktywny ? </td>
		 <td>
			<?php
				echo "$vhftp[aktywny]";
			?>
		 </td>
	 </tr>
    <tr>
      <td> Nazwa </td>
      <td>
			<input type="text" name="nazwa" size="30" value="<?php echo "$vhftp[nazwa]";?>"/>
		</td>
    </tr>
    <tr>
      <td> Domena </td>
      <td>
			<select name="domena">
			 <?php
				echo "<option> $vhftp[domena] </option>";
				 Select($QA7);
			 ?>
			</select>
		 </td>
	 </tr>
    <tr>
      <td> Katalog </td>
      <td>
			<input type="text" name="katalog" size="30" value="<?php echo "$vhftp[katalog]";?>"/>
		</td>
    </tr>
    <tr>
    <tr>
      <td> Port </td>
      <td>
			<input type="text" name="port" size="5" value="<?php echo "$vhftp[port]";?>"/>
		</td>
    </tr>
    <tr>
      <td> Data utworzenia </td>
      <td>
			<input type="text" name="data_utw" size="10" value="<?php echo "$vhftp[data_utw]";?>"/>
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