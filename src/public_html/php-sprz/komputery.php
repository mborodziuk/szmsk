<a href="index.php?panel=inst&menu=dodajkomp">Nowy komputer</a> &nbsp;
<br/>
<br/>

<form method="POST" action="index.php?panel=inst&menu=delete&typ=komp">
<?php
	$_SESSION[del1]=array('komputery'=>'id_komp');
	$_SESSION[del2]=array();
?>


<table style="text-align: left; width: 750px; height: 50px;" class="tbk1">
  <tbody>
    <tr class="tr1">
      <td style="width: 80px;">
      	Id
      </td>
      <td style="width: 170px;">
      	Nazwa
       </td>
      <td style="width: 260px;">
      	Abonent
      </td>
      <td style="width: 90px;">
      	Adresy IP
      </td>
      <td style="width: 120px; ">
      	Adresy fizyczne
      </td>
      <td style="width: 130px;">
 		System operacyjny
      </td>
      <td style="width: 50px;">
	      Taryfa
      </td>
      <td style="width: 10px;">
			::
      </td>
    </tr>
    <?php
    ListaKomputerow();
	?>
	<tr>
		<td class="klasa1" colspan="10">
				<input type="submit" value="Kasuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>

<form method="POST" action="index.php?menu=generate&typ=netgen">
<table style="text-align: left; width: 750px; height: 30px;">
  <tbody>
    <tr class="tr1">
      <td style="width: 200px;">
				:: Generator konfiguracji
      </td>
		<td>
				<input type="submit" value="Uruchom >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>

