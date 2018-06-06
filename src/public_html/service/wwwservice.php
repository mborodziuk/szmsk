<a href="index.php?panel=fin&menu=dodajtow&typ=<?php echo $_GET[typ] ?> ">Nowy towar/usługa </a> &nbsp;
<br/>
<br/>

<form method="POST" action="index.php?panel=fin&menu=tow&typ=sprzedaz">
<table style="text-align: center; width: <?php echo $conf[width2];?>; height:<?php echo $conf[height2];?>" class="tbk1">
  <tbody>
    <tr class="tr1">
      <td> Rodzaj </td>
			<td> Usługi telekomunikacyjne </td>
      <td> Sortowanie  </td>
      <td> Szukaj  </td>
      <td> Wyślij  </td>
		</tr>
		    <tr class="tr1">

      <td style="width: 200px;">
			<?php
				$taryfa=array("$conf[select]", "Abonament", "Dzierżawa", "Instalacja", "Aktywacja", "Dostęp do Internetu");
				$www->SelectFromArray($taryfa,"rodzaj", $_POST[rodzaj]); 
			?>
		</td>
      <td style="width: 200px;">
			<?php
				$taryfa=array("$conf[select]", "Tak", "Nie");
				$www->SelectFromArray($taryfa,"utelekom", $_POST[utelekom]); 
			?>
		</td>
		<td style="width: 200px;">
			<?php
				$order=array("$conf[select]", "Nazwa abonenta");
				$www->SelectFromArray($order,"order", $_POST[order]); 
			?>
		</td>
		<td class="klasa4">
				<input size="80" name="szukaj" >
		</td>
	 
		<td style="width: 200px;">
				<input type="submit" class="button1" value="Filtruj" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>


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

<table style="text-align: center; width: <?php echo $conf[width2];?>; height:<?php echo $conf[height2];?>" class="tbk1">
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
	    $service->Lista($dbh, $_GET[typ]);
	?>
	<tr>
		<td class="klasa1" colspan="8">
				<input type="submit" value="Kasuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>

<br/>