<?php

class COMPUTERS
{

function Delete ($dbh)
{
	include "func/config.php";
	
	$q="";
	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" )
			{
			//update podsieci set wykorzystana='N' where id_pds in (select id_pds from adresy_ip where id_urz='$k');
			$q.="	delete from adresy_fizyczne where ip in (select ip from adresy_ip where id_urz='$k');
						
						delete from adresy_ip where id_urz='$k';
						delete from pakiety where id_urz='$k'; 
						delete from taryfy where id_urz='$k'; 
						delete from uslugi_dodatkowe where id_urz='$k'; 
						delete from komputery where id_komp='$k';";
			}
		}
	WyswietlSql($q);	
	Query($dbh, $q);

	echo "Usunięto dane z systemu.";
}

function ListaKomputerow($dbh)
{
		include "func/config.php";
		
		$p=array
		(	
			'typ' => $_GET[typ], 	'taryfa' 		=> $_POST[taryfa], 'forma' => $_POST[forma],
			'data_od' => "$_POST[od_rok]"."-"."$_POST[od_miesiac]"."-"."$_POST[od_dzien]",
		 	'data_do'	=> "$_POST[do_rok]"."-"."$_POST[do_miesiac]"."-"."$_POST[do_dzien]",
			'order' => $_POST[order], 'abon'	=> $_POST[abon] 
		);
		
		$idk=explode(" ", $p[abon]);
		$ida=array_pop($idk);
		
		if (empty($p[order]) || $p[order] == "ID Komputera")
		{
			$p[order]="k.id_komp";
		}
		else if ($p[order] == "Nazwa abonenta")
			$p[order]="n.nazwa, k.data_podl";
		
		
	  $q="select k.id_komp, k.nazwa_smb, i.nazwa, u.symbol, n.symbol, n.nazwa, n.id_abon
				from 
				(komputery k left join nazwy n on n.id_abon=k.id_abon and n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]')
				left join
				((pakiety  p join towary_sprzedaz u on p.id_usl=u.id_tows and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]') 
				 full join 
				 (taryfy_internet i join taryfy t on i.id_trf=t.id_trf and t.aktywna_od <= '$conf[data]' and t.aktywna_do >='$conf[data]') 
				 on t.id_urz=p.id_urz  )
				on k.id_komp=t.id_urz where k.data_podl>='$p[data_od]' and k.data_podl<='$p[data_do]'	";
				
		if (!empty($p[abon]) && $p[abon] !=$conf[select])   
					$q.=" and n.id_abon='$ida' 	order by $p[order]";
					else 
					$q.=" 	order by $p[order]";
				
		WyswietlSql($q);
	  $sth1=Query($dbh,$q);
		$lp=1;
	  while ($row1=$sth1->fetchRow())
	    {
	      $ip=array();
	      DrawTable($lp++,$conf[table_color]);  	
	        {
						echo "<td> <a href=\"index.php?panel=inst&menu=updatekomp&komp=$row1[0]\"> $row1[0] </a> </td>";
				    echo "<td> $row1[1] </td>";
				    $s=Choose($row1[4], $row1[5]);
				    echo "<td> <b>$s </b> <br> <a href=\"index.php?panel=inst&menu=updateabon&abon=$row1[6]\"> $row1[6] </a></td>";
				    $q2="select i.ip from adresy_ip i, komputery k, podsieci p where i.id_urz=k.id_komp and i.id_pds=p.id_pds and p.warstwa in ('dostep_pryw', 'dostep_publ')  and i.id_urz='$row1[0]'";
				    $sth2=Query($dbh,$q2);
				    echo "<td>";
			      while ($row2=$sth2->fetchRow() )
			        {
			         array_push( $ip, $row2[0] );
			         echo " $row2[0] <br>";
			        }
			      echo "</td>";
						$q2="select i.ip from adresy_ip i, komputery k, podsieci p where i.id_urz=k.id_komp and i.id_pds=p.id_pds and p.warstwa='dostep_zewn' and i.id_urz='$row1[0]'";
				   // $sth2=Query($dbh,$q2);
				    echo "<td>";
			     /* while ($row2=$sth2->fetchRow() )
			        {
			         echo " $row2[0] <br>";
			        }*/
			      echo "</td>";
			      echo "<td>";
			      foreach ($ip as $i)
						$q3="select m.mac from adresy_fizyczne m, adresy_ip  i, podsieci p where m.ip=i.ip and i.id_pds=p.id_pds and p.warstwa='dostep_pryw' and m.ip='$i'";
						$sth3=Query($dbh,$q3);
						while ($row3=$sth3->fetchRow() )
						echo " $row3[0] <br>";
					}
				echo "</td>";
				echo "<td> $row1[2] </td>";
				echo "<td> $row1[3] </td>";
				echo "<td><input type=\"checkbox\" name=\"$row1[0]\"/></td>";
			}
		echo "</tr>";
}
	
