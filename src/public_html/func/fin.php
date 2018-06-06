<?php

function IncNr($dbh, $Q, $id='')
{
	$sth=Query($dbh, $Q);
	while ($row =$sth->fetchRow())
		{
			$str=$row[0];
		}
	if (empty($str) && !empty($id)) $str=$id;

	$nr=explode("/", $str);

	for ( $i=0,$len=strlen($str);  $i<$len;  ++$i )
	{
		if ( is_numeric($str[$i]) ) 
		{
			$newstr=substr($str,0,$i);
			$int=mb_substr( $str, $i, $len );
			break;
		}
	}
	$n=strlen($int);
	++$int;
	$n-=strlen($int);
	while($n>0)
	{
		$int="0".$int;
		--$n;
	}
	$newstr.="$int";
	return "$newstr";
}


	function ListaPrac()
	{
		$dbh=DBConnect($DBNAME1);
		$query="select  id_pracy, nazwa, data_rozp, data_zak, kwota
					from prace order by id_pracy";

		$sth=Query($dbh,$query);
		$lp=1;
		 while ($row =$sth->fetchRow())
			{
				DrawTable($lp++,$conf[table_color]);  	

					echo "<td> <a href=\"index.php?panel=fin&menu=updateprace&praca=$row[0]\"> $row[0] </a> </td>";
					echo "<td> $row[1]</td>";
					echo "<td> $row[2]</td>";
					echo "<td> $row[3]</td>";
					echo "<td> $row[4]</td>";
				echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
			 echo "</tr>";
				 }
	}

	function ListaUmp()
	{
		$dbh=DBConnect($DBNAME1);
		$query="	select  um.nr_ump, p.nazwa, pr.nazwa, um.data_zawarcia, um.typ
					from umowypracy um, pracownicy p, prace pr 
					where	 p.id_prac=um.id_prac and um.id_pracy=pr.id_pracy order by um.nr_ump";

		$sth=Query($dbh,$query);
		$l=1;
		 while ($row =$sth->fetchRow())
			{
				DrawTable($lp++,$conf[table_color]);  	

					echo "<td> <a href=\"index.php?panel=fin&menu=updateump&ump=$row[0]\"> $row[0] </a> </td>";
					echo "<td> $row[1]</td>";
					echo "<td> $row[2]</td>";
					echo "<td> $row[3]</td>";
					echo "<td> $row[4] </td>";
				echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
			 echo "</tr>";
				 }
	}

	function AddNewUmp()
	{
		$dbh=DBConnect($DBNAME1);	


		$ump=array (	
							'nr_ump'				=>	$_POST[nr_ump], 			'id_prac'	=>	FindId2($_POST[pracownik]),	'id_pracy'	=>	FindId2($_POST[praca]),
							'data_zawarcia'	=>	$_POST[data_zawarcia],	'typ'			=>	$_POST[typ]
						);
		Insert($dbh, "UMOWYPRACY", $ump);
	}

	
	
	
	function ValidatePrace()
	{
		$flag=1;
		if ( empty ($_POST[nazwa]))
			{ 
				echo "Błąd pola 'Nazwa' : pole jest puste <br>";
				$flag=0;
			}	

		if ( empty($_POST[kwota]) )
			{ 
				echo "Błąd pola 'Kwota' : pole jest puste <br>";
				$flag=0;
			}

		if ( empty($_POST[opis]) )
			{ 
				echo "Błąd pola 'Opis' : pole jest puste <br>";
				$flag=0;
			}

		if ( !ValidateDate($_POST[data_rozp]) )
			{ 
				echo "Błąd pola 'Data rozpoczęcia'<br>";
				$flag=0;
			}

		if ( !ValidateDate($_POST[data_zak]) )
			{ 
				echo "Błąd pola 'Data zańczenia'<br>";
				$flag=0;
			}

		return ($flag);
	}

	function ValidateUmp()
	{
		$flag=1;
		if ( empty ($_POST[nr_ump]))
			{ 
				echo "Błąd pola 'Numer' : pole jest puste <br>";
				$flag=0;
			}	

		if ( !ValidateDate($_POST[data_zawarcia]) )
			{ 
				echo "Błąd pola 'Data zawarcia'";
				$flag=0;
			}

		return ($flag);
	}
	
	function AddNewPrace()
	{
		$dbh=DBConnect($DBNAME1);	

		$Q1="select id_pracy from prace order by id_pracy desc limit 1";
		$id_pracy=IncValue($dbh, $Q1, "PR0000");
		
		$praca=array (	
							'id_pracy'	=>	$id_pracy, 					'nazwa'		=>	$_POST[nazwa],				'opis'	=>	$_POST[opis],
							'data_rozp'	=>	$_POST[data_rozp],		'data_zak'	=>	$_POST[data_zak],			'kwota'	=>	$_POST[kwota]
						);
		Insert($dbh, "PRACE", $praca);
	}

	function UpdatePrace($id_pracy)
	{
		$dbh=DBConnect($DBNAME1);	

		$praca=array (	
							'id_pracy'	=>	$id_pracy, 					'nazwa'		=>	$_POST[nazwa],				'opis'	=>	$_POST[opis],
							'data_rozp'	=>	$_POST[data_rozp],		'data_zak'	=>	$_POST[data_zak],			'kwota'	=>	$_POST[kwota]
						);
		Update($dbh, "PRACE", $praca);
	}


	function UpdateUmp($nr_ump)
	{
		$dbh=DBConnect($DBNAME1);	

		$SESSION[ump]=$ump;
		$ump=array (	
							'nr_ump'				=>	$ump[nr_ump],		'nr_ump'				=>	$_POST[nr_ump], 			'id_prac'	=>	FindId2($_POST[pracownik]),	
							'id_pracy'	=>	FindId2($_POST[praca]),	'data_zawarcia'	=>	$_POST[data_zawarcia],	'typ'			=>	$_POST[typ]
						);
		Update($dbh, "UMOWYPRACY", $ump);
	}
	
	



