<?php

class INVOICES
{

/////////////////////////////////////////////////////////////////
///////////// D O K U M E N T Y  K S I E G O W E ///////////////
///////////////////////////////////////////////////////////////

function DeleteFv ($dbh)
{
   include "func/config.php";
	
	$_POST2=array_reverse($_POST);
	foreach ($_POST2 as $k => $v)

		{
			if ( $k!="przycisk" )
			{
				$kwota=0;
			
				$d=explode("/", $k);
	
				$q5="select d.nr_ds, d.id_odb, a.pesel_nip from dokumenty_sprzedaz d, abonenci a where d.nr_ds like '%/$d[2]/$d[3]' and d.id_odb=a.id_abon order by nr_ds desc limit 1";	
				$sth=Query($dbh, $q5);
				$row=$sth->fetchRow();
				$ds_ost=$row[0];
				if ( !ValidateNip($row[2]) )
				{
						$q2="select t.cena from pozycje_sprzedaz p, towary_sprzedaz t where p.nr_ds='$k' and p.id_tows=t.id_tows";
						$sth=Query($dbh, $q2);
						while ($row =$sth->fetchRow())						
						$kwota+=$row[0];
			
						$q3="update abonenci set saldo=saldo+$kwota where id_abon=(select id_odb from dokumenty_sprzedaz where nr_ds='$k');
						delete from dokumenty_sprzedaz where nr_ds='$k'; delete from pozycje_sprzedaz where nr_ds='$k'";
						WyswietlSql($q3);	
						Query($dbh, $q3);
						
						if ($ds_ost != $k)
						{
							$q4="update dokumenty_sprzedaz  set nr_ds='$k'  where nr_ds='$ds_ost'; update pozycje_sprzedaz  set nr_ds='$k'  where nr_ds='$ds_ost'";
							WyswietlSql($q4);	
							Query($dbh, $q4);
						}
				}
			else 
				echo "Nie można usunąć faktury VAT, ponieważ ostatnia wystawiona w bieżącym miesiącu to faktura dla firmy.";
			}
		}
	echo "Usunięto dane z systemu.";
}

function PierwszyRoboczy($data)
{
	$d=explode("-",$data);
	
	$pierw_rob=date(w, mktime(0,0,0,$d[1],"01",$d[0]));
	if ( $pierw_rob != 0 ) 
		$dzien="01";
	else
		 $dzien="02";
	return "$d[0]-$d[1]-$dzien";
}

function InitNrFV($dbh)
{
	$data=date("Y-m");
	$nr=date("/m/Y");
	$q="select nr_ds from dokumenty_sprzedaz where data_wyst between '$data-01 00:00:00' 
	and date_trunc('month',timestamp '$data-01 00:00:00')+'1month'::interval-'1day'::interval order by nr_ds desc limit 1";
	WyswietlSql($q);
	$sth=Query($dbh, $q);
	$row=$sth->fetchRow();
	if ( empty($row) )
		$nr="FV/0001"."$nr";
	else 
		{
			$numer=explode("/",$row[0]);
			if ($numer[0] < 50)
			    $nr=$this->IncNrFV($row[0]);
			else 
				$nr="XXX";
		}
	return($nr);
}



function IncNrFV($nr)
{
    $nry=explode("/", $nr);
    ++$nry[1];
    if ($nry[1] < 10)
        $nry[1]="000"."$nry[1]";
    else if ($nry[1] < 100)
        $nry[1]="00"."$nry[1]";
    else if ( $nry[1] < 1000)
	$nry[1]="0"."$nry[1]";
	
    $new_nr="FV/$nry[1]"."/"."$nry[2]"."/"."$nry[3]";
    return($new_nr);
}

                                                                                
function FindLastFV($dbh, $date)
{
    $d=explode("-", $date);
    $Q="select nr_ds from dokumenty_sprzedaz where data_wyst between '$d[0]-$d[1]-01 00:00:00' 
	and date_trunc('month',timestamp '$d[0]-$d[1]-01 00:00:00')+'1month'::interval-'1day'::interval order by nr_ds desc limit 1";
		WyswietlSql($Q);
    $row=Query2($Q, $dbh);
    if (empty($row[0]))
        $nr="FV/0001/$d[1]/$d[0]";
    else
    $nr=$this->IncNrFV($row[0]);
    return ($nr);
}


function AInvoiceAdd($dbh)
{
	include "func/config.php";
	set_time_limit(1200);
	$fv=$fv1=$_SESSION[fabon];
	$fv[forma_plat]=$fv1[forma_plat]="przelew";
	$fv[stan]=$fv1[stan]="nieuregulowana";

	$fv[nr_ds]=$fv1[nr_ds]=$this->InitNrFV($dbh);
	
	if ( $fv{nr_ds}  != "XXX" )
		{
			$q="(select distinct a.id_abon, n.nazwa,  a.saldo, a.platnosc,  a.fv_comiesiac
					from abonenci a, umowy_abonenckie um, komputery k, nazwy n
					where um.id_abon=a.id_abon and k.id_abon=a.id_abon and k.fv='T' and k.podlaczony='T' and um.status in ('Obowiązująca')
					and n.id_abon=a.id_abon and n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]')
					union 
					(select distinct a.id_abon, n.nazwa,  a.saldo, a.platnosc,  a.fv_comiesiac
					from abonenci a, umowy_abonenckie um, telefony_voip v, nazwy n
					where um.id_abon=a.id_abon and v.id_abon=a.id_abon and v.fv='T' and v.aktywny='T' and um.status in ('Obowiązująca')
					and n.id_abon=a.id_abon and n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]') 
					union 
					(select distinct a.id_abon, n.nazwa,  a.saldo, a.platnosc,  a.fv_comiesiac
					from abonenci a, umowy_abonenckie um, settopboxy s, nazwy n
					where um.id_abon=a.id_abon and s.id_abon=a.id_abon and s.fv='T' and s.aktywny='T' and um.status in ('Obowiązująca')
					and n.id_abon=a.id_abon and n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]')
					union
					(select distinct a.id_abon, n.nazwa,  a.saldo, a.platnosc,  a.fv_comiesiac
					from abonenci a, umowy_abonenckie um, sim s, nazwy n, belong b
					where um.id_abon=a.id_abon and b.id_urz=s.id_sim and b.id_abon=a.id_abon and s.active='T' and um.status in ('Obowiązująca')
					and n.id_abon=a.id_abon and n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]'
					and b.nalezy_od <= '$conf[data]' and b.nalezy_do >='$conf[data]' )
					union 
					(select distinct a.id_abon, n.nazwa,  a.saldo, a.platnosc,  a.fv_comiesiac
					from abonenci a, umowy_serwisowe um, serwisy s, nazwy n, belong b
					where um.id_abon=a.id_abon and s.id_abon=a.id_abon and um.status in ('Obowiązująca')
					and n.id_abon=a.id_abon and n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]') 
					union
					(select distinct a.id_abon, n.nazwa,  a.saldo, a.platnosc,  a.fv_comiesiac
					from abonenci a, zobowiazania z, nazwy n
					where z.id_abon=a.id_abon and n.id_abon=a.id_abon 
					and n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]'
					and z.aktywne_od <= '$conf[data]' and z.aktywne_do >= '$conf[data]')
					
					order by 5 desc, 2, 1";
				
					WyswietlSql($q);
					$sth=Query($dbh,$q);
					while ($row =$sth->fetchRow())
						{
							$fv[id_odb]=$fv1[id_odb]=$row[0];
							//echo "$row[0] $row[1]<br>";
								
							$saldo=$row[2];
																	
							$fv[term_plat]= CountDate( $fv[data_wyst], $row[3] );
							Insert($dbh, "DOKUMENTY_SPRZEDAZ", $fv);
							$q3="";
							
							$q1=" ( select p.id_usl, t.cena, k.id_komp from komputery k, towary_sprzedaz t, pakiety p  where p.id_usl=t.id_tows 
										and p.id_urz=k.id_komp and k.fv='T' and	k.podlaczony='T' 
										and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]' and k.id_abon='$row[0]')
										union all 
										( select p.id_usl, t.cena, v.id_tlv from telefony_voip v, towary_sprzedaz t, pakiety p where p.id_usl=t.id_tows 
										and p.id_urz=v.id_tlv and v.fv='T' and v.aktywny='T' 
										and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]' and v.id_abon='$row[0]')
										union all 
										( select p.id_usl, t.cena, s.id_stb from settopboxy s, towary_sprzedaz t, pakiety p, belong b 
										where p.id_usl=t.id_tows and p.id_urz=s.id_stb and b.id_urz=s.id_stb and s.fv='T' and s.aktywny='T' 
										and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]' 
										and b.nalezy_od <= '$conf[data]' and b.nalezy_do >='$conf[data]' 
										and b.id_abon='$row[0]')
										union all 
										( select p.id_usl, t.cena, r.id_rtr from router r, towary_sprzedaz t, pakiety p, belong b
										where p.id_usl=t.id_tows and p.id_urz=r.id_rtr  and b.id_urz=r.id_rtr and r.aktywny='T' 
										and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]' 
										and b.nalezy_od  <= '$conf[data]' and b.nalezy_do  >='$conf[data]' 
										and b.id_abon='$row[0]')
										union all
										( select p.id_usl, t.cena, id_srv from serwisy s, towary_sprzedaz t, pakiety p where p.id_usl=t.id_tows 
										and p.id_urz=s.id_srv and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]' and s.id_abon='$row[0]')
										union all 
										( select p.id_usl, t.cena, s.id_sim from sim s, towary_sprzedaz t, pakiety p, belong b 
										where p.id_usl=t.id_tows and p.id_urz=s.id_sim and b.id_urz=s.id_sim and s.active='T' 
										and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]' 
										and b.nalezy_od <= '$conf[data]' and b.nalezy_do >='$conf[data]' 
										and b.id_abon='$row[0]')
										union all
										( select id_uvp, cena, id_abon from uslugi_voip where id_abon='$row[0]' and fv='N')
										"; 
												
							WyswietlSql($q1);
							$sth1=Query($dbh,$q1);
							while ($row1=$sth1->fetchRow())
								{
									$id_usl=$row1[0];
									$q3.="insert into POZYCJE_SPRZEDAZ values ('$row1[0]', 1,'$fv[nr_ds]');";
									$saldo-=$row1[1];			
										
									$q4="select ud.id_usl, ud.fv, ts.cena from uslugi_dodatkowe ud, towary_sprzedaz ts 
												where ts.id_tows=ud.id_usl  and ud.aktywna_od <= '$conf[data]' and ud.aktywna_do >='$conf[data]' and ud.id_urz='$row1[2]' "; 
									WyswietlSql($q4);
								
									$sth4=Query($dbh,$q4);
									while ($row4=$sth4->fetchRow())
									{
										if ( $row4[1] == 'T' )
										{
											$q3.="insert into POZYCJE_SPRZEDAZ values ('$row4[0]', 1,'$fv[nr_ds]');";
											$saldo-=$row4[2];
										}
									}
										
										if ( $id_usl[1]=="V" )
											$q3.="update uslugi_voip set fv='T' where id_uvp='$row1[0]';";
								}

							$q11=" select z.id_usl, t.cena, z.ilosc from zobowiazania z, towary_sprzedaz t where z.id_usl=t.id_tows 
										and z.aktywne_od <= '$conf[data]' and z.aktywne_do >='$conf[data]' and z.id_abon='$row[0]'"; 
												
							WyswietlSql($q11);
							$sth11=Query($dbh,$q11);
							while ($row11=$sth11->fetchRow())
								{
									$q3.="insert into POZYCJE_SPRZEDAZ values ('$row11[0]', $row11[2], '$fv[nr_ds]');";
									$saldo-=$row11[1]*$row11[2];			
								}
								
								
							$saldo=round($saldo, 2);
							$q3.="update abonenci set saldo=$saldo where id_abon='$row[0]'";	
							WyswietlSql($q3);
							Query($dbh, $q3);
							$fv[nr_ds]=$this->IncNrFV($fv[nr_ds]);
						}
			}
		else 				
				echo "W tym miesiacu wystawiono już jakies Faktury VAT";
}