function ValidateKomp($dbh, $ipc)
{		
		include "func/config.php";
     $flag=1;
		 

	/*	if ( empty ($_POST[taryfa]) || $_POST[taryfa]== $conf[select])
        {
          echo "Błąd pola 'Taryfa' : pole jest puste <br>";
           $flag=0;
        }*/
		if ( empty ($_POST[mi]) || $_POST[mi]== $conf[select])
        {
          echo "Błąd pola 'Miejsce instalacji' : pole jest puste <br>";
           $flag=0;
        }
     if ( empty ($_POST["wlasciciel"])  || $_POST[wlasciciel]== $conf[select])
        {
          echo "Błąd pola 'Właściciel' : pole jest puste <br>";
           $flag=0;
        }
/*    if ( empty ($_POST["nazwa"]))
        {
          echo "Błąd pola 'Nazwa komputera' : pole jest puste <br>";
          $flag=0;
        }
     $flag=0;
*/
		 $l=0;
     for ($i=0; $i<3; $i++)
        {
          if ( !empty ($_POST["mac$i"]) && $ipc->ValidateMac($dbh, $_POST["mac$i"] ))
            {
              ++$l;
            }
        }
     if ( $l>0 )
		 {
			$flag=1;
			}
		 else
		 {
			$flag=0;
			echo " Trzeba wpisać prawidłowy adres fizyczny";
		 }
		 
     return ($flag);
}