//////////////// P I S M A ///////////////////////
//////////////////////////////////////////////////

function ListaPism($typ)
{
   include "config.php";
	$dbh=DBConnect($DBNAME1);

	function Druk($dbh,$typ, $query )
	{
		$sth=Query($dbh,$query);
		$lp=1;
	   while ($row =$sth->fetchRow())
		{
					DrawTable($lp++,$conf[table_color]);  	
  				echo "<td> <a href=\"index.php?panel=fin&menu=updatepismo&typ=$typ&pismo=$row[0]\"> $row[0] </a> </td>";
	  			echo "<td> $row[1] </td>";
  				echo "<td> $row[2]</td>";
  				echo "<td> $row[3]</td>";
  				echo "<td> $row[4]</td>";
					echo "<td class=\"klasa4\"> <a href=\"javascript&#058;displayWindow('pdf/mkpdf.php?dok=psw&id_psw=$row[0]',800,1100, '38')\"> 
					<img src=\"../graphics/pdf.gif\" width=\"32\" height=\"32\" border=\"0\"/> </a> </td>";  				echo "<td> <input 				type=\"checkbox\" name=\"$row[0]\" /> </td>";
  	 			echo "</tr>";
     		}
	}
		
	if ($typ=="przych")
		{
			$query1="select pp.id_pp, pp.data, pp.data_przyj, pp.dotyczy, pp.lok_fiz, pp.lok_kopii, i.nazwa
						from pisma_przych pp, instytucje i where pp.id_nad=i.id_inst order by pp.data"; 
			$query2="select pp.id_pp, pp.data, pp.data_przyj, pp.dotyczy, pp.lok_fiz, pp.lok_kopii, a.nazwa
						from pisma_przych pp, abonenci a where pp.id_nad=a.id_abon order by pp.data"; 
			$query3="select pp.id_pp, pp.data, pp.data_przyj, pp.dotyczy, pp.lok_fiz, pp.lok_kopii, d.nazwa
						from pisma_przych pp, dostawcy d where pp.id_nad=d.id_dost order by pp.data"; 
		}
	else
		{
			$query1="select pw.id_psw, pw.data, pw.dotyczy, pw.tresc, pw.autor
						from pisma_wych pw, instytucje i where pw.id_odb=i.id_inst order by pw.data"; 
			$query2="select pw.id_psw, pw.data, pw.dotyczy, pw.tresc, pw.autor
						from pisma_wych pw full join abonenci a on pw.id_odb=a.id_abon order by pw.data"; 
			$query3="select pw.id_psw, pw.data, pw.dotyczy, pw.tresc, pw.autor
						from pisma_wych pw, dostawcy d where pw.id_odb=d.id_dost order by pw.data"; 
		}

	//	Druk($dbh, $typ, $query1);
		Druk($dbh, $typ, $query2);
	//	Druk($dbh, $typ, $query3);

}

