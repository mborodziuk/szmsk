<?php

function CreateWezwanie($dbh, $id_abon, $type)
{

		include "func/config.php";

		$q="select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer, kw.numer
		from abonenci a, sprawy_windykacyjne s, ulice u, budynki b, umowy_abonenckie um, konta_wirtualne kw
		where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
		and u.id_ul=b.id_ul and a.id_abon=kw.id_abon and a.id_abon='$id_abon'";

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

		Z przykrością stwierdzamy, że konto Państwa wskazuje zaległe należności 
		za usługi internetowe na łączną kwotę:  
		$dluznik[saldo] zł brutto.
		 
		Należności te wynikają z braku zapłaty za usługi dostępu do Internetu.
	
		Uprzejmie prosimy o niezwłoczne wpłacenie w/w kwoty na rachunek bankowy:
		NETICO S.C.  - $dluznik[konto]
		
		Przypominamy, że zaleganie z płatnością wystawionych faktur lub not 
		odsetkowych o więcej niż 14 dni od wyznaczonego terminu płatności 
		skutkuje całkowitą utratą dostępu do infrastruktury teleinformatycznej 
		operatora, zamknięciem konta i utratą wszystkich związanych z nim zasobów 
		i informacji.
				
		Jeśli Państwo, z powodu braku czasu, mają problemy z terminowym regulowaniem 
		należności za wystawione przez NETICO S.C. faktury za usługi zachęcamy do 
		korzystania z bezgotówkowych form płatności - stałe zlecenie bankowe 
		lub przelew internetowy.
				
		W razie jakichkolwiek wątpliwości dotyczących zaległych płatności prosimy 
		o kontakt pod numerem telefonu: 032 318 25 55.
			
		Z poważaniem

		NETICO S.C. 
		ul. Morcinka 2
		41-400 Mysłowice,
		infolinia  801 000 155
		kom.	500 870 870
		fax  /032/ 318 19 69
		e-mail: netico@netico.pl
		http://www.netico.pl
		http://live.netico.pl

		------------------------------------------------------------------------
		Informacja zawarta w tym mailu jest poufna i objęta tajemnicą zawodową.
		Mail skierowany jest wyłącznie do adresata. Jeżeli nie jest Pani/Pan
		adresatem tej korespondencji, informuję, że wykorzystywanie lub
		rozpowszechnianie maila oraz zawartych w nim informacji w jakiejkolwiek
		formie jest niedozwolone. Jeżeli nie jest Pani/Pan adresatem powyższej
		korespondencji uprzejmie proszę o natychmiastowe powiadomienie o tym
		fakcie nadawcy i skasowanie tej wiadomości. Dziękuję.
		";

	//	$wezwanie="$tekst0.$tekst1.$tekst2.$tekst3.$tekst4.$tekst5.$tekst6.$tekst7.$tekst8.$tekst9.$tekst10.
	//	$tekst11.$tekst12.$tekst13.$tekst14.$tekst15";
		
		return $wezwanie;

}

?>