<a href="index.php?menu=dodajpismo&typ=<?php echo $_GET[typ]; ?>">Nowe pismo </a> &nbsp;
<a href="javascript&#058;displayWindow('pdf/mkpdf.php?dok=psma',650,1000, '38')">Pisma do abonentów</a> &nbsp;

<br/>
<br/>

<form method="POST" action="index.php?menu=delete">
<?php
	if ($_GET[typ]=="przych")
		{
			$TABLE="pisma_przych";
			$ID="id_pp";
		}
	else
		{
			$TABLE="pisma_wych";
			$ID="id_pw";
		}

	$_SESSION[del1]=array($TABLE=>$ID);
	$_SESSION[del2]=array();
?>

<table style="text-align: left; width: 800px; height: 75px;" class="tbk1">
  <tbody>
    <tr class="tr1">
      <td style="width: 40px;">
      	Id 
      </td>
      <td style="width: 50px;">
      	Pismo z dnia
       </td>

      <td style="width: 100px; ">
			<?php
				if ( $_GET[typ]=="przych" )
					echo "Nadawca";
				else 
					echo "Odbiorca";
			?>
      </td>
      <td style="width: 100px;">
      	Dotyczy
      </td>
      <td style="width: 100px;">
      	Treść
      </td>
      <td style="width: 100px;">
      	Autor
      </td>
      <td style="width: 10px;">
			::
      </td>
    </tr>
    <?php
	    ListaPism( $_GET[typ] );
	?>
	<tr>
		<td class="klasa1" colspan="8">
				<input type="submit" value="Kasuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>

<br/>