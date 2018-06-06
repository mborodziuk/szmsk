<?php

class TXT
{


function E24Input($dbh)
{
	include "../func/config.php";
		
		$in="";
		$q="select t.numer, o.rpt, o.nr_np from operator o, telefony_voip t where t.numer not like '32 666 3%' and t.numer not like '33 476 0%' order by t.numer";
			$sth=Query($dbh,$q);
			while ($r=$sth->fetchRow())
			{
				// usuwamy spacje z nrow tel
				$nrtel=preg_replace('/\s+/', '', $r[0]);
				$in.="$nrtel;$r[1];$r[1];$r[1];$r[2];0\r\n";
			}
		
		echo $in;
}

function UpdLms($dbh, $dbh2)
{
	include "../func/config.php";
		
		$in="";
		$q="select n.nazwa, a.pesel_nip, a.id_abon from abonenci a, nazwy n where n.id_abon=a.id_abon and n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]' order by a.id_abon";
			$sth=Query($dbh,$q);
			while ($r=$sth->fetchRow())
			{
		
				// usuwamy spacje z nrow tel
				$nrtel=preg_replace('/\s+/', '', $r[0]);
				if ( ValidateNip($r[1]))
				{
					$id=explode("N", $r[2]);
					$in.="update customers set lastname='$r[0]', name='', type=1 where  id=$id[1]; \r\n";
				}
				else
				{
				//	$in.="$r[0] $r[1] os pryw \r\n";
				}
			}
		
		echo $in;
}


function ConvertDate($date1)
{
	$d=explode("-", $date1);
	$RR=substr($d[0], 2,2);
	$RRMMDD="$RR/$d[1]/$d[2]";
	return $RRMMDD;
}

function Optima_Vat_r($dbh, $od, $do)
{

		include "../func/config.php";
		require_once("ConvertCharset/ConvertCharset.class.php");
		$u2m = new ConvertCharset ('utf-8', 'mazovia');
		$vat_r="";
		
		$q="	select  distinct d.nr_ds, d.data_wyst, d.data_sprzed, d.term_plat, d.forma_plat, d.miejsce_wyst, 
			n.nazwa, a.pesel_nip, u.nazwa, b.numer, s.nr_lok, d.wystawil, u.miasto, u.kod, d.id_odb
			from dokumenty_sprzedaz d, abonenci a, budynki b, ulice u, nazwy n, adresy_siedzib s 
			where n.id_abon=a.id_abon and a.id_abon=s.id_abon and d.id_odb=a.id_abon and s.id_bud=b.id_bud and u.id_ul=b.id_ul 
			and n.wazne_od <= '$od' and n.wazne_do >='$od' and s.wazne_od <= '$od' and s.wazne_do >='$od'
			and d.data_wyst >= '$od' and d.data_wyst <= '$do' and d.nr_ds not like '%/Z/%'
			order by d.nr_ds, d.data_wyst ";

//echo $q;
		$date=explode("-", $od);
		$nazwa="RS-$date[0]-$date[1]";
		
		$s=Query($dbh,$q);
		while ($r=$s->fetchRow() )
			{
				
				
				$ulica="$r[8] $r[9]";
				if (!empty($r[10]))
				{
					$ulica.="/$r[10]";
				}
				
				if( ValidateNip($r[7]))
				{
				 $nip=$r[7];
				}
				else
				{
				 $nip="";
				}
				
				//////////
						$q2="(select t.nazwa, t.pkwiu, p.ilosc, t.jm, t.cena, t.vat from pozycje_sprzedaz p, towary_sprzedaz t
						where p.id_tows=t.id_tows and p.nr_ds='$r[0]' order by t.nazwa)
						union all
					 (select t.nazwa, t.pkwiu, p.ilosc, t.jm, t.cena, t.vat from pozycje_sprzedaz p, uslugi_voip t
						where p.id_tows=t.id_uvp  and p.nr_ds='$r[0]' order by t.nazwa)";

			$razem_netto=$razem_vat=$razem_brutto=0;
			$razem_netto8=$razem_vat8=$razem_brutto8=0;
			$razem_brutto_oo=0;

			$oo=0;
			$v8=0;
			$v23=0;
			$sth1=Query($dbh,$q2);
			while ( $row1=$sth1->fetchRow() )
				{	
	/*				$razem_netto+=round($netto, 2);
					$razem_vat+=round ($kwota_vat, 2);
					$razem_brutto+=round($brutto, 2); */

					$jedn_brutto=round($row1[4], 2);
					$cena_jedn_netto = $row1[4] / (1+$row1[5]/100);
					$brutto= $row1[2] * $jedn_brutto;
					// Odwrotne obciążenie
					if ( $row1[5] == "-")
					{
						$rnetto=$netto=$brutto;
					}
					else
					{
						$netto=$brutto / (1 + $row1[5]/100);
						$rnetto=round($netto, 2);
					}
					
					$kwota_vat=$brutto-$netto;
							
					// VAT 23%
					if ( $row1[5] == 23)
					{
						$v23=23;
						$razem_netto+=$rnetto;
						$razem_vat+=round ($kwota_vat, 2);
						$razem_brutto+=round($brutto, 2);
					}
					// VAT 8%
					else if ( $row1[5] == 8)
					{
						$v8=8;
						$razem_netto8+=$rnetto;
						$razem_vat8+=round ($kwota_vat, 2);
						$razem_brutto8+=round($brutto, 2);
					}
					// Odwrotne obciążenie
					else if ( $row1[5] == "-")
					{
						$razem_brutto_oo+=round($brutto, 2);
						$oo=1;
					}
					
					$cjn=number_format($cena_jedn_netto,2,'.','');
					$jb=number_format($jedn_brutto,2,'.','');
					$net=number_format($netto,2,'.','');
					$bru=number_format($brutto,2,'.','');
				}
			
				$razem=$razem_brutto+$razem_brutto8+$razem_brutto_oo;
				$suma+=$razem;
				
				$netto8=number_format($razem_netto8,2,'.','');
					$vat8=number_format($razem_vat8,  2,'.','');
				 $netto=number_format($razem_netto, 2,'.','');
					 $vat=number_format($razem_vat,   2,'.','');
				 $razem=number_format($razem,   		2,'.','');			 
				 
					$v8=number_format($v8, 2,'.','');
				 $v23=number_format($v23,2,'.','');
				
				$pod_należny+=$razem_vat;	
				$pod_należny+=$razem_vat8;	
					
				$v=array(
				'GRUPA' 		=> $nazwa,
				'DATA_TR' 	=> $this->ConvertDate($r[1]),
				'DATA_WYST' => $this->ConvertDate($r[2]),
				'IK'				=> "",
				'DOKUMENT'	=> $r[0],
				'KOREKTA_DO'=> "",
				'TYP'				=> 2,
				'KON'				=> $r[14],
				'K_NAZWA1'	=> $r[6],
				'K_NAZWA2'	=> "",
				'K_ADRES1'	=> "$ulica",
				'K_KODP'		=> "$r[13]",
				'K_MIASTO'	=> "$r[12]",
				'NIP'				=>	$nip,
				'TERMIN'		=>	$this->ConvertDate($r[3])
				);
			
				if ( $oo)
				{
					$vat_r.="$date[1],\"$v[GRUPA]\",\"$v[DATA_TR]\",\"$v[DATA_WYST]\",\"\",\"$v[DOKUMENT]\",\"\",2,0,1,16,0,\"$v[KON]\",\"$v[K_NAZWA1]\",\"$v[K_NAZWA2]\",\"$v[K_ADRES1]\",\"$v[K_KODP]\",\"$v[K_MIASTO]\",\"$v[NIP]\",\"\",64,0,0,\"\",\"\",0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,\"\",0.00,0.00,0,3,\"$v[TERMIN]\",$razem,0.00,0,0,0.000000,0.00,0.00,0.00,\"Borodziuk\",0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,4,0.00,$razem_brutto_oo,0.00\r\n";
				}
				else 
				{
					$vat_r.="$date[1],\"$v[GRUPA]\",\"$v[DATA_TR]\",\"$v[DATA_WYST]\",\"\",\"$v[DOKUMENT]\",\"\",2,0,4,1,0,\"$v[KON]\",\"$v[K_NAZWA1]\",\"$v[K_NAZWA2]\",\"$v[K_ADRES1]\",\"$v[K_KODP]\",\"$v[K_MIASTO]\",\"$v[NIP]\",\"\",64,0,0,\"\",\"\",0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,\"\",0.00,0.00,0,3,\"$v[TERMIN]\",$razem,0.00,0,0,0.000000,0.00,0.00,0.00,\"Borodziuk\",0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,";
					
					if ( $v8=="8.00" && $V23="23.00" )
					{
							$vat_r.="0,$v8,$netto8,$vat8,0,$v23,$netto,$vat\r\n";
					}
					else if ( $v8!=0 && $v23==0 )
					{
							$vat_r.="0,$v8,$netto8,$vat8\r\n";
					}
					else if ( $v8==0 && $v23!=0 )
					{
							$vat_r.="0,$v23,$netto,$vat\r\n";
					}
				}
				
			}

		$vat_r=$u2m->Convert($vat_r);

		echo $vat_r;

}



}

?>
