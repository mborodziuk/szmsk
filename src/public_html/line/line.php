<?php

class LINE
{


public $table=array( 
		'link' 	=> array('href' => "index.php?panel=admin&menu=lineadd", 'name' => 'Nowa linia'),
		'form' 	=> array('action' => 'index.php?panel=admin&menu=deleteline&typ=line'),
		'table' => array('witdh' => '1000', 'height'=>'50'),
		'row'		=> array ('Id' =>'10', 'Nazwa' =>'120','Typ linii' =>'120', 'Rodzaj traktu kabel' => '100', 'Technlogia linii' =>'120', 'Pasmo radio' =>'200', 'Przepustowość' =>'400', 'Jednostka linii' => '200', '::' =>'20')
	);
	
function Delete ($dbh)
{
	include "func/config.php";
	
	$q="";
	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" )
			{
			$q.= "delete from trakty 						where id_lin='$k';
						delete from line 						where id_lin='$k';";
			}
		}
	WyswietlSql($q);	
	Query($dbh, $q);

	echo "Usunięto dane z systemu.";
}
	
function Form($linea)
{
	include "func/config.php";
	
	$q1="select id_trt, udost, kolor_kanal, id_plc, id_ifc1, id_ifc2 from trakty where id_lin='$linea[id_lin]'  order by id_trt";
	
	
	$form=array( 
			'form' 		=> array('action' => Null, 'name'=> 'Dane węzła'),
			'table' 	=> array('witdh' => '500', 'height'=>'50'),
			'checkbox'=> array (
													array('wyswietl' => 'Ruch szkielet', 			'name'=>'ruch_szkielet', 		'value'	=>$linea[ruch_szkielet]),
													array('wyswietl' => 'Ruch dystrybucja', 	'name'=>'ruch_dystrybucja', 'value'	=>$linea[ruch_dystrybucja]),
													array('wyswietl' => 'Ruch dostęp', 				'name'=>'ruch_dostep', 			'value'	=>$linea[ruch_dostep])
													),
			'input'		=> array (
													array('wyswietl' => 'Nazwa', 									'name'=>'nazwa', 					'size'=>'30', 'value'=>$linea[nazwa])
													),
			'selectarray'		=> array (
													array('wyswietl' => 'Rodzaj traktu kabel', 'name'=>'rodzaj', 'size'=>'30', 'tablica' => array('nadziemny', 'podziemny'), 'value'=>$linea[rodzaj]),
											array('wyswietl' => 'Technologia linii', 'name'=>'technologia', 'size'=>'30', 'tablica' => array('światłowodowa', 'kablowa', 'radiowa'), 'value'=>$linea[technologia]),	
					
													
													array('wyswietl' => 'Pasmo radiowe', 'name'=>'pasmo', 'size'=>'30', 'tablica' => array('5','10', '38'), 'value'=>$linea[pasmo]),
													array('wyswietl' => 'Przepustowość', 'name'=>'przepustowosc', 'size'=>'30', 'tablica' => array('10','20', '30', '50', '100','200', '300', '400', '500'), 'value'=>$linea[przepustowosc]),
														
													array('wyswietl' => 'Trakty (włókna lub kanały)', 'name'=>'ilosc', 'size'=>'30', 'tablica' => array('24', '12', '72', '96','1', '2'), 'value'=>$linea[ilosc])
													),													
			'select'		=> array (
													array('wyswietl' => 'Punkt A', 'name'=>'pkt_a', 'size'=>'30', 'query'=>"$QA24", 'value'=>$linea[pkt_a]),
													array('wyswietl' => 'Punkt B', 'name'=>'pkt_b', 'size'=>'30', 'query'=>"$QA24", 'value'=>$linea[pkt_b])
													),
			'list'		=>array ( 
													array(
													'add'		=> array ('query'=> $q1, 'type'=> 'trt'),
													'row'		=> array ('Id' => '10',  'Udostępniony' => '30', 'Kolor / kanał' => '50', 'Połączenie' => '100', 'Złącze 1' => '100',  'Złącze 2' => '100',  '::' =>'20'),
													'link' 	=> array('href' => "index.php?panel=admin&menu=trtadd&id_lin=$linea[id_lin]", 'name' => '>>> Nowy trakt')
													)
												)											
	);
	
	if (empty ($linea)) 
		{
			$form[form][action]='index.php?panel=admin&menu=lineaddsnd';

			$form[input][0][value]="LIN-";		}
	else
		{
			$form[form][action]="index.php?panel=admin&menu=lineupdsnd&line=$linea[id_lin]";		
		}

		return ($form);
}

