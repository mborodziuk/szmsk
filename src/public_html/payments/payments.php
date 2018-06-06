<?php

class PAYMENTS
{
///////////////////////////////////////////////////
//////////////// W P Ł A T Y //////////////////////
//////////////////////////////////////////////////


function IncWpl($param)
{
    $id=explode("/", $param);
    $nr=$id[1];
    ++$nr;
    if ($nr < 10)
	{
	    $id[1]="000$nr";
	}
    else if ( $nr<100 && $nr>9)
	{
	    $id[1]="00$nr";
	}
    else if ( $nr < 1000 && $nr > 99)
	{
	    $id[1]="0$nr";
	}
    else if ( $nr >= 1000 )
	{
	    $id[1]="$nr";
	}
    $wyj="$id[0]/$id[1]/$id[2]/$id[3]";
    return $wyj;
}


function AddValidate()
{
	$flag=1;

	if (  !empty ($_POST["kwota2"]) && !preg_match("/\d+/", $_POST["kwota2"]) ) 
	{
		echo "Błąd pola 'Inna kwota' : wpisana pozycja nie jest liczbą <br>";
		$flag=0;
	}

	$rozm=strlen($_POST[opis]);
	if ($rozm > 400)
	{
		echo "Zbyt długi opis, pole opis może zawierać maksymalnie 400 znaków <br>";
		$flag=0;
	}
	
	return ($flag);	
}

function UpdValidate()
{
	$flag=1;

	if (  !empty ($_POST["kwota"]) && !preg_match("/\d+/", $_POST["kwota"]) ) 
	{
		echo "Błąd pola 'kwota' : wpisana pozycja nie jest liczbą <br>";
		$flag=0;
	}
	else if (  empty ($_POST["kwota"]) ) 
	{
		echo "Pola 'kwota': niemoże być puste <br>";
		$flag=0;
	}

	$rozm=strlen($_POST[opis]);
	if ($rozm > 400)
	{
		echo "Zbyt długi opis, pole opis może zawierać maksymalnie 400 znaków <br>";
		$flag=0;
	}

	
	return ($flag);	
}

function PaymentList($dbh, $p, &$www)
{
	include "func/config.php";
	$idk=explode(" ", $p[abon]);
	$ida=array_pop($idk);

	if (empty($p[rozliczona]) || $p[rozliczona] == "Rozliczone")
		{
			$flag=1;
			$q=" select w.id_wpl, w.data_ksiegowania, w.data_zlecona, w.forma, w.kwota, w.waluta, w.opis, n.nazwa, n.id_abon
    	    from wplaty w, nazwy n
          where w.id_kontrah=n.id_abon and w.data_ksiegowania>='$p[data_od]' and w.data_ksiegowania <= '$p[data_do]' 
					and n.wazne_od <= '$p[data_do]' and n.wazne_do >= '$p[data_do]'
					and w.rozliczona='T'";
		}
	else 
		{
			$flag=0;
			$q=" select w.id_wpl, w.data_ksiegowania, w.data_zlecona, w.forma, w.kwota, w.waluta, w.opis
    	    from wplaty w 
          where w.data_ksiegowania>='$p[data_od]' and w.data_ksiegowania <= '$p[data_do]' and w.rozliczona='N'";
		}

		if (!empty($p[abon]) && $p[abon] != $conf[select] && $flag==1)
			{
				$q.=" and n.id_abon='$ida'";
			}

	if (empty($p[order]) || $p[order] == "Data wpłaty")
			$p[order]="w.data_ksiegowania, w.data_zlecona, w.id_wpl";
	else if ($p[order] == "Nazwa kontrahenta")
			$p[order]="a.nazwa, w.data_ksiegowania, w.data_zlecona, w.id_wpl";
	else if ($p[order] == "Forma wpłaty")
			$p[order]="w.forma, w.data_ksiegowania, w.data_zlecona, w.id_wpl";	
	$q.=" order by $p[order]";

	WyswietlSql($q);
	$lp=1;
	$suma=0;
	$sth=Query($dbh,$q);
	while ($row =$sth->fetchRow())
	    {
			DrawTable($lp++,$conf[table_color]);  	
			echo "<td> <a href=\"index.php?panel=fin&menu=paymentupd&wpl=$row[0]\"> $row[0] </a> </td>";
			echo "<td> $row[1] <br> $row[2] <br> $row[3]</td>";
			echo "<td class=\"klasa8\"> $row[4] $row[5]</td>";
			$suma+=$row[4];
			if (!$flag)
				{
					echo "<td>";
					$name_select="$row[0]_select_$row[4]";
					$www->SelectWlasc($dbh, $name_select);
					echo "</td>";
				}
			else
 				echo "<td> <b> $row[7] </b> <br> $row[8]</td>"; 				
 			$row[6]=strip_tags($row[6]);
			echo "<td> $row[6] </td>";
			echo "<td class=\"klasa4\"> <a href=\"javascript&#058;displayWindow('pdf/mkpdf.php?dok=dw&id_wpl=$row[0]',800,800, '38')\"> 
				<img src=\"../graphics/pdf.gif\" width=\"32\" height=\"32\" border=\"0\"/> </a> </td>";
			echo "<td><input type=\"checkbox\" name=\"$row[0]_check\" value=\"off\"/></td>";
			echo "</tr>";
	    }

DrawTable($lp++,$conf[table_color]);
			echo "<td> </td>";
			echo "<td> <b> SUMA: </b></td>";
			echo "<td> <b>$suma </b></td>";
			echo "<td> </td>"; 				
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td></td>";
			echo "</tr>";
		
}


function ListaWplat2($p)
{
   include "config.php";
   $dbh=DBConnect($DBNAME1);
//	$abons=SelectAbon($dbh);

	$idk=explode(" ", $p[abon]);
	$ida=array_pop($idk);

	if (empty($p[rozliczona]) || $p[rozliczona] == "Rozliczone")
		{
			$flag=1;
			$q=" select w.id_wpl, w.data_ksiegowania, w.data_zlecona, w.forma, w.kwota, w.waluta, w.opis, a.nazwa, a.id_abon
    	    from wplaty w, abonenci a
          where w.id_kontrah=a.id_abon and w.data_ksiegowania>='$p[data_od]' and w.data_ksiegowania <= '$p[data_do]' and w.rozliczona='T'";
		}
	else 
		{
			$flag=0;
			$q=" select w.id_wpl, w.data_ksiegowania, w.data_zlecona, w.forma, w.kwota, w.waluta, w.opis
    	    from wplaty w 
          where w.data_ksiegowania>='$p[data_od]' and w.data_ksiegowania <= '$p[data_do]' and w.rozliczona='N'";
		}

		if (!empty($p[abon]) && $p[abon] !=$conf[select] && $flag==1)
			{
				$q.=" and a.id_abon='$ida'";
			}

	if (empty($p[order]) || $p[order] == "Data wpłaty")
			$p[order]="w.data_ksiegowania, w.data_zlecona, w.id_wpl";
	else if ($p[order] == "Nazwa kontrahenta")
			$p[order]="a.nazwa, w.data_ksiegowania, w.data_zlecona, w.id_wpl";

	$q.=" order by $p[order]";

//	echo $q;
	$lp=1;
	$sth=Query($dbh,$q);
	while ($row =$sth->fetchRow())
	    {
			DrawTable($lp++,$conf[table_color]);  	
			echo "<td> <a href=\"index.php?panel=fin&menu=updatewplate&wpl=$row[0]\"> $row[0] </a> </td>";
			echo "<td> $row[1] $row[2] $row[3]</td>";
			echo "<td> $row[4] $row[5]</td>";
			if (!$flag)
				{
					echo "<td>";
					$name_select="$row[0]_select_$row[4]";
					$www->SelectWlasc($dbh, $name_select);
					echo "</td>";
				}
			else
 				echo "<td> <b> $row[7] </b> <br> $row[8]</td>"; 				
 			$row[6]=strip_tags($row[6]);
			echo "<td> $row[6] </td>";
			echo "<td><input type=\"checkbox\" name=\"$row[0]_check\" value=\"off\"/></td>";
			echo "</tr>";
	    }
}



function Add($dbh)
{
	$wl=explode(" ", $_POST[abon]);
	$ID_ABON=$wl[count($wl)-1];

	$wpl=array 
	(	'id_wpl'		=> $this->FindLastPayment($_POST[data_wpl],$dbh),		'data_ksiegowania'	=>	$_POST[data_wpl], 		'data_zlecona'	=>	$_POST[data_wpl],
		'forma'			=> $_POST[forma], 			'kwota'					=>$_POST[kwota1], 	'waluta'			=> "PLN",
		'id_kontrah'	=> $ID_ABON,					'rozliczona' => 'T', 							'opis' 			=> $_POST[opis]);

	if ( !empty( $_POST[kwota2] ))
		{
			$wpl[kwota] = $_POST[kwota2];
		}

	Insert($dbh, "wplaty", $wpl);
	$q="update abonenci set saldo=saldo+$wpl[kwota] where id_abon='$wpl[id_kontrah]'";
	WyswietlSql($q);
	Query($dbh, $q);

}

function Upd($dbh, $id_wpl)
{

	$wl=explode(" ", $_POST[abon]);
	$ID_ABON=$wl[count($wl)-1];

	$wpl=array 
	(	'id_wpl'		=> $id_wpl,			'data_ksiegowania'	=>	$_POST[data_wpl], 		'data_zlecona'	=>	$_POST[data_wpl],
		'forma'			=> $_POST[forma], 'kwota'					=> $_POST[kwota], 	'waluta'			=> "PLN",
		'id_kontrah'	=> $ID_ABON,		'rozliczona'			=> 'T', 					'opis' 			=> $_POST[opis]);

	Update($dbh, "wplaty", $wpl);

	$kwota=$_SESSION[wpl][kwota]; 
	$id_abon=$_SESSION[wpl][id_kontrah];

	if ( $_SESSION[wpl][id_kontrah] != $wpl[id_kontrah] )
	{
		$q1="update abonenci set saldo=saldo-$kwota where id_abon='$id_abon'; 
		update abonenci set saldo=saldo+$wpl[kwota] where id_abon='$wpl[id_kontrah]'";
		WyswietlSql($q1);
		Query($dbh, $q1);
	}

	else if ( $_SESSION[wpl][id_kontrah] == $wpl[id_kontrah]  &&  $_SESSION[wpl][kwota] != $_POST[kwota] )
	{
	  $kwota=$_SESSION[wpl][kwota];
		$q="update abonenci set saldo=saldo-$kwota+$_POST[kwota] where id_abon='$wpl[id_kontrah]'";
		WyswietlSql($q1);
		Query($dbh, $q);
	}
}

function PaymentUpdAll($dbh, $array1)
{
	include "func/config.php";
	foreach ($_POST as $k => $v)
		{
			$idk=explode(" ", $v);
			$ida=array_pop($idk);
			$id=explode("_", $k);
			if ( $k!="przycisk" )
			{
				if ($id[1] == "select" && $v!=$conf[select] && !empty($v))
					{ 
						foreach ($array1 as $k1 => $v1)
						{
						$q3="update $k1 set id_kontrah='$ida', rozliczona='T' where $v1='$id[0]'; 
						update abonenci set saldo=saldo+$id[2] where id_abon='$ida'";
						WyswietlSql($q3);
						Query($dbh, $q3);
						}
					}
				else if( $id[1] == "check" && isset($_POST[$k])  )
					{
					foreach ($array1 as $k1 => $v1)
						{ 
							$q3="update abonenci set saldo=saldo-(select kwota from wplaty where id_wpl='$id[0]') where id_abon in (select id_kontrah from wplaty where id_wpl='$id[0]');
							delete from $k1 where $v1='$id[0]'";
							WyswietlSql($q3);
							Query($dbh, $q3);
						}
					}
			}
		}
	echo "Uaktualniono dane.";
}

function PaymentFilesList()
{
	include "func/config.php";
	$m=date("m");
	$y=date("Y");
	if ( $m>1 && $m<=10 )
		{
			$mp=$m-1;
			$mp="0".$mp;
			$yp=$y;
		}
	else if ( $m==1 )
		{
		 $mp=12;
		 $yp=$y-1;
		}
	else
	    {
		$mp=$m-1;
		$yp=$y;
	    }
//	echo "$yp-$mp";

	$d = "$conf[feed]/$yp/$mp";
	$f1=scandir($d);
	
	$d = "$conf[feed]/$y/$m";
	$f2=scandir($d);

	$lp=1;
	foreach (  $f1 as $f ) 
		{
			if ( is_file("$conf[feed]/$yp/$mp/$f"))
				{
					$rozm=Filesize("$conf[feed]/$yp/$mp/$f");
					DrawTable($lp,$conf[table_color]);  	
					echo "<td> $lp. </td>";
					echo "<td> <b>$f </b></td>";
					echo "<td> $rozm </td>";
					echo "<td>  </td>";
					echo "<td>  </td>";
					echo "<td>  </td>";
					echo "<td><input type=\"checkbox\" name=\"$conf[feed]/$yp/$mp/$f\" value=\"off\"/></td>";
					echo "</tr>";
					++$lp;
				}
		}
	foreach (  $f2 as $f ) 
		{
			if ( is_file("$conf[feed]/$y/$m/$f") )
				{
					$rozm=Filesize("$conf[feed]/$y/$m/$f");
					DrawTable($lp,$conf[table_color]);  	
					echo "<td> $lp. </td>";
					echo "<td> <b>$f </b></td>";
					echo "<td> $rozm </td>";
					echo "<td>  </td>";
					echo "<td>  </td>";
					echo "<td>  </td>";
					echo "<td><input type=\"checkbox\" name=\"$conf[feed]/$y/$m/$f\" value=\"off\"/></td>";
					echo "</tr>";
				++$lp;				
				}
		}
}


function FindLastPayment($date, $dbh)
{
	$d=explode("-", $date);
	
	
	$Q="select id_wpl from wplaty where data_ksiegowania between '$d[0]-$d[1]-01 00:00:00'  and date_trunc('month',timestamp '$d[0]-$d[1]-01 00:00:00')+'1month'::interval-'1day'::interval  and id_wpl  like 'WPL/%/$d[1]/$d[0]'order by id_wpl desc limit 1";
	
	WyswietlSql($Q);
	$sth=Query($dbh,$Q);
	$row =$sth->fetchRow();
	if (empty($row[0]))
		$wpl="WPL/0001/$d[1]/$d[0]";
	else
		$wpl=$this->IncWpl($row[0]);
	return $wpl;
}





function StatementLoad($dbh, $file, $forma, $id_wpl, $id_wyp, &$szmsk)
{
    include "func/config.php";
 
		$fh = fopen ("$file" ,'r') or die ($php_errormsg);        

    if ( $forma == "$firma[wyciag]" )
			while ( $s = fgets($fh, 1024) )    
      {
				$s=iconv("ISO-8859-2","UTF-8", $s);							
        if ( preg_match("/^<tr><td nowrap>[0-9]{4}(-[0-9]{2}){2}/", $s) )
          {
            $wpl = preg_split("/<\/td><td nowrap>|<\/td><td>|<\/td><td >/", $s);
            //    $wpl = explode("<\td><td>", $s);
                      
            $s=strip_tags($s);
            //  print "      $s \n";
            $kwota=$wpl[4];
                        
            if ( preg_match("/<br>Prowizja: 5,00 PLN/", $wpl[3]) )
              {
                //echo "<br>sepy<br>";
           	    $kwota+=$firma[prowizja];
             	}
                        
            $opis=strip_tags($wpl[3]);
    	        //      $opis=$wpl[7];
            	    
            	//        foreach ( $wpl as $k => $w)
            	//        {
            	//        $w=strip_tags($w);
            	//        echo "<b>$k</b> ->  $w <br>";    	    
            	//        };
         		$id_wpl=$this->IncWpl($id_wpl);
           	$wplata=array
              (
           	    'id_wpl' => $id_wpl,
           	    'data_ksiegowania' => strip_tags(strip_tags($wpl[0])),
     	    	    'data_zlecona' => strip_tags($wpl[1]),
           	    'forma' => $forma,
           	    'kwota' => $kwota,
           	    'waluta' => strip_tags($wpl[5]),
           	    'id_kontrah' => NULL,
           	    'opis' => $opis
                  //    'rozliczona'
              );
                        
           	$id_wyp=$this->IncWpl($id_wyp);
            $wyplata=array
                        (
                            'id_wyp' => $id_wyp,
                            'data_ksiegowania' => strip_tags($wpl[0]),
                            'data_zlecona' => strip_tags($wpl[1]),
                            'forma' =>  $forma,
                            'kwota' => $wpl[4],
                            'waluta' => $wpl[5],
                            'id_kontrah' => NULL,
                            'opis' => $opis
                        );
					}
          if      ( $wplata[kwota] > 0 )  Insert($dbh, "wplaty", $wplata);
          else if ( $wplata[kwota] < 0 )  Insert($dbh, "wyplaty", $wyplata);                        
			}
    	    
    else if ( $forma == "$firma[wyciag2]" )
    while ( $s = fgets($fh, 1024) )
   	    {
					$s=iconv("ISO-8859-2","UTF-8", $s);
          if ( preg_match("/^<tr><td>\d+/", $s) )
       	    {
           		$wpl = explode("</td><td>", $s);
           		$s=strip_tags($s);
        		//  print "      $s \n";
           		$kwota=$wpl[4];
           		$opis=strip_tags($wpl[7]);
    		//      $opis=$wpl[7];

							$id_wpl=$this->IncWpl($id_wpl);
	            $wplata=array
                (
                 'id_wpl' => $id_wpl,
                  'data_ksiegowania' => $wpl[1],
                  'data_zlecona' => $wpl[2],
                  'forma' =>  $forma,
                  'kwota' => $wpl[4],
                  'waluta' => $wpl[5],
									'id_kontrah' => NULL,
	                'opis' => $opis
    	            //    'rozliczona'
								);

							$id_wyp=$this->IncWpl($id_wyp);
              $wyplata=array
                (
                 'id_wypl' => $id_wyp,
                 'data_ksiegowania' => $wpl[1],
                 'data_zlecona' => $wpl[2],
                 'forma' =>  $forma,
                 'kwota' => $wpl[4],
                 'waluta' => $wpl[5],
                 'id_kontrah' => NULL,
                 'opis' => $opis                        
                );
						}	
					if      ( $wplata[kwota] > 0 )  Insert($dbh, "wplaty", $wplata);	
					else if ( $wplata[kwota] < 0 )  Insert($dbh, "wyplaty", $wyplata);
				}
 
			else if ( $forma == "$firma[wyciag3]" )
				{
					//require_once("ConvertCharset/ConvertCharset.class.php");
					//$maz2utf = new ConvertCharset ('mazovia','utf-8');
					while ( $s = fgets($fh, 4096) )
						{
//							$s=$maz2utf->Convert($s);

							$s=iconv("windows-1250","UTF-8", $s);
				//										print "$s <br>";
							$wpl = explode(",", $s);
						//	print_r($wpl);
							if ( $wpl[0] != 999 ) // 999 to ostatnia linia wyciągu
								{
									$kwota=$wpl[2]/100;
									$kw=$wpl[6];
									$opis1=mb_substr( $wpl[7],  1, -1 );
									$opis2=mb_substr( $wpl[8],  1, -1 );
									$opis3=mb_substr( $wpl[11], 1, -1 );
									$opis="$opis1 $opis2 $opis3";
									$opis=str_replace("|","", $opis);
									$opis=str_replace("\\","/", $opis);
									$opis=str_replace("'","", $opis);
								//	$opis=str_replace("ul.",' ul.', $opis);
								//$op=iconv("UTF-8","ISO-8859-2", $opis);
								//$op=strtr($op, "|",'');
								//$opis=iconv("ISO-8859-2","UTF-8", $op);
								//s	$opis=mb_convert_case($opis, MB_CASE_TITLE, "UTF-8");
									$dk1=mb_substr($wpl[1], 0, 4);
									$dk2=mb_substr($wpl[1], 4, 2);
									$dk3=mb_substr($wpl[1], 6, 2);
									$id_wpl=$this->IncWpl($id_wpl);
									$numer=mb_substr($wpl[6], 1, -1);
									$numer=KontoSpace($numer);
									$Q="select id_abon from konta_wirtualne where numer='$numer' limit 1";
									$id_abon=Query2($Q, $dbh);
									$wplata=array
									(
										'id_wpl' => $id_wpl,
										'data_ksiegowania' => "$dk1-$dk2-$dk3",
										'data_zlecona' => "$dk1-$dk2-$dk3",
										'forma' =>  $forma,
										'kwota' => $kwota,
										'waluta' => "PLN",
										'id_kontrah' => $id_abon[0],
										'opis' => $opis,
										'rozliczona' => 'T'
									);
									//print_r($wplata);
									if ( $wplata[kwota] > 0 ) 
									{	
								//		print_r($wplata);
									//	echo "<br><br>";
										Insert($dbh, "wplaty", $wplata);
										$Q2="update abonenci set saldo=saldo+$kwota where id_abon='$id_abon[0]'";
										Query($dbh,$Q2);

									}
								}
						}
			}
    fclose($fh);
}
                                    
function PaymentsLoad($dbh, &$szmsk)
{
	include "func/config.php";

	set_time_limit ( 180 );

/////////////////////////////////
//echo "Trwa wczyywnia wpłat z pliku. To może potrwać około 2 minut.";
	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" && isset($_POST[$k]))
			{
				$k[mb_strlen($k)-4]=".";
				$plik=explode("/", $k);
				array_shift($plik);
				$plik1=explode("-", $plik[count($plik)-1]);
				
//				$m=mb_substr($plik[2], 0, -4);
//print_r($plik); 
				$forma=$plik1[0];
				$y=$plik1[1];
				$m=mb_substr($plik1[2], 0, 2);
				$d=mb_substr($plik1[3], 0, 2);
				
				if ( $this->ValidateStatement($plik[count($plik)-1]) )	
				{		
						if ( $forma == $firma[wyciag] )
							{
								$forma="$firma[wyciag]";
								$flag=1;
							}
						else if ($forma == $firma[wyciag2] )
							{
								$forma="$firma[wyciag2]";
								$flag=2;
							}
						else if ($forma == $firma[wyciag3] )
							{
								$forma="$firma[wyciag3]";
								$flag=3;
							}
						else $flag=0;

						if ( $flag != 0 )
							{
								if ( $flag==1 || $flag==2)
									$Q="select * from wplaty where id_wpl like 'WPL/%/$m/$y' and forma='$forma' limit 1";
								else if ( $flag==3 )
									$Q="select * from wplaty where forma='$forma' and data_ksiegowania='$y-$m-$d' limit 1";	
									WyswietlSql($Q);
								$roww=Query2($Q,$dbh);
														
							if ( $roww==null )
							// to ponizej odkomentowac zeby moc wczytac wyciag ktory ma date wsteczna
								//if ( $roww!=null )
								{
										$Q2="select id_wpl from wplaty where id_wpl like 'WPL/%/$m/$y' order by id_wpl desc limit 1";
										WyswietlSql($Q2);
										$sth2=Query($dbh,$Q2);
										$row2 =$sth2->fetchRow();
										if ( $row2==null )
											{                                                                                            
												$id_wpl="WPL/0000/$m/$y";
												//echo "$id_wpl";
											}
												//echo "$k";
										else 
											{
												$id_wpl=$row2[0];
											}
																					
										$Q3="select id_wyp from wyplaty where id_wyp like 'WYP/%/$m/$y' order by id_wyp desc limit 1";
										WyswietlSql($Q3);
										$sth3=Query($dbh,$Q3);
										$row3 =$sth3->fetchRow();
										if ( $row3==null )
											{
												$id_wyp="WYP/0000/$m/$y";
														 //echo "$id_wpl";
											}
											 //echo "$k";
										else
											{
												 $id_wyp=$row3[0];
											}	
											
										if ( $flag==1 || $flag==2 )	
											{
											//	$plik[2][2]=".";
											//	$k="$plik[0]-$plik[1]-$plik[2]-$plik[3]-$plik[4]-$plik[5]"; 
													//echo "$k   $forma   $id_wpl, $id_wyp";                                                                 		
												$this->StatementLoad($dbh, $k, $forma, $id_wpl, $id_wyp, $szmsk);	
						//					    Rozlicz($dbh,"20$str2-$str1");
												$this->Rozlicz($dbh,"$y-$m", $szmsk);
											}
										else if ( $flag==3 )
											{ 
												
										//		$k="$plik[0]-$plik[1]-$plik[2]"; 
										//			echo "$k   $forma   $id_wpl, $id_wyp <br>";                                                                 		
												$this->StatementLoad($dbh, $k, $forma, $id_wpl, $id_wyp, $szmsk);									
											}
									}
							else
								{
									print "Plik $k juz zostal przetworzony <br> ";
								}
							}
						else 
							{
								print "Niepoprawna nazwa pliku <br>";
							}	
						
				}
			}
	}
}




