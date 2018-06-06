<?php

class CONTRACTS
{

	private function ContractType($nr_um)
	{
		$nr=explode("/", $nr_um);
		switch ( $nr[1] )
			{
				case "UMA":
					$um="UMOWY_ABONENCKIE";
					break;
				case "UMV":
					$um="UMOWY_VOIP";
					break;
				case "UMT":
					$um="UMOWY_IPTV";
					break;
				case "UMS":
					$um="UMOWY_SERWISOWE";
					break;
			} 
		return $um;
	}


	

	function TerminationContractList($dbh, $p)
	{
		include "func/config.php";
		
		$umowy="umowy_abonenckie";
		$wypowiedzenia="wypowiedzenia_umow_abonenckich";

		$q1="select w.id_wyp, w.nr_um, w.data_wpl, w.data, w.data_wej, w.uwagi, w.dokonane, n.nazwa, n.symbol, n.id_abon
								from 
								($wypowiedzenia w left join $umowy u on u.nr_um=w.nr_um and w.data_wpl>='$p[data_od]' and w.data_wpl<='$p[data_do]') 
								left join nazwy n on n.id_abon=u.id_abon where n.wazne_do >= '$p[data_do]'";

						 
		if( !empty($p[abonent]) && $p[abonent]!=$conf[select] )
					{
						$zcy=explode(" ", $_POST[abonent]);
						$id_zcy=array_pop($zcy);
						$q1.=" and n.id_abon='$id_zcy'";			
					}
		
		if ($p[dokonane]=="dokonane")
			{
				$q1.=" and w.dokonane='T'";
		
				$q1.=" order by w.id_wyp";
								
				WyswietlSql($q1);
				$lp=1;
				$sth1=Query($dbh,$q1);
				while ($row =$sth1->fetchRow())
					{
						DrawTable($lp++,$conf[table_color]);
							{	
								echo "<td> <a href=\"index.php?panel=fin&menu=terminationupd&trm=$row[0]\"> $row[0] </a></td>";
								echo "<td> <a href=\"index.php?panel=inst&menu=updateum&um=$row[1]\"> $row[1] </a></td>";
								echo "<td> $row[2] </td>";
								echo "<td> <b>$row[3] </b></td>";
								echo "<td><b>";
								echo Choose($row[8], $row[7]);
								echo "<br> </b> <a href=\"index.php?panel=inst&menu=updateabon&abon=$row[9]\"> $row[9] </a></td>";
								echo "<td> $row[5] </td>";
								echo "<td> <a href=\"index.php?panel=inst&menu=updateum&um=$row[1]\"> wznów.um. >> </a></td>";
								echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
								echo "<td class=\"klasa4\"> <a href=\"javascript&#058;displayWindow('image/mkimage.php?dok=termination&id_dok=$row[0]',800,1100, '38')\"/> <img src=\"../graphics/pdf.gif\" width=\"32\" height=\"32\" border=\"0\"/></a> </td>";
							}
						echo "</tr>";
					}
			}
	else
			{
				$q1.=" and w.dokonane='N'";
				$q1.=" order by w.data_wpl";

								
				WyswietlSql($q1);
				$lp=1;
				$sth1=Query($dbh,$q1);
				while ($row =$sth1->fetchRow())
					{
						
						DrawTable($lp++,$conf[table_color]);								
							{
								echo "<td> <a href=\"index.php?panel=fin&menu=terminationupd&trm=$row[0]\"> $row[0] </a></td>";
								echo "<td> <a href=\"index.php?panel=inst&menu=updateum&um=$row[1]\"> $row[1] </a></td>";
								echo "<td> $row[2] </td>";
								echo "<td> <b>$row[3] </b></td>";								
								echo "<td><b>";
								echo Choose($row[8], $row[7]);
								echo "<br> </b> <a href=\"index.php?panel=inst&menu=updateabon&abon=$row[9]\"> $row[9] </a></td>";
								echo "<td> $row[5] </td>";
								echo "<td> <a href=\"index.php?panel=inst&menu=updateum&um=$row[1]\"> rozw.um. >> </a></td>";
								echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
								echo "<td class=\"klasa4\"> <a href=\"javascript&#058;displayWindow('image/mkimage.php?dok=termination&id_dok=$row[0]',800,1100, '38')\"/> <img src=\"../graphics/pdf.gif\" width=\"32\" height=\"32\" border=\"0\"/></a> </td>";
							}
						echo "</tr>";
					}
			}
	}

