#include "gen.h"
#include "conf.h"
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <math.h>
#include "libpq-fe.h"


char *q1 = "select k.id_abon, k.nazwa_smb, m.mac, ai.ip, ai2.ip, i.download, i.upload,  i.download_p2p, i.download_max, i.download_noc, i.upload_noc,  kf.dhcp, kf.ipmac, kf.net, kf.proxy, kf.dg, kf.info from ((komputery k left join konfiguracje kf on k.id_konf=kf.id_konf  ) left join (adresy_ip ai2 join podsieci pd on ai2.id_pds=pd.id_pds and pd.warstwa in ('dostep_zewn') ) on k.id_komp=ai2.id_urz) join (((adresy_ip ai join podsieci pd2 on ai.id_pds=pd2.id_pds and pd2.warstwa in ('dostep_pryw', 'dostep_publ') ) left join adresy_fizyczne m on m.ip=ai.ip) join  (taryfy_internet i join taryfy t on t.id_trf=i.id_trf and t.aktywna_od <= '2013-08-14' and t.aktywna_do >='2013-08-14') on ai.id_urz=t.id_urz ) on ai.id_urz=k.id_komp order by ai.ip";
char *q2 = "select distinct n.id_abon, n.symbol, c.mac, a.ip from (cpe c join nazwy n on c.id_abon=n.id_abon and n.wazne_od <= '2013-08-18' and n.wazne_do >= '2013-08-18') join (adresy_ip a join inst_vlanu iv on iv.id_ivn=a.id_urz ) on c.id_cpe=iv.id_wzl order by a.ip;";
char abon[200]="";

//asprintf(bufor, "AB ");
char dbcon[100] = "host=91.216.213.6 port=5432 dbname=smsk user=szmsk password=szmsk";

char writefiles [][100] = 
		{
			{NAT0		  }, // 0
			{NAT1		  }, // 1
			{NAT2		  }, // 2
			{NAT3		  }, // 3
			{NAT4		  }, // 4
			{NAT5		  }, // 5
			{NAT6		  }, // 6
			{NAT7		  }, // 7
			{NAT8	    }, // 8
			{NAT16	  }, // 9
			{NAT24	  }, // 10
			
			{HFSCD0		}, // 11
			{HFSCD1		}, // 12
			{HFSCD2		}, // 13
			{HFSCD3		}, // 14
			{HFSCD4		}, // 15
			{HFSCD5		}, // 16
			{HFSCD6		}, // 17
			{HFSCD7		}, // 18
			{HFSCD8	  }, // 19
			{HFSCD16	}, // 20
			{HFSCD24	}, // 21
			{HFSCD32	}, // 22
			
			{HFSCU0		}, // 23
			{HFSCU1		}, // 24
			{HFSCU2		}, // 25
			{HFSCU3		}, // 26
			{HFSCU4		}, // 27
			{HFSCU5		}, // 28
			{HFSCU6		}, // 29
			{HFSCU7		}, // 30

			{CNT	    }, // 31
			{DHCP		  }, // 32
			{HOSTS	  }, // 33
			{DANS		  }, // 34
			{ITF		  }, // 35
			{INFO		  }, // 36
			{INFO_OFF }, // 37

			{HFSCD0N		}, // 38
			{HFSCD1N		}, // 39
			{HFSCD2N		}, // 40
			{HFSCD3N		}, // 41
			{HFSCD4N		}, // 42
			{HFSCD5N		}, // 43
			{HFSCD6N		}, // 44
			{HFSCD7N		}, // 45
			
			{HFSCU0N		}, // 46
			{HFSCU1N		}, // 47
			{HFSCU2N		}, // 48
			{HFSCU3N		}, // 49
			{HFSCU4N		}, // 50
			{HFSCU5N		}, // 51
			{HFSCU6N		}, // 52
			{HFSCU7N		}, // 53
		};
		
char **explode(char separator, char *string)
{
    int start = 0, i, k = 1, count = 2;
    char **strarr;
    
    for (i = 0; string[i] != '\0'; i++)
        /* how many rows do we need for our array? */
        if (string[i] == separator)
            count++;
    
    /* count is at least 2 to make room for the entire string
     * and the ending NULL */
    strarr = malloc(count * sizeof(char*));

    i = 0;
    while (*string++ != '\0')
    {
        if (*string == separator)
        {
            strarr[i] = malloc(k - start + 2);

						strncpy(strarr[i], string - k + start, k - start);	
            strarr[i][k - start + 1] = '\0'; /* guarantee null termination */
            start = k+1;
            i++;
        }
        k++;
    }
    /* copy the last part of the string after the last separator */
    strarr[i] = malloc(k - start);
    strncpy(strarr[i], string - k + start, k - start - 1);
    strarr[i][k - start - 1] = '\0'; /* guarantee null termination */
    strarr[++i] = NULL;
    
    return strarr;
}