function AddNewKomp($dbh, $s, $ipc)
{
		include "func/config.php";
		
    $Q1="select id_komp from komputery order by id_komp desc limit 1";
    $ID_KOMP=IncValue($dbh,$Q1);
    $DATA_PODL=$_POST[data_podl];
					
		$dhcp=CheckboxToTable($_POST[dhcp]);
	  $ipmac=CheckboxToTable($_POST[ipmac]);
    $net=CheckboxToTable($_POST[net]);
    $proxy=CheckboxToTable($_POST[proxy]);
    $dg=CheckboxToTable($_POST[dg]);
    $info=CheckboxToTable($_POST[info]);

    $podlaczony=CheckboxToTable($_POST[podlaczony]);
	  $fv=CheckboxToTable($_POST[fv]);
													
    $Q2="select id_konf from konfiguracje
         where dhcp='$dhcp' and ipmac='$ipmac' and net='$net' and proxy='$proxy' and dg='$dg' and info='$info'";
																				
    $sth=Query($dbh,$Q2);
    $row =$sth->fetchRow();
    $ID_KONF=$row[0];
																		

		$id_usl= FindId2($_POST[usluga]);
		$id_trf= FindId2($_POST[taryfa]);
		
		$wlasc=explode(" ", $_POST[wlasciciel]);
		$ID_ABON=$wlasc[count($wlasc)-1];
		
		if (empty($_POST[nazwa]))
			$kompname=CreateSymbol($s->konwertuj($_POST[wlasciciel]));
		else $kompname=$_POST[nazwa];
		
		
		$komp=array(
		'id_komp'			=> $ID_KOMP, 
		'nazwa_smb'		=> $kompname, 
		'id_konf'			=> $ID_KONF,
		'id_abon' 		=> $ID_ABON, 
		'data_podl'		=> $DATA_PODL, 
		'podlaczony'	=> $podlaczony, 
		'fv'					=> $fv, 
		'id_ivn' 			=> $r[5],
		'id_msi' 			=> FindId2($_POST[mi]) 
		);
		
	if ( $_POST[ipadres] == 'Prywatny')
	{	
		$q1="select distinct pds.id_pds, pds.adres, pds.maska, pds.brama, pds.broadcast, iv.id_ivn 
		from interfejsy_wezla i1, interfejsy_wezla i2, polaczenia pl, olt o, 
		inst_vlanu iv, przyp_vlanu p, onu onu , adresy_ip a, podsieci pds, miejsca_instalacji m
		where a.id_urz=iv.id_ivn and pl.id_ifc2=i2.id_ifc and pl.id_ifc1=i1.id_ifc and i1.id_wzl=o.id_olt 
		and  i2.id_wzl=onu.id_onu and p.id_ivn=iv.id_ivn and p.id_ifc=i1.id_ifc and a.id_pds=pds.id_pds 
		and pds.warstwa='dostep_pryw' and pds.wykorzystana='N' and onu.id_msi='$komp[id_msi]' and onu.id_abon='$ID_ABON'";
	}
	else
	{
		$q1="select distinct pds.id_pds, pds.adres, pds.maska, pds.brama, pds.broadcast, iv.id_ivn 
		from interfejsy_wezla i1, interfejsy_wezla i2, polaczenia pl, olt o, 
		inst_vlanu iv, przyp_vlanu p, onu onu , adresy_ip a, podsieci pds, miejsca_instalacji m
		where a.id_urz=iv.id_ivn and pl.id_ifc2=i2.id_ifc and pl.id_ifc1=i1.id_ifc and i1.id_wzl=o.id_olt 
		and  i2.id_wzl=onu.id_onu and p.id_ivn=iv.id_ivn and p.id_ifc=i1.id_ifc and a.id_pds=pds.id_pds 
		and pds.warstwa='dostep_publ' and and pds.wykorzystana='N' onu.id_msi='$komp[id_msi]' and onu.id_abon='$ID_ABON'";	
	}
	
	$r=Query2($q1, $dbh);
	WyswietlSql($q1);
	
	if (empty ($r) )
	{
		$q2=" select pds.id_pds, pds.adres, pds.maska, pds.brama, pds.broadcast, iv.id_ivn
	from interfejsy_wezla i,
	inst_vlanu iv, przyp_vlanu p, cpe c , adresy_ip a, podsieci pds
	where a.id_urz=iv.id_ivn  and i.id_wzl=c.id_cpe
	and  p.id_ivn=iv.id_ivn and p.id_ifc=i.id_ifc and a.id_pds=pds.id_pds
	and c.id_msi='$komp[id_msi]' and c.id_abon='$ID_ABON'";
		WyswietlSql($q2);
		$r=Query2($q2, $dbh);
	}
	
	if (empty ($r) )
	{	
		if ( $_POST[ipadres] == 'Prywatny')
			{
				$q3="select pds.id_pds, pds.adres, pds.maska, pds.brama, pds.broadcast, iv.id_ivn from podsieci pds, adresy_ip ai, inst_vlanu iv, budynki b, miejsca_instalacji m where pds.id_pds=ai.id_pds and ai.id_urz=iv.id_ivn and m.id_bud=b.id_bud and b.id_ivn1=iv.id_ivn and m.id_msi='$komp[id_msi]'";
			}
		else
		{
			$q3="select pds.id_pds, pds.adres, pds.maska, pds.brama, pds.broadcast, iv.id_ivn from podsieci pds, adresy_ip ai, inst_vlanu iv, budynki b, miejsca_instalacji m where pds.id_pds=ai.id_pds and ai.id_urz=iv.id_ivn and m.id_bud=b.id_bud and b.id_ivn3=iv.id_ivn and m.id_msi='$komp[id_msi]'";
		}
		WyswietlSql($q3);
		$r=Query2($q3, $dbh);
	}
	

	if ( !empty ($r) )
	{
		Insert($dbh, "KOMPUTERY", $komp);
		
		$ip=array(
			'id_urz'	 => $ID_KOMP,  			
			'ip'			=> $ipc->AddIp($dbh, $r),
			'id_pds'			=> $r[0]
			);
		Insert($dbh, "adresy_ip", $ip);		
		
	if ( !empty($_POST[usluga]) && $_POST[usluga]!=$conf[select] )
		{
			$pkt=array(
			'id_urz'=>$ID_KOMP, 'id_usl'=>$id_usl, 'aktywny_od' => $DATA_PODL, 'aktywny_do' => $conf[wazne_do]);
			Insert($dbh, "pakiety", $pkt);
		}
		
		$trf=array(
		'id_urz'=>$ID_KOMP, 'id_trf'=>$id_trf, 'aktywna_od' => $DATA_PODL, 'aktywna_do' => $conf[wazne_do]);
		Insert($dbh, "taryfy", $trf);
		
		
		if ( CheckboxToTable($_POST[ipzewn]) == 'T' && CheckboxToTable($_POST[ipzewn_fv]) == 'T' )
			{
				$q="insert into uslugi_dodatkowe values('$ID_KOMP', '$conf[ipzewn]', 'T', '$DATA_PODL', '$conf[wazne_do]')";
				WyswietlSql($q);
				Query($dbh,$q);	
			}
		else if ( CheckboxToTable($_POST[ipzewn]) == 'T' && CheckboxToTable($_POST[ipzewn_fv]) == 'N' )
			{
				$q="insert into uslugi_dodatkowe values('$ID_KOMP', '$conf[ipzewn]', 'N', '$DATA_PODL', '$conf[wazne_do]')";
				WyswietlSql($q);
				Query($dbh,$q);	
			}

		if ( CheckboxToTable($_POST[antywirus]) == 'T' && CheckboxToTable($_POST[antywirus_fv]) == 'T' )
			{
				$q="insert into uslugi_dodatkowe values('$ID_KOMP', '$conf[antywirus]', 'T', '$DATA_PODL', '$conf[wazne_do]')";
				WyswietlSql($q);
				Query($dbh,$q);	
			}
		else if ( CheckboxToTable($_POST[antywirus]) == 'T' && CheckboxToTable($_POST[antywirus_fv]) == 'N' )
			{
				$q="insert into uslugi_dodatkowe values('$ID_KOMP', '$conf[antywirus]', 'N', '$DATA_PODL', '$conf[wazne_do]')";
				WyswietlSql($q);
				Query($dbh,$q);	
			}	

		if ( !empty($_POST[mac0]) )
			{
			  $mac=strtolower($_POST[mac0]);
			  $Q9="insert into adresy_fizyczne values('$mac', '$ip[ip]')";
			  Query($dbh,$Q9);
				WyswietlSql($Q9);
		  }
			
		}
	else 
		{
			echo "Do miejsca instalacji $komp[id_msi] nie przypisano żadnych węzłów. <br/>
			Nie można wprowadzić komputera <br/>";
		}

}

