
<form method="POST" action="index.php?panel=inst&menu=kompwyslij">
<table style="align=center">
  <tbody>
	 <tr>
		 <td> Aktywne </td>
		 <td>
			 <input type="checkbox" checked="true" name="aktywne" value="ON" />
		 </td>
	 </tr>
	  <tr>
      <td> Abonent </td>
      <td>
		<?php
			$www->SelectWlasc($dbh, "wlasciciel");
		?>
		</td>
    </tr>

    <tr>
      <td> Nazwa komputera </td>
      <td>
		<input type="text" name="nazwa" size="30" />
		</td>
    </tr>
	 <tr>
      <td> Adres fizyczny </td>
      <td>
		<input type="text" name="mac0" size="20" value="00:00:00:00:00:00" />
		</td>
    </tr>
    <tr>
      <td> Adres IP </td>
      <td>
		<input type="text" name="ip0" size="20" value="10.0.0.0"/>
		</td>
    </tr>
	 <tr>
      <td> System operacyjny </td>
      <td>
			<select name="system">
				<option>Windows Vista </option>
				<option selected>Windows XP </option>
				<option>Windows 2000 </option>
				<option>Windows 2003 </option>
				<option>Windows 9X</option>
				<option>Linux  </option>
				<option>Inny  </option>
			</select>
		</td>
    </tr>

	 </tr>

	<tr>
	 <td> 
  	 </td>
  	  <td>
  	  	<INPUT type="submit" name="wyslij" value="Dodaj" size="30"> 
	 </td>
	 </tr>
  </tbody>
</table>

</form>