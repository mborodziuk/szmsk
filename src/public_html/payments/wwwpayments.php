<?php

		
  if ( empty($_POST[od_rok]) && empty($_POST[od_miesiac]) && empty($_POST[od_dzien]) )
    {
      $_POST[od_rok]=date("Y");
      $_POST[od_miesiac]=date("m");
      $_POST[od_dzien]=date("01");
    }
  if ( empty($_POST[do_rok]) && empty($_POST[do_miesiac]) && empty($_POST[do_dzien]) )
    {
			$_POST[do_rok]=date("Y");
      $_POST[do_miesiac]=date("m");
      $_POST[do_dzien]=date("d");
		}
  if (empty($_POST[order]))
	    $_POST[order]="Data wpłaty";
  
  if (empty($_POST[rozliczona]))
			$_POST[rozliczona]="Rozliczone";
			
	$Q1="select count(*) from wplaty where data_ksiegowania between '$_POST[od_rok]-$_POST[od_miesiac]-01 00:00:00' 
	and date_trunc('month',timestamp '$_POST[od_rok]-$_POST[od_miesiac]-01 00:00:00')+'1month'::interval-'1day'::interval";
	WyswietlSql($Q1);
	
	$Q2="select count(*) from wplaty where data_ksiegowania between '$_POST[od_rok]-$_POST[od_miesiac]-01 00:00:00' 
	and date_trunc('month',timestamp '$_POST[od_rok]-$_POST[od_miesiac]-01 00:00:00')+'1month'::interval-'1day'::interval and forma like '$firma[wyciag2]'";
	$Q3="select count(*) from wplaty where data_ksiegowania between '$_POST[od_rok]-$_POST[od_miesiac]-01 00:00:00' 
	and date_trunc('month',timestamp '$_POST[od_rok]-$_POST[od_miesiac]-01 00:00:00')+'1month'::interval-'1day'::interval and forma like '$firma[wyciag]'";
	$Q4="select count(*) from wplaty where data_ksiegowania between '$_POST[od_rok]-$_POST[od_miesiac]-01 00:00:00' 
	and date_trunc('month',timestamp '$_POST[od_rok]-$_POST[od_miesiac]-01 00:00:00')+'1month'::interval-'1day'::interval and forma like 'gotówka'";
	$Q5="select count(*) from wplaty where data_ksiegowania between '$_POST[od_rok]-$_POST[od_miesiac]-01 00:00:00' 
	and date_trunc('month',timestamp '$_POST[od_rok]-$_POST[od_miesiac]-01 00:00:00')+'1month'::interval-'1day'::interval and forma like '$firma[wyciag3]'";
	
	$Q6="select sum(kwota) from wplaty where data_ksiegowania between '$_POST[od_rok]-$_POST[od_miesiac]-01 00:00:00' 
	and date_trunc('month',timestamp '$_POST[od_rok]-$_POST[od_miesiac]-01 00:00:00')+'1month'::interval-'1day'::interval";
	$Q7="select sum(kwota) from wplaty where data_ksiegowania between '$_POST[od_rok]-$_POST[od_miesiac]-01 00:00:00' 
	and date_trunc('month',timestamp '$_POST[od_rok]-$_POST[od_miesiac]-01 00:00:00')+'1month'::interval-'1day'::interval and forma like '$firma[wyciag2]'";
	$Q8="select sum(kwota) from wplaty where data_ksiegowania between '$_POST[od_rok]-$_POST[od_miesiac]-01 00:00:00' 
	and date_trunc('month',timestamp '$_POST[od_rok]-$_POST[od_miesiac]-01 00:00:00')+'1month'::interval-'1day'::interval and forma like '$firma[wyciag]'";
	$Q9="select sum(kwota) from wplaty where data_ksiegowania between '$_POST[od_rok]-$_POST[od_miesiac]-01 00:00:00' 
	and date_trunc('month',timestamp '$_POST[od_rok]-$_POST[od_miesiac]-01 00:00:00')+'1month'::interval-'1day'::interval and forma like 'gotówka'";
	$Q10="select sum(kwota) from wplaty where data_ksiegowania between '$_POST[od_rok]-$_POST[od_miesiac]-01 00:00:00' 
	and date_trunc('month',timestamp '$_POST[od_rok]-$_POST[od_miesiac]-01 00:00:00')+'1month'::interval-'1day'::interval and forma like '$firma[wyciag3]'";
	
	$count_all=Query2($Q1, $dbh);	
	$count_inteligo=Query2($Q2, $dbh);	
	$count_pko=Query2($Q3, $dbh);	
	$count_gotowka=Query2($Q4, $dbh);	
	$count_bgz=Query2($Q5, $dbh);	
	
	$sum_all=Query2($Q6, $dbh);	
	$sum_inteligo=Query2($Q7, $dbh);	
	$sum_pko=Query2($Q8, $dbh);	
	$sum_gotowka=Query2($Q9, $dbh);	
	$sum_bgz=Query2($Q10, $dbh);	


  $param=array
	(
		'typ'			=>  $_GET[typ],    		'rozliczona' => $_POST[rozliczona],
    'data_od'	=> "$_POST[od_rok]"."-"."$_POST[od_miesiac]"."-"."$_POST[od_dzien]",
    'data_do'	=> "$_POST[do_rok]"."-"."$_POST[do_miesiac]"."-"."$_POST[do_dzien]",
    'order'		=>  $_POST[order], 'forma' => $_POST[forma],
		'abon'		=> $_POST[abon]
	);
