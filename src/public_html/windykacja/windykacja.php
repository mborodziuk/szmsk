<?php
/////////////////////////////////////////////////////////////////
//////////////////    W I N D Y K A C J A    ///////////////////
///////////////////////////////////////////////////////////////

class WINDYKACJA
{
	function ListaWindykowanych($dbh, $p, &$www)
	{
		include "func/config.php";
		$_SESSION[$session[windykacja][pagination]]=$_POST;
		
		$data_do=explode("-", $p[data_do]);
		$m=$data_do[1];

		$rb=$data_do[0];
		$rp=$rb-1;
		
		$mies=array( 
		"$rb-01"=>1, "$rb-02"=>2, "$rb-03"=>3, "$rb-04"=>4, "$rb-05"=>5, "$rb-06"=>6, 
		"$rb-07"=>7, "$rb-08"=>8, "$rb-09"=>9, "$rb-10"=>10, "$rb-11"=>11, "$rb-12"=>12, 
		"$rp-12"=>0, "$rp-11"=>-1, "$rp-10"=>-2, "$rp-09"=>-3, "$rp-08"-4, "$rp-07"=>-5, 
		"$rp-06"=>-6,"$rp-05"=>-7, "$rp-04"=>-8, "$rp-03"=>-9, "$rp-02"=>-10, "$rp-01"=>-11 );
		

		$q="select distinct s.id_spw, w.id_wnd, a.id_abon, n.symbol, n.nazwa, a.saldo, w.krok
			from abonenci a, sprawy_windykacyjne s, windykowanie w, nazwy n
			where s.id_abon=a.id_abon and a.id_abon=n.id_abon and w.id_spw=s.id_spw  
			and n.wazne_od <= '$p[data_do]' and n.wazne_do >= '$p[data_do]' 
			and s.data_zgl between '$p[data_od]' and '$p[data_do]'";
		
			function transform1($p)
			{	
				include "func/config.php";
				
				if ($p[krok]!=$conf[select])
					$q.=" and w.krok='$p[krok]'";
				if ($p[typ]!=$conf[select])
						{
							if ( $p[typ]=='niezwindykowane' )
								$q.=" and s.zwindykowana='N' and w.data_zak is null ";
							else 
							 $q.=" and s.zwindykowana='T' and w.data_zak is not null ";
						}
					
				if ($p[nazwa]!=$conf[select])
					$q.=" and n.nazwa like '$p[nazwa]%'";

				if ($p[ulice]!=$conf[select])
					$q.=" and u.nazwa='$p[ulice]'";
					
							if ($p[miasto]!=$conf[select])
											$q.=" and u.miasto='$p[miasto]'";
															
				if ($p[budynki]!=$conf[select])
					$q.=" and b.numer='$p[budynki]'";
														
				if ($p[saldo]!=$conf[select])
					{
						switch ( $p[saldo] )
							{
								case "< -200" :
										$q.=" and a.saldo < -200";
										break;
								case "-150 do -100" :
										$q.=" and a.saldo between -200 and -101";
										break;
								case "-100 do 0" :
										$q.=" and a.saldo between -100 and -1";
										break;
								case "0" :
										$q.=" and a.saldo=0";
										break;
								case "0 do 100" :
										$q.=" and a.saldo between 1 and 100";
										break;
								case "100 do 200" :
										$q.=" and a.saldo between 101 and 200";
										break;
								case "> 200" :
										$q.=" and a.saldo > 200";
										break;
							}
					}
					return $q;
			}
				$q.=transform1($p);
								
		$q.=" order by n.nazwa";
		
		WyswietlSql($q);	
		$sth=Query($dbh,$q);
		$lp=1;
		$suma=0;
		
		/*			<a href=\"javascript&#058;displayWindow(\"index.php?panel=fin&menu=spwupd&spw=$row[0]\",800,800, \"38\")\"> $row[0] </a>
				
				<a href=\"javascript&#058;displayWindow('xml/mkxml.php?dok=pozew&id_spw=$row[0]',800,1100, '38')\"> $row[0] </a>
				
				<a href=\"#\" onclick=\"window.open('windykacja/spwupd.php?spw=$row[0]', 'Nowe_okno','height=800,width=1100');\">Otwórz male okienko</a>
	*/			

	
		while ($row =$sth->fetchRow())
			{
				DrawTable($lp++,$conf[table_color]);
				$liczbaporzad=$lp-1;
				echo "<td><i>$liczbaporzad.</i></td>";
				echo "<td class=\"klasa4\">
				<a href=\"index.php?panel=fin&menu=spwupd&spw=$row[0]\"> $row[0] </a>
				 </td>";
				$s=Choose($row[3], $row[4]);
				echo "<td class=\"klasa4\"> <b>$s</b> <br> <a href=\"index.php?panel=inst&menu=updateabon&abon=$row[2]\"> $row[2] </a>  <br> $row[7]</td>";
				$saldo=round( $row[5], 2 );
				echo "<td class=\"klasa8\"> $saldo </td>";  		
				$suma-=$saldo;
				$yf=$data_do[0]-1;
				$df="$yf-$data_do[1]-01";
				$q2=" select w.kwota, w.id_wpl, w.data_ksiegowania, w.opis 
						from wplaty w
						where w.rozliczona='T' and w.id_kontrah='$row[2]' and w.data_ksiegowania>='$df'";
				WyswietlSql($q2);
				$sth2=Query($dbh,$q2);

				$start=$data_do[1]-12;
				//$start=1;
				$l=$start;
					
				//echo date(do;
				while ($row2 =$sth2->fetchRow())
					{
						$fz=1;
						$mw=explode("-",$row2[2]);
						if ( $l==$mies["$mw[0]-$mw[1]"] )
							{
								if ($fz==0) 
									{
										echo "</td>";
										$fz=1;
									}
								echo "<td class=\"klasa4\">$row2[0] ";
							}
						else if ( $l<$mies["$mw[0]-$mw[1]"])
								{
									while ( $l<$mies["$mw[0]-$mw[1]"])
										{
											if ($fz==0) 
												{
													echo "</td>";
													$fz=1;
												}
											$d=array_keys($mies, $l);
											if( $row[7] <= "$d[0]-22" )
													echo "<td class=\"klasa4\"> 0 </td>";
											else
													echo "<td class=\"klasa4\"> X </td>";										
											$l++;
										} 
									echo "<td class=\"klasa4\"> $row2[0]";
									$fz=0;
								}
						else if (  $l > $mies["$mw[0]-$mw[1]"]  )
								{
									$l--;
									echo "<br>$row2[0]";
									$fz=0;
								}
						$l++;
					}
					while ($l<=$m)
								{
									echo "<td class=\"klasa4\">0 </td>";
									$l++;
								} 
				//echo "<td class=\"klasa4\"><input type=\"checkbox\" name=\"K-$row[0]-$row[1]\"/></td>";
				
				//echo "<td class=\"klasa4\"><input type=\"checkbox\" name=\"W-$row[0]-$row[1]\"/></td>";

				
				if ( $p[typ]=='niezwindykowane' || $p[typ]==$conf[select] )
				{
					echo "<td class=\"klasa4\">";
					$www->SelectFromArray($conf[kroki], "W-$row[0]-$row[1]-$row[6]", $row[6]);
					echo "</td>";
					if ( $_SESSION[uprawnienia]=='fin' || $_SESSION[uprawnienia]=='admin' )
					{
						echo "<td class=\"klasa4\"><input type=\"checkbox\" name=\"K-$row[0]-$row[1]\"/></td>";
					}
				}
				
				
				echo "<td class=\"klasa4\"> <a href=\"javascript&#058;displayWindow('pdf/mkpdf.php?dok=pz&id_spw=$row[0]',800,1100, '38')\"> 
					<img src=\"../graphics/pdf.gif\" width=\"32\" height=\"32\" border=\"0\"/> </a> </td>";
				echo "<td class=\"klasa4\"> <a href=\"javascript&#058;displayWindow('pdf/mkpdf.php?dok=wz&id_spw=$row[0]',800,1100, '38')\"> 
					<img src=\"../graphics/pdf.gif\" width=\"32\" height=\"32\" border=\"0\"/> </a> </td>";
				echo "<td class=\"klasa4\"> <a href=\"javascript&#058;displayWindow('pdf/mkpdf.php?dok=wz2&id_spw=$row[0]',800,1100, '38')\"> 
					<img src=\"../graphics/pdf.gif\" width=\"32\" height=\"32\" border=\"0\"/> </a> </td>";
				echo "<td class=\"klasa4\"> <a href=\"javascript&#058;displayWindow('xml/mkxml.php?dok=pozew&id_spw=$row[0]',800,1100, '38')\"> 
					<img src=\"../graphics/pdf.gif\" width=\"32\" height=\"32\" border=\"0\"/> </a> </td>";
				echo "</tr>";
			}
						 DrawTable($lp++,$conf[table_color]);
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> <b> SUMA: </b></td>";
			echo "<td> <b>$suma </b></td>";
			echo "<td> </td>"; 				
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>"; 				
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>"; 				
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";			
			echo "</tr>";
	}

