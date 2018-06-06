<a href="index.php?panel=fin&menu=dodajbud">Nowy budynek </a> &nbsp;
<br/>
<br/>

<form method="POST" action="index.php?menu=delete">
<?php
	$_SESSION[del1]=array('budynki'=>'id_bud');
	$_SESSION[del2]=array();
?>
<table style="text-align: left; width: 750px; height: 50px;" class="tbk1">
  <tbody>
    <tr class="tr1">
      <td style="width: 40px;">
      	Id
      </td>
      <td style="width: 150px;">
      	Adres budynku
       </td>
      <td style="width: 70px;">
      	Administracja
      </td>
	      <td style="width: 70px;">
      	Ilość abonentów
      </td>
      <td style="width: 70px;">
      	Ilość mieszkańców
      </td>
      <td style="width: 70px; ">
      	Przyłącze
      </td>
      <td style="width: 70px;">
      	Adresacja IP
      </td>
      <td style="width: 10px;">
			::
      </td>
    </tr>
    <?php
    ListaBudynkow();
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