function ValidatePismo()
{
	$flag=1;

	if ( empty ($_POST[numer]))
		{ 
			echo "Błąd pola 'Numer' : pole jest puste <br>";
			$flag=0;
		}	

	if ( empty($_POST[data]) || !ValidateDate($_POST[data]))
		{ 
			echo "Błąd pola 'Pismo z dnia'<br>";
			$flag=0;
		}

	if ( empty($_POST[data_poczta])  || !ValidateDate($_POST[data_poczta]))
		{ 
			echo "Błąd pola 'Data otrzymania/wysłania' <br>";
			$flag=0;
		}

	return ($flag);
}

function AddNewPismo($typ)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	if ($typ=="przych")
		{
			$TABLE="pisma_przych";
			$ID="id_pp";
			$FK_NAME="id_nad";
			$DATA2="data_przyj";
			$NP="PP0000";
		}
	else
		{
			$TABLE="pisma_wych";
			$ID="id_pw";
			$FK_NAME="id_odb";
			$DATA2="data_wyj";
			$NP="PW0000";
		}

	if ( empty($_POST[instytucja]) && empty($_POST[abonent]) )
			$ID2=$_POST[dostawca];
	else 	if ( empty($_POST[instytucja]) && empty($_POST[dostawca]) )
			$ID2=$_POST[abonent];
	else 	if ( empty($_POST[dostawca]) && empty($_POST[abonent]) )
			$ID2=$_POST[instytucja];

	$Q1="select $ID from $TABLE order by $ID desc limit 1";
	$id_pisma=IncValue($dbh, $Q1, $NP);
	
	$pismo=array (	
						$ID			=>	$id_pisma, 					'numer'		=>	$_POST[numer],					'data'		=>	$_POST[data],
						$DATA2		=>	$_POST[data_poczta],		'dotyczy'	=>	IsNull($_POST[dotyczy]),	'lok_fiz'	=>	$_POST[lok_fiz],
						'lok_kopii'	=>	$_POST[lok_kopii],		$FK_NAME		=>	FindId2($ID2)
					);
	Insert($dbh, $TABLE, $pismo);
}

function UpdatePismo($typ, $id_pisma)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	if ($typ=="przych")
		{
			$TABLE="pisma_przych";
			$ID="id_psp";
			$FK_NAME="id_nad";
			$DATA2="data_przyj";
		}
	else
		{
			$TABLE="pisma_wych";
			$ID="id_psw";
			$FK_NAME="id_odb";
			$DATA2="data_wyj";
		}

	if ( empty($_POST[instytucja]) && empty($_POST[abonent]) )
			$ID2=$_POST[dostawca];
	else 	if ( empty($_POST[instytucja]) && empty($_POST[dostawca]) )
			$ID2=$_POST[abonent];
	else 	if ( empty($_POST[dostawca]) && empty($_POST[abonent]) )
			$ID2=$_POST[instytucja];

	
	$pismo=array (	
						$ID			=>	$id_pisma	, 									'numer'		=>	$_POST[numer], 				'data'		=>	$_POST[data],
						$DATA2		=>	$_POST[data_poczta],			'dotyczy'	=>	IsNull($_POST[dotyczy]),	'lok_fiz'	=>	$_POST[lok_fiz],
						'lok_kopii'	=>	$_POST[lok_kopii],			$FK_NAME		=>	FindId2($ID2)
					);
	Update($dbh, $TABLE, $pismo);
}


/////////////////////////////////////////////////
///////////// K s i a z e cz k i ////////////////
/////////////////////////////////////////////////
function ListaKa()
{
    include "config.php";
    $dbh=DBConnect($DBNAME1);
  
    $query="(select distinct a.id_abon, a.symbol, a.nazwa, u.kod, u.miasto, u.nazwa, b.numer, a.nr_mieszk
           from abonenci a,ulice u, budynki b
	   where u.id_ul=b.id_ul and a.id_bud=b.id_bud 
           )
	   union
	   (select distinct a.id_abon, a.symbol, a.nazwa, u.kod, u.miasto, u.nazwa, a.nr_bud, a.nr_mieszk
	    from abonenci a,ulice u, budynki b
	    where u.id_ul=a.id_ul)";
												   
    $sth=Query($dbh,$query);
    while ($row =$sth->fetchRow())
	{
	 echo "<tr>";
         echo "<td> <a href=\"index.php?panel=fin&menu=updateabon&abon=$row[0]\"> $row[0] </a> </td>";
         $s=Choose($row[1], $row[2]);
         echo "<td> $s </td>";
         echo "<td> $row[3] $row[4], ul. $row[5] $row[6]/$row[7] </td>";
	 echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
	 echo "</tr>";
        }
}

