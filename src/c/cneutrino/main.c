#include "gen.h"
#include "conf.h"
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <math.h>

char genfiles [][100] = 
		{
		        {"/etc/nat/cfg.oswiecim.5ghz-26"},            
                        {"/etc/nat/cfg.oswiecim.5ghz-27"},
                        {"/etc/nat/cfg.oswiecim.5ghz-28"},
			{"/etc/nat/cfg.oswiecim.5ghz-29"},
			{"/etc/nat/cfg.oswiecim.5ghz-30"},
		
			{"/etc/nat/cfg.oswiecim.zasole.garbarska.24ghz.1"},
			{"/etc/nat/cfg.oswiecim.5ghz-29.mt"},
			{"/etc/nat/cfg.oswiecim.5ghz-30.mt"},
                        {"/etc/nat/cfg.oswiecim.publ.30.mt"},
                        {"/etc/nat/cfg.oswiecim.publ.29.mt"},
	                {"/etc/nat/cfg.oswiecim.wezly.dystrybucja"},
                        {"/etc/nat/cfg.oswiecim.wezly.dostep"},
                        {"/etc/nat/cfg.oswiecim.wezly.rdzen"},
                                                                                                
                        {"/etc/nat/cfg.oswiecim.publ.30"},
                        {"/etc/nat/cfg.oswiecim.publ.29"},                                                
			};

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
		};



		
int main (int argc, char *argv[])
{
	
	int i;
	int n=11;
	int l=2501;
	int j=10;
	int k=10;
	int run;
	
	int tmpbajt=0;
	char *argument;
	
	FILE *fp, *fp1, *fp2, *active;
	FILE *fps[100];

		
	if ( ( fp=fopen(ACTIVE, "r") ) == NULL ) 
		{
			active=fwopen(ACTIVE);
			fclose(active);		
			int genrozm = (sizeof genfiles / sizeof *genfiles);
		
			// jeden argument programu (czyli jego nazwa)
			if (argc <= 1)
				{		
					int writerozm = (sizeof writefiles / sizeof *writefiles);
					
					for ( i=0; i<writerozm; i++)
					{
						fps[i]=fwopen(writefiles[i]);	
						if ( i!= 32 && i!=33 && i!=34 && i!=38)
							mkfile(fps[i]);
					}

					dhcp_head(fps[32]);
					dhcp_head2(0, fps[32]);

					hfsc_head("$IF_MAN0", 1, fps[11]);
					hfsc_head("$IF_IN0",  1, fps[23]);				

					hosts_head(fps[33]);
					
					printf (" \n Generating config files ...\n");
					for ( i=0; i<genrozm; i++)
					{
							tmpbajt=gen(genfiles[i], &n, j, k, tmpbajt, fps, "all");
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


					system ("chmod 0744 /etc/nat/sh/*");
					system ("chmod 0744 /etc/hfsc/*");
	
					printf(" Restarting DHCP ...\n");
					system ("/etc/rc.d/rc.dhcpd restart");
	
				//	printf("\n Reconfiguring Aliases ... \n");			
				//	system ("/etc/nat/sh/itf-users.sh");


					printf(" Reloading IPSETs ...\n");
					system ("/etc/nat/sh/ipset.sh");

			//		printf(" Restarting NAT ...\n");
			//		system ("/etc/nat/rc.masq");

					printf("Restarting  H F S C ...\n");
					system ("/etc/hfsc/rc.hfsc");
                                                         
					system ("rm /tmp/active");
					return 0;
				}
			// dwa argumenty programu, czyli jego nazwa i parametr np. dhcp, hfsc, nat	
			else if ( argc == 2)
				{
					if ( strcmp(argv[1], ARG1)==0  )
					{
						fps[32]=fwopen(writefiles[32]);	
						dhcp_head(fps[32]);
						dhcp_head2(0, fps[32]);
						printf (" \n Generating config files ...\n");
						for ( i=0; i<genrozm; i++)
						{
								tmpbajt=gen(genfiles[i], &n, j, k, tmpbajt, fps, ARG1);
						}
						
						dhcp_head3(fps[32]);
						//fprintf(fps[32], "} \n");
						//fprintf(fps[32], "} \n");
						fclose(fps[32]);
		
						system ("rm /tmp/active");
						
						printf(" Restarting DHCP ...\n");
						system ("/etc/rc.d/rc.dhcpd restart");
						return 0;

					}	

					else if ( strcmp(argv[1], ARG2)==0  )
					{
//						printf("\n Not implemented yet. It will be written in free time :-)");
						system ("rm /tmp/active");

							for ( i=11; i<=30; i++)
							{
								fps[i]=fwopen(writefiles[i]);	
								mkfile(fps[i]);
							}
							
							hfsc_head("$IF_MAN0", 1, fps[11]);
							hfsc_head("$IF_IN0",  1, fps[23]);				

							
							printf (" \n Generating config files ...\n");
							for ( i=0; i<genrozm; i++)
							{
									tmpbajt=gen(genfiles[i], &n, j, k, tmpbajt, fps, ARG2);
							}
			
						////////////////////////////////////////////////////////////////	
							for ( i=11; i<=30; i++)
							{
								//printf( "Closing %s file  ... \n" , writefiles[i]);
								fclose(fps[i]);	
							}	

							system ("chmod 0744 /etc/hfsc/*");

							printf("Restarting  H F S C ...\n");
							system ("/etc/hfsc/rc.hfsc");
					
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
	
}
