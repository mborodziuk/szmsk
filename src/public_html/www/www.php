<?php

class WWW
{
function Adres($array)
{
	if ( !empty($array[kod]))
		if ( !empty($array[lokal]))
			$adres="$array[kod] $array[miasto], $array[cecha] $array[ulica] $array[budynek]/$array[lokal]";
		else
			$adres="$array[kod] $array[miasto], $array[cecha] $array[ulica] $array[budynek]";
	else
			if ( !empty($array[lokal]))
			$adres="$array[miasto], $array[cecha] $array[ulica] $array[budynek]/$array[lokal]";
		else
			$adres="$array[miasto], $array[cecha] $array[ulica] $array[budynek]";
	
	return ($adres);
}

function SelectWlasc($dbh, $name='', $active='')
{
	include "func/config.php";
	$sth=Query($dbh,$QUERY2);

	if ( !empty($active) )
	{
		if (preg_match("/ /", $active))
			{
				$id=explode(" ", $active);
				$ida=array_pop($id);
			}
		else
			$ida=$active;
	}

	if ( !empty($name) )
		echo "<select name=\"$name\">";
	$flag1=0;
 	$flag2=0;
	while ($row =$sth->fetchRow())
		{
			if ( !empty($ida) && $flag2==0)
				foreach ($row as $i) 
					if ($i == $ida)
					    $flag1=1;
			if ($flag1==1)
				{
				    echo "<option selected>";
				    $flag1=0;
			    	    $flag2=1;
				}
			else
			    echo "<option>";
			echo Choose($row[1], $row[2])." $row[0]";
			echo "</option>";
		}

	if ($flag2==0 )
		echo "<option selected> $conf[select] </option> ";
	else
		echo "<option> </option>";
	if ( !empty($name) )
		echo "</select>";

}




function Select2($dbh, $query, $name='', $active='', $oth='')
{
    include "func/config.php";
		WyswietlSql($query);
    $sth=Query($dbh,$query);
        
    if ( !empty($name) )
        echo "<select name=\"$name\">";
        
    if ( !empty($active) )
        {
            if (preg_match("/ /", $active))
                {
                    $id=explode(" ", $active);
                    $ida=array_pop($id);
                }
            else
	        $ida=$active;
        }
    $flag1=0;
    $flag2=0;
    while ($row =$sth->fetchRow())
        {
            if ( !empty($ida) && $flag2==0)
                foreach ($row as $i)
	            if ($i == $ida)
                        $flag1=1;
            if ($flag1==1)
            {
                echo "<option selected>";
                $flag1=0;
                $flag2=1;
            }
            else
                echo "<option>";
            foreach ($row as $i)
            {
                echo " $i  ";
            }
    	    echo "</option>";
        }
    if ( $flag2==0 && !empty($name) )
        echo "<option selected> $conf[select] </option> ";
		else
		        echo "<option> $conf[select] </option> ";
    if ( !empty($oth) )
        echo "<option> $oth </option> ";
    if ( !empty($name) )
        echo "</select>";
}


function Select3($dbh, $query, $name='', $active='', $format='')
{
    include "func/config.php";
		WyswietlSql($query);
    $sth=Query($dbh,$query);
        
    if ( !empty($name) )
        echo "<select name=\"$name\">";
        
    if ( !empty($active) )
        {
            if (preg_match("/ /", $active))
                {
                    $id=explode(" ", $active);
                    $ida=array_pop($id);
                }
            else
	        $ida=$active;
        }
    $flag1=0;
    $flag2=0;
    while ($row =$sth->fetchRow())
        {
            if ( !empty($ida) && $flag2==0)
                foreach ($row as $i)
	            if ($i == $ida)
                        $flag1=1;
            if ($flag1==1)
            {
                echo "<option selected>";
                $flag1=0;
                $flag2=1;
            }
            else
                echo "<option>";
            foreach ($row as $k => $v)
            {
							if ( !empty($v) && !empty($format))
                echo " $format[$k] $v  ";
							else 
                echo " $v  ";							
            }
    	    echo "</option>";
        }
    if ( $flag2==0 && !empty($name) )
        echo "<option selected> $conf[select] </option> ";
		else
		        echo "<option> $conf[select] </option> ";
    if ( !empty($oth) )
        echo "<option> $oth </option> ";
    if ( !empty($name) )
        echo "</select>";
}



function Abonent($dbh, $poz)
{
  echo"<td> Abonent </td><td>";
	$this->SelectWlasc($dbh, "abonent", $poz[value]);
	echo"</td></tr>";
}

function SelectWWW($dbh, $poz)
{
  echo"<td> $poz[wyswietl] </td><td>";
  $this->Select3($dbh, $poz[query],$poz[name], $poz[value], $poz[format]);
	echo"</td></tr>";
}

function SelectArray($poz)
{
	  echo"<td> $poz[wyswietl] </td><td>";
		$this->SelectFromArray($poz[tablica], $poz[name], $poz[value]);
	echo"</td></tr>";
}

function SelectFromArray($array, $name='', $id='', $oth='')
{
	if ( !empty($name) )
		echo "<select name=\"$name\">";

   foreach ($array as $i)
		{
			if ($i == $id)
				echo "<option selected>";
			else
				echo "<option>";
			echo " $i  </option>";
		}
	if ( !empty($name) )
		echo "</select>";
}

function Checkbox($poz)
{
	if ($poz[value] == "T")
		echo "<tr><td> $poz[wyswietl] </td><td><input type=\"checkbox\" checked=\"true\" name=\"$poz[name]\" value=\"on\" /></td></tr>";
	else 
		echo "<tr><td> $poz[wyswietl] </td><td><input type=\"checkbox\" name=\"$poz[name]\" value=\"off\" /></td></tr>";
	
}

function Input($array)
{
	print <<< HTML
    <tr>
      <td> $array[wyswietl] </td>
      <td>
		<input type="text" name="$array[name]" size="$array[size]" value="$array[value]"/>
		</td>
    </tr>
HTML;
}

function Link($a)
{
echo "  <tr>  <td>  --- </td>   <td>	<a href=\"$a[href]\">$a[name]</a> </td>   </tr>";
}

function PrintList($dbh, $v)
{
		print <<< HTML
				<td class="klasa4" colspan="7">
				<table class="tbk1" style="text-align: center; width: 100%; height: 75px;" border="1" cellpadding="0" cellspacing="0">
				  <tbody>
    					<tr class="tr1">
HTML;
			
		foreach ( $v as $el => $poz )
		{
			switch ($el)
			{
					case 'add':
						$q=$poz[query];
						$t=$poz[type];
						break;
					case 'row':
						WyswietlSql($q);
						foreach ( $poz as $k=>$v)
							{ 
								echo "<td style=\"width: \"$v\"px;\">$k</td>";
							}
						beak;
						$sth1=Query($dbh,$q);
						$lp=0;
						$l=1;
						while ($row1=$sth1->fetchRow())
							{
								DrawTable($l++,$conf[table_color]);  	
									{
										$lp++;
										$menu=$t."upd";
								    echo "<td> $lp </td>";
										echo "<td> <a href=\"index.php?panel=admin&menu=$menu&$t=$row1[0]\"> $row1[0] </a> </td>";
										echo "<td> $row1[1] </td>";
										echo "<td> $row1[2] </td>";
										echo "<td> $row1[3] </td>";
										echo "<td> $row1[4] </td>";
										echo "<td> $row1[5] </td>";
										echo "<td> $row1[6] </td>";
								echo "<td><input type=\"checkbox\" name=\"$row1[0]\"/></td>";
								}
							}
						echo "</tr></tbody>	</table></td></tr>";
						break;
					case "link":
						echo "	<tr><td><a href=\"$poz[href]\">$poz[name]</a> </td></tr>";
						break;	
			}
		}
}

function ObjectAdd($dbh, &$object, $table=Null)
{
	$form=$object->Form($table);
	
	foreach ( $form as $el => $poz )
	{
		switch ($el)
		{
				case 'form':
						echo "<form method=\"POST\" action=\"$poz[action]\"><table class=\"tbk3\"><tbody>	<tr><td class=\"klasa1\" colspan=\"10\">
				$poz[name]		</td><tr>";
						break;
				case "checkbox":
						foreach ($poz as $v)
							$this->Checkbox($v);
						break;
				case "input":
						foreach ($poz as $v)
							$this->Input($v);
						break;
				case "abonent":
				    $this->Abonent($dbh, $poz);
						break;
				case "select":
						foreach ($poz as $v)
							$this->SelectWWW($dbh, $v);
						break;
				case "link":
						foreach ($poz as $v)
							$this->Link($v);
						break;	
				case "selectarray":
						foreach ($poz as $v)
							$this->SelectArray($v);
						break;
				case "list":
						foreach ($poz as $v)
							$this->PrintList($dbh, $v);
						break;	
		}
	}

	print <<< HTML
	<tr>
	 <td> 
  	 </td>
  	  <td>
  	  	<INPUT type="submit" name="wyslij" value="Wprowadź" size="30" class="button1"> 
	 </td>
	 </tr>
  </tbody>
</table>

</form>
HTML;
}
	


function TablePrint($dbh, &$object, $p)
{
  include "func/config.php";
	$table=$object->table;
	
	foreach ( $table as $el => $poz)
	{
		switch ($el)
		{
				case "link":
						echo "	<a href=\"$poz[href]\">$poz[name]</a> &nbsp;<br/><br/>";
						break;
				case 'form':
						echo "<form method=\"POST\" action=\"$poz[action]\">";
						break;
				case "table":
					echo "<table style=\"text-align: left; width: 100%; height: 50px;\" class=\"tbk1\">  <tbody>  <tr class=\"tr1\">";
						break;
				case "row":
						foreach ( $poz as $k=>$v)
							{
								echo "<td style=\"width: \"$v\"px;\">$k</td>";
							}
						beak;
						
		
		}
	}
	
	$object->PrintList($dbh, $this, $p);
	print <<< HTML
		<tr>
		<td class="klasa1" colspan="10">
				<input type="submit" value="Kasuj >>>" name="przycisk" class="button1">
		</td>
	</tr>
  </tbody>
</table>
</form>
HTML;
	}
	

function PanelPrint($dbh,  &$object, $p)
{
  include "func/config.php";
	
	
	$panel=$object->panel;
	
	foreach ( $panel as $el => $poz)
	{
		
		if ($el == "link")
		{
			print <<< HTML1
	<form method="POST" action="$poz[href]">
<table style="text-align: left; width:1000px; height: 50px;" class="tbk1">
  <tbody>
	    <tr class="tr1">
HTML1;
		}
		else
		{
			echo "<td> $el</td>";
		}
	}
	print <<< HTML2
		</tr>
		    <tr class="tr1">

      <td style="width: 200px;">
HTML2;
	
	foreach ( $panel as $el => $poz)
	{
		
		if ($el != "link")
		{
			array_unshift($poz, "$conf[select]");
			$this->SelectFromArray($poz,"$el", $p[$el]); 
			echo "</td>      <td style=\"width: 200px;\">";
		}
	}
		
	print <<< HTML3
		<td class="klasa4">
				<input size="80" name="szukaj" >
		</td>
	 
		<td style="width: 200px;">
				<input type="submit" class="button1" value="Filtruj" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>
HTML3;
}
	
function PaginationPrint($page, $pages, $next, $back, $url)
{
	$liczba=40;
	
	if($page > 1) 
	{
    echo '<a href=index.php?'.$url . $back . '> <<< Poprzednia &nbsp;</a>';
	}
	for($pg=1; $pg<=$pages; $pg++) 
	{
		echo '<a href=index.php?'.$url . $pg . '>' .$pg. '&nbsp;</a>';
				if ( $pg%$liczba == 0 )
					echo '<br/>';
	}
	
 if($page < $pages) 
	{
	    echo '<a href=index.php?'.$url . $next . '>&nbsp Następna >>> </a>';

	}
	
		echo "<br/><br/>";
}	



function Delete1 ($dbh, $array1, $array2='', $array3='')
{
  //include "config.php";
	$q="";
	
	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" )
			{
				if ( !empty($array1) )
					foreach ($array1 as $k1 => $v1)
						{ 
							$q.="delete from $k1 where $v1='$k';";
						}
				if ( !empty($array2) )
					foreach ($array2 as $k2 => $v2)
						{ 
							$q.="delete from $k2 where $v2='$k';";
						}

				if ( !empty($array3) )
					foreach ($array3 as $k3 => $v3)
						{ 
							$q.="delete from $k3 where $v3='$k'";
						}
			}
		}
	WyswietlSql($q);	
	Query($dbh, $q);
	echo "Usunięto dane z systemu.";
}

}	


?>