//////////////////////////////////////////////////
///////////// G W A R A N C J E //////////////////
//////////////////////////////////////////////////

function ListaTowGwar($typ)
{
   include "config.php";
	$dbh=DBConnect($DBNAME1);

	if ($typ=="sprzedaz")
		$query="	select id_tows, nazwa, okres_gwar, cena, symbol from towary_sprzedaz where aktywny='T' order by nazwa, id_tows";
	else 
		$query="	select id_towz, nazwa, okres_gwar, cena, symbol from towary_zakup order by nazwa, id_towz";

	$sth=Query($dbh,$query);
	$lp=1;
   while ($row =$sth->fetchRow())
		{
			 
			$tow[$row[0]]=$row[1];
			DrawTable($lp++,$conf[table_color]);  	
  			echo "<td> <a href=\"index.php?panel=fin&menu=updatetow&typ=$typ&id=$row[0]\"> $row[0] </a> </td>";
	  		echo "<td> $row[1]</td>";
  			echo "<td> $row[2]</td>";
  			echo "<td> <b> $row[3] </b> </td>";
  			echo "<td>";
  			echo "<select name=\"$row[0]\" >";
			for ($i=0; $i<101; ++$i)
				echo "<option> $i </option>";
			echo "</select>";
  			echo "</td>";
			echo "<td> $row[4]</td>";	
			echo "</tr>";
       }
	$_SESSION[tow]=$tow;
}

function ListaTowGwar2($typ)
{
   include "config.php";
	$dbh=DBConnect($DBNAME1);


	$tow=$_SESSION[tow];
	foreach ($_POST as  $k => $v )
		{
			while ($v>0)
				{
					--$v;
					echo "<tr>";
  					echo "<td> $k </td>";
	  				echo "<td> $tow[$k] </td>";
  					echo "<td> <input size=\"30\" name=\"$k-$v\" > </td>";
					echo "</tr>";
				}
		}

}

function ListaGwar($typ)
{
   include "config.php";
	$dbh=DBConnect($DBNAME1);

	if ($typ=="sprzedaz")
			$q1="	select  g.nr_gwar, a.symbol, g.data_wyst  from gwarancje_sprzedaz g, abonenci a where g.id_odb=a.id_abon order by g.data_wyst desc ";
	else 
			$q1="	select  g.nr_gwar, d.symbol, g.data_wyst  from gwarancje_zakup g, dostawcy d where d.id_dost=g.id_dost order by g.data_wyst desc ";
	$sth1=Query($dbh,$q1);
   while ($row1 =$sth1->fetchRow())
		{
			if ($typ=="sprzedaz")
				$q2="select t.symbol, p.nr_fabr, t.okres_gwar from pozycje_gwars p, towary_sprzedaz t where p.id_tows=t.id_tows and p.nr_gwar='$row1[0]' order by t.nazwa";
			else 
				$q2="select t.symbol, p.nr_fabr, t.okres_gwar from pozycje_gwarz p, towary_zakup t where p.id_towz=t.id_towz  and p.nr_gwar='$row1[0]' order by t.nazwa";
		
			echo "<tr>";
  			echo "<td> <a href=\"index.php?panel=fin&menu=updategwar&typ=$typ&nr=$row1[0]\"> $row1[0] </a> </td>";
	  		echo "<td> $row1[1]</td>";
  			echo "<td> $row1[2]</td>";
  			echo "<td>";
			$sth2=Query($dbh,$q2);
			while ($row2 =$sth2->fetchRow())
				{
					echo " <strong> $row2[0]</strong>   nr fabr. $row2[1]  gwar. $row2[2] <br>";
				}
			echo "</td>";
			echo "<td><input type=\"checkbox\" name=\"$row1[0]\"/></td>";
     echo "</tr>";
       }
}

function ListaPozGwar($typ, $nr)
{
   include "config.php";
	$dbh=DBConnect($DBNAME1);


	if ($_GET[typ]=="sprzedaz")
		{
			$q="	select t.symbol, p.nr_fabr, t.okres_gwar 
					from pozycje_gwars p, towary_sprzedaz t 
					where p.id_tows=t.id_tows and p.nr_gwar='$_GEt[nr]";
		}
	else 
		{
			$q="	select t.symbol, p.nr_fabr, t.okres_gwar 
					from pozycje_gwarz p, towary_zakup t 
					where p.id_towz=t.id_towz  and p.nr_gwar='$_GET[nr]'";
		}
	$Lp=0;
	$sth1=Query($dbh,$q);
	while ( $row1=$sth1->fetchRow() )
		{
			++$Lp;
			echo "<tr>";
			echo " <td> $Lp. </td> ";
			echo " <td> $row1[0] </td> ";
			echo " <td> $row1[1] </td> ";
			echo " <td> $row1[2] </td> ";
			echo "</tr>";
		}
}