function PrintList($dbh, $www=NULL)
{
	  $q1="select distinct id_lin, nazwa, typ_linii, rodz_traktu_kabel, tech_linii, pasmo_radio, przep_radio, jedn_linii  
					from line order by id_lin";

		
		WyswietlSql($q1);
	  $sth1=Query($dbh,$q1);
		$lp=1;
	  while ($row1=$sth1->fetchRow())
	    {
	      DrawTable($lp++,$conf[table_color]);  	
	        {
						echo "<td> <a href=\"index.php?panel=admin&menu=lineupd&line=$row1[0]\"> $row1[0] </a> </td>";
				    echo "<td> $row1[1] </td>";
				    echo "<td> $row1[2] </td>";
				    echo "<td> $row1[3] </td>";
				    echo "<td> $row1[4] </td>";
				    echo "<td> $row1[5] </td>";
				    echo "<td> $row1[6] </td>";
				    echo "<td> $row1[7] </td>";
						echo "<td><input type=\"checkbox\" name=\"$row1[0]\"/></td>";
				}
			}
		echo "</tr>";
}
	
	

function LineValidate()
	{
		$flag=1;


		if ( empty ($_POST[rodzaj]) )
		{
			echo "Nie wprowadzono rodzaju <br>";
			$flag=0;
		}

		return ($flag);	
	}	