function InvoiceList($dbh, $p, $www)
{
  include "func/config.php";

	$_SESSION[$session[invoices][pagination]]=$_POST;

	$results=$p[liczba];
	
	$idk=explode(" ", $p[abon]);
	$ida=array_pop($idk);
	
	if (empty($p[stan]))
		{
			$p[stan]="'uregulowana','nieuregulowana'";
		}
	else if ($p[stan] == "Wszystkie")
			$p[stan]="'uregulowana','nieuregulowana'";
	else if ($p[stan] == "Uregulowane")
		$p[stan]="'uregulowana'";
	else if ($p[stan] == "Nieuregulowane")
		$p[stan]="'nieuregulowana'";

	if (empty($p[order]) || $p[order] == "Data wystawienia")
		{
			$p[order]="d.data_wyst, d.nr_ds";
		}
	else if ($p[order] == "Nazwa odbiorcy")
			$p[order]="n.nazwa, d.data_wyst";

	
	$q3="	select  count (*)	from dokumenty_sprzedaz d, nazwy n
					where d.id_odb=n.id_abon and d.data_wyst >= '$p[data_od]' and d.data_wyst <= '$p[data_do]' 
					and n.wazne_od <= '$p[data_do]' and n.wazne_do >= '$p[data_do]'";
	if (!empty($p[abon]) && $p[abon] !=$conf[select])   
				$q3.=" and n.id_abon='$ida'";
					
	WyswietlSql($q3);
	
	$countData=Query2($q3, $dbh);

	$pages=ceil($countData[0]/$results);
	$page = isset($_GET['page']) ? $_GET['page'] : 1; 
	$next = $page + 1;
	$back = $page - 1; 
	$start = $page * $results - $results; 

	if ( $pages >1 )
		{
			$url='panel=fin&menu=invoices&typ=sprzedaz&page=';
			$www->PaginationPrint($page, $pages, $next, $back, $url);
		}
 
	if ($p[typ]=="sprzedaz")
		{
			$q1="	select  d.nr_ds, n.nazwa, d.data_wyst, d.data_sprzed, d.term_plat, n.id_abon
					from dokumenty_sprzedaz d, nazwy n 
					where d.id_odb=n.id_abon and d.data_wyst >= '$p[data_od]' and d.data_wyst <= '$p[data_do]' 
					and n.wazne_od <= '$p[data_do]' and n.wazne_do >= '$p[data_do]'";
					if (!empty($p[abon]) && $p[abon] !=$conf[select])   
						$q1.=" and n.id_abon='$ida' 	order by $p[order]";
					else 
					$q1.=" 	order by $p[order] limit $results offset $start";
		}
	else 
			$q1="	select  d.nr_dz, k.nazwa, d.data_wyst, d.data_sprzed, d.term_plat, n.id_abon 
					from dokumenty_zakup d, dostawcy k 
					where d.id_dost=k.id_dost and d.data_wyst >= '$p[data_od]' and d.data_wyst <= '$p[data_do]' 
					order by d.data_wyst,d.nr_dz";

	WyswietlSql($q1);
	


	$sth1=Query($dbh,$q1);
	$lp=1;
	$suma=0;
  while ($row1 =$sth1->fetchRow())
		{
			if ($p[typ]=="sprzedaz")
				$q2="(select t.nazwa, p.ilosc, t.cena from pozycje_sprzedaz p, towary_sprzedaz t where p.id_tows=t.id_tows and p.nr_ds='$row1[0]' order by 	t.nazwa)
							union all
						 (select t.nazwa, p.ilosc, t.cena from pozycje_sprzedaz p, uslugi_voip t where p.id_tows=t.id_uvp and p.nr_ds='$row1[0]' order by t.nazwa)";
		
			else 
				$q2="select t.nazwa, p.ilosc, t.cena from pozycje_zakup p, towary_zakup t where p.id_towz=t.id_towz  and p.nr_dz='$row1[0]' order by t.nazwa";

			DrawTable($lp++,$conf[table_color]);				
  		echo "<td class=\"klasa4\"> <a href=\"index.php?panel=fin&menu=invoiceupd1&typ=$p[typ]&nr=$row1[0]\"> $row1[0] </a> </td>";
	 		echo "<td class=\"klasa4b\"> $row1[1] <br> <a href=\"index.php?panel=inst&menu=updateabon&abon=$row1[5]\"> $row1[5] </a> </td>";
  		echo "<td class=\"klasa4\"> $row1[2]</td>";
  		echo "<td class=\"klasa4\">";
			$sth2=Query($dbh,$q2);
			while ($row2 =$sth2->fetchRow())
				{
					echo "$row2[0]  -- szt. $row2[1] <br>";
					$suma+=$row2[2]*$row2[1];
				}
			echo "</td>";
			if ($p[typ]=="sprzedaz")
			{
  				echo "<td class=\"klasa4\"> <a href=\"javascript&#058;displayWindow('pdf/mkpdf.php?dok=fv&typ=ORYGINAŁ&nr=$row1[0]',800,800, '38')\"> 
				<img src=\"../graphics/pdf.gif\" width=\"32\" height=\"32\" border=\"0\"/> </a> </td>";
  				
				echo "<td class=\"klasa4\"> <a href=\"javascript&#058;displayWindow('pdf/mkpdf.php?dok=fv&typ=KOPIA&nr=$row1[0]',800,800, '38')\"> 
				<img src=\"../graphics/pdf.gif\" width=\"32\" height=\"32\" border=\"0\"/> </a> </td>";
				
				echo "<td class=\"klasa4\"> <a href=\"javascript&#058;displayWindow('pdf/mkpdf.php?dok=fv&typ=DUPLIKAT&nr=$row1[0]',800,800, '38')\"> 
				<img src=\"../graphics/pdf.gif\" width=\"32\" height=\"32\" border=\"0\"/> </a> </td>";
				
				echo "<td class=\"klasa4\"> <a href=\"index.php?panel=fin&menu=sendFV&nr=$row1[0]\"> Wyślij >>> </a> </td>";				
			}
			echo "<td class=\"klasa4\"><input type=\"checkbox\" name=\"$row1[0]\"/></td>";
     echo "</tr>";
       }
			 DrawTable($lp++,$conf[table_color]);
			echo "<td> </td>";
			echo "<td> <b> SUMA: </b></td>";
			echo "<td> <b>$suma </b></td>";
			echo "<td> </td>"; 				
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "</tr>";

}

