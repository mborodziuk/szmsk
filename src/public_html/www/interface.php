<?php

class WWW
{

function FormPrint($dbh, $form)
{

}
	

function TablePrint($dbh)
	{
	
	$name='cpe';
	
	$table=array( 
	
		'link' => array('href' => "index.php?panel=inst&menu=cpeadd", 'name' => 'Nowy zestaw'),
		'row'	=> array ('Id' =>'100', 'Typ' =>'200', 'Adresy fizyczne' =>'120', 'Adresy IP' =>'80', 'Abonent' =>'370', 'Wêz³y' =>'100', 'Interfejs' =>'300', '::' =>'20')
	);
	
	
	foreach ( $table as $el => $poz)
	{
		switch ($el)
		{
				case "link":
						echo "	<a href=\"$poz[href]\">$poz[name]</a> &nbsp;<br/><br/>";
				case "row":
						echo "----";
						
		
		}
	}
	/*
	<a href="index.php?panel=inst&menu=cpeadd">Nowy zestaw</a> &nbsp;
<br/>
<br/>

<form method="POST" action="index.php?panel=inst&menu=delete&typ=cpe">
<?
	$_SESSION[del1]=array('cpe'=>'id_cpe');
	$_SESSION[del2]=array();
?>


<table style="text-align: left; width: 1000px; height: 50px;" class="tbk1">
  <tbody>
    <tr class="tr1">
      <td style="width: 100px;">
      	Id
      </td>
      <td style="width: 200px;">
      	Typ
       </td>
			<td style="width: 120px; ">
      	Adresy fizyczne
      </td>
      <td style="width: 80px;">
      	Adresy IP
      </td>			
      <td style="width: 370px;">
      	Abonent
      </td>
      <td style="width: 100px;">
				Wêz³y
      </td>
      <td style="width: 300px;">
	      Interfejs
      </td>
      <td style="width: 20px;">
			::
      </td>
    </tr>
    <?php
    $cpe->CpeList($dbh);
	?>
	<tr>
		<td class="klasa1" colspan="10">
				<input type="submit" value="Kasuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>
	*/
	}
	
}	


?>
