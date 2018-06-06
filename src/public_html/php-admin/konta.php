
<a href="index.php?menu=dodajkonto"> Nowe konto </a> &nbsp;
<br/>
<br/>

<form method="POST" action="index.php?menu=delete">
<?php
	$_SESSION[del1]=array('aliasy_email'=>'id_konta', 'konta'=>'id_konta');
	$_SESSION[del2]=array();
?>

<table style="text-align: left; width: 750px; height: 50px;" class="tbk1">
  <tbody>
    <tr class="tr1">
      <td style="width: 80px;">
      	Id
      </td>
	   <td style="width: 100px;">
      	Login
       </td>
      <td style="width: 100px;">
      	Hasło
      </td>
      <td style="width: 100px;">
      	Aliasy
      </td>
   	<td style="width: 300px; ">
      Właściciel
      </td>
      <td style="width: 40px;">
 		Antyspam
      </td>
      <td style="width: 40px;">
	   Antywir
      </td>
      <td style="width: 40px;">
		Pojemność
      </td>
      <td style="width: 80px;">
      	Data utworzenia
      </td>
      <td style="width: 10px;">
			::
      </td>
    </tr>
    <?php
    ListaKont($dbh);
	?>
	<tr>
		<td class="klasa1" colspan="10">
				<input type="submit" value="Kasuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>

<form method="POST" action="index.php?menu=generate&typ=konta">
<table style="text-align: left; width: 800px; height: 30px;">
  <tbody>
    <tr class="tr1">
      <td style="width: 200px;">
				:: Generator konfiguracji
      </td>
		<td>
				<input type="submit" value="Uruchom" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>