function InvoiceArticleList($dbh, $typ, $nr)
{
	if ($typ=="sprzedaz")
		{
			$q="(select t.nazwa, t.pkwiu, p.ilosc, t.jm, t.cena, t.vat, t.id_tows from pozycje_sprzedaz p, 
					towary_sprzedaz t where p.id_tows=t.id_tows and p.nr_ds='$nr' order by t.nazwa, t.cena)
					union all
					(select t.nazwa, t.pkwiu, p.ilosc, t.jm, t.cena, t.vat, t.id_uvp   from pozycje_sprzedaz p, 
					uslugi_voip t     where p.id_tows=t.id_uvp and p.nr_ds='$nr' order by t.nazwa, t.cena)";
		}
	else 
		{
			$q=" select t.nazwa, t.pkwiu, p.ilosc, t.jm, t.cena, t.vat, t.id_towz
					from pozycje_zakup p, towary_zakup t 
					where p.id_towz=t.id_towz  and p.nr_dz='$nr' order by t.nazwa, t.cena";
		}
	$netto=0;
	$Lp=0;
	WyswietlSql($q);
	$sth1=Query($dbh,$q);
	while ( $row1=$sth1->fetchRow() )
		{
			$netto+=$row1[2]*$row1[3];
			++$Lp;
			echo "<tr>";
			echo " <td> $Lp. </td> ";
			echo " <td> $row1[0] </td> ";
			echo " <td> $row1[1] </td> ";
			echo " <td> $row1[2] </td> ";
			echo " <td> $row1[3] </td> ";
			$cjn=round ($row1[4]/(1+$row1[5]/100), 2);
			echo " <td> $cjn </td> ";
			$brutto=$row1[2]*$row1[4];
			$netto=round ($brutto/(1+$row1[5]/100), 2);
			echo " <td> $netto </td> ";
			echo " <td> $row1[5] </td> ";
			$kwota_vat=round($netto * $row1[5]/100, 2);
			echo " <td> $kwota_vat </td> ";

			echo " <td> $brutto </td> ";
			echo "<td class=\"klasa4\"><input type=\"checkbox\" name=\"$row1[6]-$row1[2]-$nr\"/></td>";		
			echo "</tr>";
			$razem_netto+=$netto;
			$razem_vat+=$kwota_vat;
			$razem_brutto+=$brutto;
		}

	echo "<tr>";
	echo "</tr>";
	echo "<tr>";
	echo " <td colspan=\"6\">  </td>";
	echo " <td> <strong> $razem_netto </strong> </td>";
	echo " <td>  </td>";
	echo " <td> <strong> $razem_vat </strong> </td>";
	echo " <td> <strong> $razem_brutto </strong> </td>";
