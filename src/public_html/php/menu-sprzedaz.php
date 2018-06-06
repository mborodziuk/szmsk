 <tr>
   <td style="text-align: left; vertical-align: top; margin-left : 20px; width: 100px;" class="klasa6">

<table stylee="width: 180px;" class="tbk2">

<?php

	$inst_menu=array(

			'index.php?panel=sprzedaz&menu=abonenci' 		=> 	'Abonenci', 
			);

	foreach ( $inst_menu as $k => $v)
			print <<< HTML
				<tr class="tr3" onmouseover="this.style.backgroundColor='#D7D7D7'" onmouseout="this.style.backgroundColor=''">
        <td class="klasa5"> <a class="link" href=$k>&nbsp &nbsp          $v              </a> </td></tr>
HTML;
?>

</table>
        </td>
	      <td style="height: 700px; width: 100%;" colspan="4" rowspan="1" class="klasa6">
	            <br />

																																							 