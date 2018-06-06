<form method="POST" action="index.php?panel=inst&menu=dodajkontowyslij">
<table style="align=center">
  <tbody>
	 <tr>
		 <td> Konto aktywne ? </td>
		 <td>
			 <input type="checkbox" checked="true" name="aktywne" value="ON" />
		 </td>
	 </tr>
    <tr>
      <td> Login </td>
      <td>
			<input type="text" name="login" size="30" />
		</td>
    </tr>
    <tr>
      <td> Hasło </td>
      <td>
		<input type="password" name="haslo1" size="30" />
		</td>
    </tr>
	 <tr>
      <td> Powtórz hasło </td>
      <td>
		<input type="password" name="haslo2" size="30" />
		</td>
    </tr>
	 <tr>
		 <td> Filtr antyspamowy </td>
		 <td>
			 <input type="checkbox" checked="true" name="antyspam" value="ON" />
		 </td>
	 </tr>
	 <tr>
		 <td> Filtr antywirusowy </td>
		 <td>
			 <input type="checkbox" checked="true" name="antywir" value="ON" />
		 </td>
	 </tr>
	 <tr>
		 <td> Pojemność </td>
		 <td>
			 <?php
				 Select($QUERY4,"pojemnosc");
			 ?>
			&nbsp;MB
		 </td>
	 </tr>
	<tr>
	 <td> 
  	 </td>
  	  <td>
  	  	<INPUT type="submit" name="wyslij" value="Załóż" size="30"> 
	 </td>
	 </tr>
  </tbody>
</table>

</form>