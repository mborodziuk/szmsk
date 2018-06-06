<form method="POST" action="index.php?panel=inst&menu=sendstb">
<table class="tbk3">
  <tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane Dekodera
		</td>
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
      <td> Typ </td>
				<td class="klasa4">
						<option> </option>
						<?php
							$typ=array('Soiav', 'Magic', 'Ultra', 'Korbox 3.0', 'MAG200', 'MAG250', 'Korbox', 'Jabkor', 'Korbox Wave');
							$www->SelectFromArray($typ, 'typ');
						?>
				</td>    </tr>
	 <tr>
      <td> Adres Fizyczny </td>
      <td>
		<input type="text" name="mac" size="20" />
		</td>
    </tr>
    <tr>
      <td> Numer seryjny </td>
      <td>
		<input type="text" name="sn" size="20" />
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
			Select($QA11,"taryfa");
		?>
      </td>
    </tr>
    <tr>
      <td> Dzierżawa </td>
      <td>
		<?php
			Select($QA17,"dzierzawa");
		?>
      </td>
    </tr>
		<tr>
      <td> PIN </td>
      <td>
		<input type="text" name="pin" size="20" />
		</td>
    </tr>
		<tr>
      <td> Data aktywacji </td>
      <td>
		<input type="text" name="data_aktywacji" size="20" />
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
							$www->Select3($dbh, $QUERY14, "mi", $stb[id_msi], $format);
						?>
				</td>
			</tr>		
	<tr>
		<td class="klasa1" colspan="2">
			<b> Pakiety dodatkowe</b>
		</td>
	</tr>
    <tr>
      <td> Pakiet 1 </td>
      <td>
		<?php
			Select($QA27,"pakiet1");
		?>
      </td>
		<tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[pakiet1_fv], "pakiet1_fv");
			?>
		 </td>
		</tr>	
    </tr>
    <tr>
      <td> Pakiet 2 </td>
      <td>
		<?php
			Select($QA27,"pakiet2");
		?>
      </td>
		<tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[pakiet2_fv], "pakiet2_fv");
			?>
		 </td>
		</tr>	
    </tr>
    </tr>
    <tr>
      <td> Pakiet 3 </td>
      <td>
		<?php
			Select($QA27,"pakiet3");
		?>
      </td>
		<tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[pakiet3_fv], "pakiet3_fv");
			?>
		 </td>
		</tr>	
    </tr>
    </tr>
    <tr>
      <td> Pakiet 4 </td>
      <td>
		<?php
			Select($QA27,"pakiet4");
		?>
      </td>
		<tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[pakiet4_fv], "pakiet4_fv");
			?>
		 </td>
		</tr>	
    </tr>
    </tr>
    <tr>
      <td> Pakiet 5 </td>
      <td>
		<?php
			Select($QA27,"pakiet5");
		?>
      </td>
					<tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[pakiet5_fv], "pakiet5_fv");
			?>
		 </td>
		</tr>	
    </tr>
    </tr>		

	<tr>
	 <td> 
  	 </td>
  	  <td>
  	  	<INPUT type="submit" name="wyslij" value="Dodaj" size="30" class="button1"> 
	 </td>
	 </tr>
  </tbody>
</table>

</form>


