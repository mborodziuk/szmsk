
<a href="index.php?menu=dodajvhftp"> Nowy wirtualny host ftp </a>
<br/>
<br/>

<form method="POST" action="index.php?menu=delete">
<?php
	$_SESSION[del1]=array('vhost_ftp'=>'id_vhf');
	$_SESSION[del2]=array();
?>
<table style="text-align: left; width: 600px; height: 75px;" border="1" cellpadding="0" cellspacing="0">
  <tbody>
    <tr class="tr1">
      <td style="width: 80px;">
      	Id
      </td>
	   <td style="width: 110px;">
      	Nazwa
       </td>
      <td style="width: 110px;">
      	Domena
      </td>
      <td style="width: 110px;">
      	Katalog
      </td>
      <td style="width: 110px;">
      	Port
      </td>
      <td style="width: 90px;">
 			Konto
      </td>
      <td style="width: 80px;">
      	Data utworzenia
      </td>
       <td style="width: 10px;">
			::
      </td> 

   </tr>
    <?php
		ListaVHF();
	?>
	<tr>
		<td class="klasa1" colspan="9">
				<input type="submit" value="Kasuj >>>" name="przycisk">
		</td>

  </tbody>
</table>

</form>

<form method="POST" action="index.php?menu=generate&typ=vhost">
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
