<?php

class CSV
{


function CreateInwent($dbh)
{

	include "../func/config.php";

		function TN($tn)
		{
		 $tn=($tn=='T'?"Tak":"Nie");
		 return($tn);
		}
		
		function ZakonczeniaSieci2014($dbh)
		{
			$zs="";
			
			$q="
			select distinct b.id_bud, u.wojewodztwo, u.powiat, u.gmina, u.terc, u.miasto, u.simc, u.nazwa, u.ulic, b.numer, u.kod, u.cecha , u.nazwa2
			from budynki b, ulice u, miejsca_instalacji m, komputery k, umowy_abonenckie um  where 
			u.id_ul=b.id_ul and b.id_bud=m.id_bud and k.id_msi=m.id_msi and k.id_abon=um.id_abon and um.status='Obowiązująca'
			and u.miasto in ('Mysłowice', 'Oświęcim', 'Rajsko', 'Dwory Drugie', 'Zaborze', 'Babice') 
			order by u.wojewodztwo, u.powiat, u.gmina, u.miasto, b.id_bud";
			$sth=Query($dbh,$q);
			while ($r=$sth->fetchRow())
			{
				if ( $r[2]=="Mysłowice" || $r[2]=="Katowice" )
				{
					$olt="OLT0001";
				}
				else 
				{
					$olt="OLT0002";
				}
				$zs.="ZS,\"$r[0]\",\"Własna\", , , \"$olt\", \"$r[1]\",\"$r[2]\",\"$r[3]\",\"$r[4]\",\"$r[5]\",\"$r[6]\",\"$r[11] $r[12] $r[7]\",\"$r[8]\", $r[9],\"$r[10]\", , , \"światłowodowe\", \"EPON\", \"Nie\" , \"Tak\" , \"Nie\", \"Tak\" , \"Nie\" , \"Tak\",\"Nie\" ,\"250\",\"0\"  \r\n";

			}
		return($zs);
		}

		function ZakonczeniaSieci2015($dbh)
		{
			$zs="";
			
			$q="
			select distinct b.id_bud, u.wojewodztwo, u.powiat, u.gmina, u.terc, u.miasto, u.simc, u.nazwa, u.ulic, b.numer, u.kod, u.cecha , u.nazwa2
			from budynki b, ulice u, miejsca_instalacji m, komputery k, umowy_abonenckie um  where 
			u.id_ul=b.id_ul and b.id_bud=m.id_bud and k.id_msi=m.id_msi and k.id_abon=um.id_abon and um.status='Obowiązująca'
			and u.miasto in ('Mysłowice', 'Oświęcim', 'Rajsko', 'Dwory Drugie', 'Zaborze', 'Babice') 
			order by u.wojewodztwo, u.powiat, u.gmina, u.miasto, b.id_bud";
			$sth=Query($dbh,$q);
			while ($r=$sth->fetchRow())
			{
				if ( $r[5]=="Mysłowice" || $r[2]=="Katowice" )
				{
					$olt="BCN10";
				}
				else if ( $r[5]=="Rajsko")
				{
					$olt="KOR34";
				}
				else 
				{
					$olt="DWR5";
				}
				if ( !empty($r[12]) )
						$zs.="ZS,\"$r[0]\",\"Własna\", , , \"$olt\", \"$r[1]\",\"$r[2]\",\"$r[3]\",\"$r[4]\",\"$r[5]\",\"$r[6]\",\"$r[11] $r[12] $r[7]\",\"$r[8]\", $r[9],\"$r[10]\", , , \"światłowodowe\", \"EPON\", \"Nie\" , \"Tak\" , \"Nie\", \"Tak\" , \"Nie\" , \"Tak\", ,\"1000\",\"0\"  \r\n";
				else
						$zs.="ZS,\"$r[0]\",\"Własna\", , , \"$olt\", \"$r[1]\",\"$r[2]\",\"$r[3]\",\"$r[4]\",\"$r[5]\",\"$r[6]\",\"$r[11] $r[7]\",\"$r[8]\", $r[9],\"$r[10]\", , , \"światłowodowe\", \"EPON\", \"Nie\" , \"Tak\" , \"Nie\", \"Tak\" , \"Nie\" , \"Tak\", ,\"1000\",\"0\"  \r\n";

			}
		return($zs);
		}

		// Węzeł własny
		function WezlyWlasne($dbh)
		{
		$ww="";
		$q="select o.id_olt, u.wojewodztwo, u.powiat, u.gmina, u.terc, u.miasto, u.simc, u.nazwa, u.ulic, b.numer, u.kod, u.cecha, u.nazwa2  from olt o, budynki b, ulice u where o.id_bud=b.id_bud and u.id_ul=b.id_ul order by o.id_olt";
			$sth=Query($dbh,$q);
			while ($r=$sth->fetchRow())
			{
				$ww.="WW,\"$r[0]\",\"Węzeł własny\",\"\", \"\", \"$r[1]\",\"$r[2]\",\"$r[3]\",\"$r[4]\",\"$r[5]\",\"$r[6]\",\"$r[11] $r[12] $r[7]\",$r[8], \"$r[9]\",\"$r[10]\",  \"\", \"\", \"budynek mieszkalny\", \"Nie\" , \"Nie\" , \"Nie\"  \r\n";

			}
		return($ww);
		}

		
		// Interfejsy
		function Interfejsy($dbh)
		{
		$int="";
		$q="select id_ifc, id_wzl, rdzen, dystrybucja, dostep, medium, pasmo, technologia, przepustowosc from interfejsy_wezla where id_wzl like 'OLT%' order by id_wzl, id_ifc";
			$sth=Query($dbh,$q);
			while ($r=$sth->fetchRow())
			{
				$tn2=TN($r[2]);
				$tn3=TN($r[3]);
				$tn4=TN($r[4]);
				
				$int.="I,\"$r[0]\",\"$r[1]\",\"$tn2\",\"$tn3\",\"$tn4\",\"$r[5]\",\"$r[6]\",\"$r[7]\",\"$r[8]\", \"$r[8]\", 1, 1, 0 \r\n";

			}
		return($int);
		}
		
		// Usługi
		function Uslugi($dbh)
		{
		$us="";
		$q="select b.id_bud from budynki b, ulice u where u.id_ul=b.id_ul and u.miasto in ('Mysłowice', 'Oświęcim', 'Rajsko', 'Zaborze', 'Brzezinka', 'Dwory Drugie') order by b.id_bud";
		$s=Query($dbh,$q);
		$lp=1;
		 while ($r=$s->fetchRow())
			{
				$q1="select count(k.id_abon) from miejsca_instalacji m, komputery k, abonenci a, umowy_abonenckie um where 
				a.id_abon=k.id_abon and a.id_abon=um.id_abon and um.status='Obowiązująca' and
				(a.pesel_nip not like ('%-%-%-%') or a.pesel_nip not like ('[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]') )
				and k.id_msi=m.id_msi 
				and m.id_bud='$r[0]'"; 
				
				$q2="select count(k.id_abon) from miejsca_instalacji m, komputery k, abonenci a, umowy_abonenckie um where 
				a.id_abon=k.id_abon and a.id_abon=um.id_abon and um.status='Obowiązująca' and
				(a.pesel_nip like ('%-%-%-%') or a.pesel_nip like ('[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]') )
				and k.id_msi=m.id_msi 
				and m.id_bud='$r[0]'"; 
				
				$s1=Query($dbh,$q1);
				$r1 =$s1->fetchRow();
				$s2=Query($dbh,$q2);
				$r2 =$s2->fetchRow();
				
				if ( $r1[0] > 0 )
				$us.="U,\"ZAS$r[0]\",\"$r[0]\",\"Nie\",\"Nie\",\"Nie\",\"Tak\",\"Nie\",\"Nie\",\"\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\",\"$r1[0]\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\",\"$r2[0]\",\"0\",\"0\",\"0\",\"0\" \r\n";
			}
		return($us);
		}	

		function PunktyAdresowe2014($dbh)
		{
			$pa="";
			
			$q="
			select distinct b.id_bud, u.wojewodztwo, u.powiat, u.gmina, u.terc, u.miasto, u.simc, u.nazwa, u.ulic, b.numer, u.kod, u.cecha , u.nazwa2
			from budynki b, ulice u where 
			u.id_ul=b.id_ul and u.miasto in ('Mysłowice', 'Oświęcim', 'Rajsko', 'Dwory Drugie', 'Zaborze', 'Babice')
			and b.id_bud not in (select distinct m.id_bud from miejsca_instalacji m, umowy_abonenckie u, komputery k where u.status='Obowiązująca' and k.id_msi=m.id_msi and k.id_abon=u.id_abon)
			order by u.wojewodztwo, u.powiat, u.gmina, u.miasto, u.nazwa, b.numer";
			$sth=Query($dbh,$q);
			while ($r=$sth->fetchRow())
			{
				if ( $r[2]=="Mysłowice" || $r[2]=="Katowice" )
				{
					$inw="INW001";
				}
				else 
				{
					$inw="INW002";
				}
				$cecha=trim($r[11]);
				$ul1=trim($r[12]);
				$ul2=trim($r[7]);
				if (!empty($ul1))
					$pa.="PA,\"$r[0]\", \"$inw\", \"planowane\",\"$r[1]\",\"$r[2]\",\"$r[3]\",\"$r[4]\",\"$r[5]\",\"$r[6]\",\"$cecha $ul1 $ul2\",\"$r[8]\", $r[9],\"$r[10]\", , , \r\n";
				else
					$pa.="PA,\"$r[0]\", \"$inw\", \"planowane\",\"$r[1]\",\"$r[2]\",\"$r[3]\",\"$r[4]\",\"$r[5]\",\"$r[6]\",\"$cecha $ul2\",\"$r[8]\", $r[9],\"$r[10]\", , , \r\n";

			}
		return($pa);
		}	
		
		
		function PunktyAdresowe2015($dbh)
		{
			$pa="";
			
			$q="
			select distinct b.id_bud, u.wojewodztwo, u.powiat, u.gmina, u.terc, u.miasto, u.simc, u.nazwa, u.ulic, b.numer, u.kod, u.cecha , u.nazwa2
			from budynki b, ulice u where 
			u.id_ul=b.id_ul and u.miasto in ('Mysłowice', 'Oświęcim', 'Rajsko', 'Dwory Drugie', 'Zaborze', 'Babice')
			and b.id_bud not in (select distinct m.id_bud from miejsca_instalacji m, umowy_abonenckie u, komputery k where u.status='Obowiązująca' and k.id_msi=m.id_msi and k.id_abon=u.id_abon)
			order by u.wojewodztwo, u.powiat, u.gmina, u.miasto, u.nazwa, b.numer";
			$sth=Query($dbh,$q);
			while ($r=$sth->fetchRow())
			{
				if ( $r[2]=="Mysłowice" || $r[2]=="Katowice" )
				{
					$inw="INW001";
				}
				else 
				{
					$inw="INW002";
				}
				$cecha=trim($r[11]);
				$ul1=trim($r[12]);
				$ul2=trim($r[7]);
				if (!empty($ul1))
					$pa.="PA,\"$r[0]\", \"$inw\", \"planowane\",\"$r[1]\",\"$r[2]\",\"$r[3]\",\"$r[4]\",\"$r[5]\",\"$r[6]\",\"$cecha $ul1 $ul2\",\"$r[8]\", $r[9],\"$r[10]\", , , \r\n";
				else
					$pa.="PA,\"$r[0]\", \"$inw\", \"planowane\",\"$r[1]\",\"$r[2]\",\"$r[3]\",\"$r[4]\",\"$r[5]\",\"$r[6]\",\"$cecha $ul2\",\"$r[8]\", $r[9],\"$r[10]\", , , \r\n";

			}
		return($pa);
		}	
	
	function UpdateUlic($dbh)
	{
		$q1="select distinct ul.id_ul, ul.nazwa, ul.miasto, t.simc, t.ulic, t.ul2, t.cecha  from ulice ul, teryt2 t where ul.nazwa=t.ul1 and ul.miasto=t.miej 
		and t.miej in ('Mysłowice', 'Oświęcim', 'Rajsko', 'Brzezinka', 'Babice', 'Dwory Drugie', 'Zaborze') order by ul.id_ul";
		WyswietlSql($q1);
		$q='';
		$sth=Query($dbh,$q1);
		$lp=1;
		 while ($row =$sth->fetchRow())
			{
				$q.="	update ulice set simc='$row[3]', ulic='$row[4]' where id_ul='$row[0]';"; 
			}
		return($q);
	}
	
	/*$interfejsy=Interfejsy($dbh);	
	$wezlywlasne=WezlyWlasne($dbh);*/
	$zs=ZakonczeniaSieci2015($dbh);
	$uslugi=Uslugi($dbh);
//	$pa=PunktyAdresowe($dbh);

	//$q=UpdateUlic($dbh);
	
/*	echo <<<CSV
DP,"NETICO  s.c. Michał Pielorz, Krzysztof Rogacki, Jerzy Borodziuk","2220839510","240792386","5621","","","śląskie","Mysłowice","Mysłowice","2470011","Mysłowice","0941487","ul. Fryderyka Szopena","22023","26","41-400","www.netico.pl","biuro@netico.pl","Nie","Nie","Nie","Nie","Nie","Nie","Mirosław","Borodziuk","327453333","","mborodziuk@netico.pl"
PO,"D1","E-Poludnie","6262925765","240927030","","śląskie","Bytom","Bytom","2462011","Bytom","0938670","ul. Zielna","26077","25","41-907"
PO,"D2","e-Fuzja Sp. Z o.o.","7010014510","140466394","","mazowieckie","Warszawa","Warszawa","1465011","Warszawa","0918123","al. Aleje Jerozolimskie","45207","81","02-001"
"PI","INW001","2018","światłowodowa","1320000","9000","oświadczenie właściciela","Tak","Tak","Nie","Nie","Nie","Nie","2015-05","2016-03","2016-04","2018-12","2018-12"
"PI","INW002","2018","światłowodowa","660000","4000","oświadczenie właściciela","Tak","Tak","Nie","Nie","Nie","Nie","2015-05","2016-03","2016-04","2018-12","2018-12"
\r\n
CSV;
*/
	
	echo <<<CSV
DP,"NETICO  s.c. Michał Pielorz, Krzysztof Rogacki, Jerzy Borodziuk","2220839510","240792386","5621","","","śląskie","Mysłowice","Mysłowice","2470011","Mysłowice","0941487","ul. Fryderyka Chopina","02849","26","41-400","www.netico.pl","biuro@netico.pl","Tak","Tak","Tak","Tak","Tak","Tak","Mirosław","Borodziuk","327453333","","mborodziuk@netico.pl"
PO,"PO001","STOWARZYSZENIE NA RZECZ ROZWOJU SPOŁECZEŃSTWA INFORMACYJNEGO E-POŁUDNIE","6262925765","240927030","8720","śląskie","Bytom","Bytom","2462011","Bytom","0938670","ul. Antoniego Józefczaka","07629","29 lok. 40","41-902",
PO,"PO002","Korbank media cyfrowe sp. z o.o.","8971721120","020373926","6729","dolnośląskie","Wrocław","Wrocław","0264011","Wrocław","0986283","ul. Nabycińska","13722","19","53-677",
\r\n
CSV;
	
  //echo $wezlywlasne;
	//echo $interfejsy;
	echo $zs;
	echo $uslugi;
	//echo $pa;
}


}

?>
