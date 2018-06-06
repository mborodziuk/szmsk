<?php
        if ( empty($_POST[od_rok]) && empty($_POST[od_miesiac]) && empty($_POST[od_dzien]) )
            {
            $_POST[od_rok]=date("Y",  strtotime("-1 Months") );
            $_POST[od_miesiac]=date("m", strtotime("-1 Months") );
            $_POST[od_dzien]=date("01");
            }
        if ( empty($_POST[do_rok]) && empty($_POST[do_miesiac]) && empty($_POST[do_dzien]) )
            {
            $_POST[do_rok]=date("Y", strtotime("+1 Months") );
            $_POST[do_miesiac]=date("m", strtotime("+1 Months") );
            $_POST[do_dzien]=date("d");
            }

 $p=array(
			'umowa' 		=> $_POST[umowa],		'nazwa'	=> $_POST[nazwa],		'ulice'	=> $_POST[ulice],
			'budynki'	=> $_POST[budynki],	'saldo' 	=> $_POST[saldo],		'miasto' => $_POST[miasto],
			'data_od'	=> "$_POST[od_rok]"."-"."$_POST[od_miesiac]"."-"."$_POST[od_dzien]",
			'data_do'	=> "$_POST[do_rok]"."-"."$_POST[do_miesiac]"."-"."$_POST[do_dzien]",
			'usluga'	=> $_POST[usluga], 'nowi' => $_POST[nowi]
 			);
 
	if (empty($p[umowa]))
		$p[umowa]='obowiązująca';

	if (empty($p[nazwa]))
		$p[nazwa]=$conf[select];
	
	
	if ( !isset($p[usluga]) )
		$p[usluga]="Internet";
	
foreach ($p as $k => $v)
	{
		if ( !isset($p[$k]) )
			$p[$k]=$conf[select];
	}
			
	?>

<a href="index.php?panel=inst&menu=dodajabon">Nowy abonent</a> &nbsp;
<a href="javascript&#058;displayWindow('pdf/mkpdf.php?dok=msm&data_od=<?php echo $p[data_od] ?>&data_do=<?php echo $p[data_do]?>',1100,800, '38')">
Lista dla MSM </a> &nbsp;
<a href="index.php?panel=inst&menu=konwertujabon">Konw</a> &nbsp;

<br/>
<br/>

<form method="POST" action="index.php?panel=inst&menu=abonenci">
<table style="text-align: center; width: <?php echo $conf[width2];?>; height:<?php echo $conf[height2];?>" class="tbk1">
  <tbody>
    <tr class="tr1">
       <td style="width: 200px;">
           Um. 
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
       <td> Abon./Um. </td>
        <td style="width: 150px;">
              <?php
               $umowa=array($conf[select],"obowiązująca", "rozwiązana", "zawieszona","windykowana", "czas nieokreślony", "czas określony", "brak umowy","oczekujący","Zainteresowany");
                $www->SelectFromArray($umowa,"umowa", $p[umowa]);
            ?>
         </td>
	<td>Nazwa</td>
             <td style="width: 150px;">
               
							 
							 					<input size="30" name="nazwa" value ="<?php echo "$p[nazwa]"; ?>">

          </td>
                                                                                         
       <td> Saldo </td>
       <td>  	        <?php
	         $saldo=array($conf[select],"< -200","-150 do -100","-100 do 0", "0", "0 do 100", "100 do 200","> 200" );
	         $www->SelectFromArray($saldo,"saldo", $p[saldo]);
	        ?> </td>
								 <td><input type="checkbox" name="nowi"/></td>
	</tr>
	<tr class="tr1">
		<td style="width: 80px;"> od do</td>
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
	     <td style="width: 150px;">
	     Miasto
             </td>
	     <td style="width: 150px;">
                <?php
                $q="select distinct miasto from ulice order by miasto";
                Select($q, "miasto", $p[miasto], $conf[select]);
                ?>
                                                                                                 
	     </td>
	     <td>Ulica</td>
	     <td style="width: 150px;">
	        <?php
				$q="select nazwa from ulice order by nazwa";
    			Select($q, "ulice", $p[ulice], $conf[select]);
	        ?>
	      </td>
	      <td>Nr budynku</td>
	     <td style="width: 70px;">
	        <?php
				$q="select distinct numer from budynki order by numer";
    			Select($q, "budynki", $p[budynki], $conf[select]);
	        ?>
	      </td>
				<td></td>
	     </tr>
	     <tr class="tr1">
       <td> Internet </td>
       <td> <input type="radio" name="usluga" value="Internet" 	<?php $ch=($p[usluga]=="Internet" ? "checked" : ""); echo $ch;?> /> </td>
       <td> VoIP </td>
       <td> <input type="radio" name="usluga" value="VoIP" 			<?php $ch=($p[usluga]=="VoIP" ? "checked" : ""); echo $ch;?>/> </td>
       <td> IpTV </td>
       <td> <input type="radio" name="usluga" value="IpTV" 			<?php $ch=($p[usluga]=="IpTV" ? "checked" : ""); echo $ch;?>/> </td>                      
	     <td> Serwis </td>
	     <td> <input type="radio" name="usluga" value="Serwis" 		<?php $ch=($p[usluga]=="Serwis" ? "checked" : ""); echo $ch;?>/> </td>
	     <td> Wirtualni </td>
	     <td> <input type="radio" name="usluga" value="Wirtualni" 		<?php $ch=($p[usluga]=="Wirtualni" ? "checked" : ""); echo $ch;?>/> </td>	   	<td style="width: 200px;">
          <input type="submit" class="button1" value="Filtruj" name="przycisk">
	      </td>
	</tr>
	
  </tbody>
  </table>
  </form>

<form method="POST" action="index.php?panel=fin&menu=zastosuj_abon">
<?php
$_SESSION[del1]=array('umowy_abonenckie'=>'id_abon', 'abonenci'=>'id_abon','telefony'=>'id_podm', 'maile'=>'id_podm', 'kontakty'=>'id_podm');
$_SESSION[del2]=array('telefony' => 'id_podm', 'maile'=>'id_podm', 'adresy_siedzib' => 'id_abon', 'nazwy' => 'id_abon');
?>
<table class="tbk1" style="text-align: left; width: <?php echo $conf[width2];?>; height:<?php echo $conf[height2];?>;">
  <tbody>
    <tr class="tr1">
		      <td style="width: 3%;">
			Lp.
      </td>
      <td style="width: 5%;">
      	Id
      </td>
      <td style="width: 28%;">
      	Imię i nazwisko <br> (nazwa)
       </td>
      <td style="width: 20%;">
      	Adres instalacji
      </td>
      <td style="width: 20%; ">
      	Dane kontaktowe
      </td>
      <td style="width: 10%;">
 	Il. usł.
      </td>
      <td style="width: 5%;">
	  Saldo
      </td>
		<?php
			if ( 	$_SESSION[uprawnienia]=='fin' || $_SESSION[uprawnienia]=='admin' )
			{
				echo <<<KW
	<td style="width: 3%;">
			K
      </td>
      <td style="width: 3%;">
			W
      </td>
      <td style="width: 3%;">
			P
      </td>
KW;
}
			?>
    </tr>
    <?php
    $customers->ListaAbonentow($dbh, $p);
	?>
	<tr>
		<td class="klasa1" colspan="10">
				<input type="submit" class="button1" value="Zastosuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>