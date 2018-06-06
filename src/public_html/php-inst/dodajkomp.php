<form method="POST" action="index.php?panel=inst&menu=kompwyslij">
<table style="align=center">
  <tbody>
	 <tr>
		 <td> Podłączony </td>
		 <td>
			 <input type="checkbox" checked="true" name="podlaczony" value="ON" />
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			 <input type="checkbox" checked="true" name="fv" value="ON" />
		 </td>
	 </tr>
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
			Select($QA5,"taryfa");
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
			 <input type="checkbox" checked="true" name="net" value="ON" />
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
			 <input type="checkbox" name="dg" value="OFF" />
		 </td>
	 </tr>

	 <tr>
		 <td> Informacja o nieuregulowanych płatnościach </td>
		 <td>
			 <input type="checkbox" name="info" value="OFF" />
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