<a href="index.php?menu=dodajgwar&typ=<?php echo $_GET[typ] ?> ">Nowa gwarancja </a> &nbsp;
<br/>
<br/>

<form method="POST" action="index.php?menu=delete">

<?php
	if ($_GET[typ]=="sprzedaz")
		{
			$TABLE1="gwarancje_sprzedaz";
			$TABLE2="pozycje_gwars";
			$ID="nr_gwar";
		}
	else
		{
			$TABLE1="gwarancje_zakup";
			$TABLE2="pozycje_gwarz";
			$ID="nr_gwar";
		}

	$_SESSION[del1]=array( $TABLE1=>$ID, $TABLE2=>$ID);
	$_SESSION[del2]=array();

?>

<table style="text-align: left; width: 750px; height: 50px;" class="tbk1">
  <tbody>
    <tr class="tr1">
      <td style="width: 40px;">
      	Nr gwarancji
      </td>
      <td style="width: 70px;">
      	Dostawca
       </td>
      <td style="width: 20px;">
      	Data wystawienia
      </td>
      <td style="width: 250px; ">
      	Pozycje
      </td>
      <td style="width: 5px; ">
      	::
      </td>
    </tr>
    <?php
	    ListaGwar($_GET[typ]);
	?>
	<tr>
		<td class="klasa1" colspan="5">
				<input type="submit" value="Kasuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>
<br/>