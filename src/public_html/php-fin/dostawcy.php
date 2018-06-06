<a href="index.php?menu=dodajdost">Nowy dostawca </a> &nbsp;
<br/>
<br/>

<form method="POST" action="index.php?menu=delete">
<?php
$_SESSION[del1]=array('dostawcy'=>'id_dost','telefony'=>'id_podm', 'maile'=>'id_podm','konta_bankowe'=>'id_wlasc', 'kontakty'=>'id_podm');
$_SESSION[del2]=array('telefony' => 'id_podm', 'maile'=>'id_podm');
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
      <td style="width: 120px;">
      	Adres
      </td>
      <td style="width: 140px; ">
      	Dane kontaktowe
      </td>
      <td style="width: 140px;">
      	Osoba kontaktowa
      </td>
      <td style="width: 10px;">
			::
      </td>
    </tr>
    <?php
	    ListaDostawcow();
	?>

	<tr>
		<td class="klasa1" colspan="6">
				<input type="submit" value="Kasuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>
<br/>