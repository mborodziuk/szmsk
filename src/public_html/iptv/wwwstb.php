<a href="index.php?panel=inst&menu=addstb">Nowy STB</a> &nbsp;
<br/>
<br/>

<table style="text-align: center; width: <?php echo $conf[width2];?>; height:<?php echo $conf[height2];?>" class="tbk1">
  <tbody>
    <tr class="tr1">
		
<form method="POST" action="index.php?panel=inst&menu=deletestb">

<?php
	$_SESSION[del1]=array('settopboxy'=>'id_stb');
	$_SESSION[del2]=array('pakiety' => 'id_urz');
	
	$bmk_tab=array(

			'Id' 					=> 	'80', 
			'Typ' 	=> 	'120',
			'Adres Fizyczny' 			=> 	'120',
			'Nr Seryjny' 	=> 	'120',
			'Abonent' 	=> 	'200',
			'Pakiet' 	=> 	'120',
			'::'					=>	'10',
			);

	foreach ( $bmk_tab as $k => $v )
			print <<< HTML
      <td style="width: "$v"px;">
      	$k
      </td>
HTML;

   $iptv->ListaSTB($dbh);
		
?>

	<tr>
		<td class="klasa1" colspan="10">
				<input type="submit" class="button1" value="Kasuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>




