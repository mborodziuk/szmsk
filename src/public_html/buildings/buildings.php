<?php

class BUILDINGS
{


///////////////////////////////////////////////////
//////////////// B U D Y N K I ///////////////////
/////////////////////////////////////////////////

function BuildingList($dbh, $p, $www=NULL)
{
	include "func/config.php";
	$results=$p[liczba];

	$_SESSION[$session[building][pagination]]=$_POST;
	
		$q="select b.id_bud, u.nazwa_1, u.nazwa_2, b.numer, s.nazwa, a.symbol, b.il_mieszk, b.przylacze, p.adres, p.maska 
		from 
		((budynki b join (ulic u join simc s on u.gmi=s.gmi and u.pow=s.pow) on 'b.id_ul'='u.id') 
		left join instytucje a on b.id_adm=a.id_inst) 
		left join 
		(( inst_vlanu v left join adresy_ip i on v.id_ivn=i.id_urz) left join podsieci p on p.id_pds=i.id_pds)
		on b.id_ivn1=v.id_ivn
		order by u.nazwa_1, s.nazwa,  b.numer, b.id_bud"; 
		
	WyswietlSql($q);
	$sth=Query($dbh,$q);
	$lp=1;
   while ($row =$sth->fetchRow())
		{
			$q1="	select count(k.id_abon) from miejsca_instalacji m, komputery k where k.id_msi=m.id_msi and m.id_bud='$row[0]'"; 
			//WyswietlSql($q1);
			$sth1=Query($dbh,$q1);
			$row1 =$sth1->fetchRow();
			DrawTable($lp++,$conf[table_color]);  	
				echo "<td> <a href=\"index.php?panel=fin&menu=buildupd&bud=$row[0]\"> $row[0] </a> </td>";
	  		echo "<td> ul. $row[1] $row[3], $row[4]</td>";
  			echo "<td> $row[5]</td>";
  			echo "<td> $row1[0]</td>";
  			echo "<td> $row[6]</td>";
  			echo "<td> $row[7]</td>";
  			echo "<td> $row[8] <br> $row[8] </td>";
			echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
     echo "</tr>";
		}
		
	
	$q1="select b.id_bud, u.nazwa, b.numer, u.miasto, a.symbol, b.il_mieszk, b.przylacze, p.adres, p.maska, a.nazwa, u.nazwa2
	from 
	((budynki b join ulice u on b.id_ul=u.id_ul) left join instytucje a on b.id_adm=a.id_inst) 
	left join 
	(( inst_vlanu v left join adresy_ip i on v.id_ivn=i.id_urz) left join podsieci p on p.id_pds=i.id_pds)
	on b.id_ivn1=v.id_ivn 
  where b.data_podl <= '$p[data_do]' and b.data_podl >= '$p[data_od]'"; 
	
	$q3="select count(*) from 
	((budynki b join ulice u on b.id_ul=u.id_ul) left join instytucje a on b.id_adm=a.id_inst) 
	left join 
	(( inst_vlanu v left join adresy_ip i on v.id_ivn=i.id_urz) left join podsieci p on p.id_pds=i.id_pds)
	on b.id_ivn1=v.id_ivn
	where b.data_podl <= '$p[data_do]' and b.data_podl >= '$p[data_od]'"; 
	
		if (!empty($p[predkosc]) && $p[predkosc] !=$conf[select] )   
		{
			$q1.=" and b.przylacze like '%$p[predkosc]%'";
			$q3.=" and b.przylacze like '%$p[predkosc]%'";
		}				
	if (!empty($p[miasto]) && $p[miasto] !=$conf[select] )  
		{
			$q1.=" and u.miasto='$p[miasto]'";
			$q3.=" and u.miasto='$p[miasto]'";
		}
	if (!empty($p[ul]) && $p[ul] !=$conf[select] )  
		{
			$q1.=" and u.nazwa='$p[ul]'";
			$q3.=" and u.nazwa='$p[ul]'";
		}
	//WyswietlSql($q3);
		
	$countData=Query2($q3, $dbh);

	$pages=ceil($countData[0]/$results);
	$page = isset($_GET['page']) ? $_GET['page'] : 1; 
	$next = $page + 1;
	$back = $page - 1; 
	$start = $page * $results - $results; 

	if ( $pages >1 )
		{
			$url="panel=fin&menu=buildings&order=$_GET[order]&page=";
			$www->PaginationPrint($page, $pages, $next, $back, $url);
		}
				
		$q1.=" order by $_GET[order] limit $results offset $start";	
		
	WyswietlSql($q1);
	$q='';
	$sth=Query($dbh,$q1);
	$lp=1;
   while ($row =$sth->fetchRow())
		{
			$q1="	select count(k.id_abon) from miejsca_instalacji m, komputery k where k.id_msi=m.id_msi and m.id_bud='$row[0]'"; 
			WyswietlSql($q1);
			$sth1=Query($dbh,$q1);
			$row1 =$sth1->fetchRow();
			DrawTable($lp++,$conf[table_color]);  	
				echo "<td> <a href=\"index.php?panel=fin&menu=buildupd&bud=$row[0]\"> $row[0] </a> </td>";
	  		echo "<td> $row[3]</td>";
	  		echo "<td> $row[1] $row[10] $row[2] </td>";
  			echo "<td> $row[4]</td>";
  			echo "<td> $row1[0]</td>";
  			echo "<td> $row[5]</td>";
  			echo "<td> $row[6]</td>";
  			echo "<td> $row[7] <br> $row[8] </td>";
			echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
     echo "</tr>";
		}


		
}

function BuildAdd($dbh)
{
	include "func/config.php";
	$id_bud=IncValue($dbh, $QA15, "bud000");

	if ( empty( $_POST[inna_ul] ) && $_POST[ulica]!="Inna")
		{
			$bud=array (
			'id_bud'		=> $id_bud, 	
			'data_podl'	=> $_POST[data_podl], 
			'id_ul'			=> FindId2( $_POST[ulica] ), 
			'id_adm'		=> FindId2( $_POST[administracja] ),   
			'numer'			=> $_POST[nr_bud], 
			'il_mieszk'	=> IsNull($_POST[il_mieszk]), 	
			'przylacze'	=> $_POST[przylacze], 
			'id_wzl'		=> FindId2($_POST[wzl]),
			'id_ivn1'		=> FindId2($_POST[ivn1]),
			'id_ivn2'		=> FindId2($_POST[ivn2]),
			'id_ivn3'		=> FindId2($_POST[ivn3]));
		}
	else	if ( !empty( $_POST[inna_ul] ) && !empty( $_POST[miasto] ) && !empty( $_POST[kod] ) && $_POST[ulica]=="Inna")
		{
			$Q1="select id_ul from ulice order by id_ul desc limit 1";
			$id_ul=IncValue($dbh, $Q1, "ul0000");
			$ul=array( 'id_ul'=> $id_ul ,	'cecha'=> $_POST[cecha],	'nazwa'=>	$_POST[inna_ul], 'miasto'=> $_POST[miasto], 'powiat'=> $_POST[miasto], 'gmina'=> $_POST[miasto], 'kod'=> $_POST[kod]);
		
		if ( ValidateKod($_POST[kod]) )
				{
					Insert($dbh, "ulice", $ul);
					$bud=array ('id_bud'	=>$id_bud, 	'id_ul'	=>	$id_ul, 'id_adm'	=>FindId2( $_POST[administracja] ),   'numer'=>$_POST[nr_bud],
								'il_mieszk'	=>IsNull($_POST[il_mieszk]), 	'przylacze'		=>$_POST[przylacze], 			'data_podl'	=> $_POST[data_podl] );
				}
		}		
	Insert($dbh, "budynki", $bud);
			
}


function BuildUpd($dbh, $id_bud)
{	
	include "func/config.php";

	if ( empty( $_POST[inna_ul] ) && $_POST[ulica]!="Inna")
		{
			$bud=array (	
			'id_bud'			=> $id_bud, 	
			'data_podl'		=> $_POST[data_podl], 
			'id_ul'				=> FindId2( $_POST[ulica] ), 
			'id_adm'			=> FindId2( $_POST[administracja] ),   
			'numer'				=> $_POST[nr_bud],
			'il_mieszk'		=> IsNull($_POST[il_mieszk]), 	
			'przylacze'		=> $_POST[przylacze], 
			'id_wzl'		=> FindId2($_POST[wzl]),			
			'id_ivn1'			=> FindId2($_POST[ivn1]),
			'id_ivn2'			=> FindId2($_POST[ivn2]),
			'id_ivn3'			=> FindId2($_POST[ivn3])
			);
		}
	else	if ( !empty( $_POST[inna_ul] ) && $_POST[ulica]=="Inna")
		{
			$id_ul=IncValue($dbh, $QA16, "ul000");
			$ul=array( 'id_ul'=> $id_ul ,		'nazwa'=>	$_POST[ulica], 'miasto'=> "Mysłowice", 'kod'=> "41-406");
			Insert($dbh, "ulice", $ul);
			$bud=array ('id_bud'	=>$id_bud, 	'id_ul'	=>	$id_ul, 'id_adm'	=>FindId2( $_POST[administracja] ),   'numer'=>$_POST[nr_bud],
						'il_mieszk'	=>IsNull($_POST[il_mieszk]), 	'przylacze'		=>$_POST[przylacze], 'data_podl'	=> $_POST[data_podl]);
		}
	Update($dbh, "budynki", $bud);

}

function BuildValidate($dbh)
{
	$flag=1;
	if ( empty ($_POST[nr_bud]))
		{ 
			echo "Błąd pola 'Numer budynku' : pole jest puste <br>";
			$flag=0;
		}	

	if ( empty($_POST[inna_ul]) && $_POST[ulica]=="Inna")
		{ 
			echo "Błąd pola 'Ulica' : pole jest puste <br>";
			$flag=0;
		}
		
	if ( !empty($_POST[ulica]) )
	{
		$q="select id_ul from ulice where nazwa='$_POST[inna_ul]' and miasto='$_POST[miasto]' limit 1"; 
		WyswietlSql($q);
		$s=Query($dbh,$q);
		$r=$s->fetchRow();
		if (!empty($r))
		{ 
			echo "Jest już dodana ulica $_POST[inna_ul]. <br>";
			$flag=0;
		}			
	}


	return ($flag);
}

	
}

?>
