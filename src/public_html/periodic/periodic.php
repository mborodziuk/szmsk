<?php		

CLASS PERIODIC
{

	function PERIODIC($dbh)
		{
			include "func/config.php";
			$Y=date("Y");
			$m=date("m");

			$pm=PrevMonth("$Y-$m");
			
			$this->AddVoipServices($dbh, $pm);
		}

	function AddVoipServices($dbh, $pm)
		{
			include "func/config.php";
				
			$q="select a.id_abon, p.nr_zrodlowy, sum(p.oplata), p.vat from polaczenia_voip p, abonenci a, telefony_voip t where a.id_abon=t.id_abon 
						and p.nr_zrodlowy=t.numer and p.data 
						between '$pm-01 00:00:00' and date_trunc('month',timestamp '$pm-01 00:00:00')+'1month'::interval
						and t.aktywny='T' and t.fv='T' group by p.nr_zrodlowy, a.id_abon, p.vat order by a.id_abon";
						
			WyswietlSql($q);
			$sth=Query($dbh,$q);
			while ($row =$sth->fetchRow())
				{
					// add only this voip services witch costs per month more than 0 zl 
					if ( $row[2]> 0 )
					{
						$Q="select id_uvp from USLUGI_VOIP order by id_uvp desc limit 1";
						$id_uvp=IncValue($dbh, $Q, "UVP00000");
									
						$uvp=array(
						'id_uvp' => $id_uvp, 'nazwa' => "Rozmowy tel. dla nru $row[1] w miesiącu $pm", 
						"vat" => $row[3], "cena" => round($row[2], 2), 'id_abon' => $row[0], 'jm' => "szt.", "fv" => 'N');

						Insert($dbh, "uslugi_voip", $uvp);
					}
				}
		}
/*
	function ContractsTerminate($dbh)
		{
			include "func/config.php";
				
		$umowy="umowy_abonenckie";
		$wypowiedzenia="wypowiedzenia_umow_abonenckich";
		
		$data=date(Y-m-d);
		
		$q="update $umowy set status='Rozwiązana' where nr_um in (select nr_um	from $wypowiedzenia where data_wej<='$date')";
		WyswietlSql($q);
	  //Query2($q, $dbh);
		}
		
	*/	
}										
?>
