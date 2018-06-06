#include "libpq-fe.h"
#include <stdlib.h>

char sql[500] = "select nazwa_smb from komputery order by id_komp;";

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
