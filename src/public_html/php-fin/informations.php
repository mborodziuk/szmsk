<?php
	$dbh=DBConnect($DBNAME1);
#   $Q1="select count(*) from abonenci";
    $Q1="select count(distinct nr_um) from umowy_abonenckie where status='Obowiązująca'";
      
	$sth1=Query($dbh, $Q1);
	$row1 =$sth1->fetchRow();

   $Q2="select count(distinct id_abon) from umowy_abonenckie where status='Zawieszona'";
	$sth2=Query($dbh, $Q2);
	$row2 =$sth2->fetchRow();

   $Q3="select count(*) from abonenci where status='Oczekujący'";
	$sth3=Query($dbh, $Q3);
	$row3 =$sth3->fetchRow();

   $Q4="select count(*) from abonenci where status='Zainteresowany'";
	$sth4=Query($dbh, $Q4);
	$row4 =$sth4->fetchRow();

   $Q5="select count(*) from abonenci where saldo<0";
	$sth5=Query($dbh, $Q5);
	$row5 =$sth5->fetchRow();

$abon=array
(	'wszyscy'					=> $row1[0],		'podlaczeni'	=> $row2[0],		'oczekujacy' => $row3[0],	
	'zainteresowani'	=> $row4[0],	'zadluzeni'		=> $row5[0]		);

   $Q10="select count(*) from budynki";
	$sth10=Query($dbh, $Q10);
	$row10 =$sth10->fetchRow();

   $Q11="select count(*) from budynki where przylacze='100 Mbit/s'";
	$sth11=Query($dbh, $Q11);
	$row11 =$sth11->fetchRow();

   $Q12="select count(*) from budynki where przylacze='10 Mbit/s'";
	$sth12=Query($dbh, $Q12);
	$row12 =$sth12->fetchRow();

   $Q13="select count(*) from budynki where przylacze='1 Gbit/s'";
	$sth13=Query($dbh, $Q13);
	$row13 =$sth13->fetchRow();

$budynki=array
(	'wszystkie' 		=> $row10[0],		'100'	=> $row11[0],		'10' => $row12[0], '1000' => $row13[0]	);


	$Q20="select count(*) from instytucje";
	$sth20=Query($dbh, $Q20);
	$row20 =$sth20->fetchRow();

	$Q21="select count(*) from instytucje";
	$sth21=Query($dbh, $Q21);
	$row21 =$sth21->fetchRow();

	$Q22="select count(*) from instytucje";
	$sth22=Query($dbh, $Q22);
	$row22 =$sth22->fetchRow();

	$Q23="select count(*) from instytucje";
	$sth23=Query($dbh, $Q23);
	$row23 =$sth23->fetchRow();


$inst=array
(	'wszystkie' 		=> $row20[0],		'mieszk'	=> $row21[0],		'jst' => $row22[0], 'inne' => $row23[0]	);


	$Q30="select count(*) from dokumenty_sprzedaz";
	$sth30=Query($dbh, $Q30);
	$row30 =$sth30->fetchRow();

	$Q31="select count(*) from dokumenty_zakup";
	$sth31=Query($dbh, $Q31);
	$row31 =$sth31->fetchRow();

	$Q32="select count(*) from gwarancje_zakup";
	$sth32=Query($dbh, $Q32);
	$row32 =$sth32->fetchRow();

	$Q33="select count(*) from gwarancje_sprzedaz";
	$sth33=Query($dbh, $Q33);
	$row33 =$sth33->fetchRow();

	$Q34="select count(*) from pisma_przychodzace";
	$sth34=Query($dbh, $Q34);
	$row34 =$sth34->fetchRow();

	$Q35="select count(*) from pisma_wych";
	$sth35=Query($dbh, $Q35);
	$row35 =$sth35->fetchRow();


$dok=array
(	'sprzed' 		=> $row30[0],	'zak'		=> $row31[0],		'gwar_zak' => $row32[0], 
	'gwar_sprzed'	=> $row33[0], 	'pisma_przych'	=> $row34[0], 	'pisma_wych' => $row35[0]	);

?>


<table class="tbk3">
  <tbody align="center" valign="center">
    <tr>
      <td>
			<table style="text-align: center; width: 300px; height: 200px;" class="tbk3">
			  <tbody align="center" valign="center">
  				  <tr style="height : 20px;">
						<td class="klasa1" colspan="2">
								<strong>Abonenci</strong>
						</td>
					</tr>
  				  <tr>
	      			<td class="klasa2">
								Umowy obowiązujące: <br/>
								Umowy zawieszone: <br/>
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
			<table style="text-align: center; width: 300px; height: 200px;" class="tbk3">
			  <tbody align="center" valign="center">
  				  <tr style="height : 20px;">
						<td class="klasa1" colspan="2">
								<strong>Budynki</strong>
						</td>
					</tr>
  				  <tr>
	      			<td class="klasa2">
								Wszystkie: <br/>
								Przyłącze 1 Gbit/s: <br/>
								Przyłącze 100 Mbit/s: <br/>
								Przyłącze 10 Mbit/s: <br/>
						</td>
						<td class="klasa4">
							<?php
								echo "$budynki[wszystkie] <br/>";
								echo "$budynki[1000] <br/>";
								echo "$budynki[100] <br/>";
								echo "$budynki[10] <br/>";

							?>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
    </tr>
    <tr>
      <td>
			<table style="text-align: center; width: 300px; height: 200px;" class="tbk3">
			  <tbody align="center" valign="center">
  				  <tr style="height : 20px;">
						<td class="klasa1" colspan="2">
								<strong>Instytucje</strong>
						</td>
					</tr>
  				  <tr>
	      			<td class="klasa2">
								Wszystykie: <br/>
								Instytucje mieszkaniowe: <br/>
								Jednostki samrządu terytorialnego: <br/>
								Inne: <br/>
						</td>
						<td class="klasa4">
							<?php
								echo "$inst[wszystkie] <br/>";
								echo "$inst[mieszk] <br/>";
								echo "$inst[jst] <br/>";
								echo "$inst[inne] <br/>";
							?>
						</td>
					</tr>
				</tbody>
			</table>

		</td>
      <td>
			<table style="text-align: center; width: 300px; height: 200px;" class="tbk3">
			  <tbody align="center" valign="center">
  				  <tr style="height : 20px;">
						<td class="klasa1" colspan="2">
								<strong>Dokumenty</strong>
						</td>
					</tr>
  				  <tr>
	      			<td class="klasa2">
								Dokumenty sprzedaży: <br/>
								Dokumenty zakupu: <br/>
								Gwarancje sprzedaży: <br/>
								Gwarancje  zakupu: <br/>
								Pisma przychodzące: <br/>
								Pisma wychodzące: <br/>
						</td>
						<td class="klasa4">
							<?php
								echo "$dok[sprzed] <br/>";
								echo "$dok[zak] <br/>";
								echo "$dok[gwar_sprzed] <br/>";
								echo "$dok[gwar_zak] <br/>";
								echo "$dok[pisma_przych] <br/>";
								echo "$dok[pisma_wych] <br/>";
							?>
						</td>
					</tr>
				</tbody>
			</table>

		</td>
    </tr>
  </tbody>
</table>