function UpdateGwar($typ, $nr)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	if ($typ =="sprzedaz")
		{
			$TABLE1="gwarancje_sprzedaz";
			$TABLE2="pozycje_gwars";
			$IDK="id_odb";
			$nazwak="odbiorca";
		}
	else
		{
			$TABLE1="gwarancje_zakup";
			$TABLE2="pozycje_gwarz";
			$IDK="id_dost";
			$nazwak="dostawca";
		}

	$gwar=array
	(
		'nr_gwar'			=> $_POST[nr_gwar],				$IDK			=>FindId2($_POST[$nazwak]), 	'data_wyst'	=>$_POST[data_wyst], 	
	);
	$gwar2=array
	('nr_gwar'	=>$nr);

	$poz1=array('nr_gwar'=>$_POST[nr_gwar]);
	$poz2=array('nr_gwar'=>$nr);

	Update($dbh, $TABLE2, $poz1, $poz2);
	Update($dbh, $TABLE1, $gwar, $gwar2);

}

function AddPozGwar($typ)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	if ($typ =="sprzedaz")
		{
			$TABLE="pozycje_gwars";
			$NT="id_towz";
		}
	else
		{
			$TABLE="pozycje_gwarz";
			$NT="id_towz";
		}

	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" )
			{
				$id=explode("-",$k);
				$q3="insert into $TABLE values ('$v','$id[0]','$_SESSION[nr_gwar]')";
				echo "$q3 <br>";
				Query($dbh, $q3);
			}
		}

}

function AddNewGwar($typ)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	if ($typ =="sprzedaz")
		{
			$TABLE="gwarancje_sprzedaz";
			$ID="nr_gwar";
			$NK="id_odb";
		}
	else
		{
			$TABLE="gwarancje_zakup";
			$ID="nr_gwar";
			$NK="id_dost";
		}

	$gwar=array (	
						'nr_gwar'=>$_POST[nr_gwar], 	$NK	=>	FindId2($_POST[dostawca]), 'data_wyst'	=>$_POST[data_wyst]
					);
	Insert($dbh, $TABLE, $gwar);
}

function ValidateGwar()
{
	$flag=1;

	if ( empty ($_POST[nr_gwar]))
		{ 
			echo "Błąd pola 'Numer' : pole jest puste <br>";
			$flag=0;
		}	

	if ( !ValidateDate($_POST[data_wyst]) )
		{ 
			echo "Błąd pola 'Data wyatawienia' <br>";
			$flag=0;
		}

	return ($flag);
}

function ValidatePozGwar()
{
	$flag=1;
	foreach($_POST as $k => $v)
		if ( empty ($v))
			{ 
				$flag=0;
			}	
	if ($flag==0)
			echo "Błąd pola 'Numer fabryczny' : pole jest puste <br>";
	return ($flag);
}








//////////////////////////////////////////////////
//////////////// D O S T A W C Y ////////////////
////////////////////////////////////////////////

function ListaDostawcow()
{
   include "config.php";
	$dbh=DBConnect($DBNAME1);

	$query="select  id_dost, symbol, nazwa, ulica, nr_bud, nr_mieszk, miasto, kod, nip, regon, aktywny, pl_vat
				from dostawcy order by id_dost";

	$sth1=Query($dbh,$query);
	$lp=1;
   while ($row =$sth1->fetchRow())
		{
			$q2="select telefon, tel_kom from telefony where id_podm='$row[0]'";
  			$sth2=Query($dbh,$q2);
  			$row2=$sth2->fetchRow();
  			$q3="select email from maile where id_podm='$row[0]'";
  			$sth3=Query($dbh,$q3);
  			$row3=$sth3->fetchRow();
			$q5="select nazwa from kontakty where id_podm='$row[0]'";
   		$sth5=Query($dbh,$q5);
	   	$row5=$sth5->fetchRow();
			$q6="select t.telefon, t.tel_kom from telefony t, kontakty k where k.id_kontakt=t.id_podm and k.id_podm='$row[0]'";
   		$sth6=Query($dbh,$q6);
   		$row6=$sth6->fetchRow();
			$q7="select email from maile m, kontakty k where k.id_kontakt=m.id_podm and k.id_podm='$row[0]'";
   		$sth7=Query($dbh,$q7);
   		$row7=$sth7->fetchRow();

			DrawTable($lp++,$conf[table_color]);  	

  			echo "<td> <a href=\"index.php?panel=fin&menu=updatedost&dost=$row[0]\"> $row[0] </a> </td>";
	  		echo "<td> $row[1] </td>";
  			echo "<td> $row[7] $row[6],<br/> ul. $row[3] $row[4]/$row[5] </td>";
  			echo "<td>";
			if ( !empty($row2[0]) )
					echo "tel.:  $row2[0] <br>";
			if ( !empty($row2[1]) )
					echo "tel.kom.:  $row2[1] <br>";
			if ( !empty($row3[0]) )
					echo "e-mail:  $row3[0]";
			echo "</td>";	
  			echo "<td>";
			if ( !empty($row5[0]) )
				echo "$row5[0] <br/>";
			if ( !empty($row6[0]) )
				echo "tel.: $row6[0] <br/>";
			if ( !empty($row6[1]) )
				echo "tel.kom.: $row6[1] <br/>";
			if ( !empty($row7[0]) )
				echo "e-mail: $row7[0] <br/>";
			echo "</td>";
			echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
     echo "</tr>";
       }
}

