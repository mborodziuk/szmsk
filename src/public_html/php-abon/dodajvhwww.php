<form method="POST" action="index.php?panel=inst&menu=dodajvhwwyslij">
<table style="align=center">
  <tbody>
    <tr>
      <td> Konto </td>
      <td>
		<?php
			Select($QUERY66, "konto");
		?>
		</td>
    </tr>
	 <tr>
		 <td> Host aktywny ? </td>
		 <td>
			 <input type="checkbox" checked="true" name="aktywny" value="ON" />
		 </td>
	 </tr>
    <tr>
      <td> Nazwa </td>
      <td>
			<input type="text" name="nazwa" size="30" value="www."/>
		</td>
    </tr>
    <tr>
      <td> Domena </td>
      <td>
			 <?php
				 Select($QUERY7,"domena");
			 ?>
		 </td>
	 </tr>
    <tr>
      <td> Katalog </td>
      <td>
			<input type="text" name="katalog" size="30" value="public_html"/>
		</td>
    </tr>
    <tr>
      <td> Data utworzenia </td>
      <td>
			<?php echo date('Y-m-d'); ?>
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