	function CreateWezwanie($dbh, $id_abon, $type)
	{

		include "func/config.php";

		$q="select s.id_spw, a.id_abon, n.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, sb.nr_lok, u.nazwa, u.miasto, 		u.kod, b.numer, kw.numer
		from abonenci a, nazwy n, adresy_siedzib sb, sprawy_windykacyjne s, ulice u, budynki b, umowy_abonenckie um, konta_wirtualne kw
		where a.id_abon=n.id_abon and a.id_abon=s.id_abon and s.id_abon=a.id_abon  and sb.id_bud=b.id_bud and um.id_abon=a.id_abon 
		and u.id_ul=b.id_ul and a.id_abon=kw.id_abon 
		and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]' and sb.wazne_od <= '$conf[data]' and sb.wazne_do >='$conf[data]' and a.id_abon='$id_abon'";
		WyswietlSql($q);
		$sth=Query($dbh,$q);
		$row=$sth->fetchRow();
	
		$dluznik=array
			(
				'id_spw'		=> $row[0],		'id_abon' => $row[1],		'nazwa'			=> $row[2], 	'saldo'			=> $row[3],	
				'um_numer'	=> $row[4],		'data_zaw'=> $row[5], 	'typ_um'		=> $row[6],		'platnosc'	=> $row[7],		
				'ulica'			=> $row[9],		'nr_bud'	=> $row[12],	'nr_mieszk'	=> $row[8],
				'miasto'		=> $row[10],	'kod'			=> $row[11], 	'konto'		=> $row[13]
			);

