<?php
	$dbh=DBConnect($DBNAME1);

   $Q1="select count(*) from abonenci";
   $Q2="select count(*) from abonenci where status='Podłączony'";
   $Q3="select count(*) from abonenci where status='Oczekujący'";
   $Q4="select count(*) from abonenci where status='Zainteresowany'";
   $Q5="select count(*) from abonenci where saldo<0";
   $Q10="select count(*) from komputery";
   $Q11="select count(*) from komputery where podlaczony='T'";
   $Q12="select count(*) from komputery where podlaczony='N'";
   $Q20="select count(*) from konta";
   $Q21="select count(*) from konta where aktywne='T'";
   $Q22="select count(*) from konta where aktywne='N'";
   $Q30="select count(*) from vhost_www";
   $Q31="select count(*) from vhost_ftp";

	$row1=Query2($Q1, $dbh);
	$row2=Query2($Q2, $dbh);
	$row3=Query2($Q3, $dbh);
	$row4=Query2($Q4, $dbh);
	$row5=Query2($Q5, $dbh);
	$row10=Query2($Q10, $dbh);
	$row11=Query2($Q11, $dbh);
	$row12=Query2($Q12, $dbh);
	$row20=Query2($Q20, $dbh);
	$row21=Query2($Q21, $dbh);
	$row22=Query2($Q22, $dbh);
	$row30=Query2($Q30, $dbh);
	$row31=Query2($Q31, $dbh);

$abon=array
(	'wszyscy' 		=> $row1[0],		'podlaczeni'	=> $row2[0],		'oczekujacy' => $row3[0],	
	'zainteresowani'	=> $row4[0],	'zadluzeni'		=> $row5[0]		);
$komp=array
(	'wszystkie' 		=> $row10[0],		'podlaczone'	=> $row11[0],		'odlaczone' => $row12[0]	);
$konta=array
(	'wszystkie' 		=> $row20[0],		'aktywne'	=> $row21[0],		'nieaktywne' => $row22[0]	);   $Q20="select count(*) from konta";
$vhost=array
(	'wszystkie' 		=> ($row30[0]+$row31[0]),		'www'	=> $row30[0],		'ftp' => $row31[0]	);

?>


<table class="tbk3">
  <tbody align="center" valign="center">
    <tr>
      <td>
			<table class="tbk3" style="width: 300px; height: 200px;" >
			  <tbody align="center" valign="center">
  				  <tr style="height : 33px;">
				    <td class="klasa1" colspan="2">
						<b>Abonenci</b>
				</td>
				</tr>
  				  <tr>
	      				    <td class="klasa2">
								Wszyscy: <br/>
								Podłączeni: <br/>
								Oczekujący: <br/>
								Zainteresowani: <br/>
								Zadłużeni: <br/>
						</td>
						<td class="klasa4">
							<?php
								echo "$abon[wszyscy] <br/>";
								echo "$abon[podlaczeni] <br/>";
								echo "$abon[oczekujacy] <br/>";
								echo "$abon[zainteresowani] <br/>";
								echo "$abon[zadluzeni] <br/>";
							?>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
      <td>
			<table class="tbk3" style="width: 300px; height: 200px;" >
			  <tbody align="center" valign="center">
  				  <tr style="height : 20px;">
						<td class="klasa1" colspan="2">
								<b>Komputery</b>
						</td>
					</tr>
  				  <tr>
	      			<td class="klasa2">
								Wszystkie: <br/>
								Podłączone: <br/>
								Odłączone: <br/>
						</td>
						<td class="klasa4">
							<?php
								echo "$komp[wszystkie] <br/>";
								echo "$komp[podlaczone] <br/>";
								echo "$komp[odlaczone] <br/>";

							?>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
    </tr>
    <tr>
      <td>
			<table class="tbk3" style="width: 300px; height: 200px;" >
			  <tbody align="center" valign="center">
  				  <tr style="height : 10px;">
						<td class="klasa1" colspan="2">
								<b>Konta</b>
						</td>
					</tr>
  				  <tr>
	      			<td class="klasa2">
								Wszystkie: <br/>
								Aktywne: <br/>
								Nieaktywne: <br/>
						</td>
						<td class="klasa4">
							<?php
								echo "$konta[wszystkie] <br/>";
								echo "$konta[aktywne] <br/>";
								echo "$konta[nieaktywne] <br/>";
							?>
						</td>
					</tr>
				</tbody>
			</table>

		</td>
      <td>
			<table class="tbk3" style="width: 300px; height: 200px;" >
			  <tbody align="center" valign="center">
  				  <tr style="height : 10px;">
						<td class="klasa1" colspan="2">
								<b>Serwery wirtualne</b>
						</td>
					</tr>
  				  <tr>
	      			<td class="klasa2">
								Wszystkie: <br/>
								WWW: <br/>
								FTP: <br/>
						</td>
						<td class="klasa4">
							<?php
								echo "$vhost[wszystkie] <br/>";
								echo "$vhost[www] <br/>";
								echo "$vhost[ftp] <br/>";
							?>
						</td>
					</tr>
				</tbody>
			</table>

		</td>
    </tr>
  </tbody>
</table>