function Statement($dbh, $file, $forma, $id_wpl)
{
    include "/home/szmsk3/public_html/func/config.php";
 
		$fh = fopen ("$file" ,'r') or die ($php_errormsg);        

			if ( $forma == "$firma[wyciag3]" )
				{
					require_once("ConvertCharset/ConvertCharset.class.php");
					$maz2utf = new ConvertCharset ('mazovia','utf-8');
					while ( $s = fgets($fh, 1024) )
						{
							$s=$maz2utf->Convert($s);
							$wpl = explode(",", $s);
							if ( $wpl[0] == 110 )
								{
									$kwota=$wpl[2]/100;
									$kw=$wpl[6];
									$opis1=mb_substr( $wpl[7],  1, -1 );
									$opis2=mb_substr( $wpl[8],  1, -1 );
									$opis3=mb_substr( $wpl[11], 1, -1 );
									$opis="$opis1 $opis2 $opis3";
									$opis=str_replace("|","", $opis);
									$opis=str_replace("\\","/", $opis);
									$opis=str_replace("'","", $opis);

									$dk1=mb_substr($wpl[1], 0, 4);
									$dk2=mb_substr($wpl[1], 4, 2);
									$dk3=mb_substr($wpl[1], 6, 2);
									$id_wpl=$this->IncWpl($id_wpl);
									$numer=mb_substr($wpl[6], 1, -1);
									$numer=KontoSpace($numer);
									$Q="select id_abon from konta_wirtualne where numer='$numer' limit 1";
									$id_abon=Query2($Q, $dbh);
									$wplata=array
									(
										'id_wpl' 						=> $id_wpl,
										'data_ksiegowania' 	=> "$dk1-$dk2-$dk3",
										'data_zlecona' 			=> "$dk1-$dk2-$dk3",
										'forma' 						=>  $forma,
										'kwota' 						=> $kwota,
										'waluta' 						=> "PLN",
										'id_kontrah' 				=> $id_abon[0],
										'opis' 							=> $opis,
										'rozliczona' 				=> 'T'
									);
									
										Insert($dbh, "wplaty", $wplata);
										$Q2="update abonenci set saldo=saldo+$kwota where id_abon='$id_abon[0]'";
										Query($dbh,$Q2);
								}
						}
			}
    fclose($fh);
}




