#!/usr/bin/php -q

<?php


include "../public_html/func/config.php";
include "../public_html/func/szmsk.php";
include "../public_html/www/www.php";
include "../public_html/szmsk/szmsk.php";
include "../public_html/func/config.php";


$dbh=DBConnect($DBNAME1);

$q=" select distinct ul.id_ul, t.ulic, ul.ulic, t.ul2, t.simc from ulice ul, teryt2 t where ul.nazwa=t.ul1 and ul.miasto=t.miej and miej in ('Mysłowice', 'Oświęcim', 'Rajsko', 'Brzezinka', 'Babice', 'Dwory Drugie') order by ul.id_ul;";
WyswietlSql($q);
$sth=Query($dbh,$q);
while ($r =$sth->fetchRow())
		{
			$q2="update ulice set ulic='$r[1]', nazwa2='$r[3]', simc='$r[4]' where id_ul='$r[0]'";
			print "$q2 \n";
			Query($dbh,$q2);
			
			/*$t=explode("l", $r[0]);
			$q2="update budynki set id_ul='ul0$t[1]' where id_ul='$r[0]';update ulice set id_ul='ul0$t[1]' where id_ul='$r[0]'"; 
			echo "$q2 \n";
			$sth2=Query($dbh,$q2);
		#	$r2 =$sth2->fetchRow();*/
		}
?>