		function ValidateTerminationAdd()
	{
		include "func/config.php";
		$flag=1;
		
		$id=explode(" ", $_POST[abonent]);
		$id_abon=array_pop($id);
		
		$q="select nr_um from umowy_abonenckie where nr_um='$_POST[nr_um]' and id_abon='$id_abon'";
		$row=Query2($q);
		if (  empty ($row[0]) ) 
		{
			echo "Błąd pola 'Numer umowy' : nie ma takiej umowy";
			$flag=0;
		}

		
		if (  empty ($_POST[abonent]) || $_POST[abonent]==$conf[select] ) 
		{
			echo "Błąd pola 'Abonent' : pole jest puste <br>";
			$flag=0;
		}
		
		 if ( empty($_FILES['userfile']['name'])  )
		 {
			echo "Brak obrazu (skanu) wypowiedzenia ! <br>";
			$flag=0;		 
		 }

		if ( strlen($_POST[uwagi])>500 )
		{ 	 
			echo "Treść może mieć maksymalnie 500 znaków ! <br>";
			$flag=0;
		}
		
		if ( ValidateDate($_POST[data_wpl]) || ValidateDate($_POST[data_pis]) || ValidateDate($_POST[data_wej]) )
			$flag==0;
	
		return ($flag);	
	}
	
	
	function TerminationAdd($dbh)
	{
		include "func/config.php";
		$umowy="umowy_abonenckie";
		$wypowiedzenia="wypowiedzenia_umow_abonenckich";
	

		
		$id_wyp=IncItNum2($dbh, $date=$_POST[data_wpl], "WPA");
		
		 $uploadfile = $conf[upload] .'/'. basename($_FILES['userfile']['name']);
		 $name = $_POST['name'];

		 if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
		 {   // echo "File is valid, and was successfully uploaded.\n";
		 }
		 else   {   echo "File size greater than 300kb!\n\n";   }

		 echo "$uploadfile\n";

		 $conn = pg_pconnect("dbname=$DBNAME1 user=$USER password=$PASS");
		 pg_query($conn, "begin");
		 $oid=pg_lo_import($conn, $uploadfile); 
		    pg_query($conn, "commit");
	
		$wypowiedzenie=array('id_wyp'=> $id_wyp, 'nr_um' =>$_POST[nr_um], 'data_wpl'=>$_POST[data_wpl], 'data'=>$_POST[data_pis],
												'data_wej'=>$_POST[data_wej],  'uwagi'=> $_POST[tresc], 'dokonane' => 'N', 'obraz'=> $oid);
												
		Insert($dbh, $wypowiedzenia, $wypowiedzenie);
		
		$subject="$_POST[abonent] Wypowiada umowę";
		$body="$_POST[abonent] z dniem $_POST[data_wej] wypowiada umowę numer $_POST[nr_um].";

		
		$maile=explode(";", $conf[wypowiedzenia_email]);
		foreach ($maile as $m)
		{
			$email=new EMAIL();
			$email->WyslijMaila("$conf[szmsk_email]", $m, $subject, $body);
		}
		
	}
	
	function TerminationUpd($dbh, $id_wyp)
	{
		include "func/config.php";
		$umowy="umowy_abonenckie";
		$wypowiedzenia="wypowiedzenia_umow_abonenckich";
		$wyp2=$_SESSION['wyp'];
	
     if ( !empty($_FILES['userfile']['name'])  )	
		 {
			 $uploadfile = $conf[upload] .'/'. basename($_FILES['userfile']['name']);
			 $name = $_POST['name'];

			 if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
			 {   // echo "File is valid, and was successfully uploaded.\n";
			 }
			 else   {   echo "File size greater than 300kb!\n\n";   }

			// echo "\n $uploadfile\n \n";

		 $conn = pg_pconnect("dbname=$DBNAME1 user=$USER password=$PASS");
			 pg_query($conn, "begin");
			 $oid=pg_lo_import($conn, $uploadfile); 
			 pg_query($conn, "commit");
		}
	
		$wypowiedzenie=array('id_wyp'=> $id_wyp, 'nr_um' =>$_POST['nr_um'], 'data_wpl'=>$_POST[data_wpl], 'data'=>$_POST[data_pis],
												'data_wej'=>$_POST[data_wej],  'uwagi'=> $_POST[tresc], 'dokonane' => 'N');
		
		 // echo "\n a $oid b $wyp2[obraz] c\n";
			
		if ( $oid != $wyp2[obraz] && !empty($_FILES['userfile']['name']) )
		{
		  //echo "\n a $oid b $wyp2[obraz] c\n";
			$wypowiedzenie['obraz']=$oid;
		}	
		Update($dbh, $wypowiedzenia, $wypowiedzenie);
		
		
		$subject="[Aktualizacja] $_POST[abonent] Wypowiada umowę";
		$body="$_POST[abonent] z dniem $_POST[data_wej] wypowiada umowę numer $_POST[nr_um].";
		
		$maile=explode(";", $conf[wypowiedzenia_email]);
		foreach ($maile as $m)
		{
			$email=new EMAIL();
			$email->WyslijMaila("$conf[szmsk_email]", $m, $subject, $body);
		}
		
	}
}

?>