//	echo " <td>  </td>";
	echo "</tr>";
		
include_once "slownie/slownie.php";
$x=new slownie;
$slownie=$x->zwroc($razem_brutto);
	echo "<tr>";
	echo " <td colspan=\"3\"> Słownie: </td>";
	echo " <td colspan=\"7\"> <strong> $slownie </strong> </td>";
	echo "</tr>";


}

function AInvoiceList($dbh, $www)
{
	include "func/config.php";
	
	$array=array("1","2","3","4","5");

	$query="select distinct a.id_abon, n.symbol, n.nazwa, u.kod, u.miasto, u.nazwa, b.numer, s.nr_lok
				from abonenci a,ulice u, budynki b, umowy_abonenckie um, komputery k, nazwy n, adresy_siedzib s
				where u.id_ul=b.id_ul and s.id_bud=b.id_bud and um.id_abon=a.id_abon and k.id_abon=a.id_abon and a.id_abon=n.id_abon and a.id_abon=s.id_abon 
				and n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]' and s.wazne_od <= '$conf[data]' and s.wazne_do >= '$conf[data]'
			
				and um.status='Obowiązująca' 
				order by u.nazwa, b.numer, s.nr_lok";
	WyswietlSql($query);
	$sth=Query($dbh,$query);
	$lp=1;
   while ($row =$sth->fetchRow())
		{
  		$q1="select count(id_komp) from komputery k, abonenci a where k.id_abon=a.id_abon and a.id_abon='$row[0]'"; 
   					
				 
			$sth1=Query($dbh,$q1);
   		$row1=$sth1->fetchRow();

			DrawTable($lp++,$conf[table_color]);  	
 			echo "<td> <a href=\"index.php?panel=fin&menu=updateabon&abon=$row[0]\"> $row[0] </a> </td>";
			$s=Choose($row[1], $row[2]);
	  		echo "<td> $s </td>";
  			echo "<td> $row[3] $row[4], ul. $row[5] $row[6]/$row[7] </td>";
			echo "<td>";
			$www->SelectFromArray($array, "$row[0]", $row1[0]);
			echo "</td>";
//			echo "<td><input type=\"checkbox\" name=\"$row[0]\" checked=\"true\"/></td>";
         echo "</tr>";
       }
}

