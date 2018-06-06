
<a href="index.php?menu=dodajdomene"> Nowa domena </a>
<br/>
<br/>

<form method="POST" action="index.php?menu=delete">
<?php
	$_SESSION[del1]=array('domeny'=>'nazwa');
	$_SESSION[del2]=array();
?>

<table style="text-align: left; width: 750px; height: 50px;" class="tbk1">
  <tbody>
    <tr class="tr1">
	   <td style="width: 240px;">
      	Nazwa
       </td>
      <td style="width: 150px;">
      	IP
      </td>
      <td style="width: 100px;">
      	Data rejestracji
      </td>
      <td style="width: 10px;">
			::
      </td>
    </tr>
    <?php
    ListaDomen();
	?>
	<tr>
		<td class="klasa1" colspan="4">
				<input type="submit" value="Kasuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>
