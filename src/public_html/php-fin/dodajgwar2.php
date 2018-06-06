<form method="POST" action="index.php?menu=newgwarwyslij&typ=<?php echo $_GET[typ]?>">

<?php
	if ($_GET[typ]=="sprzedaz")
		{
			$TABLE="pozycje_gwars";
			$ID="id_tows";
		}
	else
		{
			$TABLE="pozycje_gwarz";
			$ID="id_towz";
		}

?>

<table style="text-align: left; width: 600px; height: 75px;" border="1" cellpadding="0" cellspacing="0">
  <tbody>
    <tr class="tr1">
      <td style="width: 40px;">
      	Id
      </td>
      <td style="width: 200px;">
      	Nazwa
       </td>
      <td style="width: 40px;">
      	Numer fabryczny
      </td>
    </tr>
    <?php
	    ListaTowGwar2($_GET[typ]);
	?>
	<tr>
		<td class="klasa1" colspan="3">
				<input type="submit" value="Dalej >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>
<br/>
