	<tr>
		<td class="klasa1" colspan="2">
				Dane Dekodera
		</td>
		<tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[aktywny], "aktywnys");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[fv], "fvs");
			?>
		 </td>
	 </tr>
     <tr>
      <td> Taryfa </td>
      <td>
		<?php
			Select($QA11,"taryfas", $stb[taryfa]);
		?>
      </td>
    </tr>	 
	 	 <tr>
      <td> Dekoder </td>
      <td>
		<?php
			Select($QA20,"stb", $stb[id_stb]);
		?>
		</td>
    </tr>
	 <tr>
      <td> Data aktywacji </td>
      <td>
		<input type="text" name="data_aktywacjis" size="20" value="<?php	empty($stb[data_aktywacji]) ? print "$Y-$m-01" : print "$stb[data_aktywacji]";	?>"/>
		</td>
    </tr
		<tr>
		<td class="klasa1" colspan="2">
			<b> Media Player </b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv5], "addsrv5");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv5_fv], "addsrv5_fv");
			?>
		 </td>
	 </tr>
	 
		<tr>
		<td class="klasa1" colspan="2">
			<b> Nagrywanie PVR</b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv6], "addsrv6");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv6_fv], "addsrv6_fv");
			?>
		 </td>
	 </tr>

	 

	 		<tr>
		<td class="klasa1" colspan="2">
			<b> Pakiet KIDS </b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv1], "addsrv1");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv1_fv], "addsrv1_fv");
			?>
		 </td>
	 </tr>
	 
		<tr>
		<td class="klasa1" colspan="2">
			<b> Pakiet PLANETE+</b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv2], "addsrv2");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv2_fv], "addsrv2_fv");
			?>
		 </td>
	 </tr>

			<tr>
		<td class="klasa1" colspan="2">
			<b> Pakiet HBO</b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv3], "addsrv3");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv3_fv], "addsrv3_fv");
			?>
		 </td>
	 </tr> 
		
<?php
	 print_r($stb);
?>	
	