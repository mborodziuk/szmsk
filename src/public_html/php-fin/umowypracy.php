<a href="index.php?menu=dodajump&ump=<?php echo $_GET[ump]; ?>">Nowa umowa </a> &nbsp;
<br/>
<br/>

<form method="POST" action="index.php?menu=delete">
<?php
	$_SESSION[del1]=array('umowypracy'=>'nr_ump');
	$_SESSION[del2]=array();
?>

<table style="text-align: left; width: 800px; height: 75px;" border="1" cellpadding="0" cellspacing="0">
  <tbody>
    <tr class="tr1">
      <td style="width: 40px;">
      	Id 
      </td>
      <td style="width: 50px;">
      	Pracownik
       </td>
      <td style="width: 50px;">
			Praca
      </td>
      <td style="width: 100px; ">
			Data zawarcia
      </td>
      <td style="width: 100px;">
      	Typ
      </td>
      <td style="width: 10px;">
			::
      </td>
    </tr>
    <?php
	    ListaUmp();
	?>
	<tr>
		<td class="klasa1" colspan="6">
				<input type="submit" value="Kasuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>

<br/>