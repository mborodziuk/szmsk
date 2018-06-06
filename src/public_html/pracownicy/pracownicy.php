<?php
//////////////////////////////////////////////////
///////////// P R A C O W NI C Y ////////////////
////////////////////////////////////////////////
class PRACOWNICY
{

	function ListaPracownikow()
	{
		include "func/config.php";
		$dbh=DBConnect($DBNAME1);

		$query="select  p.id_prac, p.nazwa, p.ulica, p.nr_bud, p.nr_mieszk, p.miasto, p.kod, p.nip, p.pesel, p.sn_dowodu, p.data_ur, p.mezczyzna, d.symbol
					from pracownicy p left join dzialy d on  p.id_dpt=d.id_dpt
					order by p.nazwa";

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
					
				DrawTable($lp++,$conf[table_color]);  	

					echo "<td> <a href=\"index.php?panel=fin&menu=updateprac&prac=$row[0]\"> $row[0] </a> </td>";
					echo "<td> <b>$row[1] </b></td>";
					echo "<td> $row[6] $row[5], ul. $row[2] $row[3]/$row[4] </td>";
					echo "<td>";
				if ( !empty($row2[0]) )
						echo "tel.:  $row2[0] <br>";
				if ( !empty($row2[1]) )
						echo "tel.kom.:  $row2[1] <br>";
				echo "</td>";
				echo "<td>";
				if ( !empty($row3[0]) )
						echo "e-mail:  $row3[0]";
				echo "</td>";	
					echo "<td> $row[12] </td>";

				echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
			 echo "</tr>";
				 }
	}



	function AddNewPrac()
	{
		$dbh=DBConnect($DBNAME1);	
		$Q1="select id_prac from pracownicy order by id_prac desc limit 1";
		$id_prac=IncValue($dbh, $Q1, "PRC000");

		$prac=array (
				'id_prac'	=>$id_prac, 	'nazwa'	=>$_POST[nazwa], 'imie_ojca' =>$_POST[imie_ojca], 'imie_matki' =>$_POST[imie_matki],
				'nazw_pan_matki' =>$_POST[nazw_pan_matki],	'miejsce_ur' =>$_POST[miejsce_ur],
				'ulica'	=>$_POST[ulica], 'nr_bud'=>$_POST[nr_bud],
				'nr_mieszk'	=>IsNull($_POST[nr_mieszk]),'miasto'	=>$_POST[miasto], 	'kod'		=>$_POST[kod], 'pesel'=>IsNull($_POST[pesel]),
				'nip'	=>IsNull($_POST[nip]), 'sn_dowodu'	=>IsNull($_POST[sn_dowodu]),
				'data_ur'=>$_POST[data_ur], 'mezczyzna'=>$_POST[mezczyzna], 'stanowisko'=>$_POST[stanowisko], 'zatrudniony'=> 'T'
			);
		Insert($dbh, "pracownicy", $prac);

		if ( !empty($_POST[telefon]) || !empty($_POST[telkom]))
			{
				$tel=array('kierunkowy'=> "0-32", 'telefon' => IsNull($_POST[telefon]), 'tel_kom' => IsNull($_POST[telkom]), 'id_podm'=> $id_prac);
				Insert($dbh, "TELEFONY", $tel);
			}

		if ( !empty($_POST[email]) )
				{
					$Q20="insert into MAILE values ('$_POST[email]', '$id_prac')";
					WyswietlSql($Q20);
					Query($dbh, $Q20);
				}

		if ( !empty($_POST[konto]) )
			{		
				$konto=array('nr_kb'=> $_POST[d_konto], 'bank' => IsNull($_POST[bank]), 'id_wlasc'=> $id_prac);
				Insert($dbh, "KONTA_BANKOWE", $konto);
			}
		
	}

	function UpdatePrac($id_prac)
	{

		$dbh=DBConnect($DBNAME1);	

		$ktk1=$_SESSION[kontakty];
		$tel1=$_SESSION[tel];
		$mail1=$_SESSION[mail];

		$prac=array (
							'id_prac'	=>$id_prac, 	'nazwa'	=>$_POST[nazwa],	'imie_ojca' =>$_POST[imie_ojca], 
							'imie_matki' =>$_POST[imie_matki],	'nazw_pan_matki' =>$_POST[nazw_pan_matki],      'miejsce_ur' =>$_POST[miejsce_ur],
							'ulica'	=>$_POST[ulica], 'nr_bud'=>$_POST[nr_bud],
							'nr_mieszk'	=>IsNull($_POST[nr_mieszk]),'miasto'	=>$_POST[miasto], 	'kod'		=>$_POST[kod], 'pesel'=>IsNull($_POST[pesel]),
							'nip'	=>IsNull($_POST[nip]), 'sn_dowodu'	=>IsNull($_POST[sn_dowodu]),
							'data_ur'=>$_POST[data_ur], 'mezczyzna'=>$_POST[mezczyzna], 'stanowisko'=>$_POST[stanowisko]
						);
		Update($dbh, "pracownicy", $prac);

		if ( !empty($_POST[telefon]) || !empty($_POST[telkom]))
			{
				$tel2=array('id_podm'=> $id_prac, 'kierunkowy'=> "0-32", 'telefon' => IsNull($_POST[telefon]), 'tel_kom' => IsNull($_POST[telkom]));
				if ( !empty($tel1[telefon]) || !empty($tel1[tel_kom]) )
					Update($dbh, "TELEFONY", $tel2);
				else 
					Insert($dbh, "TELEFONY", $tel2);
			}
		else if ( empty($_POST[telefon]) && empty($_POST[telkom])  &&   ( !empty($tel1[telefon]) || !empty($tel1[tel_kom]) )  )
			{
				$Q="delete from TELEFONY where id_podm='$id_prac'";
				WyswietlSql($Q);
				Query($dbh, $Q);
			}

		if ( !empty($_POST[email]) )
				{
					$mail2=array('id_podm'=> $id_prac, 'email'=>$_POST[email]);
					if ( !empty($mail1[email]) )
						Update($dbh, "MAILE", $mail2);
					else 
						Insert($dbh, "MAILE", $mail2);
				}
		else if ( empty($_POST[email]) && !empty($mail1[email]) )
			{
				$Q="delete from MAILE where id_podm='$id_prac'";
				WyswietlSql($Q);
				Query($dbh, $Q);
			}

		
		if ( !empty($_POST[konto]) )
				{
					$konto2=array('id_wlasc'=> $id_prac, 'nr_kb'=>$_POST[konto], 'bank'=>IsNull($_POST[bank]) );
					if ( !empty($konto1[nr_kb]) )
						Update($dbh, "KONTA_BANKOWE", $konto2);
					else 
						Insert($dbh, "KONTA_BANKOWE", $konto2);
				}
		else if ( empty($_POST[d_konto]) && !empty($konto1[nr_kb]) )
			{
				$Q="delete from KONTA_BANKOWE where nr_kb='$konto1[nr_kb]'";
				WyswietlSql($Q);
				Query($dbh, $Q);
			}
	}



	function ValidatePrac()
	{
		$flag=1;

		if (  empty ($_POST["nazwa"]) ) 
		{
			echo "Błąd pola 'Nazwa pracownika' : pole jest puste <br>";
			$flag=0;
		}
		
		return ($flag);	
	}


}


?>