		$adres1=$dluznik[kod]." ".$dluznik[miasto];
		$adres2="ul. ".$dluznik[ulica]." ".$dluznik[nr_bud];
		if (!empty($dluznik[nr_mieszk]))
		$adres2.="/$dluznik[nr_mieszk]";

		$adresat=array('nazwa' => $dluznik[nazwa], 'adres1' => $adres1, 'adres2' => $adres2);
			
		$dluznik[saldo]=-$dluznik[saldo];
			
			
		$wezwanie="Szanowni Państwo.

Z przykrością stwierdzamy, że konto Państwa wskazuje zaległe należności za usługi na łączną kwotę:
$dluznik[saldo] zł brutto.

Uprzejmie prosimy o niezwłoczne wpłacenie w/w kwoty na rachunek bankowy:
NETICO S.C.  - $dluznik[konto]
		
Jeżeli uregulowaliście już Państwo ww należności to prosimy potraktować to ponaglenie jako nieaktualne.
		
Przypominamy, że zaleganie z płatnością wystawionych faktur lub not odsetkowych o więcej niż 14 dni od wyznaczonego terminu płatności może skutkować całkowitą utratą dostępu do infrastruktury teleinformatycznej operatora, zamknięciem konta i utratą wszystkich związanych z nim zasobów i informacji.
				
Jeśli Państwo, z powodu braku czasu, mają problemy z terminowym regulowaniem należności za wystawione przez NETICO S.C. faktury za usługi zachęcamy do korzystania ze stałego zlecenia przelewu (przelew cykliczny).
				
W razie jakichkolwiek wątpliwości dotyczących zaległych płatności prosimy o kontakt na adres e-mail: finanse@netico.pl lub telefoniczny pod numerem telefonu: 32 745 33 33.
			
Z poważaniem

NETICO S.C. 
ul. Szopena 26
41-400 Mysłowice,
infolinia  801 000 155
kom.	500 870 870
fax  32 745 33 34
e-mail: biuro@netico.pl
http://www.netico.pl

------------------------------------------------------------------------
Informacja zawarta w tym mailu jest poufna i objęta tajemnicą zawodową. Mail skierowany jest wyłącznie do adresata. Jeżeli nie jest Pani/Pan adresatem tej korespondencji, informuję, że wykorzystywanie lub rozpowszechnianie maila oraz zawartych w nim informacji w jakiejkolwiek formie jest niedozwolone. Jeżeli nie jest Pani/Pan adresatem powyższej korespondencji uprzejmie proszę o natychmiastowe powiadomienie o tym fakcie nadawcy i skasowanie tej wiadomości. Dziękuję.
";

