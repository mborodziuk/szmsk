<form method="POST" action="index.php?panel=fin&menu=fabonwyslij">

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

	$_SESSION[fabon]=array
	(
	'data_wyst'		=> $_POST[data_wyst],	'data_sprzed'	=>$_POST[data_sprzed],
	'miejsce_wyst'	=> $_POST[miejsce_wyst], 'wystawil'=> $_POST[wystawil]
	);


?>

<table style="text-align: left; width: 700px; height: 75px;" border="1" cellpadding="0" cellspacing="0">
  <tbody>
    <tr class="tr1">
      <td style="width: 40px;">
      	Id
      </td>
      <td style="width: 200px;">
      	Nazwa abonenta
       </td>
      <td style="width: 350px;">
      	Adres
       </td>
      <td style="width: 50px;">
      	Ilość komp.
      </td>
      <td style="width: 10px;">
      	FV
      </td>
    </tr>
    <?php
	    ListaFAbon();
	?>
	<tr>
		<td class="klasa1" colspan="5">
				<input type="submit" class="button1" value="Dalej >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>
<br/>
