<?php
	
	if(empty($_POST))
		$_POST=$_SESSION[$session[windykacja][pagination]];
		
		
        if ( empty($_POST[od_rok]) && empty($_POST[od_miesiac]) && empty($_POST[od_dzien]) )
            {
            $_POST[od_rok]=date("2008");
            $_POST[od_miesiac]="01";
            $_POST[od_dzien]=date("01");
            }
        if ( empty($_POST[do_rok]) && empty($_POST[do_miesiac]) && empty($_POST[do_dzien]) )
            {
            $_POST[do_rok]=date("Y");
            $_POST[do_miesiac]=date("m");
            $_POST[do_dzien]=date("d");
            }
	
	$p=array(
			'krok' 		=> $_POST[krok],		'nazwa'	=> $_POST[nazwa],		'ulice'	=> $_POST[ulice], 'typ'=>$_POST[typ],
			'budynki'	=> $_POST[budynki],	'saldo' 	=> $_POST[saldo],		'miasto' => $_POST[miasto],
			'data_od'	=> "$_POST[od_rok]"."-"."$_POST[od_miesiac]"."-"."$_POST[od_dzien]",
			'data_do'	=> "$_POST[do_rok]"."-"."$_POST[do_miesiac]"."-"."$_POST[do_dzien]",
 			);

	
	if (empty($p[krok]))
	$p[krok]='obserwacja';
	
	if (empty($p[typ]))
					$p[typ]='niezwindykowane';
	
//echo $p[typ];
	
	foreach ($p as $k => $v)
	{
		if ( !isset($p[$k]) )
			$p[$k]=$conf[select];
	}
	
	$m=$_POST[do_miesiac];
	$y=$_POST[do_rok];
	$yb=$y-1;

	$miesiac=array( 
	1=>"I<br>$y", 2=>"II<br>$y", 3=>"III<br>$y", 4=>"IV<br>$y", 5=>"V<br>$y", 6=>"VI<br>$y", 7=>"VII<br>$y", 8=>"VIII<br>$y", 9=>"IX<br>$y", 10=>"X<br>$y", 11=>"XI<br>$y", 12=>"XII<br>$y", 
  0=>"XII<br>$yb", -1=>"XI<br>$yb", -2=>"X<br>$yb", -3=>"IX<br>$yb", -4=>"VIII<br>$yb", -5=>"VII<br>$yb", -6=>"VI<br>$yb", -7=>"V<br>$yb", -8=>"IV<br>$yb", -9=>"III<br>$yb", -10=>"II<br>$yb", -11=>"I<br>$yb" );
	
	$_SESSION['windyk']=$p;
	
			$q2="select d.nr_ds, t.cena, d.term_plat, d.data_wyst from towary_sprzedaz t, pozycje_sprzedaz p, dokumenty_sprzedaz d  where t.id_tows=p.id_tows and d.nr_ds=p.nr_ds 
			and d.id_odb='ABON0986' order by d.data_wyst desc";


			


			

	?>
					<a href="#" onclick="window.open('nowa_strona.htm', 'Nowe_okno','height=150,width=200');">Otwórz male okienko</a>

<a href="javascript&#058;displayWindow('pdf/mkpdf.php?dok=zwz3&krok=<?php echo $p[krok] ?>',800,800, '38')">
Zestawienie WDZ</a> &nbsp;

<a href="javascript&#058;displayWindow('pdf/mkpdf.php?dok=rspw&data_od=
<?php echo $p[data_od] ?>&data_do=<?php echo $p[data_do] ?>',1100,800, '38')">
Raport o zadłużeniach</a> &nbsp;

<a href="index.php?panel=fin&menu=automate"> Automatyzuj </a> &nbsp;
<a href="index.php?panel=fin&menu=addnewwindyk"> Dodaj nowych </a> &nbsp;

<form method="POST" action="index.php?panel=fin&menu=windykacja">
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
       <td> Krok </td>
        <td style="width: 150px;">
              <?php
               $krok=$conf[kroki];
							 $www->SelectFromArray($krok,"krok", $p[krok]);
            ?>
         </td>
	<td> Zadłużenia</td>
        <td style="width: 150px;">
              <?php
               $typ=array($conf[select],"zwindykowane", "niezwindykowane");
                $www->SelectFromArray($typ,"typ", $p[typ]);
            ?>
         </td>	                                                                                       
       <td> Nazwa</td>
          <td style="width: 150px;">
               <?php
                $nazwa=array($conf[select],A, Ą, B, C, Ć, D, E, Ę, F, G, H, I, J , K, L ,Ł, M, N, Ń, O , P, R, S, Ś, T, U, W, X, Y, Z, Ż, Ź);
             $www->SelectFromArray($nazwa,"nazwa", $p[nazwa]);
             ?>
          </td>
     
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
	     </tr>
	     <tr class="tr1">
         <td> </td>
                  <td> </td>
                  <td> </td>
                  <td> </td>
                  <td> </td>
                  <td> </td>
                <td>Saldo</td>                                                                                       
	     <td style="width: 70px;">
	        <?php
	         $saldo=array($conf[select],"< -200","-150 do -100","-100 do 0", "0", "0 do 100", "100 do 200","> 200" );
	         $www->SelectFromArray($saldo,"saldo", $p[saldo]);
	        ?>
	      </td>
	      <td></td>
	   	<td style="width: 200px;">
          <input type="submit" value="Filtruj" class="button1" name="przycisk">
	      </td>
	</tr>
	
  </tbody>
  </table>
  </form>

<form method="POST" action="index.php?panel=fin&menu=zastosuj_windyk">
<?php
$_SESSION[krok]=$p[krok];
?>
<table class="tbk1" style="text-align: center; width: <?php echo $conf[width2];?>; height:<?php echo $conf[height2];?>">
  <tbody>
    <tr class="tr1">
		  <td style="width: 10px;">
			Lp.
      </td>
      <td style="width: 20px;">
      	Id
      </td>
      <td style="width: 235px;">
      	Imię i nazwisko <br> (nazwa)
       </td>
      <td style="width: 20px;">
      	Saldo
      </td>
 <?php
	$start=$m-12;
	$l=$start;
	while ($l<=$m)
{
	echo "<td style=\"width: 15px;\"> $miesiac[$l]</td>";
	$l++;
} 

?>
			<td style="width: 10px;">
			Krok
      </td>
      <td style="width: 10px;">
			K
      </td>
      <td style="width: 30px; ">
      	Pon
      </td>
      <td style="width: 30px; ">
      	Pis
      </td>			
      <td style="width: 30px; ">
      	Krd
      </td>			
      <td style="width: 30px; ">
      	Sąd
      </td>			
    </tr>
    <?php
   $windykacja->ListaWindykowanych($dbh, $_SESSION['windyk'], $www);
	?>
	<tr class="tr1">
		<td class="klasa1" colspan="25">
				<input type="submit" class="button1" value="Zastosuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>