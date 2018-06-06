
<table style="text-align: left; width: 600px; height: 75px;" border="1" cellpadding="2" cellspacing="3">
  <tbody>
    <tr class="tr1">
      <td style="width: 80px;">
      	Id
      </td>
      <td style="width: 170px;">
      	Nazwa
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
    </tr>
    <?php
		ListaKomputerow();
	?>
  </tbody>
</table>

<form method="POST" action="index.php?panel=inst&menu=generate&typ=netgen">
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