	//	$wezwanie="$tekst0.$tekst1.$tekst2.$tekst3.$tekst4.$tekst5.$tekst6.$tekst7.$tekst8.$tekst9.$tekst10.
	//	$tekst11.$tekst12.$tekst13.$tekst14.$tekst15";
		
		return $wezwanie;

}





	function ZastosujWindykacja($krok, &$zlc, &$szmsk)
	{
		include "func/config.php";
		$dbh=DBConnect($DBNAME1);
		$data=date("Y-m-d");
		
		foreach ($_POST as $k => $v)
			{
				if ($k!="przycisk" )
					{
						$t=explode("-", $k);

						if ($t[0]=="K" )
						{
								$windykowanie=array('id_wnd'=>$t[2], 'data_zak'=>$data);
								Update($dbh, "windykowanie", $windykowanie);
								$spr_windyk=array('id_spw'=>$t[1], 'zwindykowana'=> 'T');
								Update($dbh, "Sprawy_windykacyjne", $spr_windyk);
						}
					 else if ($t[0]=="W" &&  $t[3]!=$v  && $t[1]!="przycisk" )
						{		
						
								  $p=array_search($krok, $conf[kroki]);
									$windykowanie=array('id_wnd'=>$t[2], 'data_zak'=>$data);
									Update($dbh, "windykowanie", $windykowanie);
									
									$windykowanie=array('id_wnd'=>IncItNum($dbh, $data, "WND"), 'data_rozp'=>$data, 'data_zak' =>'NULL', 'krok'=> $v, 'id_spw'=>$t[1]);
									Insert($dbh, "windykowanie", $windykowanie);
									switch($v)
									{
										case "info":
												$this->WlaczInfo();
												break;
										case "mail":
												$q2="select id_abon from sprawy_windykacyjne where id_spw='$t[1]'";
												$r=Query2($q2,$dbh);
												$id_abon=$r[0];
												$this->WyslijEmail($dbh, $id_abon);
												break;
										case "blokada":
												$this->WlaczBlokade();
												break;						
										case "krd":
												$this->Krd($dbh, $t[1], $zlc, $szmsk);
												break;
										case "nota" :
											$this->NotaObciazeniowa($dbh, $t[1]);
											break;											
										case "firma":
												break;						
									}
								
						}
					}
			}
			
		echo "Wprowadzono zmiany do systemu.<br>";
	}

	function Automate()
	{
	
		include "func/config.php";
	

		function ZakonczWindykacje($dbh, $id_spw, $id_wnd)
		{
			$data=date("Y-m-d");
			$windykowanie=array('id_wnd'=>$id_wnd, 'data_zak'=>$data);
			Update($dbh, "windykowanie", $windykowanie);
			$spr_windyk=array('id_spw'=>$id_spw, 'zwindykowana'=> 'T');
			Update($dbh, "Sprawy_windykacyjne", $spr_windyk);
		}
		
			$Q="update windykowanie set data_zak='$data' where data_zak is NULL and id_spw in (select s.id_spw from abonenci a, sprawy_windykacyjne s, windykowanie w where a.saldo=0 and a.id_abon=s.id_abon and s.id_spw=w.id_spw and w.krok in ('info', 'blokada', 'pismo'));
	update sprawy_windykacyjne set zwindykowana='T' where zwindykowana='N' and id_abon in (select s.id_abon from abonenci a, sprawy_windykacyjne s, windykowanie w where a.saldo=0 and a.id_abon=s.id_abon and w.id_spw=s.id_spw and w.krok in ('info', 'blokada', 'pismo'))";
	
	//	Query($dbh, $Q);
		
		$q="select  sum.id_spw, sum.id_wnd,  sum.id_abon , sum.nazwa, sum.saldo, sum(tcena), sum.krok from 
		( 
		select s.id_spw, w.id_wnd, w.krok, a.id_abon, n.nazwa, a.saldo, sum(t.cena) as tcena from 
		towary_sprzedaz t, komputery k, abonenci a, sprawy_windykacyjne s, windykowanie w, nazwy n  
		where k.id_taryfy=t.id_tows and a.id_abon=k.id_abon and w.id_spw=s.id_spw and s.id_abon=a.id_abon and w.data_zak is null and s.zwindykowana='N' and n.id_abon=a.id_abon and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'
		group by a.id_abon, n.nazwa, a.saldo, s.id_spw, w.id_wnd, w.krok 
		union 
		select s.id_spw, w.id_wnd, w.krok, a.id_abon, n.nazwa, a.saldo, sum(t.cena) as tcena from 
		towary_sprzedaz t, telefony_voip v, abonenci a , sprawy_windykacyjne s, windykowanie w, nazwy n 
		where v.id_tvoip=t.id_tows and a.id_abon=v.id_abon and w.id_spw=s.id_spw and s.id_abon=a.id_abon and w.data_zak is null and s.zwindykowana='N' and n.id_abon=a.id_abon and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'
		group by a.id_abon, n.nazwa, a.saldo, s.id_spw, w.id_wnd, w.krok
		union
		select s.id_spw, w.id_wnd, w.krok, a.id_abon, n.nazwa, a.saldo, sum(t.cena) as tcena from 
		towary_sprzedaz t, settopboxy x, abonenci a , sprawy_windykacyjne s, windykowanie w, nazwy n 
		where x.id_taryfy=t.id_tows and a.id_abon=x.id_abon and w.id_spw=s.id_spw and s.id_abon=a.id_abon and w.data_zak is null and s.zwindykowana='N' and n.id_abon=a.id_abon and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'
		group by a.id_abon, n.nazwa, a.saldo, s.id_spw, w.id_wnd, w.krok
		) 
		as sum group by sum.id_abon, sum.nazwa, sum.saldo, sum.id_spw, sum.id_wnd, sum.krok";

			
		$sth=Query($dbh,$q);
		$lp=1;
		 while ($row =$sth->fetchRow())
			{
					switch ( $row[6] )
							{
								case "mail" :
											if ( $row[4] >= 0 )
										{
											ZakonczWindykacje( $dbh, $row[0], $row[1]);
											echo "$row[3] usunięto z kroku windykacyjnego mail<br>";
										}							
										break;
								case "info" :
										if ( $row[4] >=-2*$row[5] )
										{
											ZakonczWindykacje( $dbh, $row[0], $row[1]);
											echo "$row[3] usunięto z kroku windykacyjnego info<br>";
										}
																					break;
								case "blokada" :
										if ( $row[4] >=-2*$row[5]  )
										{
										ZakonczWindykacje( $dbh, $row[0], $row[1]);
										echo "$row[3] usunięto z kroku windykacyjnego blokada<br>";
										}
										break;
								case "pismo" :
										if ( $row[4] >=-2*$row[5]  )
										{
										ZakonczWindykacje( $dbh, $row[0], $row[1]);
										echo "$row[3] usunięto z kroku windykacyjnego pismo<br>";
										}
										break;
								case "krd" :
										//echo "krd <br>";
										break;
								case "nota" :
/*										echo "Trzeba sprawdzić czy trzeba i wystawić note obciążeniową klientowi <br>
										za np. nie dotrzymanie czasu obowiązywania umowy i promocji <br>
										lub za brak zawrotu dzierżawionego sprzętu <br>";*/
										break;
								case "firma" :
										//echo "firma <br>";
										break;
								case "sad" :
										//echo "sad <br>";
										break;
							}
			}
				
		echo "Wprowadzono zmiany do systemu.<br>";
	}	
	
	
	function WyslijEmail( $dbh, $id_abon )
	{
			include "func/config.php";
			$data=date("Y-m-d");

			$wezwanie=$this->CreateWezwanie($dbh, $id_abon, 1);
			$q="select email from maile where id_podm='$id_abon'";
			$sth=Query($dbh,$q);
			$row =$sth->fetchRow();
			$to="$row[0]";
			
			if (!empty($to))
				{
					$email=new EMAIL();
					$email->WyslijMaila("$firma[email3]", "$to", 'PONAGLENIE ZAPŁATY',"$wezwanie");
					//$email->SendMail("$firma[email3]", 'NETICO S.C. | Finanse', $to, 'PONAGLENIE ZAPŁATY', $wezwanie, array());
				}
			else
				echo "Brak maila <br>";
	}
	
	
		function PierwszyKrok( $dbh, $id_abon )
	{
			include "func/config.php";
			$data=date("Y-m-d");
			$id_spw=IncItNum($dbh, $data, "SPW");
			
			$spr_windyk=array('id_spw'=>$id_spw, 'data_zgl'=>$data, 'id_abon'=> $id_abon,'id_prac' =>'NULL', 'zwindykowana'=> 'N');
			Insert($dbh, "Sprawy_windykacyjne", $spr_windyk);
			$windykowanie=array('id_wnd'=>IncItNum($dbh, $data, "WND"), 'data_rozp'=>$data, 'data_zak' =>'NULL', 'krok'=> 'obserwacja', 'id_spw'=>$id_spw);
			Insert($dbh, "windykowanie", $windykowanie);
	}
	
	function DodajDoWindykacji($dbh)
	{

		include "func/config.php";
	
		$q="select  sum.id_abon , sum.nazwa, sum.saldo, sum(tcena), sum.status from 
		( select a.id_abon, n.nazwa, a.saldo, u.status, sum(t.cena) as tcena from 
		towary_sprzedaz t, komputery k, abonenci a, umowy_abonenckie u, nazwy n
		where k.id_taryfy=t.id_tows and a.id_abon=k.id_abon and  u.id_abon=a.id_abon and u.status='Obowiązująca' and k.fv='T' and n.id_abon=a.id_abon and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'
		and a.id_abon not in ( select s.id_abon from sprawy_windykacyjne s, windykowanie w where w.data_zak is null and s.zwindykowana='N')
		group by a.id_abon, n.nazwa, a.saldo, u.status  
		union 
		select a.id_abon, n.nazwa, a.saldo, u.status, sum(t.cena) as tcena from 
		towary_sprzedaz t, telefony_voip v, abonenci a , umowy_abonenckie u, nazwy n
		where v.id_tvoip=t.id_tows and a.id_abon=v.id_abon and  u.id_abon=a.id_abon and u.status='Obowiązująca' and v.fv='T' and n.id_abon=a.id_abon and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'
		and a.id_abon not in ( select s.id_abon from sprawy_windykacyjne s, windykowanie w where w.data_zak is null and s.zwindykowana='N')
		group by a.id_abon, n.nazwa, a.saldo, u.status
		union 
		select a.id_abon, n.nazwa, a.saldo, u.status, sum(t.cena) as tcena from 
		towary_sprzedaz t, settopboxy x, abonenci a , umowy_abonenckie u, nazwy n
		where x.id_taryfy=t.id_tows and a.id_abon=x.id_abon and  u.id_abon=a.id_abon and u.status='Obowiązująca' and x.fv='T' and n.id_abon=a.id_abon and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'
		and a.id_abon not in ( select s.id_abon from sprawy_windykacyjne s, windykowanie w where w.data_zak is null and s.zwindykowana='N')
		group by a.id_abon, n.nazwa, a.saldo, u.status) 
		as sum group by sum.id_abon, sum.nazwa, sum.saldo, sum.status";
		
		WyswietlSql($q);
		$sth=Query($dbh,$q);
		$lp=1;
		 while ($row =$sth->fetchRow())
			{
					switch ( $row[4] )
							{
								case "Obowiązująca" :
										//echo "Obowiązująca<br>";
										if ( $row[2]-5 <= -2*$row[3] )
										{
												echo "Dodano: $row[1],  $row[2] , $row[3] <br>";
												$this->PierwszyKrok($dbh, $row[0]);
											}
											
										break;
								case "Rozwiązana" :
										echo "info<br>";
										break;

								case "Windykowana" :
										echo "krd <br>";
										break;
								case "Zawieszona" :
										echo "krd <br>";
										break;
							}
			}
				
		echo "Wprowadzono zmiany do systemu.<br>";
	
		
		}

	function WlaczInfo()
	{
		echo "Włączono informację o nieuregulowanych płatnościach <br>";
	}

	function WlaczBlokade()
	{
		echo "Włączono blokadę dostępu do Internetu <br>";
	}

	function Krd($dbh, $id_spw, $zlc, $szmsk)
	{
		$q1="update umowy_abonenckie set status='windykowana' where id_abon in (select id_abon from sprawy_windykacyjne where id_spw='$id_spw')";
		Query($dbh,$q1);
		
		$q2="select id_abon from sprawy_windykacyjne where id_spw='$id_spw'";
		$r=Query2($q2,$dbh);
		$id_abon=$r[0];
		
		$zlc->Demontaz($dbh, $id_abon, $szmsk);
	}
	
	function NotaObciazeniowa($dbh, $id_spw)
	{	
		echo "Trzeba sprawdzić czy trzeba wystawić notę obciążeniową klientowi za np. nie dotrzymanie <br>
		czasu obowiązywania umowy i promocji lub za brak zawrotu dzierżawionego sprzętu <br><br>";

	}
	
	
	function SpwValidate($dbh)
	{
		$flag=1;
		if ( ValidateDate($_POST[data_zgl]) )
				{ 	 
					$flag=1;
				}
		else
				{
					$flag=0;
				}

		return ($flag);	
	}	

function SpwUpd($dbh, $id_spw)
{
		include "func/config.php";	
		$spwa=$_SESSION[$id_spw.$_SESSION[login]];
				
		$spw=array(
						'id_spw'	  => $id_spw,  		
						'data_zgl'	=> $_POST[data_zgl], 
						'opis'			=> $_POST[opis]
					);
		Update($dbh, "sprawy_windykacyjne", $spw);
		
	}
}

?>