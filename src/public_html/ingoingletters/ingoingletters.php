<?php

class INGOINGLETTERS
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


	

	function InLtrList($dbh, $p)
	{
		include "func/config.php";
		
		$umowy="umowy_abonenckie";
		$wypowiedzenia="wypowiedzenia_umow_abonenckich";

		$q1="select p.id_psp, p.data_wpl, p.data, p.uwagi, n.nazwa, n.symbol, n.id_abon, i.id_inst, i.nazwa, i.symbol
								from 	( pisma_przychodzace p left join nazwy n on p.id_nad=n.id_abon and n.wazne_do >= '$p[data_do]') join
								( pisma_przychodzace p2 left join instytucje i on p2.id_nad=i.id_inst) on p.id_psp=p2.id_psp 
	
						 and p.data_wpl>='$p[data_od]' and p.data_wpl<='$p[data_do]'";

						 
		if( !empty($p[abonent]) && $p[abonent]!=$conf[select] )
					{
						$zcy=explode(" ", $_POST[abonent]);
						$id_zcy=array_pop($zcy);
						$q1.=" and p.id_nad='$id_zcy'";			
					}
		
				$q1.=" order by p.data_wpl";
								
				WyswietlSql($q1);
				$lp=1;
				$sth1=Query($dbh,$q1);
				while ($row =$sth1->fetchRow())
					{
						DrawTable($lp++,$conf[table_color]);
							{	
								echo "<td> <a href=\"index.php?panel=fin&menu=inltrupd&inltr=$row[0]\"> $row[0] </a></td>";
								echo "<td><b>";
								if ( empty($row[7]))
									{
										echo Choose($row[5], $row[4]);
										echo "<br> </b> <a href=\"index.php?panel=inst&menu=updateabon&abon=$row[6]\"> $row[6] </a></td>";										
									}
								else
									{
										echo Choose($row[9], $row[8]);
										echo "<br> </b> <a href=\"index.php?panel=inst&menu=updateinst&inst=$row[7]\"> $row[7] </a></td>";
									}
								

								echo "<td> $row[1] </td>";
								echo "<td> $row[2] </b></td>";
								echo "<td> $row[3] </td>";

								echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
								echo "<td class=\"klasa4\"> <a href=\"javascript&#058;displayWindow('image/mkimage.php?dok=inltr&id_dok=$row[0]',800,1100, '38')\"/> <img src=\"../graphics/pdf.gif\" width=\"32\" height=\"32\" border=\"0\"/></a> </td>";
							}
						echo "</tr>";
					}
	}

		function ValidateInLtrAdd()
	{
		include "func/config.php";
		$flag=1;

		if (  (empty ($_POST[abonent]) || $_POST[abonent]==$conf[select]) && (empty($_POST[instytucja]) || $_POST[instytucja]==$conf[select] )   ) 
		{
			echo "Pole 'Abonent' lub 'Instytucja' musi być wypełnione : pole jest puste <br>";
			$flag=0;
		}

		if (  (!empty ($_POST[abonent]) && $_POST[abonent]!=$conf[select]) && (!empty ($_POST[instytucja]) && $_POST[instytucja]!=$conf[select]) ) 
		{
			echo "Tylo jedno pole 'Abonent' lub 'Instytucja' może być wypełnione <br>";
			$flag=0;
		}

		
		 if ( empty($_FILES['userfile']['name'])  )
		 {
			echo "Brak obrazu (skanu) pisma ! <br>";
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
	

	function ValidateInLtrUpd()
	{
		include "func/config.php";
		$flag=1;

		if (  (empty ($_POST[abonent]) || $_POST[abonent]==$conf[select]) && (empty($_POST[instytucja]) || $_POST[instytucja]==$conf[select] )   ) 
		{
			echo "Pole 'Abonent' lub 'Instytucja' musi być wypełnione : pole jest puste <br>";
			$flag=0;
		}

		if (  (!empty ($_POST[abonent]) && $_POST[abonent]!=$conf[select]) && (!empty ($_POST[instytucja]) && $_POST[instytucja]!=$conf[select]) ) 
		{
			echo "Tylo jedno pole 'Abonent' lub 'Instytucja' może być wypełnione <br>";
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
	
	function InLtrAdd($dbh)
	{
		include "func/config.php";
	
		if (  (!empty ($_POST[abonent]) || $_POST[abonent]!=$conf[select]) && (empty($_POST[instytucja]) || $_POST[instytucja]==$conf[select] )   ) 
		{
			$id=explode(" ", $_POST[abonent]);
			$id_nad=array_pop($id);
		}
		else 	if (  (empty ($_POST[abonent]) || $_POST[abonent]==$conf[select]) && (!empty($_POST[instytucja]) || $_POST[instytucja]!=$conf[select] )   ) 
		{
			$id=explode(" ", $_POST[instytucja]);
			$id_nad=array_pop($id);
		}
	
		$id_psp=IncItNum2($dbh, $date=$_POST[data_wpl], "PSP");
		
		 $uploadfile = $conf[upload] .'/'. basename($_FILES['userfile']['name']);
		 $name = $_POST['name'];


		 if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
		 {   
			echo "Plik został wczytany poprawnie.\n";
		 }
		 else   {   echo "Błąd przy wczytywaniu pliku !\n\n";   }

		 echo "$uploadfile\n";

		 $conn = pg_pconnect("dbname=$DBNAME1 user=$USER password=$PASS");
		 pg_query($conn, "begin");
		 $oid=pg_lo_import($conn, $uploadfile); 
		    pg_query($conn, "commit");
	
		$psp=array('id_psp'=> $id_psp, 'id_nad' =>$id_nad, 'data_wpl'=>$_POST[data_wpl], 'data'=>$_POST[data_pis],
												'uwagi'=> $_POST[tresc], 'obraz'=> $oid);
												
		Insert($dbh, "pisma_przychodzace", $psp);
		
		
		
		$subject="$_POST[abonent] $_POST[instytucja] wysłał/a do nas pismo";
		$body="$_POST[abonent] $_POST[instytucja] wysłał/a do nas dnia $_POST[data_wpl] pismo";
		
		$maile=explode(";", $conf[pismaprzych_email]);
		foreach ($maile as $m)
		{
			$email=new EMAIL();
			$email->WyslijMaila("$conf[szmsk_email]", $m, $subject, $body);
		}
		
		
	}
	
	function InLtrUpd($dbh, $id_psp)
	{
		include "func/config.php";

		if (  (!empty ($_POST[abonent]) || $_POST[abonent]!=$conf[select]) && (empty($_POST[instytucja]) || $_POST[instytucja]==$conf[select] )   ) 
		{
			$id=explode(" ", $_POST[abonent]);
			$id_nad=array_pop($id);
		}
		else 	if (  (empty ($_POST[abonent]) || $_POST[abonent]==$conf[select]) && (!empty($_POST[instytucja]) || $_POST[instytucja]!=$conf[select] )   ) 
		{
			$id=explode(" ", $_POST[instytucja]);
			$id_nad=array_pop($id);
		}
	
		$psp2=$_SESSION['psp'];
	
     if ( !empty($_FILES['userfile']['name'])  )	
		 {
			 $uploadfile = $conf[upload] .'/'. basename($_FILES['userfile']['name']);
			 $name = $_POST['name'];


			 if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
				{
					echo "Plik został wczytany poprawnie.\n";
				}
			else   {   echo "Błąd przy wczytywaniu pliku !\n\n";   }

			// echo "\n $uploadfile\n \n";

		 $conn = pg_pconnect("dbname=$DBNAME1 user=$USER password=$PASS");
			 pg_query($conn, "begin");
			 $oid=pg_lo_import($conn, $uploadfile); 
			 pg_query($conn, "commit");
		}
	
		$psp=array('id_psp'=> $id_psp, 'id_nad' =>$id_nad, 'data_wpl'=>$_POST[data_wpl], 'data'=>$_POST[data_pis],
												'uwagi'=> $_POST[tresc]);		
		 // echo "\n a $oid b $wyp2[obraz] c\n";
			
		if ( $oid != $psp2[obraz] && !empty($_FILES['userfile']['name']) )
		{
		  //echo "\n a $oid b $wyp2[obraz] c\n";
			$psp['obraz']=$oid;
		}	
		Update($dbh, "pisma_przychodzace", $psp);
		

		$subject="[Aktualizacja] $_POST[abonent] $_POST[instytucja] wysłał/a do nas pismo";
		$body="$_POST[abonent] $_POST[instytucja] wysłał/a do nas dnia $_POST[data_wpl] pismo";
		
		$maile=explode(";", $conf[pismaprzych_email]);
		foreach ($maile as $m)
		{
			$email=new EMAIL();
			$email->WyslijMaila("$conf[szmsk_email]", $m, $subject, $body);
		}
		
	}
}

?>
