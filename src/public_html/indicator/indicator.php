<?php

class INDICATOR
{


function IndicatorList($dbh, $p)
{
		include "func/config.php";
					
		$data_do=explode("-", $p[data_do]);
		$m=$data_do[1];

		$rb=$data_do[0];
		$rp=$rb-1;
		
		
		$q="select distinct i.id_itl, a.id_abon, n.symbol, n.nazwa, a.saldo, u.kod, u.miasto, 
			u.nazwa, b.numer, s.nr_lok, t.telefon, t.tel_kom, i.trudnosc, i.data_zgl, i.data_zak
			from abonenci a, instalacje i, podlaczenia p, nazwy n, ulice u, budynki b, adresy_siedzib s, telefony t
			where i.id_abon=a.id_abon and a.id_abon=n.id_abon and p.id_itl=i.id_itl 
			and u.id_ul=b.id_ul and s.id_bud=b.id_bud and a.id_abon=s.id_abon and t.id_podm=a.id_abon
			
			and n.wazne_od <= '$p[data_do]' and n.wazne_do >= '$p[data_do]'
			and s.wazne_od <= '$p[data_do]' and s.wazne_do >= '$p[data_do]'
			and i.data_zgl between '$p[data_od]' and '$p[data_do]' ";
		
		 $q.=" and i.wykonana='T' and p.data_zak is not null ";

		 					
		$q.=" order by i.data_zak, i.data_zgl, n.nazwa";
		
		WyswietlSql($q);	
		
		$sth=Query($dbh,$q);
		$razem=0;
		$lp=1;
		 while ($row =$sth->fetchRow())
			{
				$il_dni = round((strtotime($row[14]) - strtotime($row[13])) / 86400);
				$razem+=$il_dni;
				$key=array_search($row[6], $conf[etapy]);
				DrawTable($lp++,$conf[table_color], $key, $key);
				$liczbaporzad=$lp-1;
				echo "<td><i>$liczbaporzad.</i></td>";
				echo "<td class=\"klasa4\">
				<a href=\"index.php?panel=inst&menu=itlupd&itl=$row[0]\"> $row[0] </a>  <br> $row[13]
				 </td>";
				echo "<td class=\"klasa4\"> $row[14] </td>";
					
				$s=Choose($row[2], $row[3]);
					echo "<td class=\"klasa4b\"> $s <br> <a href=\"index.php?panel=inst&menu=updateabon&abon=$row[1]\"> $row[1] </a>  </td>";
					echo "<td class=\"klasa4\"> $row[6], ul. $row[7] $row[8]";
					
					echo "<td class=\"klasa4\">";
				if ( !empty($row[10]) )
					echo "$row[10] <br/>";
				if ( !empty($row[11]) )
					echo " $row[11] <br/>";
				echo "</td>";
				echo "<td class=\"klasa4\"> $il_dni </td>";
				echo "</tr>";
			}
			$wsk=round($razem/$lp/2);
			echo "Średni czas oczekiwania na przyłączenie do sieci: $wsk";
}

}

?>
