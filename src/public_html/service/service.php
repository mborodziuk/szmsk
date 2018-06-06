<?php

class SERVICE
{


function AddNewTow($dbh, $typ)
{
	include "func/config.php";

	if ($typ =="sprzedaz")
		{
			$TABLE="towary_sprzedaz";
			$ID="id_tows";
		}
	else
		{
			$TABLE="towary_zakup";
			$ID="id_towz";
		}

	switch ($_POST[typ])
		{
			case "towar":
				$Q1="select $ID from $TABLE where $ID like 'TOW%' order by $ID desc limit 1";
				$id_tow=IncValue($dbh, $Q1, "TOW0000");
				break;
			case "usluga":
				$Q1="select $ID from $TABLE where $ID like 'USL%' order by $ID desc limit 1";
				$id_tow=IncValue($dbh, $Q1, "USL0000");
				break;
		}

	$tow=array (	
						$ID	=>$id_tow, 	'symbol'	=>	IsNull($_POST[symbol]), 'nazwa'	=>$_POST[nazwa],   'pkwiu'=>IsNull($_POST[pkwiu]),
						'vat'	=>$_POST[vat], 	'cena'		=>$_POST[cena], 'opis'=>IsNull($_POST[opis]), 'okres_gwar' => $_POST[okres_gwar], 'jm'	=> "szt.",
						'aktywny' => 'T', 'utelekom' => CheckboxToTable($_POST[utelekom])
					);
	Insert($dbh, $TABLE, $tow);
}

function UpdateTow($dbh, $typ, $id_tow)
{
	include "func/config.php";
	$tow0=$_SESSION[$id_tow.$_SESSION[login]];
		
	if ($typ =="sprzedaz")
		{
			$TABLE="towary_sprzedaz";
			$ID="id_tows";
		}
	else
		{
			$TABLE="towary_zakup";
			$ID="id_towz";
		}

	$tow=array (	
						$ID	=>$tow0[$ID], 		'symbol'		=>	IsNull($_POST[symbol]), 'nazwa'	=>$_POST[nazwa],   'pkwiu'=>IsNull($_POST[pkwiu]),
						'vat'	=>$_POST[vat], 	'cena'		=>$_POST[cena], 'opis'=>IsNull($_POST[opis]), 'okres_gwar' => $_POST[okres_gwar],
						'aktywny' => CheckboxToTable($_POST[aktywny]), 'utelekom' => CheckboxToTable($_POST[utelekom])
					);
	Update($dbh, $TABLE, $tow);

}

function ValidateTow()
{
	$flag=1;

	if ( empty ($_POST[nazwa]))
		{ 
			echo "Błąd pola 'Nazwa' : pole jest puste <br>";
			$flag=0;
		}	

	if ( empty($_POST[cena]) )
		{ 
			echo "Błąd pola 'Cena' : pole jest puste <br>";
			$flag=0;
		}

	return ($flag);
}

function Lista($dbh, $typ)
{
	include "func/config.php";

	if ($typ=="sprzedaz")
	{
		$p=array
		(	
			'order' => $_POST[order], 'rodzaj'	=> $_POST[rodzaj] , 'utelekom'	=> $_POST[utelekom], 'szukaj'	=> $_POST[szukaj] 
		);
	
	if ( $p[utelekom]=='Tak' )
		$ut='T';
	else if ( $p[utelekom]=='Nie' )
		$ut='N';
	
		
		$q="	select  id_tows, symbol, nazwa, pkwiu, vat, cena,  opis from towary_sprzedaz where aktywny='T' ";
	}
	else 
		$q="	select  id_towz, symbol, nazwa, pkwiu, vat, cena,  opis from towary_zakup order by nazwa";

	if (!empty($p[rodzaj]) && $p[rodzaj] !=$conf[select] )   
					$q.=" and nazwa like '%$p[rodzaj]%'";
	
	if (!empty($p[szukaj])  )   
					$q.=" and nazwa like '%$p[szukaj]%'";
					
	if (!empty($p[utelekom]) && $p[utelekom] !=$conf[select] )   
					$q.=" and utelekom='$ut'";
			
	$q.=" order by nazwa";
	
	WyswietlSql($q);
	$sth=Query($dbh,$q);
	$lp=1;
   while ($row =$sth->fetchRow())
		{
			DrawTable($lp++,$conf[table_color]);  	
			if ( $row[4]!="zw" && $row[4]!="-")
			{
				$netto=round ($row[5] / (1 + $row[4]/100), 2);
			}
			else
			{
				$netto=$row[5];
			}
 			echo "<td> <a href=\"index.php?panel=fin&menu=updatetow&typ=$typ&id=$row[0]\"> $row[0] </a> </td>";
  		echo "<td> <b> $row[2] </b></td>";
 			echo "<td> $row[3]</td>";
 			echo "<td> $netto </td>";
 			echo "<td> $row[4] % </td>";
			echo "<td> <strong>$row[5]</strong> </td>";
 			echo "<td> $row[1]</td>";
			echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
     echo "</tr>";
       }
}



}