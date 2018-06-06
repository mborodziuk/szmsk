#!/usr/bin/php -q

<?php
include "../public_html/func/config.php";
include "../public_html/func/szmsk.php";
include "../public_html/www/www.php";
include "../public_html/szmsk/szmsk.php";
include "../public_html/func/config.php";


$dbh=DBConnect($DBNAME1);

$table="wmrodz";

// include class file
include("Unserializer.php");
$xml="WMRODZ.xml";
#$xml="SIMC.xml";
#$xml="ULIC.xml";

// tell the unserializer to create an object
$options = array("complexType" => "object");
   
// create object
$unserializer = new XML_Unserializer($options);
    
// unserialize the document
#$result = $unserializer->unserialize($xml, true );    
     
// dump the result
//print_r($unserializer->getUnserializedData());
$unserializer->unserialize($xml, true);
$rekordy = $unserializer->getUnserializedData();
echo "element glowny kodu XML: <b>";
echo $unserializer->getRootName();
echo "</B><br>\n";

#print_r($rekordy);
#if(is_array($rekordy->catalog->row) === false){ print("<br>To nie jest tablica<br>");}
$ile = count($rekordy->catalog->row);
echo "<br>Ilosc rekordow: $ile\n";

echo "<br>Listing:<br>\n";
for ($i=0;$i<count($rekordy->catalog->row); ++$i)
{
        print($i." : ");
        print($rekordy->catalog->row[$i]->col[0]." : ");
        print($rekordy->catalog->row[$i]->col[1]." : ");
        print($rekordy->catalog->row[$i]->col[2]."<br>\n");

	
							$rm=$rekordy->catalog->row[$i]->col[0];
				$nazwa_rm=$rekordy->catalog->row[$i]->col[1];
				 $stan_na=$rekordy->catalog->row[$i]->col[2];

				$query = "insert into $table (rm, nazwa_rm, stan_na) 
				values ('$rm', '$nazwa_rm', '$stan_na')";
	
	print "$query \n";
	Query($dbh, $query);

}
return 0;
?>
