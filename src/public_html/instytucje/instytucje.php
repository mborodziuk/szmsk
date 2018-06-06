<?php


//////////////////////////////////////////////////
///////////// I N S T Y T U C J E ///////////////
////////////////////////////////////////////////
class INSTYTUCJE
{

	function AddNewInst()
	{
		$dbh=DBConnect($DBNAME1);	

		$Q1="select id_inst from instytucje where id_inst like 'INS%' order by id_inst desc limit 1";
		$ID="INS0000";


		$id_inst=IncValue($dbh, $Q1, $ID);

		$inst=array (	'id_inst'	=>$id_inst, 			'nazwa'	=>$_POST[i_nazwa],	'ulica'	=>$_POST[i_ulica], 'nr_bud'=>$_POST[i_nrbud],
							'nr_lokalu'	=>IsNull($_POST[i_nrlokalu]),'miasto'	=>$_POST[i_miasto], 	'kod'		=>$_POST[i_kod], 'symbol'=>$_POST[i_symbol]);
		Insert($dbh, "instytucje", $inst);

		if ( !empty($_POST[i_telefon]) || !empty($_POST[i_telkom]))
			{
				$teli=array('kierunkowy'=> "0-32", 'telefon' => IsNull($_POST[i_telefon]), 'tel_kom' => IsNull($_POST[i_telkom]), 'id_podm'=> $id_inst);
				Insert($dbh, "TELEFONY", $teli);
			}

		if ( !empty($_POST[i_email]) )
				{
					$Q20="insert into MAILE values ('$_POST[i_email]', '$id_inst')";
					echo $Q20;
					Query($dbh, $Q20);
				}

		
		if ( !empty($_POST[k_nazwa]) )
		{
			$Q="select id_kontakt from KONTAKTY order by id_kontakt desc limit 1";
			$id_kontakt=IncValue($dbh, $Q, "KTK0000");

			$ktk=array( 'id_kontakt' => $id_kontakt, 			'nazwa' => $_POST[k_nazwa], 				'kod' => IsNull($_POST[k_kod]), 'miasto' => IsNull($_POST[k_miasto]),
							'ulica' => IsNull($_POST[k_ulica]),	'nr_bud' => IsNull($_POST[k_nrbud]),	'nr_mieszk' => IsNull($_POST[k_nrlokalu]), 
							'id_podm' => $id_inst );

			Insert($dbh, "KONTAKTY", $ktk);

			if ( !empty($_POST[k_telefon]) || !empty($_POST[k_telkom]))
				{
					$telk=array('id_podm'=>$id_kontakt, 'kierunkowy'=>"0-32", 'telefon' => IsNull($_POST[k_telefon]), 'tel_kom' =>IsNull($_POST[k_telkom]) );
					Insert($dbh, "TELEFONY", $telk);
				}
			if ( !empty($_POST[k_email]) )
				{
					$Q11="insert into MAILE values ('$_POST[k_email]', '$id_kontakt')";
					echo $Q11;
					Query($dbh, $Q11);
				}
		}
	}

	function UpdateInst($id_inst)
	{
		$dbh=DBConnect($DBNAME1);	

		$ktk1=$_SESSION[kontakty];
		$teli1=$_SESSION[teli];
		$maili1=$_SESSION[maili];
		$telk1=$_SESSION[telk];
		$mailk1=$_SESSION[mailk];

		$inst=array (	'id_inst'	=>$id_inst, 			'nazwa'	=>$_POST[i_nazwa],	'ulica'	=>$_POST[i_ulica], 'nr_bud'=>$_POST[i_nrbud],
							'nr_lokalu'	=>IsNull($_POST[i_nrlokalu]),'miasto'	=>$_POST[i_miasto], 	'kod'		=>$_POST[i_kod], 'symbol'=>$_POST[i_symbol]);
		Update($dbh, "instytucje", $inst);

		if ( !empty($_POST[i_telefon]) || !empty($_POST[i_telkom]))
			{
				$teli2=array('id_podm'=> $id_inst, 'kierunkowy'=> "0-32", 'telefon' => IsNull($_POST[i_telefon]), 'tel_kom' => IsNull($_POST[i_telkom]));
				if ( !empty($teli1[telefon]) || !empty($teli1[tel_kom]) )
					Update($dbh, "TELEFONY", $teli2);
				else 
					Insert($dbh, "TELEFONY", $teli2);
			}
		else if ( empty($_POST[i_telefon]) && empty($_POST[i_telkom])  &&   ( !empty($teli1[telefon]) || !empty($teli1[tel_kom]) )  )
			{
				$Q="delete from TELEFONY where id_podm='$id_inst'";
				echo $Q;
				Query($dbh, $Q);
			}

		if ( !empty($_POST[i_email]) )
				{
					$maili2=array('id_podm'=> $id_inst, 'email'=>$_POST[i_email]);
					if ( !empty($maili1[email]) )
						Update($dbh, "MAILE", $maili2);
					else 
						Insert($dbh, "MAILE", $maili2);
				}
		else if ( empty($_POST[i_email]) && !empty($maili1[email]) )
			{
				$Q="delete from MAILE where id_podm='$id_inst'";
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
										'nr_mieszk' => IsNull($_POST[k_nrlokalu]), 'id_podm' => $id_inst );
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

	function ListaInstytucji()
	{
		$dbh=DBConnect($DBNAME1);

		$query="select i.id_inst, i.nazwa, i.ulica, i.nr_bud, i.nr_lokalu, i.miasto, i.kod
					from instytucje i
					order by i.id_inst";

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

					echo "<td> <a href=\"index.php?panel=fin&menu=updateinst&inst=$row[0]\"> $row[0] </a> </td>";
					echo "<td> $row[1] </td>";
					echo "<td> $row[6] $row[5], ul. $row[2] $row[3]/$row[4] </td>";
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

	function ValidateInst()
	{
		$flag=1;

		if (  empty ($_POST["i_nazwa"]) ) 
		{
			echo "Błąd pola 'Nazwa instytucji' : pole jest puste <br>";
			$flag=0;
		}
		
		return ($flag);	
	}



}

?>