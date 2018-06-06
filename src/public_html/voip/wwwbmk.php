<a href="index.php?panel=inst&menu=addgate">Nowa bramka</a> &nbsp;
<br/>
<br/>

<table style="text-align: center; width: <?php echo $conf[width2];?>; height:<?php echo $conf[height2];?>" class="tbk1">
  <tbody>
    <tr class="tr1">
		
<form method="POST" action="index.php?panel=inst&menu=delete&typ=bmk">

<?php
	$_SESSION[del1]=array('bramki_voip'=>'id_bmk');
	$_SESSION[del2]=array();
	
	$bmk_tab=array(

			'Id' 					=> 	'80', 
			'Producent' 	=> 	'120',
			'Model' 			=> 	'120',
			'Nr Seryjny' 	=> 	'120',
			'Adres Fizyczny' 	=> 	'140',
			'Abonent' 	=> 	'200',
			'::'					=>	'10',
			);

	foreach ( $bmk_tab as $k => $v )
			print <<< HTML
      <td style="width: "$v"px;">
      	$k
      </td>
HTML;

   $voip->ListaBramek($dbh);
		
?>

	<tr>
		<td class="klasa1" colspan="10">
				<input type="submit" class="button1" value="Kasuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>