function UpdateKomp($dbh, $ID_KOMP, $ipc)
{		
		include "func/config.php";
		
		$kmp=$_SESSION[$session[komp][update]];
		$fiz="$ID_KOMP.$session[mac][update]";
		$mac=$_SESSION['$fiz'];
		
		$dhcp=CheckboxToTable($_POST[dhcp]);
	  $ipmac=CheckboxToTable($_POST[ipmac]);
    $net=CheckboxToTable($_POST[net]);
    $proxy=CheckboxToTable($_POST[proxy]);
    $dg=CheckboxToTable($_POST[dg]);
    $info=CheckboxToTable($_POST[info]);
		
    $podlaczony=CheckboxToTable($_POST[podlaczony]);
		$fv=CheckboxToTable($_POST[fv]);
									
    $Q2="select id_konf from konfiguracje
         where dhcp='$dhcp' and ipmac='$ipmac' and net='$net' and proxy='$proxy' and dg='$dg' and info='$info'";
		WyswietlSql($Q2);	
		
		$sth=Query($dbh,$Q2);
		$row =$sth->fetchRow();
		$ID_KONF=$row[0];
		$ID_ABON=FindId2($_POST[wlasciciel]);

		$id_usl= FindId2($_POST[usluga]);
		$id_trf= FindId2($_POST[taryfa]);
		
		$komp=array(
		'id_komp'			=> $ID_KOMP, 			
		'nazwa_smb'		=> $_POST[nazwa], 
		'id_konf'			=> $ID_KONF,
		'podlaczony'	=> $podlaczony, 
		'fv'					=> $fv, 
		'id_abon' 		=> $ID_ABON, 
		'data_podl' 	=> $_POST[data_podl],
		'id_msi' 			=> FindId2($_POST[mi]) 
		);
				
			
		if ( $komp[id_msi] != $kmp[id_msi] || $_POST[ipadres] != $kmp[ipadres] )
		{
			if ( $_POST[ipadres] == 'Prywatny')
			{	
				$q1="select distinct pds.id_pds, pds.adres, pds.maska, pds.brama, pds.broadcast, iv.id_ivn 
				from interfejsy_wezla i1, interfejsy_wezla i2, polaczenia pl, olt o, 
				inst_vlanu iv, przyp_vlanu p, onu onu , adresy_ip a, podsieci pds, miejsca_instalacji m
				where a.id_urz=iv.id_ivn and pl.id_ifc2=i2.id_ifc and pl.id_ifc1=i1.id_ifc and i1.id_wzl=o.id_olt 
				and  i2.id_wzl=onu.id_onu and p.id_ivn=iv.id_ivn and p.id_ifc=i1.id_ifc and a.id_pds=pds.id_pds 
				and pds.warstwa='dostep_pryw' and pds.wykorzystana='N' and onu.id_msi='$komp[id_msi]' and onu.id_abon='$ID_ABON'";
			}
			else
			{
				$q1="select distinct pds.id_pds, pds.adres, pds.maska, pds.brama, pds.broadcast, iv.id_ivn 
				from interfejsy_wezla i1, interfejsy_wezla i2, polaczenia pl, olt o, 
				inst_vlanu iv, przyp_vlanu p, onu onu , adresy_ip a, podsieci pds, miejsca_instalacji m
				where a.id_urz=iv.id_ivn and pl.id_ifc2=i2.id_ifc and pl.id_ifc1=i1.id_ifc and i1.id_wzl=o.id_olt 
				and  i2.id_wzl=onu.id_onu and p.id_ivn=iv.id_ivn and p.id_ifc=i1.id_ifc and a.id_pds=pds.id_pds 
				and pds.warstwa='dostep_publ' and pds.wykorzystana='N' and onu.id_msi='$komp[id_msi]' and onu.id_abon='$ID_ABON'";	
			}
			
			$r=Query2($q1, $dbh);
			WyswietlSql($q1);
	
			if (empty ($r) )
			{
						
			$q2=" select distinct pds.id_pds, pds.adres, pds.maska, pds.brama, pds.broadcast, iv.id_ivn
		from interfejsy_wezla i,
		inst_vlanu iv, przyp_vlanu p, cpe c , adresy_ip a, podsieci pds
		where a.id_urz=iv.id_ivn  and i.id_wzl=c.id_cpe
		and  p.id_ivn=iv.id_ivn and p.id_ifc=i.id_ifc and a.id_pds=pds.id_pds
		and c.id_msi='$komp[id_msi]' and c.id_abon='$ID_ABON'";
			WyswietlSql($q2);
			$r=Query2($q2, $dbh);

			}
			
			if (empty ($r) )
			{	
				if ( $_POST[ipadres] == 'Prywatny')
					{
						$q3="select pds.id_pds, pds.adres, pds.maska, pds.brama, pds.broadcast, iv.id_ivn from 
						podsieci pds, adresy_ip ai, inst_vlanu iv, budynki b, miejsca_instalacji m where 
						pds.id_pds=ai.id_pds and ai.id_urz=iv.id_ivn and m.id_bud=b.id_bud and b.id_ivn1=iv.id_ivn and m.id_msi='$komp[id_msi]'";
					}
				else
				{
					$q3="select pds.id_pds, pds.adres, pds.maska, pds.brama, pds.broadcast, iv.id_ivn from 
					podsieci pds, adresy_ip ai, inst_vlanu iv, budynki b, miejsca_instalacji m where 
					pds.id_pds=ai.id_pds and ai.id_urz=iv.id_ivn and m.id_bud=b.id_bud and b.id_ivn3=iv.id_ivn and m.id_msi='$komp[id_msi]'";
				}			
				WyswietlSql($q3);
				$r=Query2($q3, $dbh);
			}
			
			if (empty ($r) )
			{	
				if ( $_POST[ipadres] == 'Prywatny')
					{
						$q3=" select distinct pds.id_pds, pds.adres, pds.maska, pds.brama, pds.broadcast, iv.id_ivn 
						from interfejsy_wezla i1, interfejsy_wezla i2, trakty t, wezly l3, wezly l2, inst_vlanu iv, inst_vlanu iv2, przyp_vlanu p,  
						adresy_ip a, podsieci pds, miejsca_instalacji m, budynki b where 
						
						a.id_urz=iv.id_ivn and t.id_ifc2=i2.id_ifc and t.id_ifc1=i1.id_ifc and i1.id_wzl=l3.id_wzl and i2.id_wzl=l2.id_wzl 
						and p.id_ivn=iv.id_ivn and p.id_ifc=i1.id_ifc and a.id_pds=pds.id_pds and  m.id_bud=b.id_bud and b.id_ivn1=iv2.id_ivn
						and iv2.id_wzl=l2.id_wzl
						and m.id_msi='$komp[id_msi]'";
					}
				else
				{
					$q3="select pds.id_pds, pds.adres, pds.maska, pds.brama, pds.broadcast, iv.id_ivn from 
					podsieci pds, adresy_ip ai, inst_vlanu iv, budynki b, miejsca_instalacji m where 
					pds.id_pds=ai.id_pds and ai.id_urz=iv.id_ivn and m.id_bud=b.id_bud and b.id_ivn3=iv.id_ivn and m.id_msi='$komp[id_msi]'";
				}			
				WyswietlSql($q3);
				$r=Query2($q3, $dbh);
			}

			if ( !empty ($r) )
				{
				Update($dbh, "KOMPUTERY", $komp);

				$ip=array(
					'id_urz'	 	=> $ID_KOMP,  			
					'ip'				=> $ipc->AddIp($dbh, $r),
					'id_pds'		=> $r[0]
					);
				Update($dbh, "adresy_ip", $ip);
				// adres ip się zmienia
				$ai=$ip[ip];
				
				for ( $i=0; $i<3; $i++ )
					{
						$name="mac"."$i";
						if ( !empty($mac[$i]) )
						{
							$Q7="update adresy_fizyczne set ip='$ai' where mac='$mac[$i]' and ip='$kmp[ip]'";
							WyswietlSql($Q7);	
							Query($dbh,$Q7);
						}
					}
				}
			else 
				{
				echo "Do miejsca instalacji $komp[id_msi] nie przypisano żadnych węzłów. <br/>
				Nie można zaktualizować nowego adresu ip komputera <br/>";
				}
			}
		else
			{
				Update($dbh, "KOMPUTERY", $komp);
				// adres ip sie nie zmienia
				$ai=$kmp[ip];
			}
		
		
		if ( $id_usl!= $kmp[id_usl] && IsNull($id_usl)!='NULL')
		{
			$q1="update pakiety set id_usl='$id_usl' where id_urz='$ID_KOMP' and aktywny_do='$conf[wazne_do]'";
			WyswietlSql($q1);
			$row=Query($dbh, $q1);
		}
		else if ( !empty($kmp[id_usl]) && IsNull($id_usl)=='NULL'  )
		{
			$q="update pakiety set aktywny_do='$conf[poprzednidzien]' where id_urz='$ID_KOMP' and aktywny_do='$conf[wazne_do]'";
			WyswietlSql($q);
			$row=Query($dbh, $q);
		}
		else if ( empty($kmp[id_usl]) && IsNull($id_usl)!='NULL'  )
		{
			$pkt=array(
			'id_urz'=>$ID_KOMP, 'id_usl'=>$id_usl, 'aktywny_od' => $conf[data], 'aktywny_do' => $conf[wazne_do]);
			Insert($dbh, "pakiety", $pkt);
		}
		
		if ( $id_trf!= $kmp[id_trf] )
		{
			$q2="update taryfy set id_trf='$id_trf' where id_urz='$ID_KOMP' and aktywna_do='$conf[wazne_do]'";
			WyswietlSql($q2);
			$row=Query($dbh, $q2);
		}
		
		$this->AditionalServices($dbh, $ID_KOMP, $kmp, $ipc);
		
		
		for ( $i=0; $i<3; $i++ )
		{
			$name="mac"."$i";
			if ( !empty($mac[$i]) && empty($_POST[$name]) ) 
				{
					$Q7="delete from adresy_fizyczne where mac='$mac[$i]' and ip='$ai'";
					WyswietlSql($Q7);	
					Query($dbh,$Q7);
		    }

			else if ( $mac[$i] != $_POST[$name] && !empty($_POST[$name]) && !empty($mac[$i]))
					{
						echo "$i $name";
						$Q7="update adresy_fizyczne set mac='$_POST[$name]' where mac='$mac[$i]' and ip='$ai'";
						WyswietlSql($Q7);	
						Query($dbh,$Q7);
					}
			else if ( empty($mac[$i]) && !empty($_POST[$name]) )
				{

					$Q7="insert into adresy_fizyczne values ('$_POST[$name]','$ai')";
					WyswietlSql($Q7);	
					Query($dbh,$Q7);
				}			
		}

				
}	



