#!/usr/bin/perl -w
use HTML::FormatText 2;
require "/home/szmsk/perl/config.h.pl";


sub IncValue
{
    @id=split(/\//, $_[0]);
    $nr=$id[1];
    ++$nr;
    if ($nr < 10)
	{
	$id[1]="00$nr";
	}
    elsif ( $nr<100 && $nr>9)
	{
	$id[1]="0$nr";
	}
    
    $wyj="$id[0]/$nr/$id[2]/$id[3]";
    return $wyj;
}

													
sub konwertuj
{
  %pl=( '±' => 'a', 'æ' => 'c', 'ê' => 'e', '³' => 'l', 'ñ' => 'n', 
		'ó' => 'o', '¶' => 's', '¿' => 'z', '¼' => 'z' );
	 	 
  $nazwapl=$_[0];
  foreach $i (keys %pl) 
  {    	 
	$nazwapl =~ s/$i/$pl{$i}/gi;
  }
  return $nazwapl;
}


sub update
{

    $Q5="update wplaty set id_kontrah='$_[1]', rozliczona='T' where opis='$_[2]'";
    $sth5=$_[0]->prepare($Q5);
    $sth5->execute();									

    $Q6="update abonenci set saldo=saldo+$_[3] where id_abon='$_[1]'";
    print "$Q6 \n";
    $sth6=$_[0]->prepare($Q6);
    $sth6->execute();
}


######################################

$dbh = DBI->connect("dbi:$DBTYPE:dbname=$DBNAME;host=$HOST", $USER, $PASS) || die "Nie mozna nawiazac polaczeni z baz± danych !!!";

@plik=split(/-/, $ARGV[0]);
$str1=substr($plik[2], 0, -4);
$str2=substr($plik[1], 2, 3);
$Q="select * from wplaty where id_wpl like 'WPL/%/$str1/$str2'";

print "======= $Q \n";

$sth=$dbh->prepare($Q);
$sth->execute();	    

@roww = $sth->fetchrow_array();

if ( @roww==null )
{
print "--------------------------------------------------------------";
    open(PLIK, $ARGV[0]) || die "Nie mozna otworzyc pliku";
    $id_wpl="WPL/000/$str1/$str2";
    $id_wyp="WYP/000/$str1/$str2";
    while ($row = <PLIK>)
    {
    if ($row =~/^<tr><td>\d+/ )
        {
	print "      $row \n";
	@wpl = split(/<\/td><td>/, $row); 
	print @wpl;
	$kwota=substr($wpl[4], 1, length($wpl[4]));   
	$opis=$wpl[7];
	if ( $wpl[4] > 0)
	    {
	    $id_wpl=IncValue($id_wpl);
	    $Q1="insert into WPLATY values ('$id_wpl', '$wpl[1]','$wpl[2]', 'przelew', $kwota, '$wpl[5]', NULL, '$opis')";
	    }
	elsif ( $wpl[4] <0)
	    {
	    $id_wyp=IncValue($id_wyp);
	    $Q1="insert into WYPLATY values ('$id_wyp', '$wpl[1]','$wpl[2]', 'przelew', $kwota, '$wpl[5]', NULL, '$opis')";
	    }

	#print "....$Q1 \n";
	$sth=$dbh->prepare($Q1);
	$sth->execute();						
        }
    }	
    close PLIK;

    $lp=0;
    $Q2="select distinct a.id_abon, a.nazwa,  u.nazwa, b.numer, a.nr_mieszk from abonenci a, budynki b, ulice u , umowy_abonenckie um 
	 where a.id_bud=b.id_bud and u.id_ul=b.id_ul and um.id_abon=a.id_abon and um.status='Obowi±zuj±ca' order by a.nazwa";
    $Q3="select opis, kwota, rozliczona from wplaty where rozliczona='N'";

    $sth2=$dbh->prepare($Q2);
    $sth2->execute();
    while (@row2 = $sth2->fetchrow_array() )
    {    
	@nazwa=split(" ", $row2[1] );

	$imie=$nazwa[1];
	$imiepl=&konwertuj($nazwa[1]);
	$nazwisko=$nazwiskom=$nazwiskok=$nazwa[0];
	$nazwiskopl=&konwertuj($nazwa[0]);
	$nazw_koncowka=substr($nazwisko, -2,2);
	if ($nazw_koncowka eq "ki")
	  {
		substr($nazwiskok,-1)="a";
	  }
	elsif ($nazw_koncowka eq "ka")
	  {
		 substr($nazwiskom, -1)="i";
	  }
	$ulica=$row2[2];
	$ulicapl=&konwertuj($row2[2]);
	$bud=$row2[3];
	$mieszk=$row2[4];
	
#	print "$row2[1] ********* $imie $nazwisko\n";
	$sth3=$dbh->prepare($Q3);
	$sth3->execute();

	while (@row3 = $sth3->fetchrow_array() )
	{
#	    if ( $row3[0] =~ /^($nazwisko|$nazwiskopl)/i )
	    if ( $row3[0] =~ /($nazwisko|$nazwiskopl|$nazwiskom|$nazwiskok)/i )
	    {
		  $Q4="select count(nazwa) from abonenci where nazwa like '%$nazwisko %' \n";
		  $sth4=$dbh->prepare($Q4);
		  $sth4->execute();
		  @row4= $sth4->fetchrow_array();
		  if ( $row4[0] > 1)	  
			{
			  if ( $row3[0] =~ /($ulica|$ulicapl)*$bud*$mieszk/i)
			  {
			   ++$lp;
			   print "$lp. ||| $nazwisko $imie \n";
                    	    &update($dbh, $row2[0], $row3[0], $row3[1]);			   										   
			  }
			  elsif ( $row3[0] =~ /($imie|$imiepl)/i)
			  {
			    ++$lp;
        		    print "$lp. ||| $nazwisko $imie \n";
	                    &update($dbh, $row2[0], $row3[0], $row3[1]);
			    }
			}
		  elsif ( $row4[0] == 1)
			{
			++$lp;
	  		print "$lp. $nazwisko |$nazwiskok $nazwiskom| $imie \n";
			&update($dbh, $row2[0], $row3[0], $row3[1]);
			}
	    }
		#else { print "------------------$nazwisko $nazwiskok $nazwiskom \n";}
	}
    }
}

else
    {
    print "Plik juz zostal przetworzony";
    }
