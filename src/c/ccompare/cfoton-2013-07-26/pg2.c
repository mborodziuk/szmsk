#include "libpq-fe.h"
#include <stdlib.h>

char sql[500] = "select k.nazwa_smb, m.mac, i.ip, iz.ip, t.download, t.upload , tt.download as download_lan, tt.upload as upload_lan,f.dhcp, f.ipmac, f.net, f.proxy, f.dg, f.info \
from \
( (adresy_ip_zewn iz full join adresy_ip i on iz.id_urz=i.id_urz ) join adresy_fizyczne m on  m.ip=i.ip ) \
join \
( ((komputery k join konfiguracje f on k.id_konf=f.id_konf ) full join taryfy_internet t on t.id_tows=k.id_taryfy ) join taryfy_internet tt on tt.id_taryfy=k.id_taryfylan) \
on k.id_komp=i.id_urz order by i.ip;";

char dbcon[100] = "host=91.216.213.6 port=5432 dbname=smsk user=szmsk password=szmsk";

int main()
{
    PGconn     *conn;
    conn = PQconnectdb("host=91.216.213.6 port=5432 dbname=szmsk user=szmsk password=szmsk");
//    conn = PQconnectdb(dbcon);
    PGresult *wynik;
    int i,j;
				
    wynik = PQexec(conn, sql);
    					
    for(i=0;i<PQntuples(wynik);i++)
    {
        for(j=0;j<PQnfields(wynik);j++)
            printf("%-20s",PQgetvalue(wynik,i,j));
            printf("\n");
    }

    PQclear(wynik);									
    PQfinish(conn);
    return 0;
}