function ValidateDost()
{
	$flag=1;

	if (  empty ($_POST["d_nazwa"]) ) 
	{
		echo "Błąd pola 'Nazwa dostawcy' : pole jest puste <br>";
		$flag=0;
	}

	if (  !ValidateKod($_POST["d_kod"]) ) 
	{
		$flag=0;
	}

	if (  !empty($_POST[d_kod]) && !ValidateKod($_POST["d_kod"]) ) 
	{
		$flag=0;
	}
	
	return ($flag);	
}

function UpdateDost($id_dost)
{
	include "config.php";

	$dbh=DBConnect($DBNAME1);	

	$ktk1=$_SESSION[kontakty];
	$teld1=$_SESSION[teld];
	$maild1=$_SESSION[maild];
	$telk1=$_SESSION[telk];
	$mailk1=$_SESSION[mailk];
	$kontod1=$_SESSION[kontod];

	$dost=array (	'id_dost'	=>$id_dost, 	'nazwa'	=>$_POST[d_nazwa],	'ulica'	=>$_POST[d_ulica], 'nr_bud'=>$_POST[d_nrbud],
						'nr_mieszk'	=>IsNull($_POST[d_nrmieszk]),'miasto'	=>$_POST[d_miasto], 	'kod'		=>$_POST[d_kod], 'symbol'=>$_POST[d_symbol],
						'nip'	=>IsNull($_POST[d_nip]), 'regon'	=>IsNull($_POST[d_regon]),
						'aktywny'		=>CheckboxToTable($_POST[d_aktywny]), 'pl_vat'=>CheckboxToTable($_POST[d_pl_vat]));
	Update($dbh, "dostawcy", $dost);

	if ( !empty($_POST[d_telefon]) || !empty($_POST[d_telkom]))
		{
			$teld2=array('id_podm'=> $id_dost, 'kierunkowy'=> "0-32", 'telefon' => IsNull($_POST[d_telefon]), 'tel_kom' => IsNull($_POST[d_telkom]));
			if ( !empty($teld1[telefon]) || !empty($teld1[tel_kom]) )
				Update($dbh, "TELEFONY", $teld2);
			else 
				Insert($dbh, "TELEFONY", $teld2);
		}
	else if ( empty($_POST[d_telefon]) && empty($_POST[d_telkom])  &&   ( !empty($teld1[telefon]) || !empty($teld1[tel_kom]) )  )
 		{
			$Q="delete from TELEFONY where id_podm='$id_dost'";
			echo $Q;
			Query($dbh, $Q);
		}

	if ( !empty($_POST[d_email]) )
			{
				$maild2=array('id_podm'=> $id_dost, 'email'=>$_POST[d_email]);
				if ( !empty($maild1[email]) )
					Update($dbh, "MAILE", $maild2);
				else 
					Insert($dbh, "MAILE", $maild2);
			}
	else if ( empty($_POST[d_email]) && !empty($maild1[email]) )
 		{
			$Q="delete from MAILE where id_podm='$id_dost'";
			echo $Q;
			Query($dbh, $Q);
		}

	
	if ( !empty($_POST[d_konto]) )
			{
				$kontod2=array('id_wlasc'=> $id_dost, 'nr_kb'=>$_POST[d_konto], 'bank'=>IsNull($_POST[d_bank]) );
				if ( !empty($kontod1[nr_kb]) )
					Update($dbh, "KONTA_BANKOWE", $kontod2);
				else 
					Insert($dbh, "KONTA_BANKOWE", $kontod2);
			}
	else if ( empty($_POST[d_konto]) && !empty($kontod1[nr_kb]) )
 		{
			$Q="delete from KONTA_BANKOWE where nr_kb='$kontod1[nr_kb]'";
			echo $Q;
			Query($dbh, $Q);
		}


	if ( !empty($_POST[k_nazwa]) )
		{
			if ( empty($ktk1[nazwa]) )
				{
					$Q="select id_kontakt from KONTAKTY order by id_kontakt desc limit 1";
					$id_kontakt=IncValue($dbh, $Q, "KTK0000");
					$ktk2=array( 'id_kontakt' => $id_kontakt, 			'nazwa' => $_POST[k_nazwa], 				'kod' => IsNull($_POST[k_kod]),
									'miasto' => IsNull($_POST[k_miasto]), 'ulica' => IsNull($_POST[k_ulica]),	'nr_bud' => IsNull($_POST[k_nrbud]),
									'nr_mieszk' => IsNull($_POST[k_nrlokalu]), 'id_podm' => $id_dost );
					Insert($dbh, "KONTAKTY", $ktk2);
				}
			else if ( !empty($ktk1[nazwa]) )
				{
					$Q="select id_kontakt from KONTAKTY where id_podm='$id_inst'";
		  			$sth=Query($dbh,$Q);
		  			$row=$sth->fetchRow();
		 			$id_kontakt=$row[0];
					$ktk2=array( 'id_kontakt' => $id_kontakt, 'id_podm' => $id_inst , 'nazwa' => $_POST[k_nazwa],		'kod' => IsNull($_POST[k_kod]),
									'miasto' => IsNull($_POST[k_miasto]), 'ulica' => IsNull($_POST[k_ulica]),	'nr_bud' => IsNull($_POST[k_nrbud]),
									'nr_mieszk' => IsNull($_POST[k_nrlokalu]));
					Update($dbh, "KONTAKTY", $ktk2);	
				}

		if ( !empty($_POST[k_telefon]) || !empty($_POST[k_telkom]))
			{
				if ( empty($telk1[telefon]) && empty($telk1[tel_kom]) )
					{
						$telk2=array('kierunkowy'=>'0-32', 'telefon'=>IsNull($_POST[k_telefon]), 'tel_kom'=>IsNull($_POST[k_telkom]), 'id_podm'=>$id_kontakt );
						Insert($dbh, "TELEFONY", $telk2);
					}
				else	if ( !empty($telk1[telefon]) || !empty($telk1[tel_kom]) )
					{
						$telk2=array('id_podm'=>$id_kontakt ,'telefon'=>IsNull($_POST[k_telefon]), 'tel_kom'=>IsNull($_POST[k_telkom]));
						Update($dbh, "TELEFONY", $telk2);
					}
			}
		else if ( empty($_POST[k_telefon]) && empty($_POST[k_telkom]) && (!empty($telk1[telefon]) || !empty($telk1[tel_kom])) )
			{
				$Q="delete from TELEFONY where id_podm='$id_kontakt'";
				echo $Q;
				Query($dbh, $Q);
			}

		if ( !empty($_POST[k_email]) )
			{
				if ( empty($mailk1[email]) )
					{
						$Q11="insert into MAILE values ('$_POST[k_email]', '$id_kontakt')";
						echo $Q11;
						Query($dbh, $Q11);
					}
				else
					{
						$Q11="update MAILE set 'email'='$_POST[k_email]' where 'id_podm'='$id_kontakt";
						echo $Q11;
						Query($dbh, $Q11);
						}
			}
		else if (empty($_POST[k_email])  && !empty($mailk1[email]) )
			{
				$Q="delete from MAILE where id_podm='$id_kontakt'";
				echo $Q;
				Query($dbh, $Q);
			}
	}
	else if ( empty($_POST[k_nazwa]) && !empty($ktk1[nazwa]) )
 		{
			$Q="delete from KONTAKTY where id_podm='$id_inst'";
			echo $Q;
			Query($dbh, $Q);
		}

}

