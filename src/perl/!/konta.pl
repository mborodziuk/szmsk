#!/usr/bin/perl -w
use DBI; 

$PATH="/home/mail";

$DBTYPE="Pg";
$USER="szmsk";
$PASS="szmsk";
$HOST="localhost";
$DBNAME="szmsk";

$Q1="select k.login, k.login_old, k.haslo, k.aktywne, g.antywir, g.antyspam, a.nazwa
     from konta k, abonenci a, grupy g where k.id_abon=a.id_abon and k.id_gr=g.id_gr";


# usuwa biale znaki
sub trim
{
    my $string = shift;
    $string =~ s/^\s+//;
    $string =~ s/\s+$//;
    return $string;
}																																																																		 


sub AddAccount
{

   print "Dodaje konto : $_[0] \n";
    #system("mkdir $PATH/$_[0]");
    #system("useradd -d $PATH/$_[0] -g email -s /bin/false $_[0]");
    #system("/var/qmail/bin/maildirmake $PATH/$_[0]/Maildir");
    #system("chown -R $_[0] $PATH/$_[0]");		    
    #system("echo $_[0]:$_[1] | chpasswd");
}

sub DeleteAccount
{

    print "Usuwam konto: $_[0] \n";
    #system ("userdel $_[0]");
    #system ("rm -r $PATH/$_[0]");
}

sub BlockAccount
{
    #system("chmod 000 $PATH/$_[0]");
}


sub RenameAccount
{
    #system("mv $PATH/$_[0] $PATH/$_[1]");
    #system("userdel $_[0]");
    #system("useradd -d $PATH/$_[1] -g email -s /bin/false $_[1]");
    #system("chown -R $_[1] $PATH/$_[1]");
    #system("echo $_[1]:$_[2] | chpasswd");
}

sub search
{
    $flag=0;
    foreach $i ( @{$_[0]} )
    {
	if ( "$i" eq "$_[1]" )
	    {
		$flag=1;
		last;
	    }
    }
    return $flag;
}						    	

#--------------------------------------------------------------------------------------------------------------------------------------------------#

@konta1=();
@konta2=();
opendir(DIR, $PATH);
@files= grep {!/^\./ } readdir(DIR);
closedir(DIR);

$dbh = DBI->connect("dbi:$DBTYPE:dbname=$DBNAME;host=$HOST", $USER, $PASS);
$sth=$dbh->prepare($Q1);
$sth->execute();
while (@row = $sth->fetchrow_array() )
    {
	push(@konta1, $row[0]);
	print "$row[0] $row[1] $row[2] $row[3] $row[4] $row[5] \n";
	if("$row[3]" eq "N")
	{
	    &BlockAccount($row[0]);
	}
	if ( &search(\@files, $row[0])==0 )		
	{				
    	    if ( &search(\@files, $row[1])==0 )
		{
		    &AddAccount( $row[0], $row[2]);
		}
	    else {
		    &RenameAccount($row[0], $row[1], $row[2]);	
		}
	}
	else
	{
	    #system("echo $row[0]:$row[2] | chpasswd");
	}
			    
    }

foreach $i (@files)
{
    if (&search(\@konta1, $i)==0)
    {
	&DeleteAccount($i);
    }
}
