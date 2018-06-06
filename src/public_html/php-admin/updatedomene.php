<?php
	$dbh=DBConnect($DBNAME1);

   $Q1="select nazwa, ip, data_rej from domeny where nazwa='$_GET[domena]'";
	$sth1=Query($dbh, $Q1);
	$row1 =$sth1->fetchRow();

	$_SESSION['domeny']=$domeny=array
	(
		'nazwa'		=>$_GET[domena],		'ip'	=>$row1[1],	 	'data_rej'		=>$row1[2]
	);
?>

<form method="POST" action="index.php?menu=updatedomenewyslij&domena=<?php echo "$_GET[domena]" ?>">
<table style="align=center">
  <tbody>
    <tr>
      <td> Nazwa </td>
      <td>
			<input type="text" name="nazwa" size="30" value="<?php echo "$domeny[nazwa]";?>"/>
		</td>
    </tr>
    <tr>
      <td> IP </td>
      <td>
			<input type="text" name="ip" size="30" value="<?php echo "$domeny[ip]";?>"/>
		</td>
    </tr>
    <tr>
      <td> Data rejestracji </td>
      <td>
			<input type="text" name="data_rej" size="10" value="<?php echo "$domeny[data_rej]";?>"/>
		</td>
    </tr>
	<tr>
	 <td> 
  	 </td>
  	  <td>
  	  	<INPUT type="submit" name="wyslij" value="Wprowadź" size="30"> 
	 </td>
	 </tr>
  </tbody>
</table>

</form>
