<!-- id_usaw        | character(8)           | not null
 czas_rozp      | character(19)          |
 czas_us        | character(19)          | not null
 usuwajacy      | character(6)           | not null
 opis_usuniecia | character varying(400) |
 licznik_przed  | real                   |
 licznik_po     | real                   |
 id_awr         | character(8)           |
-->
<form method="POST" action="index.php?panel=inst&menu=dodajusawrwyslij&awr=<?php echo $_GET[awr] ?>">
<table style="width:500px" >
  <tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane awarii
		</td>
	</tr>
	<tr>
		<td class="klasa2"> 
				Usuwający
		</td> 
		<td class="klasa4">
			<?php
				Select($QUERY12, "usuwajacy");
			?>
		</td>
	</tr> 	<tr>
		<td class="klasa2">
			Opis usunięcia
		</td>
		<td class="klasa2">
			<textarea name="opis" cols="60" rows="3"></textarea>
		</td>	
	</tr>

	<tr>
	 <td> 
  	 </td>
  	  <td>
  	  	<INPUT type="submit" name="wyslij" value="Wprowadź" size="30"> 
	 </td>
	 </tr>
  </tbody>
</table>

</form>