function InvoiceAdd($dbh, $typ)
{

	if ($typ =="sprzedaz")
		{
			$TABLE1="dokumenty_sprzedaz";
			$TABLE2="pozycje_sprzedaz";
			$ID="nr_ds";
			$NK="id_odb";
		}
	else
		{
			$TABLE1="dokumenty_zakup";
			$TABLE2="pozycje_zakup";
			$ID="nr_dz";
			$NK="id_dost";
		}
	$dokks=$_SESSION[dokks];
	$flag=0;
	foreach ($_POST as $k => $v)
		{
			if ( $v!=0 && $k!="przycisk" && $flag==0)
			{
				Insert($dbh, $TABLE1, $dokks);
				$flag=1;
			}
			if ( $v!=0 && $k!="przycisk")
			{
				$q3="insert into $TABLE2 values ('$k','$v','$dokks[$ID]')";
				WyswietlSql($q3);
				Query($dbh, $q3);
			if ($typ=="sprzedaz")
				{
					$q4="select vat, cena from towary_sprzedaz where id_tows='$k'";
					$row4=Query2($q4, $dbh);
					$kwota = $v * round($row4[1], 2 );
					$q5="update abonenci set saldo=saldo-$kwota where id_abon='$dokks[id_odb]'";
					WyswietlSql($q5);
					Query($dbh, $q5);
				}			
			}
		}
}