function LineAdd($dbh)
{
		include "func/config.php";

		$Q= "select id_lin from line 							order by id_lin desc limit 1";
		$Q4="select id_trt from trakty 						order by id_trt desc limit 1";
		
		
		$colors=array(1=>'czerwony', 2=>'zielony', 3=>'niebieski', 4=>'biały', 5=>'fioletowy', 6=>'pomarańczowy', 
		7=>'szary', 8=>'żółty', 9=>'brązowy', 10=>'różowy', 11=>'czarny', 12=>'turkusowy' );
		
		if ($_POST[technologia] == 'radiowa' )
		{
			$line=array(
			'id_lin'	  				=> IncValue($dbh,$Q,  "LIN00000"),
			'nazwa'							=> $_POST[nazwa], 
			'tech_linii'				=> $_POST[technologia], 
			'typ_linii'					=> 'linia bezprzewodowa', 
			'pasmo_radio'				=> $_POST[pasmo], 
			'przep_radio'				=> $_POST[przepustowosc], 
			'jedn_linii'				=> 'kanały', 
			'pkt_a' 						=> FindId2($_POST[pkt_a]),   
			'pkt_b' 						=> FindId2($_POST[pkt_b]),   
	 
			'ruch_szkielet'			=> CheckboxToTable($_POST[ruch_szkielet]), 
			'ruch_dystrybucja'	=> CheckboxToTable($_POST[ruch_dystrybucja]),
			'ruch_dostep'				=> CheckboxToTable($_POST[ruch_dostep])
			);		
			Insert($dbh, "line", $line);
			
			for ( $i=1, $t=1, $l=1; $i<=$_POST[ilosc]; $i++ )
				{
					$trt=array(
						'id_trt'	  				=> IncValue($dbh,$Q4,  "TRT00000"), 
						'id_lin'						=> $line[id_lin],
						'ruch_szkielet' 		=> CheckboxToTable($_POST[ruch_szkielet]),
						'ruch_dystrybucja' 	=> CheckboxToTable($_POST[ruch_dystrybucja]),
						'ruch_dostep' 			=> CheckboxToTable($_POST[ruch_dostep]),
						'udost'							=> 'N',
						'kolor_kanal'				=> "5600",
						);
					Insert($dbh, "trakty", $trt);	
				}
		}
		else
		{
			$line=array(
			'id_lin'	  				=> IncValue($dbh,$Q,  "LIN00000"), 
			'nazwa'							=> $_POST[nazwa], 			
			'rodz_traktu_kabel'	=> $_POST[rodzaj], 
			'tech_linii'				=> $_POST[technologia], 
			'typ_linii'					=> 'linia kablowa', 
			'jedn_linii'				=> 'włókna', 
			'pkt_a' 						=> FindId2($_POST[pkt_a]),   
			'pkt_b' 						=> FindId2($_POST[pkt_b]),   
			'ruch_szkielet'			=> CheckboxToTable($_POST[ruch_szkielet]), 
			'ruch_dystrybucja'	=> CheckboxToTable($_POST[ruch_dystrybucja]),
			'ruch_dostep'				=> CheckboxToTable($_POST[ruch_dostep])
			);	
			
			Insert($dbh, "line", $line);
			
				///A=przełącznica, B=przełącznica
			if ( preg_match('/ODF/', $line[pkt_a])  && preg_match('/ODF/', $line[pkt_b]) )
				{
				$q1="select id_skt from socket where id_skt not in 
						( select id_ifc1 from trakty where id_lin in (select id_lin from line where pkt_a='$line[pkt_a]')) 
						and id_skt not in 
						( select id_ifc2 from trakty where id_lin in (select id_lin from line where pkt_b='$line[pkt_a]'))
						and id_odf='$line[pkt_a]' order by id_skt";
				WyswietlSql($q1);
				
				$q2="select id_skt from socket where id_skt not in 
					( select id_ifc1 from trakty where id_lin in (select id_lin from line where pkt_a='$line[pkt_b]')) 
					and id_skt not in 
					( select id_ifc2 from trakty where id_lin in (select id_lin from line where pkt_b='$line[pkt_b]'))
					and id_odf='$line[pkt_b]' order by id_skt";
				WyswietlSql($q2);

				$sth1=Query($dbh,$q1);
				$ifc1=array();
				while ( $row1=$sth1->fetchRow() )
				{
					array_push($ifc1, $row1[0]);
				}
				
				$sth2=Query($dbh,$q2);
				$ifc2=array();
				while ( $row2=$sth2->fetchRow() )
				{
					array_push($ifc2, $row2[0]);
				}
				
				for ( $i=1, $j=0, $t=1, $l=1; $i<=$_POST[ilosc]; $i++, $l++, $j++ )
					{
						$trt=array(
							'id_trt'	  				=> IncValue($dbh,$Q4,  "TRT00000"),
							'id_lin'						=> $line[id_lin],
							'ruch_szkielet' 		=> CheckboxToTable($_POST[ruch_szkielet]),
							'ruch_dystrybucja' 	=> CheckboxToTable($_POST[ruch_dystrybucja]),
							'ruch_dostep' 			=> CheckboxToTable($_POST[ruch_dostep]),
							'udost'							=> 'N',
							'id_ifc1'						=> $ifc1[$j],
							'id_ifc2'						=> $ifc2[$j],
							'kolor_kanal'				=> "T$t-$colors[$l]",
							);
						if ( $l%12==0 )
							{
								$l=0;
								++$t;
							}
						Insert($dbh, "trakty", $trt);	
					}
				}
			else 	if ( preg_match('/ODF/', $line[pkt_a]) && !preg_match('/ODF/', $line[pkt_b]) )
				{
					$q1="select id_skt from socket where id_skt not in 
						( select id_ifc1 from trakty where id_lin in (select id_lin from line where pkt_a='$line[pkt_a]')) 
						and id_skt not in 
						( select id_ifc2 from trakty where id_lin in (select id_lin from line where pkt_b='$line[pkt_a]'))
						and id_odf='$line[pkt_a]' order by id_skt";
					WyswietlSql($q1);

					$sth1=Query($dbh,$q1);
					$ifc1=array();
					while ( $row1=$sth1->fetchRow() )
					{
						array_push($ifc1, $row1[0]);
					}
					if ( ! empty($ifc1))
					{
						for ( $i=1, $j=0, $t=1, $l=1; $i<=$_POST[ilosc]; $i++, $l++, $j++ )
							{
								$trt=array(
									'id_trt'	  				=> IncValue($dbh,$Q4,  "TRT00000"),
									'id_lin'						=> $line[id_lin],
									'ruch_szkielet' 		=> CheckboxToTable($_POST[ruch_szkielet]),
									'ruch_dystrybucja' 	=> CheckboxToTable($_POST[ruch_dystrybucja]),
									'ruch_dostep' 			=> CheckboxToTable($_POST[ruch_dostep]),
									'udost'							=> 'N',
									'id_ifc1'						=> $ifc1[$j],
									'id_ifc2'						=> 'NULL',
									'kolor_kanal'				=> "T$t-$colors[$l]",
									);
								if ( $l%12==0 )
									{
										$l=0;
										++$t;
									}
								Insert($dbh, "trakty", $trt);	
							}
					}
					else 
							echo "Brak wolnych złącz w przełącznicy. <br>";
				}	
			else 	if ( !preg_match('/ODF/', $line[pkt_a]) && !preg_match('/ODF/', $line[pkt_b]) )
				{
					$q1="select id_trt, kolor_kanal from trakty where id_lin in (select id_lin from line where pkt_b='$line[pkt_a]')
					and id_ifc2 is null order by id_trt";
					WyswietlSql($q1);
								
					$sth1=Query($dbh,$q1);
					$ifc1=array();
					//$colors=array();
					$trt1=array();
					while ( $row1=$sth1->fetchRow() )
					{
						array_push($ifc1, 	$row1[0]);
						//array_push($colors, $row1[1]);
					}

					for ( $i=1, $j=0, $t=1, $l=1; $i<=$_POST[ilosc]; $i++, $j++, $l++ )
						{
							$trt2=array(
								'id_trt'	  				=> IncValue($dbh,$Q4,  "TRT00000"),
								'id_lin'						=> $line[id_lin],
								'ruch_szkielet' 		=> CheckboxToTable($_POST[ruch_szkielet]),
								'ruch_dystrybucja' 	=> CheckboxToTable($_POST[ruch_dystrybucja]),
								'ruch_dostep' 			=> CheckboxToTable($_POST[ruch_dostep]),
								'udost'							=> 'N',
								'id_ifc1'						=> $ifc1[$j],
								'id_ifc2'						=> 'NULL',
								'kolor_kanal'				=> "T$t-$colors[$l]",
								);
							if ( $l%12==0 )
							{
								$l=0;
								++$t;
							}
							Insert($dbh, "trakty", $trt2);	
							
							$trt1=array(
								'id_trt'	  				=> $ifc1[$j],
								'id_ifc2'						=> $trt2[id_trt],
								);
							Update($dbh, "trakty", $trt1);
						}
				}	
				
			else 	if ( !preg_match('/ODF/', $line[pkt_a]) && preg_match('/ODF/', $line[pkt_b]) )
				{
					$q1="select id_trt, kolor_kanal from trakty where id_lin in (select id_lin from line where pkt_b='$line[pkt_a]')
					and id_ifc2 is null order by id_trt";
					WyswietlSql($q1);
					
					$q2="select id_skt from socket where id_skt not in 
					( select id_ifc1 from trakty where id_lin in (select id_lin from line where pkt_a='$line[pkt_b]')) 
					and id_skt not in 
					( select id_ifc2 from trakty where id_lin in (select id_lin from line where pkt_b='$line[pkt_b]'))
					and id_odf='$line[pkt_b]' order by id_skt";
					WyswietlSql($q2);
								
					$sth1=Query($dbh,$q1);
					$ifc1=array();
					$colors=array();
					while ( $row1=$sth1->fetchRow() )
					{
						array_push($ifc1, 	$row1[0]);
						array_push($colors, $row1[1]);
					}

					$sth2=Query($dbh,$q2);
					$ifc2=array();
					while ( $row2=$sth2->fetchRow() )
					{
						array_push($ifc2, $row2[0]);
					}
					if ( ! empty($ifc2))
						{
							for ( $i=1, $j=0, $t=1; $i<=$_POST[ilosc]; $i++, $j++ )
								{
									$trt2=array(
										'id_trt'	  				=> IncValue($dbh,$Q4,  "TRT00000"),
										'id_lin'						=> $line[id_lin],
										'ruch_szkielet' 		=> CheckboxToTable($_POST[ruch_szkielet]),
										'ruch_dystrybucja' 	=> CheckboxToTable($_POST[ruch_dystrybucja]),
										'ruch_dostep' 			=> CheckboxToTable($_POST[ruch_dostep]),
										'udost'							=> 'N',
										'id_ifc1'						=> $ifc1[$j],
										'id_ifc2'						=> $ifc2[$j],
										'kolor_kanal'				=> "$colors[$j]",
										);
									Insert($dbh, "trakty", $trt2);	
									
									$trt1=array(
										'id_trt'	  				=> $ifc1[$j],
										'id_ifc2'						=> $trt2[id_trt],
										);
									Update($dbh, "trakty", $trt1);
								}
						}
					else
						echo "Brak wolnych złącz w przełącznicy. <br>";	
				}	
		}
}
	

