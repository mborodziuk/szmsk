<a href="index.php?panel=inst&menu=addtlv">Nowy telefon</a> &nbsp;
<br/>
<br/>

<table style="text-align: center; width: <?php echo $conf[width2];?>; height:<?php echo $conf[height2];?>" class="tbk1">
  <tbody>
    <tr class="tr1">
		
<form method="POST" action="index.php?panel=inst&menu=deletetlv">

<?php
	$_SESSION[del1]=array('telefony_voip'=>'id_tlv');
	$_SESSION[del2]=array();
	
	$tlv_tab=array(

			'Id' 					=> 	'80', 
			'Numer' 	=> 	'170',
			'Abonent' 			=> 	'260',
			'Taryfa' 	=> 	'200',
			'::'					=>	'10',
			);

	foreach ( $tlv_tab as $k => $v )
			print <<< HTML
      <td style="width: "$v"px;">
      	$k
      </td>
HTML;

   $voip->ListaTlv($dbh);
		
?>

	<tr>
		<td class="klasa1" colspan="10">
				<input type="submit" class="button1" value="Kasuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>