function AddNewDost()
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	
	$Q1="select id_dost from dostawcy order by id_dost desc limit 1";
	$id_dost=IncValue($dbh, $Q1, "DOST000");

	$dost=array (	'id_dost'	=>$id_dost, 	'nazwa'	=>$_POST[d_nazwa],	'ulica'	=>$_POST[d_ulica], 'nr_bud'=>$_POST[d_nrbud],
						'nr_mieszk'	=>IsNull($_POST[d_nrmieszk]),'miasto'	=>$_POST[d_miasto], 	'kod'		=>$_POST[d_kod], 'symbol'=>$_POST[d_symbol],
						'nip'	=>IsNull($_POST[d_nip]), 'regon'	=>IsNull($_POST[d_regon]),
						'aktywny'		=>CheckboxToTable($_POST[d_aktywny]), 'pl_vat'=>CheckboxToTable($_POST[d_pl_vat]));
	Insert($dbh, "dostawcy", $dost);

	if ( !empty($_POST[d_telefon]) || !empty($_POST[d_telkom]))
		{
			$teld=array('kierunkowy'=> "0-32", 'telefon' => IsNull($_POST[d_telefon]), 'tel_kom' => IsNull($_POST[d_telkom]), 'id_podm'=> $id_dost);
			Insert($dbh, "TELEFONY", $teld);
		}

	if ( !empty($_POST[d_email]) )
			{
				$Q20="insert into MAILE values ('$_POST[d_email]', '$id_dost')";
				echo $Q20;
				Query($dbh, $Q20);
			}

	if ( !empty($_POST[d_konto]) )
		{
			$kontod=array('nr_kb'=> $_POST[d_konto], 'bank' => IsNull($_POST[d_bank]), 'id_wlasc'=> $id_dost);
			Insert($dbh, "KONTA_BANKOWE", $kontod);
		}

	
	if ( !empty($_POST[k_nazwa]) )
	{
		$Q="select id_kontakt from KONTAKTY order by id_kontakt desc limit 1";
		$id_kontakt=IncValue($dbh, $Q, "KTK0000");

		$ktk=array( 'id_kontakt' => $id_kontakt, 			'nazwa' => $_POST[k_nazwa], 				'kod' => IsNull($_POST[k_kod]), 'miasto' => IsNull($_POST[k_miasto]),
						'ulica' => IsNull($_POST[k_ulica]),	'nr_bud' => IsNull($_POST[k_nrbud]),	'nr_mieszk' => IsNull($_POST[k_nrlokalu]), 
						'id_podm' => $id_dost );

		Insert($dbh, "KONTAKTY", $ktk);

		if ( !empty($_POST[k_telefon]) || !empty($_POST[k_telkom]))
			{
				$ktk[td]=IsNull($_POST[k_telefon]);
				$ktk[tk]=IsNull($_POST[k_telkom]);
				$Q10="insert into TELEFONY values ('0-32', '$ktk[td]', '$ktk[tk]', '$id_kontakt')";
				echo $Q10;
				Query($dbh, $Q10);
			}
		if ( !empty($_POST[k_email]) )
			{
				$Q11="insert into MAILE values ('$_POST[k_email]', '$id_kontakt')";
				echo $Q11;
				Query($dbh, $Q11);
			}
	}
}


