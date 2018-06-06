<tr>

<td style="text-align: left; vertical-align: top; margin-left : 20px; width: 100px;" class="klasa6">
<table style="width: 180px;" class="tbk2">
<?php

	$admin_menu=array(

			'index.php?panel=admin&menu=abonenci' 					=> 	'Abonenci', 
			'index.php?panel=admin&menu=voipcon'						=> 	'Połączenia Voip',			
		
		'index.php?panel=admin&menu=nodes&order=id_wzl' 	=> 	'Węzły',
			'index.php?panel=admin&menu=odf' 				=> 	'Przełącznice',
			'index.php?panel=admin&menu=ap' 				=> 	'Nadajniki',
			'index.php?panel=admin&menu=olt' 				=> 	'OLTy',
			'index.php?panel=admin&menu=spliter'		=> 	'Splitery',
			'index.php?panel=admin&menu=mufy' 			=> 	'Mufy',
			'index.php?panel=admin&menu=line' 			=> 	'Linie',

			'index.php?panel=admin&menu=snt' 				=> 	'Podsieci',
			'index.php?panel=admin&menu=sectors' 		=> 	'Sektory',			
			'index.php?panel=admin&menu=konta'			=>	'Konta',
			'index.php?panel=admin&menu=taryfa' 		=> 	'Taryfy',
			'maps/map.php' 													=> 	'Mapa sieci',
			
			'index.php?panel=admin&menu=domeny'			=>	'Domeny',
			'index.php?panel=admin&menu=awarie'			=>	'Awarie',
			'index.php?panel=admin&menu=zlecenia'		=>	'Zlecenia',
			'index.php?panel=admin&menu=statystyki'	=>	'Statystyki',
			'index.php?panel=admin&menu=operator'		=>	'Operatorzy',
			
			'index.php?panel=admin&menu=report'			=>	'Raporty',
			'index.php?panel=admin&menu=phpinfo'			=>	'PHP info',
			'http://my.netico.pl'										=>	'phpMyAdmin',
			'http://pg.netico.pl'										=>	'phpPgAdmin',
			'https://reseler.voip.artcom.pl/'			=>	'Artcom VOIP',
			'https://nieczesto.avios.pl/admin/' =>   'AVIos'
			);

	foreach ( $admin_menu as $k => $v)
			print <<< HTML
				<tr class="tr3" onmouseover="this.style.backgroundColor='#D7D7D7'" onmouseout="this.style.backgroundColor=''">
        <td class="klasa5"> <a class="link" href=$k>&nbsp &nbsp          $v              </a> </td></tr>
HTML;
?>

</table>
        </td>
	      <td style="height: 700px; width: 100%;" colspan="4" rowspan="1" class="klasa6">
	            <br />
																																																							 