?>

<a href="index.php?panel=fin&menu=paymentadd">Wpłata </a> &nbsp;
<a href="index.php?panel=fin&menu=paymentimp">Wczytaj wpłaty</a> &nbsp;
<br/>
<br/>

<?php
	$_SESSION[upd1]=array('wplaty'=>'id_wpl');
	$_SESSION[upd2]=array();

	
	echo "<strong>Liczba uznań:</strong> $count_all[0]  &nbsp;&nbsp; <strong>Inteligo:</strong> $count_inteligo[0] &nbsp;&nbsp; 
				<strong>PKO:</strong> $count_pko[0] &nbsp;&nbsp;<strong>BGŻ:</strong> $count_bgz[0] &nbsp;&nbsp;<strong>Gotówka:</strong> $count_gotowka[0] <br>";

	echo "<strong>Suma uznań:</strong> $sum_all[0] zł  &nbsp;&nbsp; <strong>Inteligo:</strong> $sum_inteligo[0] zł &nbsp;&nbsp;
				<strong>PKO:</strong> $sum_pko[0] zł &nbsp;&nbsp;<strong>BGŻ:</strong> $sum_bgz[0] &nbsp;&nbsp;<strong>Gotówka:</strong> $sum_gotowka[0]  <br>";
	
?>

<form method="POST" action="index.php?panel=fin&menu=payments">
<table style="text-align: center; width: <?php echo $conf[width2];?>; height:<?php echo $conf[height2];?>" class="tbk1" >
  <tbody>
    <tr class="tr1">
       <td style="width: 80px;">
           Od 
       </td>
       <td>
       <?php
        $lata=array($_POST[od_rok]);
        for ($i=1; $i<=10; ++$i)
            {
            $rok1=$_POST[od_rok]+$i;
            $rok2=$_POST[od_rok]-$i;
            array_push($lata, $rok1);
            array_unshift($lata, $rok2);
            }
         $www->SelectFromArray($lata,"od_rok", $_POST[od_rok]);
        ?>
       </td>
       <td style="width: 20px;">
       <?php
           $miesiace=array("01","02","03","04","05","06","07","08","09","10","11","12");
           $www->SelectFromArray($miesiace,"od_miesiac", $_POST[od_miesiac]);
       ?>
       </td>
       <td style="width: 20px;">
       <?php
            $dni=array("01","02","03","04","05","06","07","08","09","10","11","12", "13","14","15",
            "16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
            $www->SelectFromArray($dni,"od_dzien", $_POST[od_dzien]);
       ?>
       </td>
       <td> Typ dokumentow </td>
       <td> Sortowanie  </td>
       <td> Nazwa kontrahenta  </td>
       <td> Wyślij  </td>
		<tr class="tr1">
		<td style="width: 80px;">Do</td>
		<td>
        <?php
          $lata=array($_POST[od_rok]);
          for ($i=1; $i<=10; ++$i)
            {
              $rok1=$_POST[od_rok]+$i;
              $rok2=$_POST[od_rok]-$i;
              array_push($lata, $rok1);
              array_unshift($lata, $rok2);
            }
					$www->SelectFromArray($lata,"do_rok", $_POST[do_rok]);
				?>
		</td>
		<td style="width: 20px;">
	  <?php
		    $www->SelectFromArray($miesiace,"do_miesiac", $_POST[do_miesiac]);
			?>
		</td>

		<td style="width: 20px;">
		    <?php
          $www->SelectFromArray($dni,"do_dzien", $_POST[do_dzien]);
		    ?>
		</td>

		<td style="width: 200px;">
        <?php
		      $rozliczona=array("Rozliczone", "Nierozliczone");
		      $www->SelectFromArray($rozliczona,"rozliczona", $_POST[rozliczona]);
		    ?>
		</td>
		<td style="width: 200px;">
	      <?php
					$order=array("Data wpłaty", "Nazwa kontrahenta", "Gotówka", "Forma wpłaty", );
					$www->SelectFromArray($order,"order", $_POST[order]);
	      ?>
	     </td>
	  <td style="width: 200px;">
        <?php
	         $ida=$www->SelectWlasc($dbh, "abon", $_POST[abon]);
	      ?>
	  </td>
	  <td style="width: 200px;">
          <input type="submit" class="button1" value="Filtruj" name="przycisk">
	  </td>
	</tr>
  </tbody>
  </table>
  </form>


  <form method="POST" action="index.php?panel=fin&menu=paymentsupdall">
  <table style="text-align: center; width: <?php echo $conf[width2];?>; height:<?php echo $conf[height2];?>" class="tbk1">
    <tbody>		
	<tr class="tr1">
      <td style="width: 90px;">
      	Id
      </td>
      <td style="width: 80px;">
      	Księgowanie Zlecenie Forma      	
      </td>
    <td style="width: 50px;">
      	Kwota
      </td>
      <td style="width: 200px;">
      	Kontrahent Abonent
    </td>
      <td style="width: 300px;">
      	Opis
      </td>
      <td style="width: 40px;">
			KP
      </td>
      <td style="width: 20px;">
			Usuń
      </td>
   </tr>
    <?php
			$payment->PaymentList($dbh, $param, $www);
    ?>
	<tr>
    	<td class="klasa1" colspan="9">
	    <input type="submit" class="button1" value="Uaktualnij >>>" name="przycisk">
	</td>
	</tr>
  </tbody>
</table>
</form>

<br/>