function InvoiceUpd2($dbh, $typ)
{

	if ($typ =="sprzedaz")
		{
			$TABLE1="dokumenty_sprzedaz";
			$TABLE2="pozycje_sprzedaz";
			$ID="nr_ds";
			$NK="id_odb";
		}
	else
		{
			$TABLE1="dokumenty_zakup";
			$TABLE2="pozycje_zakup";
			$ID="nr_dz";
			$NK="id_dost";
		}
	$dokks=$_SESSION[dokks];
	$flag=0;
	foreach ($_POST as $k => $v)
		{
			if ( $v!=0 && $k!="przycisk")
			{
				$q3="insert into $TABLE2 values ('$k','$v','$dokks[$ID]')";
				WyswietlSql($q3);
				Query($dbh, $q3);
			if ($typ=="sprzedaz")
				{
					$q4="select vat, cena from towary_sprzedaz where id_tows='$k'";
					$row4=Query2($q4, $dbh);
					$kwota = $v * round($row4[1], 2 );
					$q5="update abonenci set saldo=saldo-$kwota where id_abon='$dokks[$NK]'";
				WyswietlSql($q5);
				Query($dbh, $q5);
				}			
			}
		}
}

function InvoiceUpd3($dbh)
{

	$TABLE1="dokumenty_sprzedaz";
	$TABLE2="pozycje_sprzedaz";
	$ID="nr_ds";
	$NK="id_odb";

	$dokks=$_SESSION[dokks];
	$flag=0;
						
	foreach ($_POST as $k => $v)
		{
			if ($k!="przycisk")
			{
				$t=explode("-", $k);
				//echo ">> $t[1] <<<";
				$cena = str_replace(",", ".", $t[1]);
				$q3="insert into $TABLE2 values ('$t[0]','1','$dokks[$ID]');";
				$q3.="update uslugi_voip set fv='T' where id_uvp='$t[0]';";
				$q3.="update abonenci set saldo=saldo-$cena where id_abon='$dokks[$NK]'";
				WyswietlSql($q3);
				Query($dbh, $q3);
					
			}
		}
}