//////////////////////////////////////////////////
//////////////// T O W A R Y ////////////////////
////////////////////////////////////////////////

function AddNewTow($typ)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

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
						'aktywny' => 'T'
					);
	Insert($dbh, $TABLE, $tow);
}

function UpdateTow($typ, $id_tow)
{
	include "config.php";

	$dbh=DBConnect($DBNAME1);	

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
						$ID	=>$id_tow, 		'symbol'		=>	IsNull($_POST[symbol]), 'nazwa'	=>$_POST[nazwa],   'pkwiu'=>IsNull($_POST[pkwiu]),
						'vat'	=>$_POST[vat], 	'cena'		=>$_POST[cena], 'opis'=>IsNull($_POST[opis]), 'okres_gwar' => $_POST[okres_gwar],
						'aktywny' => CheckboxToTable($_POST[aktywny])
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

function ListaTow($typ)
{
   include "config.php";
	$dbh=DBConnect($DBNAME1);

	if ($typ=="sprzedaz")
		$query="	select  id_tows, symbol, nazwa, pkwiu, vat, cena,  opis from towary_sprzedaz where aktywny='T' order by nazwa";
	else 
		$query="	select  id_towz, symbol, nazwa, pkwiu, vat, cena,  opis from towary_zakup order by nazwa";

	$sth=Query($dbh,$query);
	$lp=1;
   while ($row =$sth->fetchRow())
		{
			DrawTable($lp++,$conf[table_color]);  	
			$netto=round ($row[5] / (1 + $row[4]/100), 2);
	  
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







?>