function BgzLoad($dbh, $file)
{
	
	include "/home/szmsk3/public_html/func/config.php";
	$m=date("m");
	$y=date("Y");
	
	$fil=explode('/', $file);
	$nazwa=array_pop($fil);
	
	set_time_limit ( 180 );
															
							if ( $this->ValidateStat($dbh, $nazwa) )
									{
										echo "Loading $nazwa file into the database \n";
										$pw=array( 'nazwa'=> $nazwa, 'bank'=>$firma[wyciag3]);
										Insert($dbh, 'pliki_wplat', $pw);
										
										$Q2="select id_wpl from wplaty where id_wpl like 'WPL/%/$m/$y' order by id_wpl desc limit 1";
										WyswietlSql($Q2);
										$sth2=Query($dbh,$Q2);
										$row2 =$sth2->fetchRow();
										if ( $row2==null )
											{                                                                                            
												$id_wpl="WPL/0000/$m/$y";
												$id_wyp="WYP/0000/$m/$y";
											}
										else 
											{
												$id_wpl=$row2[0];
											}
                           		
												$this->Statement($dbh, $file, "bgz", $id_wpl);	

									}
							else
								{
									print "Plik $nazwa juz zostal przetworzony <br> ";
								}
								
	}


function ValidateStat($dbh, $nazwa)
{
	include "/home/szmsk3/public_html/func/config.php";
	$q="select nazwa from pliki_wplat where nazwa='$nazwa' and bank='$firma[wyciag3]'";
	WyswietlSql($q);
	$r=Query2($q, $dbh);
	if ( empty($r) )
	{
		$f=1;
	}
	else
		$f=0;

	return($f);
}