function TaryfaAdd($dbh,$ID_KOMP, $ipc, $aktywny_od=Null)
{
		include "func/config.php";
		$kmp=$_SESSION[$session[komp][update]];
		$ID_TARYFY= FindId2($_POST[taryfa]);
		if ( $kmp['id_trf'] != $ID_TARYFY)
		{
			if ($aktywny_od == Null)
			{
				$aktywny_od=$_POST[aktywny_od];
			}

			$aktywny_do2=date('Y-m-d', strtotime('-1 day', strtotime($aktywny_od))); 
			$q="update taryfy set aktywna_do='$aktywny_do2' where id_urz='$ID_KOMP' and aktywna_do='$conf[wazne_do]'";
			$row=Query($dbh, $q);
				
			$trf=array(
			'id_urz' 		=> $ID_KOMP, 'id_trf' 		=> $ID_TARYFY, 	 'aktywna_od' => $aktywny_od, 'aktywna_do' => $conf[wazne_do]);
			Insert($dbh, "taryfy", $trf);
		}
		$this->AditionalServices($dbh, $ID_KOMP, $kmp, $ipc, $aktywny_od);
}

function UslugaAdd($dbh,$ID_KOMP, $ipc, $aktywny_od=Null)
{
		include "func/config.php";
		$kmp=$_SESSION[$session[komp][update]];
		$id_usl= FindId2($_POST[usluga]);
		if ( $kmp['id_usl'] != $id_usl)
		{
			if ($aktywny_od == Null)
			{
				$aktywny_od=$_POST[aktywny_od];

			}

			$aktywny_do2=date('Y-m-d', strtotime('-1 day', strtotime($aktywny_od))); 
			$q="update pakiety set aktywny_do='$aktywny_do2' where id_urz='$ID_KOMP' and aktywny_do='$conf[wazne_do]'";
			$row=Query($dbh, $q);
				
			$usl=array(
			'id_urz' 		=> $ID_KOMP, 'id_usl' 		=> $id_usl, 	 'aktywny_od' => $aktywny_od, 'aktywny_do' => $conf[wazne_do]);
			Insert($dbh, "pakiety", $usl);
		}
		$this->AditionalServices($dbh, $ID_KOMP, $kmp, $ipc, $aktywny_od);
}



