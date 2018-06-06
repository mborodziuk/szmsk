<?php
?>
 <tr>
      <td class="klasa1">
			 <strong> Id komputera </strong>
		</td>
      <td class="klasa1">
			<?php	
				echo "$komp[id_komp]";	
			?>
		</td>
    </tr>
	 <tr>
		 <td> Podłączony </td>
		 <td>
			<?php
			empty($komp[podlaczony]) ? print TableToCheckbox("T", "podlaczony") : print TableToCheckbox($komp[podlaczony], "podlaczony") ;
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				empty($komp[fv]) ? print TableToCheckbox("T", "fv") : print TableToCheckbox($komp[podlaczony], "fv") ;
			?>
		 </td>
	 </tr>
   <tr>
      <td> Taryfa </td>
      <td>
			<?php
				$www->Select2($dbh, $QA5, "taryfak", $komp[id_taryfy]);
			?>
      </td>
    </tr>
    <tr>
      <td> Nazwa komputera </td>
      <td>
		<input type="text" name="nazwa" size="30" value="<?php echo $komp[nazwa_smb]; ?>"/>
		</td>
    </tr>
	 <tr>
      <td> Adresy fizyczne </td>
      <td>

			<table class="tbk1">
			  <tbody>
  				  <tr>
					<td>
						<input type="text" name="mac0" size="17" value="<?php	empty($mac[0]) ? print "00:00:00:00:00:00" : print "$mac[0]";	?>"/>
					</td>
				</tr>
  				  <tr>
					<td>
						<input type="text" name="mac1" size="17" value="<?php	echo "$mac[1]";	?>"/>
					</td>
				</tr>
  				  <tr>
					<td>
						<input type="text" name="mac2" size="17" value="<?php	echo "$mac[2]";	?>"/>
					</td>
				</tr>
				</tbody>
			</table>

		</td>
    </tr>
    <tr>
      <td> Adresy IP </td>
      <td>
			<table class="tbk1">
			  <tbody>
  				  <tr>
					<td>
						<input type="text" name="ip0" size="10" value="<?php	empty($ip[0]) ? print "10.0.0.0" : print "$mac[0]";	?>"/>
					</td>
				</tr>
  				  <tr>
					<td>
						<input type="text" name="ip1" size="10" value="<?php	echo "$ip[1]";	?>"/>
					</td>
				</tr>
  				  <tr>
					<td>
						<input type="text" name="ip2" size="10" value="<?php	echo "$ip[2]";	?>"/>
					</td>
				</tr>
				</tbody>
			</table>
		</td>
    </tr>
	 <tr>
		 <td> DHCP </td>
		 <td>
			<?php
				empty($komp[dhcp]) ? print TableToCheckbox("T", "dhcp") : print TableToCheckbox($komp[dhcp], "dhcp") ;
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Powiąż IP z MAC </td>
		 <td>
			<?php
				empty($komp[ipmac]) ? print TableToCheckbox("T", "ipmac") : print TableToCheckbox($komp[ipmac], "ipmac") ;
			?>
	 </td>
	 </tr>
	 <tr>
		 <td> Dostęp do Internetu </td>
		 <td>
			<?php
				empty($komp[net]) ? print TableToCheckbox("T", "net") : print TableToCheckbox($komp[net], "net") ;
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> WWW przez proxy </td>
		 <td>
			<?php
				empty($komp[proxy]) ? print TableToCheckbox("T", "proxy") : print TableToCheckbox($komp[proxy], "proxy") ;
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Blokada treści erotycznych </td>
		 <td>
			<?php
				empty($komp[dg]) ? print TableToCheckbox("N", "dg") : print TableToCheckbox($komp[dg], "dg") ;
			?>
		 </td>
	 </tr>

	 <tr>
		 <td> Informacja o nieuregulowanych płatnościach  </td>
		 <td>
			<?php
				empty($komp[info]) ? print TableToCheckbox("N", "info") : print TableToCheckbox($komp[info], "info") ;
			?>
		 </td>
	 </tr>
	 <?php
	 print_r($komp);
?>	 
		