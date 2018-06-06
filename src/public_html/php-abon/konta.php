
<a href="index.php?panel=inst&menu=dodajkonto"> Nowe konto </a> &nbsp;
<br/>
<br/>

<form method="POST" action="index.php?panel=inst&menu=delete">
<?php
	$_SESSION[del1]=array('konta'=>'id_konta');
	$_SESSION[del2]=array();
?>
<table style="text-align: left; width: 600px; height: 75px;" border="1" cellpadding="0" cellspacing="0">
  <tbody>
    <tr class="tr1">
      <td style="width: 60px;">
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
		ListaKont();
	?>
	<tr>
		<td class="klasa1" colspan="9">
				<input type="submit" value="Kasuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>

<form method="POST" action="index.php?panel=inst&menu=generate&typ=konta">
<table style="text-align: left; width: 600px; height: 30px;">
  <tbody>
    <tr class="tr1">
      <td style="width: 200px;">
				:: Wprowadź zmiany
      </td>
		<td>
				<input type="submit" value="OK" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>
