
<form method="POST" action="index.php?panel=inst&menu=kompwyslij">
<table style="align=center">
  <tbody>
		<tr>
		<td class="klasa1" colspan="2">
			<b> Dane komputera (hosta)</b>
		</td>
	</tr>
	    <tr>
      <td> Data podłaczenia </td>
      <td>
		<input type="text" name="data_podl" size="20" value="<?php echo $conf[pierwszy]; ?>"/>
		</td>
    </tr> 
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
			$www->SelectWlasc($dbh,"wlasciciel");
		?>
		</td>
    </tr>
    <tr>
      <td> Usługa </td>
      <td>
		<?php
			Select($QA5,"usluga");
		?>
      </td>
    </tr>
    <tr>
      <td> Taryfa </td>
      <td>
		<?php
			Select($QA21,"taryfa");
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
		<input type="text" name="mac0" size="20" />
		</td>
    </tr>
  <tr>
      <td> Adres IP </td>
      <td>
		<?php
			$ip=array("Prywatny", "Publiczny");
			$www->SelectFromArray($ip, "ipadres");
		?>
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
				<td class="klasa1" colspan="2">
					Miejsce instalacji
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Adres
				</td>
				<td class="klasa4">
						<option> </option>
						<?php
							$format=array(0=>'', 1=>'', 2=>'lok. ', 3=>'', 4=>'');
							$www->Select3($dbh, $QUERY14, "mi", $komp[id_msi], $format);
						?>
				</td>
			</tr>
		<tr>
			<td>
			<a href="index.php?panel=inst&menu=msiadd&mi=<?php echo "$_GET[abon]" ?>"> Inny adres >>> </a>
			</td>
			</tr>		
	 <tr> 
		<tr>
		<td class="klasa1" colspan="2">
			<b> Zewnętrzny Adres IP</b>
		</td>
	</tr>
		 <tr>
		 <td> Aktywny </td>
		 <td>
			 <input type="checkbox"  name="ipzewn"  />
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			 <input type="checkbox"  name="ipzewn_fv"  />
		 </td>
	 </tr>
	<tr>
		<tr>
		<td class="klasa1" colspan="2">
			<b> Antywirus</b>
		</td>
	</tr>
		 <tr>
		 <td> Aktywny </td>
		 <td>
			 <input type="checkbox"  name="antywirus"  />
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			 <input type="checkbox"  name="antywirus_fv"  />
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