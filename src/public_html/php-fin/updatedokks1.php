<?php
	if ($_GET[typ]=="sprzedaz")
		{
			$TABLE="pozycje_gwars";
			$ID="id_tows";
			$kontrach="odbiorca";
			$IDK="id_odb";
			$NR_DK="nr_ds";
		}
	else
		{
			$TABLE="pozycje_gwarz";
			$ID="id_towz";
			$kontrach="sprzedawca";
			$IDK="id_dost";
			$NR_DK="nr_dz";
		}

/*	$dokks=array
	(
	$NR_DK			=> $_GET[nr], 			$IDK			=> FindId2($_POST[$kontrach]),
	'data_wyst'		=> $_POST[data_wyst],	'data_sprzed'	=>$_POST[data_sprzed], 	'term_plat'	=> CountDate($_POST[data_wyst], $_POST[term_plat]),
	'miejsce_wyst'	=> $_POST[miejsce_wyst], 'forma_plat'	=>$_POST[forma_plat], 	'stan'		=> $_POST[stan]
	);
*/

	
//echo $_POST[data_wyst];
// echo $dokks[nr_ds];

	if ($_GET[typ]=="sprzedaz")
			$dokks[wystawil]=$_POST[wystawil];
	

?>
<form method="POST" action="index.php?panel=fin&menu=newpozdokkswyslij">
<table style="text-align: left; width: 800px; height: 75px;" border="1" cellpadding="0" cellspacing="0">
  <tbody>
    <tr class="tr1">
      <td style="width: 40px;">
      	Id
      </td>
      <td style="width: 200px;">
      	Nazwa
       </td>
      <td style="width: 50px;">
      	Okres gwarancji
      </td>
      <td style="width: 10px;">
      	Cena
      </td>					
      <td style="width: 10px;">
      	Ilość
      </td>
	      <td style="width: 150px;">
      	Symbol
      </td>			
    </tr>
    <?php
	    ListaTowGwar("sprzedaz");
	?>
	<tr>
		<td class="klasa1" colspan="4">
				<input type="submit" class="button1" value="Dalej >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>
<br/>