function InvoiceUpd($dbh, $typ, $nr)
{
	
	if ($typ =="sprzedaz")
		{
			$TABLE1="dokumenty_sprzedaz";
			$TABLE2="pozycje_sprzedaz";
			$NR="nr_ds";
			$IDK='id_odb';
			$nazwak="odbiorca";
		}
	else
		{
			$TABLE1="dokumenty_zakup";
			$TABLE2="pozycje_zakup";
			$NR="nr_dz";
			$IDK="id_dost";
			$nazwak="dostawca";
		}

	$dokks=array
	(
		$NR			=> $_POST[nr_d], 						$IDK			=>FindId2($_POST[$nazwak]), 	'data_wyst'	=>$_POST[data_wyst], 	
		'data_sprzed'		=>$_POST[data_sprzed],		'term_plat'	=>	$_POST[term_plat],	'forma_plat'=>$_POST[forma_plat],		'stan'		=>$_POST[stan],		'miejsce_wyst'		=>$_POST[miejsce_wyst]
	);
	$dokks2=array
	($NR	=>$nr);

	$poz1=array($NR=>$_POST[nr_d]);
	$poz2=array($NR=>$nr);
									
	Update($dbh, $TABLE2, $poz1, $poz2);
	Update($dbh, $TABLE1, $dokks, $dokks2);

	
	$id_abon=$_SESSION[dokks][$IDK];
		
	if ( $_SESSION[dokks][$IDK] != $dokks[$IDK] )
	{
	
		if ($typ=="sprzedaz")
			{
				$q=" select t.nazwa, t.pkwiu, p.ilosc, t.jm, t.cena, t.vat, t.id_tows
						from pozycje_sprzedaz p, towary_sprzedaz t 
						where p.id_tows=t.id_tows and p.nr_ds='$nr' order by t.nazwa, t.cena";
			}
		else 
			{
				$q=" select t.nazwa, t.pkwiu, p.ilosc, t.jm, t.cena, t.vat, t.id_towz
						from pozycje_zakup p, towary_zakup t 
						where p.id_towz=t.id_towz  and p.nr_dz='$nr' order by t.nazwa, t.cena";
			}
		$netto=0;
		$sth1=Query($dbh,$q);
		while ( $row1=$sth1->fetchRow() )
			{
				$brutto=$row1[2]*$row1[4];
				$razem_brutto+=$brutto;
			}

		$q1="update abonenci set saldo=saldo+$razem_brutto where id_abon='$id_abon'; 
		update abonenci set saldo=saldo-$razem_brutto where id_abon='$dokks[$IDK]'";
	//	echo "$q1";
		
		Query($dbh, $q1);
	}
	
	$kwota=0;
	
	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" )
			{
				$e=explode("-", $k);
				$f=explode("/", $e[2]);
				if ( $f[0]=="FV" )
				{
					$q5="select count(*) from pozycje_sprzedaz where nr_ds='$e[2]'";	
					WyswietlSql($q5);	
					$sth=Query($dbh, $q5);
					$row=$sth->fetchRow();

					if ( $row[0] > 1 )
					{
							$q2="(select cena from towary_sprzedaz where id_tows='$e[0]')
										union
									 (select cena from uslugi_voip     where  id_uvp='$e[0]')";
									
							$sth=Query($dbh, $q2);
							WyswietlSql($q2);	
							$row =$sth->fetchRow();
							$ilosc=$e[1];
							$kwota+=$ilosc*$row[0];
							$q3="delete from pozycje_sprzedaz where ctid in ( select ctid from pozycje_sprzedaz where nr_ds='$e[2]' and id_tows='$e[0]' and ilosc='$e[1]' limit 1 offset 0)";
							WyswietlSql($q3);	
							Query($dbh, $q3);
					}
					else 
						echo "Nie można usunąć pozycji, ponieważ faktura ma tylko jedna pozycję.";
				}
			}
		}

	$q4="update abonenci set saldo=saldo+$kwota where id_abon='$dokks[$IDK]'";
	WyswietlSql($q4);	
	Query($dbh, $q4);
}

