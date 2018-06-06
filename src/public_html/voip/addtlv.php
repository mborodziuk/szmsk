<form method="POST" action="index.php?panel=inst&menu=sendtlv">
<table style="align=center">
  <tbody>
	 <tr>
	 		<td class="klasa1" colspan="2">
				Dane Telefonu Voip
		</td>
		</tr>
		<tr>
		 <td> Aktywny </td>
		 <td>
			 <input type="checkbox" name="aktywny" value="ON" />
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			 <input type="checkbox"  name="fv" value="ON" />
		 </td>
	 </tr>
    <tr>
      <td> Numer </td>
      <td>
		<input type="text" name="numer" size="30" value="32 745 33 "/>
		</td>
    </tr>	 
    <tr>
      <td> Abonent </td>
      <td>
		<?php
			$www->SelectWlasc($dbh, "abonent");
		?>
		</td>
    </tr>
    <tr>
      <td> Taryfa </td>
      <td>
		<?php
			Select($QA9,"taryfa");
		?>
      </td>
    </tr>
	 <tr>
      <td> Bramka </td>
      <td>
		<?php
			Select($QA10,"bramka");
		?>
		</td>
    </tr>
    <tr>
      <td> Data aktywacji </td>
      <td>
		<input type="text" name="data_aktywacji" size="20" value="<?php echo $conf[data]; ?>"/>
		</td>
    </tr>
		
	<tr>
		<td class="klasa1" colspan="2">
			<b> Utrzymanie linii </b>
		</td>
	</tr>
		 <tr>
		 <td> Aktywne </td>
		 <td>
			 <input type="checkbox"  name="addsrv7"  />
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowane </td>
		 <td>
			 <input type="checkbox"  name="addsrv7_fv"  />
		 </td>
	 </tr>	
	 
	<tr>
		<td class="klasa1" colspan="2">
			<b> Blok. połączeń po przekr. pakietu </b>
		</td>
	</tr>
		 <tr>
		 <td> Aktywne </td>
		 <td>
			 <input type="checkbox"  name="addsrv14"  />
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowane </td>
		 <td>
			 <input type="checkbox"  name="addsrv14_fv"  />
		 </td>
	 </tr>	
	 <tr>
	 <td> 
  	 </td>
  	  <td>
  	  	<INPUT type="submit" name="wyslij" value="Wyślij" size="30" class="button1"> 
	 </td>
	 </tr>
  </tbody>
</table>

</form>