#!/usr/bin/php -q

<?php


include "../public_html/func/config.php";
include "../public_html/func/szmsk.php";
include "../public_html/www/www.php";
include "../public_html/szmsk/szmsk.php";
include "../public_html/func/config.php";


$dbh=DBConnect($DBNAME1);

$q=" select distinct woj, pow, gmi, miej, ul1, ul2, cecha, simc, ulic from teryt2 where id not in (select distinct t.id from ulice ul, teryt2 t where ul.nazwa=t.ul1 and ul.miasto=t.miej) and miej in ('Mysłowice', 'Oświęcim', 'Rajsko', 'Brzezinka', 'Babice', 'Dwory Drugie') order by woj, pow, gmi, miej,ul2";
WyswietlSql($q);
$sth=Query($dbh,$q);
while ($r =$sth->fetchRow())
		{
			if ( $r[3] == 'Mysłowice')
				$kod='41-400';
			else
				$kod='32-600';
				
			$Q1="select id_ul from ulice order by id_ul desc limit 1";
			$id_ul=IncValue($dbh, $Q1, "ul0000");
			
			$r[0]=mb_strtolower($r[0],"UTF-8");
			$ul=array( 'id_ul'=> $id_ul ,		'wojewodztwo'=>	$r[0], 'powiat' =>	$r[1], 'gmina' =>	$r[2], 'miasto' =>	$r[3], 
			'nazwa' =>	$r[4],  'nazwa2' => $r[5],  'cecha'=>	$r[6], 'simc'=>	$r[7], 'ulic'=>	$r[8], 'kod' => $kod);
			
			print_r($ul);
			$q2="insert into ulice (id_ul, wojewodztwo, powiat, gmina, miasto,		nazwa,  nazwa2,  cecha, simc, ulic, kod) values ('$id_ul' ,'$r[0]', '$r[1]',	'$r[2]', '$r[3]', '$r[4]', '$r[5]', '$r[6]', '$r[7]', '$r[8]', '$kod')";
			print "$q2 \n";
	Query($dbh,$q2);
			/*$t=explode("l", $r[0]);
			$q2="update budynki set id_ul='ul0$t[1]' where id_ul='$r[0]';update ulice set id_ul='ul0$t[1]' where id_ul='$r[0]'"; 
			echo "$q2 \n";
			$sth2=Query($dbh,$q2);
		#	$r2 =$sth2->fetchRow();*/
		}
?>
