<form method="POST" action="index.php?menu=dodajdomenewyslij">
<table style="align=center">
  <tbody>
    <tr>
      <td> Nazwa </td>
      <td>
			<input type="text" name="nazwa" size="30"/>
		</td>
    </tr>
    <tr>
      <td> IP </td>
      <td>
			<input type="text" name="ip" size="30" value="83.16.19.42"/>
		</td>
    </tr>
    <tr>
      <td> Data rejestracji </td>
      <td>
			<input type="text" name="data_rej" size="10" value="<?php echo date('Y-m-d'); ?>"/>
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