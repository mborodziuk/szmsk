#include "libpq-fe.h"
#include <stdlib.h>

char sql[1000] = "select k.id_abon, k.nazwa_smb, m.mac, ai.ip, ai2.ip, i.download, i.upload,  i.download_p2p, i.download_max, i.download_noc, i.upload_noc,  kf.dhcp, kf.ipmac, kf.net, kf.proxy, kf.dg, kf.info from ((komputery k left join konfiguracje kf on k.id_konf=kf.id_konf  ) left join (adresy_ip ai2 join podsieci pd on ai2.id_pds=pd.id_pds and pd.warstwa in ('dostep_zewn') ) on k.id_komp=ai2.id_urz) join (((adresy_ip ai join podsieci pd2 on ai.id_pds=pd2.id_pds and pd2.warstwa in ('dostep_pryw', 'dostep_publ') ) left join adresy_fizyczne m on m.ip=ai.ip) join  (taryfy_internet i join taryfy t on t.id_trf=i.id_trf and t.aktywna_od <= '2013-08-14' and t.aktywna_do >='2013-08-14') on ai.id_urz=t.id_urz ) on ai.id_urz=k.id_komp order by ai.ip";

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