function InvoiceValidate1()
{
	$flag=1;

	if ( !ValidateDate($_POST[data_wyst]) )
		{ 
			echo "Błąd pola 'Data wystawienia' <br>";
			$flag=0;
		}

	if ( !ValidateDate($_POST[data_sprzed]) )
		{ 
			echo "Błąd pola 'Data sprzedaży'  <br>";
			$flag=0;
		}

	return ($flag);
}

function InvoiceValidate2()
{
	$flag=0;
	foreach($_POST as $k => $v)
		if ( !empty ($v))
			{ 
				$flag=1;
			}	
	if ($flag==0)
			echo "Nie wybrano ani jednego towaru / usługi <br>";
	return ($flag);
}

	

function ArticleList($dbh, $typ)
{
   include "func/config.php";

	if ($typ=="sprzedaz")
		$query="	select id_tows, nazwa, okres_gwar, cena, symbol from towary_sprzedaz where aktywny='T' order by nazwa, cena, id_tows";
	else 
		$query="	select id_towz, nazwa, okres_gwar, cena, symbol from towary_zakup order by nazwa, cena, id_towz";
	WyswietlSql($query);

	$sth=Query($dbh,$query);
	$lp=1;
   while ($row =$sth->fetchRow())
		{
			 
			$tow[$row[0]]=$row[1];
			DrawTable($lp++,$conf[table_color]);  	
  			echo "<td> <a href=\"index.php?panel=fin&menu=updatetow&typ=$typ&id=$row[0]\"> $row[0] </a> </td>";
	  		echo "<td> $row[1]</td>";
  			echo "<td> $row[2]</td>";
  			echo "<td> <b> $row[3] </b> </td>";
  			echo "<td>";
  			echo "<select name=\"$row[0]\" >";
			for ($i=0; $i<101; ++$i)
				echo "<option> $i </option>";
			echo "</select>";
  			echo "</td>";
			echo "<td> $row[4]</td>";	
			echo "</tr>";
       }
	$_SESSION[tow]=$tow;
}
	
function VoipArticleList($dbh)
{
   include "func/config.php";
	 $query="	select id_uvp, nazwa,  cena from uslugi_voip where fv='N' order by nazwa, cena, id_uvp";
	WyswietlSql($query);

	$sth=Query($dbh,$query);
	$lp=1;
   while ($row =$sth->fetchRow())
		{
			$cena = str_replace(".", ",", $row[2]);
			$tow[$row[0]]=$row[1];
			DrawTable($lp++,$conf[table_color]);  	
  			echo "<td> <a href=\"index.php?panel=fin&menu=updatetow&id=$row[0]\"> $row[0] </a> </td>";
	  		echo "<td> $row[1]</td>";
  			echo "<td> $cena</td>";
					echo "<td class=\"klasa4\"><input type=\"checkbox\" name='$row[0]-$cena'/></td>";
			echo "</tr>";
       }
	$_SESSION[tow]=$tow;
}

}

?>