char *hostname(char *str1, char *str2)
{
		char abon[200]="";
		char **tabstr;
		
		strncat(abon,	str1, ABONLENGTH);
		strcat(abon,	"_");
		tabstr=explode(" ", str2);
		strcat(abon,	tabstr[0]);
		
		return(abon);
}
	
int main (int argc, char *argv[])
{
	Comp kmp;
	int i;
	int n=11;
	int l=2501;
	int j=10;
	int k=10;
	int run;
	
	int tmpbajt=0;
	char *argument;
	char *string;
	char **tabstr;
	
	FILE *fp, *fp1, *fp2, *active;
	FILE *fps[100];
	
	PGconn     *conn;
   conn = PQconnectdb("host=91.216.213.6 port=5432 dbname=szmsk user=szmsk password=szmsk");
  //conn = PQconnectdb(conninfo);
  PGresult *wynik, *wynik2;
  int a,b;
				
	wynik = PQexec(conn, q1);
	wynik2 = PQexec(conn, q2);
					
	if ( ( fp=fopen(ACTIVE, "r") ) == NULL ) 
		{
			active=fwopen(ACTIVE);
			fclose(active);		
			
			//////// jeden argument programu (czyli jego nazwa) ////////////
			if (argc <= 1)
				{	
					int writerozm = (sizeof writefiles / sizeof *writefiles);
					
					for ( i=0; i<writerozm; i++)
					{
						fps[i]=fwopen(writefiles[i]);	
						if ( i!= 32 && i!=33 && i!=34 )
							mkfile(fps[i]);
					}
					
					dhcp_head(fps[32]);
					dhcp_head2(BAJT_MYSLOWICE, fps[32], 10, 0);

					hfsc_head("$IF_MAN0", 1, fps[11]);
					hfsc_head("$IF_MAN1", 1, fps[12]);
					hfsc_head("$IF_MAN2", 1, fps[13]);
					hfsc_head("$IF_MAN3", 1, fps[14]);
					hfsc_head("$IF_MAN4", 1, fps[15]);					
					hfsc_head("$IF_MAN5", 1, fps[16]);
					hfsc_head("$IF_MAN6", 1, fps[17]);
					hfsc_head("$IF_MAN7", 1, fps[18]);

					hfsc_head("$IF_MAN0", 1, fps[38]);
					hfsc_head("$IF_MAN1", 1, fps[39]);
					hfsc_head("$IF_MAN2", 1, fps[40]);
					hfsc_head("$IF_MAN3", 1, fps[41]);
					hfsc_head("$IF_MAN4", 1, fps[42]);					
					hfsc_head("$IF_MAN5", 1, fps[43]);
					hfsc_head("$IF_MAN6", 1, fps[44]);
					hfsc_head("$IF_MAN7", 1, fps[45]);
					
					hfsc_head("$IF_IN0",  1, fps[23]);				
					hfsc_head("$IF_IN1",  1, fps[24]);				
					hfsc_head("$IF_IN2",  1, fps[25]);				
					hfsc_head("$IF_IN3",  1, fps[26]);				
					hfsc_head("$IF_IN4",  1, fps[27]);				
					hfsc_head("$IF_IN5",  1, fps[28]);				
					hfsc_head("$IF_IN6",  1, fps[29]);				
					hfsc_head("$IF_IN7",  1, fps[30]);
					
					hfsc_head("$IF_IN0",  1, fps[46]);				
					hfsc_head("$IF_IN1",  1, fps[47]);				
					hfsc_head("$IF_IN2",  1, fps[48]);				
					hfsc_head("$IF_IN3",  1, fps[49]);				
					hfsc_head("$IF_IN4",  1, fps[50]);				
					hfsc_head("$IF_IN5",  1, fps[51]);				
					hfsc_head("$IF_IN6",  1, fps[52]);				
					hfsc_head("$IF_IN7",  1, fps[53]);				

					hosts_head(fps[33]);

					for(a=0; a<PQntuples(wynik); a++)
					{
							strncat(abon,	PQgetvalue(wynik, a, 0), ABONLENGTH);
							strcat(abon,	"_");
							strcat(abon,	PQgetvalue(wynik, a, 1));
							
							/*
							strncat(abon,	PQgetvalue(wynik, a, 0), ABONLENGTH);
							strcat(abon,	"_");
							tabstr=explode(" ", PQgetvalue(wynik, a, 1));
							strcat(abon,	tabstr[0]);
							*/
							kmp.host=abon;
							kmp.mac=PQgetvalue(wynik, a, 2);
							kmp.ip=PQgetvalue(wynik, a, 3);
							kmp.ip_zewn=PQgetvalue(wynik, a, 4);
							kmp.download=PQgetvalue(wynik, a, 5);
							kmp.upload=PQgetvalue(wynik, a, 6);
							kmp.download_p2p=PQgetvalue(wynik, a, 7);
							kmp.download_max=PQgetvalue(wynik, a, 8);
							kmp.download_noc=PQgetvalue(wynik, a, 9);
							kmp.upload_noc=PQgetvalue(wynik, a, 10);
	
							kmp.dhcp=PQgetvalue(wynik, a, 11);
							kmp.powiaz=PQgetvalue(wynik, a, 12);
							kmp.net=PQgetvalue(wynik, a, 13);
							kmp.proxy=PQgetvalue(wynik, a, 14);
							kmp.dg=PQgetvalue(wynik, a, 15);
							kmp.info=PQgetvalue(wynik, a, 16);
							printf("\n");
							tmpbajt=gen(kmp, &n, j, k, tmpbajt, fps, "all", tmpbajt);
							strcpy(abon, "");
					}
					

					tmpbajt=BAJT_CORE;
					for(a=0; a<PQntuples(wynik2); a++)
					{
							strncat(abon,	PQgetvalue(wynik2, a, 0), ABONLENGTH);
						//	strcat(abon,	"_");
						//	strcat(abon,	PQgetvalue(wynik2, a, 1));
							strcat(abon,	"_w");
							
							
							kmp.host=abon;
							kmp.mac=PQgetvalue(wynik2, a, 2);
							kmp.ip=PQgetvalue(wynik2, a, 3);
							kmp.ip_zewn="";
							kmp.download=LANSPEED;
							kmp.upload=LANSPEED;
							kmp.download_p2p=LANSPEED;
							kmp.download_max=LANSPEED;
							kmp.download_noc=LANSPEED;
							kmp.upload_noc=LANSPEED;
	
							kmp.dhcp="T";
							kmp.powiaz="N";
							kmp.net="T";
							kmp.proxy="N";
							kmp.dg="N";
							kmp.info="N";
	//printf ("%s\t\t%s\t ip: %s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s \n", kmp.host, kmp.mac, kmp.ip, kmp.ip_zewn, kmp.download, kmp.upload, kmp.dhcp, kmp.powiaz, kmp.net, kmp.proxy, kmp.dg, kmp.info);

							tmpbajt=gen(kmp, &n, j, k, tmpbajt, fps, "all", tmpbajt);
							strcpy(abon, "");
					}
	
						dhcp_head3(fps[32]);
						//fprintf(fps[32], "} \n");
						//fprintf(fps[32], "} \n");
					
				////////////////////////////////////////////////////////////////	
					for ( i=0; i<writerozm; i++)
					{
						//printf( "Closing %s file  ... \n" , writefiles[i]);
						fclose(fps[i]);	
					}	

					system ("chmod 0774 /etc/nat/sh/*");
					system ("chmod 0774 /etc/hfsc/*");
	
					printf(" Restarting DHCP ...\n");
					//system ("/etc/rc.d/rc.dhcpd restart");
	
				//	printf("\n Reconfiguring Aliases ... \n");			
				//	system ("/etc/nat/sh/itf-users.sh");


					printf(" Reloading IPSETs ...\n");
					//system ("/etc/nat/sh/ipset.sh");

			//		printf(" Restarting NAT ...\n");
			//		system ("/etc/nat/rc.masq");

					printf("Restarting  H F S C ...\n");
					//system ("/etc/hfsc/rc.hfsc");
         
                                                         
					system ("rm /tmp/active");
					return 0;
				}
			/////////////////////////////////////////////////////////////////////////////////////	
			// dwa argumenty programu, czyli jego nazwa i parametr np. dhcp, hfsc, nat	
			else if ( argc == 2)
				{
				
					// DHCP
					if ( strcmp(argv[1], ARG1)==0  )
					{
						fps[32]=fwopen(writefiles[32]);	
						dhcp_head(fps[32]);
						dhcp_head2(BAJT_MYSLOWICE, fps[32], 10, 0);
						
						tmpbajt=BAJT_MYSLOWICE;
						for(a=0; a<PQntuples(wynik); a++)
						{
								kmp.host=PQgetvalue(wynik, a, 1);
								kmp.mac=PQgetvalue(wynik, a, 2);
								kmp.ip=PQgetvalue(wynik, a, 3);
								kmp.ip_zewn=PQgetvalue(wynik, a, 4);
								kmp.download=PQgetvalue(wynik, a, 5);
								kmp.upload=PQgetvalue(wynik, a, 6);
								kmp.download_p2p=PQgetvalue(wynik, a, 7);
								kmp.download_max=PQgetvalue(wynik, a, 8);
								kmp.download_noc=PQgetvalue(wynik, a, 9);
								kmp.upload_noc=PQgetvalue(wynik, a, 10);
		
								kmp.dhcp=PQgetvalue(wynik, a, 11);
								kmp.powiaz=PQgetvalue(wynik, a, 12);
								kmp.net=PQgetvalue(wynik, a, 13);
								kmp.proxy=PQgetvalue(wynik, a, 14);
								kmp.dg=PQgetvalue(wynik, a, 15);
								kmp.info=PQgetvalue(wynik, a, 16);
								printf("\n");
								tmpbajt=gen(kmp, &n, j, k, tmpbajt, fps, ARG1, tmpbajt);
						}
						
						
						tmpbajt=BAJT_CORE;
						for(a=0; a<PQntuples(wynik2); a++)
						{

								kmp.host=PQgetvalue(wynik2, a, 1);
								kmp.mac=PQgetvalue(wynik2, a, 2);
								kmp.ip=PQgetvalue(wynik2, a, 3);
								kmp.ip_zewn="";
								kmp.download=LANSPEED;
								kmp.upload=LANSPEED;
								kmp.download_p2p=LANSPEED;
								kmp.download_max=LANSPEED;
								kmp.download_noc=LANSPEED;
								kmp.upload_noc=LANSPEED;
		
								kmp.dhcp="T";
								kmp.powiaz="N";
								kmp.net="T";
								kmp.proxy="N";
								kmp.dg="N";
								kmp.info="N";
		//printf ("%s\t\t%s\t ip: %s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s \n", kmp.host, kmp.mac, kmp.ip, kmp.ip_zewn, kmp.download, kmp.upload, kmp.dhcp, kmp.powiaz, kmp.net, kmp.proxy, kmp.dg, kmp.info);

								tmpbajt=gen(kmp, &n, j, k, tmpbajt, fps, "all", tmpbajt);
						}
							
						dhcp_head3(fps[32]);
						//fprintf(fps[32], "} \n");
						//fprintf(fps[32], "} \n");
						fclose(fps[32]);
		
						system ("rm /tmp/active");
						
						printf(" Restarting DHCP ...\n");
					//	system ("/etc/rc.d/rc.dhcpd restart");
						return 0;

					}	
					
					// HFSC
					else if ( strcmp(argv[1], ARG2)==0  )
					{
							for ( i=11; i<=30; i++)
							{
								fps[i]=fwopen(writefiles[i]);	
								mkfile(fps[i]);
							}
							for ( i=38; i<=53; i++)
							{
								fps[i]=fwopen(writefiles[i]);	
								mkfile(fps[i]);
							}
							
					hfsc_head("$IF_MAN0", 1, fps[11]);
					hfsc_head("$IF_MAN1", 1, fps[12]);
					hfsc_head("$IF_MAN2", 1, fps[13]);
					hfsc_head("$IF_MAN3", 1, fps[14]);
					hfsc_head("$IF_MAN4", 1, fps[15]);					
					hfsc_head("$IF_MAN5", 1, fps[16]);
					hfsc_head("$IF_MAN6", 1, fps[17]);
					hfsc_head("$IF_MAN7", 1, fps[18]);

					hfsc_head("$IF_MAN0", 1, fps[38]);
					hfsc_head("$IF_MAN1", 1, fps[39]);
					hfsc_head("$IF_MAN2", 1, fps[40]);
					hfsc_head("$IF_MAN3", 1, fps[41]);
					hfsc_head("$IF_MAN4", 1, fps[42]);					
					hfsc_head("$IF_MAN5", 1, fps[43]);
					hfsc_head("$IF_MAN6", 1, fps[44]);
					hfsc_head("$IF_MAN7", 1, fps[45]);
					
					hfsc_head("$IF_IN0",  1, fps[23]);				
					hfsc_head("$IF_IN1",  1, fps[24]);				
					hfsc_head("$IF_IN2",  1, fps[25]);				
					hfsc_head("$IF_IN3",  1, fps[26]);				
					hfsc_head("$IF_IN4",  1, fps[27]);				
					hfsc_head("$IF_IN5",  1, fps[28]);				
					hfsc_head("$IF_IN6",  1, fps[29]);				
					hfsc_head("$IF_IN7",  1, fps[30]);
					
					hfsc_head("$IF_IN0",  1, fps[46]);				
					hfsc_head("$IF_IN1",  1, fps[47]);				
					hfsc_head("$IF_IN2",  1, fps[48]);				
					hfsc_head("$IF_IN3",  1, fps[49]);				
					hfsc_head("$IF_IN4",  1, fps[50]);				
					hfsc_head("$IF_IN5",  1, fps[51]);				
					hfsc_head("$IF_IN6",  1, fps[52]);				
					hfsc_head("$IF_IN7",  1, fps[53]);				

							
						tmpbajt=BAJT_MYSLOWICE;
						for(a=0; a<PQntuples(wynik); a++)
						{

								kmp.host=PQgetvalue(wynik, a, 1);
								kmp.mac=PQgetvalue(wynik, a, 2);
								kmp.ip=PQgetvalue(wynik, a, 3);
								kmp.ip_zewn=PQgetvalue(wynik, a, 4);
								kmp.download=PQgetvalue(wynik, a, 5);
								kmp.upload=PQgetvalue(wynik, a, 6);
								kmp.download_p2p=PQgetvalue(wynik, a, 7);
								kmp.download_max=PQgetvalue(wynik, a, 8);
								kmp.download_noc=PQgetvalue(wynik, a, 9);
								kmp.upload_noc=PQgetvalue(wynik, a, 10);
		
								kmp.dhcp=PQgetvalue(wynik, a, 11);
								kmp.powiaz=PQgetvalue(wynik, a, 12);
								kmp.net=PQgetvalue(wynik, a, 13);
								kmp.proxy=PQgetvalue(wynik, a, 14);
								kmp.dg=PQgetvalue(wynik, a, 15);
								kmp.info=PQgetvalue(wynik, a, 16);
								printf("\n");
								tmpbajt=gen(kmp, &n, j, k, tmpbajt, fps, ARG2, tmpbajt);
						}
			
						////////////////////////////////////////////////////////////////	
							for ( i=11; i<=30; i++)
							{
								//printf( "Closing %s file  ... \n" , writefiles[i]);
								fclose(fps[i]);	
							}	
							for ( i=38; i<=53; i++)
							{
								fclose(fps[i]);	
							}
							system ("chmod 0744 /etc/hfsc/*");

							printf("Restarting  H F S C ...\n");
							//system ("/etc/hfsc/rc.hfsc");
							
							system ("rm /tmp/active");
							return 0;
					}	

					else if ( strcmp(argv[1], ARG3)==0  )
					{
						printf("\n Not implemented yet. It will be written in free time :-) \n\n");
						system ("rm /tmp/active");
						exit(1);						
					}	

					else 
						{
							printf("\n Dozwolone argumenty :");
							printf("\n dhcp, hfsc, nat \n\n");
							system ("rm /tmp/active");
							exit(1);
						}	
	
				}
			else 
				{
					printf("\n Dozwolone argumenty :");
					printf("\n dhcp, hfsc, nat \n\n");
					system ("rm /tmp/active");
					exit(1);
				}	
		}
	else 
		{ 			
			printf("\n Jest juz uruchomiona jedna instancja generatora.");
			printf("\n Czekaj az zostanie zakonczona. \n\n");
			exit(1);
		}
		
		
    PQclear(wynik);									
    PQclear(wynik2);
    PQfinish(conn);
    return 0;
}


