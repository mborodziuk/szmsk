  <form method="POST" action="index.php?panel=fin&menu=wczytajwplwyslij">
  <table style="text-align: left; width: 750px; height: 60px;" border="1" cellpadding="0" cellspacing="0">
    <tbody>		
	<tr class="tr1">
      <td style="width: 20px; ">
      	Lp.
      </td>
	<td style="width: 200px;">
      	Nazwa
      </td>
      <td style="width: 100px;">
      	Rozmiar
      </td>
    <td style="width: 100px;">
      	Właściciel
      </td>
      <td style="width: 100px;">
		Prawa dostępu
    </td>
      <td style="width: 100px; ">
      	Ostatni dostęp 
      </td>
      <td style="width: 20px; ">
      	::
      </td>
    </tr>

    <?php
	ListaPlikowWplat();
    ?>
	<tr>
    	<td class="klasa1" colspan="6">
	    <input type="submit" class="button1" value="Wczytaj >>>" name="przycisk">
	</td>
	</tr>
  </tbody>
</table>
</form>

<br/>