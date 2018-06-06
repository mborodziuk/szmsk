<?php

//////////////////////////////////////////////////////
//////////////////// CESJE ///////////////////////////
//////////////////////////////////////////////////////

class CESJE
{
	
	function CESJE()
	{
		//include "func/config.php";
	}

	function AddNewCesje()
	{
		include "func/config.php";
		$dbh=DBConnect($DBNAME1);	

		$id=explode(" ", $_POST[stary_abon]);
		$id_abons=array_pop($id);
		$id=explode(" ", $_POST[nowy_abon]);
		$id_abonn=array_pop($id);
		
		$nr_csj=$_POST["nr_csj1"]."/CSJ/".$_POST["nr_csj2"];
		$data="$_POST[rok]"."-"."$_POST[miesiac]"."-"."$_POST[dzien]";
		if ($data[0] !="2" && $data[1] !="0")
				$data="20"."$data";

		if ( ValidateCsj( $nr_csj, $data) )
			{
				$cesje=array('id_csj'=>$nr_csj, 'data'=>$data, 'id_abons' =>$id_abons, 'id_abonn' =>$id_abonn);
				Insert($dbh, "cesje", $cesje);

				$q="update komputery set id_abon='$id_abonn' where id_abon='$id_abons';
						update settopboxy set id_abon='$id_abonn' where id_abon='$id_abons';
						update telefony_voip set id_abon='$id_abonn' where id_abon='$id_abons';
						update umowy_abonenckie set id_abon='$id_abonn' where id_abon='$id_abons' and status='Obowiązująca'";
				WyswietlSql($q);
				Query($dbh, $q);	
			}
	}

	function ListaCesji($p)
	{
		include "func/config.php";	
		$dbh=DBConnect($DBNAME1);

		$q1="select c.id_csj, c.data, c.id_abons, c.id_abonn, a.nazwa, a.symbol, ab.nazwa, ab.symbol 
					from cesje c, nazwy a, nazwy ab 
					where a.id_abon=c.id_abons and ab.id_abon=c.id_abonn 
					and a.wazne_od <= '$p[data_do]' and a.wazne_do >= '$p[data_do]'
					and ab.wazne_od <= '$p[data_do]' and ab.wazne_do >= '$p[data_do]'
					and c.data between '$p[data_od]' and '$p[data_do]'";
					
				if( !empty($p[stary_abon]) && $p[stary_abon]!=$conf[select] )
						{
							$abon=explode(" ", $_POST[stary_abon]);
							$id_abon=array_pop($abon);
							$q1.=" and c.id_abons='$id_abon'";			
						}
				if( !empty($p[nowy_abon]) && $p[nowy_abon]!=$conf[select] )
						{
							$abon=explode(" ", $_POST[nowy_abon]);
							$id_abon=array_pop($abon);
							$q1.=" and c.id_abonn='$id_abon'";			
						}				
				$q1.=" order by c.id_csj";
				
				WyswietlSql($q1);
				$lp=1;
				$sth1=Query($dbh,$q1);
				while ($row =$sth1->fetchRow())
					{
						DrawTable($lp++,$conf[table_color]);
							{
								$czas1=substr($row[1],0,-3);
								echo "<td> <a href=\"index.php?panel=fin&menu=updatecsj&csj=$row[0]\"> $row[0] </a></td>";
								echo "<td> $row[1] </td>";
								echo "<td><b>";
								echo Choose($row[5], $row[4]);
								echo "</b></td>";
								echo "<td><b>";
								echo Choose($row[7], $row[6]);
								echo "</b></td>";
								echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
							}
						echo "</tr>";
					}
	}
}	



?>