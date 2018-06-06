s		 <tr>
	 		<td class="klasa1" colspan="2">
				Dane Telefonu Voip
		</td>
		</tr>
		<tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($tlv[aktywny], "aktywny");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($tlv[fv], "fv");
			?>
		 </td>
	 </tr>
	 <tr>
      <td> Telefon </td>
      <td>
		<input type="text" name="numer" size="30" value="<?php echo "$tlv[numer]";  ?>"/>	
		</td>
    </tr> 
    <tr>
      <td> Taryfa </td>
      <td>
		<?php
			Select($QA9,"taryfat", $tlv[taryfa]);
		?>
      </td>
    </tr>
	 <tr>
      <td> Bramka </td>
      <td>
		<?php
			Select($QA10,"bramka", $tlv[id_bmk]);
		?>
		</td>
    </tr>
    <tr>
      <td> Data aktywacji </td>
      <td>
		<input type="text" name="data_aktywacji" size="20" value="<?php echo "$tlv[data_aktywacji]";  ?>"/>
		</td>
    </tr>
