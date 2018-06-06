<a href="index.php?panel=fin&menu=dodajprac ">Nowy pracownik </a> &nbsp;
<br/>
<br/>

<form method="POST" action="index.php?panel=fin&menu=delete">
<?
	$_SESSION[del1]=array('pracownicy'=>'id_prac');
	$_SESSION[del2]=array();
?>

<table style="text-align: left; width: 750px; height: 50px;" class="tbk1">
  <tbody>
    <tr class="tr1">
      <td style="width: 40px;">
      	Id 
      </td>
      <td style="width: 120px;">
      	Imie i nazwisko
       </td>
      <td style="width: 200px;">
      	Adres
      </td>
      <td style="width: 100px; ">
      	Telefony
      </td>
      <td style="width: 100px;">
      	Adres e-mail
      </td>
      <td style="width: 10px;">
			::
      </td>
    </tr>
    <?
    ListaPracownikow();
	?>
	<tr>
		<td class="klasa1" colspan="6">
				<input type="submit" class="button1" value="Kasuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>
