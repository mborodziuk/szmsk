<form method="POST" action="index.php?panel=inst&menu=kompwyslij">
<table style="align=center">
  <tbody>
    <tr>
      <td> Właściciel </td>
      <td>
		<?php
			SelectWlasc("wlasciciel");
		?>
		</td>
    </tr>
    <tr>
      <td> Taryfa </td>
      <td>
		<?php
			Select($QUERY5,"taryfa");
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
		<input type="text" name="mac" size="20" />
		</td>
    </tr>
    <tr>
      <td> Adres IP </td>
      <td>
		<input type="text" name="adresip" size="20" />
		</td>
    </tr>
	 <tr>
      <td> System operacyjny </td>
      <td>
			<select name="system">
				<option>Windows XP </option>
				<option>Windows 2000 </option>
				<option>Windows 2003 </option>
				<option>Windows 9X</option>
				<option>Linux  </option>
				<option>Inny  </option>
			</select>
		</td>
    </tr>
	 <tr>
		 <td> DHCP </td>
		 <td>
			 <input type="checkbox" checked="true" name="dhcp" value="ON" />
		 </td>
	 </tr>
	 <tr>
		 <td> Powiąż IP z MAC </td>
		 <td>
			 <input type="checkbox" checked="true" name="ipmac" value="ON" />
		 </td>
	 </tr>
	 <tr>
		 <td> Dostęp do Internetu </td>
		 <td>
			 <input type="checkbox" checked="true" name="inet" value="ON" />
		 </td>
	 </tr>
	 <tr>
		 <td> WWW przez proxy </td>
		 <td>
			 <input type="checkbox" checked="true" name="proxy" value="ON" />
		 </td>
	 </tr>
	 <tr>
		 <td> Blokada treści erotycznych </td>
		 <td>
			 <input type="checkbox" name="antyporn" value="OFF" />
		 </td>
	 </tr>
	 <tr>
		 <td> Przekierowanie GG </td>
		 <td>
			 <input type="checkbox" name="przekiergg" value="OFF" />
		 </td>
	 </tr>
	 <tr>
		 <td> Przekierowanie FTP </td>
		 <td>
			 <input type="checkbox" name="przekierftp" value="OFF" />
		 </td>
	 </tr>
	 <tr>
		 <td> Przekierowanie EMULE </td>
		 <td>
			 <input type="checkbox" name="przekieremule" value="OFF" />
		 </td>
	 </tr>
	 <tr>
		 <td> Przekierowanie inne </td>
		 <td>
			 <input type="checkbox" name="przekierinne" value="OFF" />
		 </td>
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