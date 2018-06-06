<?php

class JAZDY
{

	function rand_weighted($array)
	{
			$total=0;
			foreach ( $array as $key => $weight)
			{
		$total+=$weight;
		$distr[$key]=$total;
			}
			
			$rand = mt_rand(0, $total - 1);
			
			foreach ( $distr as $key => $weights )
			{
		if ( $rand < $weights ) 
				return $key;
			}
			
	}

	function FindLastJzd($dbh)
	{
			$Q="select id_jzd from jazdy order by id_jzd desc limit 1";
			$sth=Query($dbh,$Q);
			$row =$sth->fetchRow();
			if (empty($row[0]))
					$jzd="JZD0000";
			else
			$jzd=$row[0];
			return $jzd;
	}


	function IncValue2($str)
	{
			for ( $i=0,$len=strlen($str);  $i<$len;  ++$i )
					{
							if ( is_numeric($str[$i]) )
									{
									$newstr=substr($str,0,$i);
									$int=substr( $str, $i, $len );
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
																																																																																																																																																																	
					
	function IncJzd($p)
	{
			$id=explode("/", $p);
			$nr=$id[1];
			++$nr;
			if ($nr < 10)
					{
					$id[1]="00$nr";
					}
			else if ( $nr<100 && $nr>9)
					{
					$id[1]="0$nr";
					}
			else if ( $nr < 999 && $nr > 99)
					{
					$id[1]="$nr";
					}
			$wyj="$id[0]/$id[1]/$id[2]/$id[3]";
			return $wyj;
	}
																																																																																																																																																			

	function CreateJourneys($data_od, $data_do, $pojazd)
	{
			$dbh=DBConnect($DBNAME1);
			$q="select  id_ts, ilosc  from trasy where nr_rej like '$pojazd' order by id_ts";
			//echo "$q'";
			$sth=Query($dbh,$q);
			while ($row =$sth->fetchRow())
		{
				$trasy[$row[0]]=$row[1];
		}
		
			$data=explode("-", $data_od);
			$year=$data[0];
			$month=$data[1];
			$day=$data[2];
			$ilosc_dni= date(t,mktime(0,0,0,$month,$day,$year));
			
			$id_jzd=$this->FindLastJzd($dbh);
			for ($i=1; $i<= $ilosc_dni; $i++)
			{
		$dzien_tyg=date(w, mktime(0,0,0,$month,$i,$year));
		if ( $dzien_tyg != 0 )
		{
				$id_jzd=$this->IncValue2($id_jzd);
				$jazda=array
				(
			'id_jzd'	=>	$id_jzd,
			'data'		=>	"$year-$month-$i",
			'id_ts'		=>	$this->rand_weighted($trasy),
			'nr_rej'	=>	$pojazd,
			'id_cel'	=>	'CEL001'
				);
				Insert($dbh, "jazdy", $jazda);
		}
			}  
			echo "Jazdy dla samochodu $pojazd w miesiącu $data[1].$data[0] zostały wprowadzone.";  
	}

	function ListaJazd($p, &$www)
	{
		$dbh=DBConnect($DBNAME1);

			$Q15="select opis, id_ts from trasy where nr_rej like '$p[pojazd]' order by opis";
			$Q16="select opis, id_cel from cele order by opis";

			if (empty($p[zatwierdzona]) || $p[zatwierdzona] == "Zatwierdzone")
		{
							$flag=1;
							$q="select j.id_jzd, j.data, t.id_ts, t.opis, c.id_cel, c.opis, t.km
					from jazdy j, trasy t, cele c
									where j.id_cel=c.id_cel and j.id_ts=t.id_ts and j.data>='$p[data_od]' and j.data <= '$p[data_do]' and j.zatwierdzona='T'"; 
					}
			
			else
						{
								$flag=0;
			$q="select j.id_jzd, j.data, t.id_ts, t.opis,  c.id_cel, c.opis, t.km
									from jazdy j, trasy t, cele c
									where j.id_cel=c.id_cel and j.id_ts=t.id_ts and j.data>='$p[data_od]' and j.data <= '$p[data_do]' and j.zatwierdzona='N'";
																								
		}


			if (!empty($p[pojazd]) && $p[pojazd] !=$conf[select] && $flag==1)
				{
			$q.=" and j.nr_rej='$p[pojazd]'";
				}
			if (empty($p[order]) || $p[order] == "Data")
						$p[order]="j.data";

		else if ($p[order] == "Cel")
		$p[order]="c.opis";
		$q.=" order by $p[order]";

			WyswietlSql($q);
		$lp=1;
		$sth=Query($dbh,$q);
		while ($row =$sth->fetchRow())
				{
				$a=explode("-", $row[1]);
				$b=getdate(mktime(0,0,0,$a[1],$a[2],$a[0]));
				
					DrawTable($lp++,$conf[table_color]);
				echo "<td> <a href=\"index.php?panel=fin&menu=updatejzd&jzd=$row[0]\"> $row[0] </a> </td>";
				echo "<td> $row[1] <br> $b[weekday]</td>";
				if (!$flag)
						{
								echo "<td>";
								$name_select="$row[0]_select_$row[2]";
								$www->Select2($dbh, $Q15, $name_select, $row[2]);
								echo "</td>";
								echo "<td>";
								$name_select="$row[0]_select_$row[4]";
								$www->Select2($dbh, $Q16, $name_select, $row[4]);
							echo "</td>";                                                    
						}
				else
				{
					echo "<td> <b> $row[3] </b></td>";
					echo "<td> <b> $row[5] </b></td>";
				}
					
				$row[6]=strip_tags($row[6]);
				echo "<td> $row[6]</td>";
				echo "<td><input type=\"checkbox\" name=\"$row[0]_check\" value=\"off\"/></td>";
				echo "</tr>";
				}
		}



	function UpdateJzd($array1)
	{
		 $dbh=DBConnect($DBNAME1);
		 for ( reset($_POST); $k=key($_POST), $v=$_POST[$k]; next($_POST) )
				 {
						 $idk=explode(" ", $v);
						 $ida=array_pop($idk);
						 $id=explode("_", $k);
						if ( $k!="przycisk" )
								 {
										 if ( $id[1] == "select" && $v!=$conf[select] && !empty($v) )
									 {  
											foreach( $array1 as $k1 => $v1 )
											{
															$q3="update $k1 set id_ts='$ida', zatwierdzona='T', ";    	 
															next($_POST); 
															$k=key($_POST); $v=$_POST[$k]; 
															$idk=explode(" ", $v);
															$ida=array_pop($idk);
															$id=explode("_", $k);                     
															$q3.="id_cel='$ida' where $v1='$id[0]'";
															WyswietlSql("$q3 <br>");
															Query($dbh, $q3);
															} 
												 }
										 else if( $id[1] == "check" && isset($_POST[$k])  )
												 {
														 foreach ($array1 as $k1 => $v1)
																 {
																		 $q3="delete from $k1 where $v1='$id[0]'";
																		 WyswietlSql($q3);
																		 Query($dbh, $q3);
																 }
									 }
								 }
				 }
						 echo "Uaktualniono dane.";
	}

}

?>