function LineUpd($dbh, $id_lin)
{
		include "func/config.php";
	
		$line0=$_SESSION[$session[line][update]];
			
		
		if ($_POST[technologia] == 'radiowa' )
		{
			$line=array(
			'id_lin'	  				=> $id_lin,  
			'nazwa'							=> $_POST[nazwa],			
			'tech_linii'				=> $_POST[technologia], 
			'typ_linii'					=> 'linia bezprzewodowa', 
			'pasmo_radio'				=> $_POST[pasmo], 
			'przep_radio'				=> $_POST[przepustowosc], 
			'jedn_linii'				=> 'kanały', 
			'pkt_a' 						=> FindId2($_POST[pkt_a]),   
			'pkt_b' 						=> FindId2($_POST[pkt_b]),   
	 
			'ruch_szkielet'			=> CheckboxToTable($_POST[ruch_szkielet]), 
			'ruch_dystrybucja'		=> CheckboxToTable($_POST[ruch_dystrybucja]),
			'ruch_dostep'				=> CheckboxToTable($_POST[ruch_dostep])
			);		
			
			Update($dbh, "line", $line);
		}
		else
		{
			$line=array(
			'id_lin'	  				=> $id_lin, 
			'nazwa'							=> $_POST[nazwa], 			
			'rodz_traktu_kabel'	=> $_POST[rodzaj], 
			'tech_linii'				=> $_POST[technologia], 
			'typ_linii'					=> 'linia kablowa', 
			'jedn_linii'				=> 'włókna', 
			'pkt_a' 						=> FindId2($_POST[pkt_a]),   
			'pkt_b' 						=> FindId2($_POST[pkt_b]),   
	 
			'ruch_szkielet'			=> CheckboxToTable($_POST[ruch_szkielet]), 
			'ruch_dystrybucja'		=> CheckboxToTable($_POST[ruch_dystrybucja]),
			'ruch_dostep'				=> CheckboxToTable($_POST[ruch_dostep])
			);	
			
			Update($dbh, "line", $line);
		}
	}
	
}	


?>