function MsiAdd($dbh, $id_komp)
{
		include "func/config.php";
		$Q= "select id_msi from miejsca_instalacji	order by id_msi desc limit 1";

		
		$msi=array(
		'id_msi'	  	=> IncValue($dbh,$Q,  "MSI00000"),
		'id_bud'			=> FindId2($_POST[budynek]),
		'nr_lok'		  => $_POST[nr_lok]
		);		
		Insert($dbh, "miejsca_instalacji", $msi);
		
			$q="update komputery set id_msi='$msi[id_msi]'  where id_komp='$id_komp'";
			$row=Query($dbh, $q);
	
}

function AditionalServices($dbh, $ID_KOMP, $kmp,  $ipc, $aktywna_od=Null)
{
		include "func/config.php";
		$Q1="select id_pds, adres, maska, brama, broadcast from podsieci where wykorzystana='N' and warstwa='dostep_zewn'";

					
		if ($aktywna_od == Null)
		{
			$aktywna_od=$conf[data];
			$aktywny_do2=date('Y-m-d', strtotime('-1 day', strtotime($aktywna_od))); 
		}
		else
			$aktywny_do2=date('Y-m-d', strtotime('-1 day', strtotime($aktywna_od))); 
		
		
		if ( CheckboxToTable($_POST[ipzewn]) == 'T' && $kmp[ipzewn] =='N' )
			{
				if ( CheckboxToTable($_POST[ipzewn_fv]) == 'T' )
					$q="insert into uslugi_dodatkowe values('$ID_KOMP', '$conf[ipzewn]', 'T', '$aktywna_od', '$conf[wazne_do]')";
				
				else if ( CheckboxToTable($_POST[ipzewn_fv]) == 'N' )
					$q="insert into uslugi_dodatkowe values('$ID_KOMP', '$conf[ipzewn]', 'N', '$aktywna_od', '$conf[wazne_do]')";
				
				WyswietlSql($q);
				Query($dbh,$q);
				
				WyswietlSql($Q1);
				$r=Query2($Q1, $dbh);
				$ipzewn=array(
					'id_urz'	 	=> $ID_KOMP,  			
					'ip'				=> $ipc->AddIp($dbh, $r),
					'id_pds'		=> $r[0]
					);
				Insert($dbh, "adresy_ip", $ipzewn);
			}
			
		else if ( CheckboxToTable($_POST[ipzewn]) == 'T' && $kmp[ipzewn] =='T' )
			{
				if ( CheckboxToTable($_POST[ipzewn_fv]) == 'T' )
					$q="update uslugi_dodatkowe set fv='T' where id_urz='$ID_KOMP' and id_usl='$conf[ipzewn]'";
				
				else if ( CheckboxToTable($_POST[ipzewn_fv]) == 'N' )
					$q="update uslugi_dodatkowe set fv='N' where id_urz='$ID_KOMP' and id_usl='$conf[ipzewn]'";
					
				WyswietlSql($q);
				Query($dbh,$q);
			}
			
		else if ( CheckboxToTable($_POST[ipzewn]) == 'N' && $kmp[ipzewn] =='T' )
		{
		
			$q="update uslugi_dodatkowe set aktywna_do='$aktywny_do2' where id_urz='$ID_KOMP' and id_usl='$conf[ipzewn]' and aktywna_do='$conf[wazne_do]'";
			WyswietlSql($q);
			Query($dbh,$q);
			
			$Q2="delete from adresy_ip where ip in 
			(select i.ip from adresy_ip i, podsieci p where i.id_pds=p.id_pds and p.warstwa='dostep_zewn' and i.id_urz='$ID_KOMP' )";
			WyswietlSql($Q2);
			Query($dbh,$Q2);
		}
		
		
		if ( CheckboxToTable($_POST[antywirus]) == 'T' && $kmp[antywirus] =='N' )
			{
				if ( CheckboxToTable($_POST[antywirus_fv]) == 'T' )
					$q="insert into uslugi_dodatkowe values('$ID_KOMP', '$conf[antywirus]', 'T', '$aktywna_od', '$conf[wazne_do]')";
				
				else if ( CheckboxToTable($_POST[antywirus_fv]) == 'N' )
					$q="insert into uslugi_dodatkowe values('$ID_KOMP', '$conf[antywirus]', 'N', '$aktywna_od', '$conf[wazne_do]')";
					
			WyswietlSql($q);
			Query($dbh,$q);
			}
			
		else if ( CheckboxToTable($_POST[antywirus]) == 'T' && $kmp[antywirus] =='T' )
			{
				if ( CheckboxToTable($_POST[antywirus_fv]) == 'T' )
					$q="update uslugi_dodatkowe set fv='T' where id_urz='$ID_KOMP' and id_usl='$conf[antywirus]'";
				else if ( CheckboxToTable($_POST[antywirus_fv]) == 'N' )
					$q="update uslugi_dodatkowe set fv='N' where id_urz='$ID_KOMP' and id_usl='$conf[antywirus]'";
					
				WyswietlSql($q);
				Query($dbh,$q);
			}
			
		else if ( CheckboxToTable($_POST[antywirus]) == 'N' && $kmp[antywirus] =='T' )
		{
			$q="update uslugi_dodatkowe set aktywna_do='$aktywny_do2' where id_urz='$ID_KOMP' and id_usl='$conf[antywirus]' and aktywna_do='$conf[wazne_do]'";
			WyswietlSql($q);
			Query($dbh,$q);
		}
		


}



}

?>
