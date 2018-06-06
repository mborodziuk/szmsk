<a href="index.php?panel=fin&menu=dodajtow&typ=<?php echo $_GET[typ] ?> ">Nowy towar/usługa </a> &nbsp;
<br/>
<br/>

<form method="POST" action="index.php?menu=delete">

<?php
	if ($_GET[typ]=="sprzedaz")
		{
			$TABLE="towary_sprzedaz";
			$ID="id_tows";
		}
	else
		{
			$TABLE="towary_zakup";
			$ID="id_towz";
		}

	$_SESSION[del1]=array( $TABLE=>$ID);
	$_SESSION[del2]=array();

?>

<table style="text-align: left; width: 1000px; height: 50px;" class="tbk1">
  <tbody>
    <tr class="tr1">
      <td style="width: 40px;">
      	Id
      </td>
      <td style="width: 120px;">
      	Nazwa
       </td>
      <td style="width: 50px;">
      	PKWiU
      </td>
      <td style="width: 50px; ">
      	Cenna netto [zł]
      </td>
      <td style="width: 20px;">
      	VAT
      </td>
      <td style="width: 50px; ">
      	Cenna brutto [zł]
      </td>
      <td style="width: 150px; ">
      	Symbol      </td>
      <td style="width: 5px; ">
      	::
      </td>
    </tr>
    <?php
	    ListaTow($_GET[typ]);
	?>
	<tr>
		<td class="klasa1" colspan="7">
				<input type="submit" value="Kasuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>

<br/>