function ValidateStatement($str)
{
			include "func/config.php";
			$wynik=preg_match("/^($firma[wyciag]|$firma[wyciag2]|$firma[wyciag3])-[0-9]{4}(-[0-9]{2}){1,2}\.(txt|TXT|htm|html)/", $str);
	
			if ($wynik==0)
				echo "Nieprawidłowa nazwa pliku z wyciągiem ($str) !!! <br> Nazwa powinna być w postaci np: bgz-2009-05-25.txt, pko-2009-05-25.htm, inteligo-2009-05-25.htm <br> <br> ";
			return ($wynik);
		}

function create_match($tab)
{
    $text='/';
    foreach ( $tab as $v )
    {	
			$v_Nr="$v"."Nr";
	  
          $match.="\b$v\b|\b$v_Nr|"; 
    }
    $match=mb_substr($match,0,mb_strlen($match)-1);
    return $match;
}



function Rozlicz($dbh, $data, &$szmsk)
{
    function UpdateWpl1($p0, $p1, $p2, $p3)
    {
			$Q5="update wplaty set id_kontrah='$p1', rozliczona='T' where id_wpl='$p2'; update abonenci set saldo=saldo+$p3 where id_abon='$p1';";
			WyswietlSql($Q5);
			Query($p0,$Q5);
    }

    set_time_limit(300);
    include "func/config.php";
    
    $lp=0;

    $Q2="select distinct n.id_abon, n.nazwa,  u.nazwa, b.numer, s.nr_lok 
				from budynki b, ulice u , umowy_abonenckie um, nazwy n, adresy_siedzib s
         where s.id_bud=b.id_bud and u.id_ul=b.id_ul and n.id_abon=s.id_abon and um.id_abon=n.id_abon and um.status='Obowiązująca' 
				 and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]' and s.wazne_od <= '$conf[data]' and s.wazne_do >='$conf[data]'
				 order by n.nazwa";
		WyswietlSql($Q2);
    $Q3="select opis, kwota, rozliczona, id_wpl from wplaty where rozliczona='N' and data_ksiegowania like '$data%'";

    $sth2=Query($dbh,$Q2);
    while ( $row2 =$sth2->fetchRow() )
        {
            $id_abon=$row2[0];
						$id_abon2=mb_substr($id_abon, -4,4);
						
            $nazwa=explode(" ", $row2[1] );
            $imie=$nazwa[1];
            $imiepl=$szmsk->konwertuj($nazwa[1]);
            if ( ! preg_match ("/ABONI/i", $id_abon ))
                {
                    $flag=0;
                    $nazwisko=$nazwiskom=$nazwiskok=$nazwa[0];
                    $nazwiskopl=$szmsk->konwertuj($nazwa[0]);
										$nazwiskoNr=$nazwisko;
                    $nazw_koncowka=mb_substr($nazwisko, -2,2);
                    if ($nazw_koncowka == "ki")
                        {
                            $nazwiskok=substr_replace($nazwisko,'a', -1);
                        }
                    else if ($nazw_koncowka == "ka")
                        {
                            $nazwiskom=substr_replace($nazwisko,'i', -1);
                        }
                }
            else
                {
                    $flag=1;
                    $nazwa_firmy=$row2[1];
                }
								$ulica=$row2[2];
								$ulicapl=$szmsk->konwertuj($row2[2]);
								$bud=$row2[3];
								$mieszk=$row2[4];
				//	    if ( $flag==0 )
				//             echo " $row2[1] $nazwisko:: $nazwiskopl $nazwiskom $nazwiskok => <br>";
								$matches=array($nazwisko,$nazwiskom, $nazwiskok, $nazwiskopl);
								$match=$this->create_match($matches);
				//echo "$match <br>";
							
								$sth3=Query($dbh,$Q3);
								$lpn=0;
						
				//	  if ($nazwisko!="Dorota")
						
								while ($row3 =$sth3->fetchRow())
									{
	//	$lp_all++;
										if ( preg_match("/$id_abon|ABON.$id_abon2|ABONI.$id_abon2/i",$row3[0]) )
											{
												++$lp;
												//print "Znaleziono : $id_abon - $nazwisko $imie ";
												UpdateWpl1($dbh, $row2[0], $row3[3], $row3[1]);						  
											}
										else if ( $flag==0 && preg_match ("/$match/i", $row3[0] ) ||  $flag==1 && preg_match("/\b$nazwa_firmy\b/i",$row3[0]) )
											{
										//		echo "Znaleziono | $nazwisko ";
												$Q4="select count(nazwa) from nazwy where nazwa like '%$nazwisko %' or nazwa like '%$nazwiskom %' or nazwa like 
											'%$nazwiskopl %' or nazwa like '%$nazwiskok %' and wazne_od <= '$conf[data]' and wazne_do >='$conf[data]'";
												WyswietlSql($Q4);
												$sth4=Query($dbh, $Q4);
												$row4= $sth4->fetchRow();
												if ( $row4[0] > 1)
													{
														if ( preg_match ("/(\b$imie\b|\b$imiepl\b)|((\b$ulica\b|\b$ulicapl\b)+$bud+$mieszk)/i", $row3[0]) )
		                        {
		                        ++$lp;
					
		      //                       print "Wlsciwe imie:  $nazwisko $imie <br>";
		                          // UpdateWpl1($dbh, $row2[0], $row3[3], $row3[1]);
		                        }
													}
												else if ( $row4[0] == 1)
														{
													++$lp;
										//         print "$lp. + $nazwisko |$nazwiskok $nazwiskom| $imie $row3[3]<br>";
															//	UpdateWpl1($dbh, $row2[0], $row3[3], $row3[1]);
														}
											}
										else 
										{
											$lpn++; 
											 //echo "Nie znaleziono - |$nazwisko| nazwisko <br> $row3[0] <br> <br>";
											 //echo "$nazwisko ";
										}
			
		}
	}
    $sprawnosc=round($lp*100/($lp+$lpn),2);
    $all=$lp+$lpn;
    echo "Rozliczono $lp wpłat z $all ogółem wszystkich wpłat. Pozostało $lpn wpłat nie rozliczonych. <br> Sprawność na poziomie: $sprawnosc % <br><br>";
}

///////////////////////////////////////////////////

}
?>
