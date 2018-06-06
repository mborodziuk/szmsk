<a href="index.php?menu=dodajprace&praca=<?php echo $_GET[praca]; ?>">Nowa praca </a> &nbsp;
<br/>
<br/>

<form method="POST" action="index.php?menu=delete">
<?php
	$_SESSION[del1]=array('prace'=>'id_pracy');
	$_SESSION[del2]=array();
?>

<table style="text-align: left; width: 750px; height: 50px;" class="tbk1">
  <tbody>
    <tr class="tr1">
      <td style="width: 40px;">
      	Id 
      </td>
      <td style="width: 50px;">
      	Nazwa skrócona
       </td>
      <td style="width: 50px;">
			Data rozpoczęcia
      </td>
      <td style="width: 100px; ">
			Data zakończenia
      </td>
      <td style="width: 100px;">
      	Kwota
      </td>
      <td style="width: 10px;">
			::
      </td>
    </tr>
    <?php
	    ListaPrac();
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