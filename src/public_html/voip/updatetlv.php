 <?php
 
	$Q="select t.id_tlv, t.numer, t.aktywny, t.fv,  b.id_bmk, b.producent, b.nr_seryjny, p.id_usl, t.id_abon, t.data_aktywacji
	from
	(telefony_voip t left join bramki_voip b on t.id_bmk=b.id_bmk  ) 
	left join  
	(towary_sprzedaz ts join pakiety p on p.id_usl=ts.id_tows and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]')
	on t.id_tlv=p.id_urz
	where 	t.id_tlv='$_GET[tlv]'";

	$row=Query2($Q, $dbh);

	$tlv=array(
	'id_tlv' 	=> $row[0], 	'numer'						=>$row[1], 	'aktywny'	=>$row[2],			'fv'	=>	$row[3], 
 	'id_bmk'					=>$row[4],	'producent'	=>$row[5],		'sn'	=>  $row[6],	'id_taryfy' => $row[7],
	'id_abon' => $row[8],	'data_aktywacji' 	=>$row[9]);
	
		$q2="select p.id_usl, t.symbol, p.aktywny_od, p.aktywny_do 
	from telefony_voip v, pakiety p, towary_sprzedaz t 
	where v.id_tlv=p.id_urz and t.id_tows=p.id_usl and v.id_tlv='$_GET[tlv]'";
	
	WyswietlSql($q2);
	$trf=array(	);
	$sth2=Query($dbh,$q2);
	while ($row2=$sth2->fetchRow())
	{	
		$t=array(
		'id_usl' 	=> $row2[0], 'symbol'						=>$row2[1], 	'aktywny_od'	=>$row2[2],			'aktywny_do'	=>	$row2[3]
		);
		array_push($trf, $t);		
	}
	
	$q4="select fv from uslugi_dodatkowe where id_usl='$conf[addsrv7]' and id_urz='$_GET[tlv]' and aktywna_od <= '$conf[data]' and aktywna_do >='$conf[data]'";
	$row4=Query2($q4, $dbh);
	WyswietlSql($q4);
	if ( !empty($row4) )
	{
		$tlv[addsrv7]='T';
		$tlv[addsrv7_fv]=$row4[0];
	}
	else
	{
		$tlv[addsrv7]='N';
		$tlv[addsrv7_fv]='N';	
	}
	
	$q5="select fv from uslugi_dodatkowe where id_usl='$conf[addsrv14]' and id_urz='$_GET[tlv]' and aktywna_od <= '$conf[data]' and aktywna_do >='$conf[data]'";
	$row5=Query2($q5, $dbh);
	WyswietlSql($q5);
	if ( !empty($row5) )
	{
		$tlv[addsrv14]='T';
		$tlv[addsrv14_fv]=$row5[0];
	}
	else
	{
		$tlv[addsrv14]='N';
		$tlv[addsrv14_fv]='N';	
	}
	
	$_SESSION[$_GET[tlv].$_SESSION[login]]=$tlv;

?>
<form method="POST" action="index.php?panel=inst&menu=sendupdtlv&tlv=<?php echo "$_GET[tlv]" ?>">
<table style="align=center">
  <tbody>
	 <tr>
	 		<td class="klasa1" colspan="2">
				Dane Telefonu Voip
		</td>
		</tr>
		<tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($tlv[aktywny], "aktywny");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($tlv[fv], "fv");
			?>
		 </td>
	 </tr>
    <tr>
      <td> Numer </td>
      <td>
		<input type="text" name="numer" size="30" value="<?php echo "$tlv[numer]";  ?>"/>
		</td>
    </tr>	 
    <tr>
      <td> Abonent </td>
      <td>
		<?php
			$www->SelectWlasc($dbh, "abonent", $tlv[id_abon]);
		?>
		</td>
    </tr>
    <tr>
      <td> Taryfa aktualna </td>
      <td>
		<?php
			Select($QA9,"taryfa", $tlv[id_taryfy]);
		?>
      </td>
    </tr>
		
 <tr>
      <td> Taryfy wszystkie </td>
      <td>
			<?php
			if ( !empty ($trf) )
			{
				$i=1;
				foreach ($trf as $l)
				{
					echo "$i. <b>$l[symbol] </b>$l[id_usl], aktywny od: $l[aktywny_od] do: $l[aktywny_do] <br>";
					$i++;
				}
			}
			?>
      </td>
    </tr>
 	

	 <tr>
      <td> Bramka </td>
      <td>
		<?php
			Select($QA10,"bramka", $tlv[id_bmk]);
		?>
		</td>
    </tr>
    <tr>
      <td> Data aktywacji </td>
      <td>
		<input type="text" name="data_aktywacji" size="20" value="<?php echo "$tlv[data_aktywacji]";  ?>"/>
		</td>
    </tr>
		
			<tr>
		<td class="klasa1" colspan="2">
			<b> Utrzymanie linii </b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywne </td>
		 <td>
			<?php
				echo TableToCheckbox($tlv[addsrv7], "addsrv7");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowane </td>
		 <td>
			<?php
				echo TableToCheckbox($tlv[addsrv7_fv], "addsrv7_fv");
			?>
		 </td>
	 </tr>

	 <tr>
		<td class="klasa1" colspan="2">
			<b> Blok. połączeń po przekr. pakietu </b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywne </td>
		 <td>
			<?php
				echo TableToCheckbox($tlv[addsrv14], "addsrv14");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowane </td>
		 <td>
			<?php
				echo TableToCheckbox($tlv[addsrv14_fv], "addsrv14_fv");
			?>
		 </td>
	 </tr>
	 
	 
	<tr>
	 <td> 
  	 </td>
	<td> 
	 <a href="index.php?panel=inst&menu=trftlvadd&tlv=<?php echo "$_GET[tlv]" ?>">Nowa taryfa >>> </a>
	 </td>
	 </tr>
	 
	 
			
	<tr>
	<tr>
	 <td> 
  	 </td>
  	  <td>
  	  	<INPUT type="submit" name="wyslij" value="Wyślij" size="30" class="button1"> 
	 </td>
	 </tr>
  </tbody>
</table>

</form>