 <tr>
   <td style="text-align: left; vertical-align: top; margin-left : 20px; width: 180px;" class="klasa6">

<table stylee="width: 180px;" class="tbk2">

<?php

	$inst_menu=array(

			'index.php?panel=inst&menu=abonenci' 		=> 	'Abonenci', 
			'index.php?panel=inst&menu=plg'					=>	'Podłączenia',
			'index.php?panel=inst&menu=prl'					=>	'Przedłużenia',
			'index.php?panel=inst&menu=komputery' 	=> 	'Komputery',
			'index.php?panel=inst&menu=cpe' 				=> 	'Zestawy radiowe',
			'index.php?panel=inst&menu=onu' 				=> 	'Końcówki ONU',
			'index.php?panel=inst&menu=router' 			=> 	'Routery klienckie',
			'index.php?panel=inst&menu=stb' 				=> 	'Dekodery (STB)',
			'index.php?panel=inst&menu=bmk' 				=> 	'Bramki Voip',
			'index.php?panel=inst&menu=tlv' 				=> 	'Telefony Voip',
			'index.php?panel=inst&menu=sim' 				=> 	'Karty SIM',
			'index.php?panel=inst&menu=modem'				=> 	'Modemy GSM',
			'index.php?panel=inst&menu=konta'				=>	'Konta',
			'index.php?panel=inst&menu=wwwmailboxes'=>	'Email',
			'index.php?panel=inst&menu=awarie'			=>	'Awarie',
			'index.php?panel=inst&menu=zlecenia'		=>	'Zlecenia',
			'index.php?panel=inst&menu=complaint'		=>	'Reklamacje',
			'index.php?panel=inst&menu=roster'			=>	'Grafik dyżurów',
			);

	foreach ( $inst_menu as $k => $v)
		if ( $v!='Awarie')
		{
			if ( ValidateAuth("'sprzedaz','inst', 'admin','fin'",$_SESSION['login'],$_SESSION['haslo']) )
				{
					print <<< HTML
						<tr class="tr3" onmouseover="this.style.backgroundColor='#D7D7D7'" onmouseout="this.style.backgroundColor=''">
						<td class="klasa5"> <a class="link" href=$k>&nbsp &nbsp          $v              </a> </td></tr>
HTML;
				}
		}
		else
		{
							print <<< HTML
						<tr class="tr3" onmouseover="this.style.backgroundColor='#D7D7D7'" onmouseout="this.style.backgroundColor=''">
						<td class="klasa5"> <a class="link" href=$k>&nbsp &nbsp          $v              </a> </td></tr>
HTML;

		}
?>

</table>
        </td>
	      <td style="height: 700px; width: 820px;" colspan="4" rowspan="1" class="klasa6">
	            <br />
