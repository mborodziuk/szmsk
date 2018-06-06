#include "gen.h"
#include "conf.h"
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/stat.h>
#include <sys/types.h>


/*int arraysize()
{
	return (sizeof if_lan0 / sizeof *if_lan0)
}
*/


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

int validateargs(int k, char *arg)
{
	char argumenty [][100] =
	{
			{"dhcp"}, // 0
	};
	int argrozm = (sizeof argumenty / sizeof *argumenty);
	int flag=0;
	int i;
	
	if ( k > 2)
		{
			flag=0;
			printf ("\nProgram mo¿e mieæ maksymalnie jeden argument ! \nTy wpisa³es %d. \n\n", --k);
		}
	else
		{
			for ( i=0; i<argrozm; i++)
			{
				if ( strcmp(arg+1, argumenty[i]) == 0 )
					flag=1;
				else
					{
						printf ("\nNiepoprawny argument - dopuszczalne argumenty : dhcp\n\n");
						flag=0;
					}
			}
		}
	return(flag);
}


char hextab(int m)
{
	char a;
	switch(m)
	{
	 case 0:
			a='0';	
			break;			
	 case 1:
			a='1';	
			break;			
	 case 2:
			a='2';	
			break;			
	 case 3:
			a='3';	
			break;			
	 case 4:
			a='4';	
			break;			
	 case 5:
			a='5';	
			break;			
	 case 6:
			a='6';	
			break;			
	 case 7:
			a='7';	
			break;			
	 case 8:
			a='8';	
			break;			
	 case 9:
			a='9';	
			break;			
	 case 10:
			a='A';	
			break;			
	 case 11:
			a='B';	
			break;			
	 case 12:
			a='C';	
			break;			
	 case 13:
			a='D';	
			break;			
	 case 14:
			a='E';	
			break;			
	 case 15:
			a='F';	
			break;
		default:
			a='G';
			break;
	}
	
	return(a);
	
}

void reverse(char s[])
{
    int c, i, j;

    for (i = 0, j = strlen(s)-1; i<j; i++, j--) {
        c = s[i];
        s[i] = s[j];
        s[j] = c;
    }
}

/* itoa:  convert n to characters in s */
void itoa(int n)
{
    int i, sign;
		char s[100];

    if ((sign = n) < 0)  /* record sign */
        n = -n;          /* make n positive */
    i = 0;
    do {       /* generate digits in reverse order */
        s[i++] = n % 10 + '0';   /* get next digit */
    } while ((n /= 10) > 0);     /* delete it */
    if (sign < 0)
        s[i++] = '-';
    s[i] = '\0';
		printf("%s", s);
 //   reverse(s);
} 


char *hex(int i)
{
	int m, n;
	char a, b;
	char *string1 = "0x";
	char *string2 = malloc(4*sizeof *string2);

	m=i/16;
	n=i%16;
	
	a=hextab(m);	
	b=hextab(n);
	
	sprintf(string2, "%s%c%c", string1, a, b );
	
	return (string2);
}	
	
int brama29 (int i)
{
	int b, c;
	
    c = i / 8;
    b = c*8 +6;
    return (b);
}

// Enable internet for user
void masq(str ip, str mac, str ipzewn, FILE *fp)
{ 
	char napis[100]="";
	char napis2[100]="-m mac --mac-source ";
	
	if ( strcmp("ff:ff:ff:ff:ff:ff", mac) != 0 )
		{
			sprintf(napis, "%s %s", napis2, mac);
		}

			    
	fprintf(fp,  "$IPT -A INPUT   %s -s %s -j ACCEPT  \n", napis, ip);
	fprintf(fp,  "$IPT -A FORWARD %s -s %s -j ACCEPT  \n", napis, ip);	
	fprintf(fp,  "$IPT -A FORWARD -d %s -j ACCEPT     \n", ip);	
 
	if ( strcmp(ipzewn,IP_NAT) != 0 )
		{
			fprintf(fp,  "$IPT -t nat -A POSTROUTING -s %s -o $IF_INET3 -d ! $N_INET3 -j SNAT --to %s \n", ip, ipzewn);
			fprintf(fp,  "$IPT -t nat -A PREROUTING -d %s -j DNAT --to %s  \n", ipzewn, ip);
		}
}	


void interfaces(int i, str ipzewn, str iface, str netmask, FILE *fp)
{
		fprintf(fp,  "ifconfig %s:%d \t %s \t \t netmask %s \n", iface, i, ipzewn, netmask);
}


// Redirect to proxy
void proxy (str ip, str mac, FILE * fp)
{

	char napis[100]="";
	char napis2[100]="-m mac --mac-source ";
	
	if ( strcmp("ff:ff:ff:ff:ff:ff", mac) != 0 )
		{
			sprintf(napis, "%s %s", napis2, mac);
		}

		fprintf(fp, "$IPT -t nat -A PREROUTING %s -s %s -p tcp -m multiport --dports 80,8080 -d $IP_LAN0 -j RETURN  			\n", napis, ip);		
		fprintf(fp, "$IPT -t nat -A PREROUTING %s -s %s -p tcp -m multiport --dports 80,8080 -j DNAT --to $IP_LAN0:8080  	\n", napis, ip);		
}



void bez_proxy (str ip, str mac, FILE * fp)
{
	char napis[100]="";
	char napis2[100]="-m mac --mac-source ";
	
	if ( strcmp("ff:ff:ff:ff:ff:ff", mac) != 0 )
		{
			sprintf(napis, "%s %s", napis2, mac);
		}
		
	fprintf(fp, "$IPT -t nat -A PREROUTING %s -s %s -p tcp -m multiport --dports 80,8080 -j RETURN  			\n", napis, ip);		
}


void wylacz_net(str ip, str mac, FILE * fp)
{
	char napis[100]="";
	char napis2[100]="-m mac --mac-source ";
	
	if ( strcmp("ff:ff:ff:ff:ff:ff", mac) != 0 )
		{
			sprintf(napis, "%s %s", napis2, mac);
		}

		fprintf(fp, "$IPT -I FORWARD -s %s -j DROP  			\n", ip);		
		fprintf(fp, "$IPT -t nat -A PREROUTING -s %s -p tcp -m multiport --dports 80,8080 -j DNAT --to $IP_LAN_WWW:8083  			\n", ip);		
}       


void info(str ip, str host, FILE *info, FILE *info_off)
{

		fprintf(info, "#---- %s -------------------------------------------------------------------------------------------------------#  			\n", host);	
		fprintf(info, "$IPT -t nat -I PREROUTING -s %s -p tcp -m multiport --dports 80,8080 -j DNAT --to $IP_LAN_WWW:8085  			\n", ip);	
		
		fprintf(info_off, "#---- %s -------------------------------------------------------------------------------------------------------#  			\n", host);	
		fprintf(info_off, "$IPT -t nat -D PREROUTING -s %s -p tcp -m multiport --dports 80,8080 -j DNAT --to $IP_LAN_WWW:8085  			\n", ip);	
}


void dansguardian(str ip, FILE *fp)
{
		fprintf(fp, "%s", ip);
}


void hfsc(str host, str ip, str ipzewn, str netdown, str landown, int *i, FILE *fps[])
{
	FILE *fp, *fpup;
	int b1, b2, b3, b4, classid, classidup, b22, i2, i3, i4, i5;
	char *ht1, *ht2, *hfsc_file, *hfscup_file, *iflan, *ifin, *CEILD, *CEILU, *CEIL_P2P, *CEILDLAN, *CEILULAN;
	char **tabip;

	char *ht = malloc(6*sizeof *ht);

	
	tabip=explode('.', ip);

	b1=atoi(tabip[0]);
	b2=b22=atoi(tabip[1]);
	b3=atoi(tabip[2]);
	b4=atoi(tabip[3]);
	
/*	printf("%d\n", b1);
	printf("%d\n", b2);
	printf("%d\n", b3);
	printf("%d\n", b4);
	*/
	ht2=hex(b4);
	
	
/*	
	if( b2 >= BAJT_WLAN1 || b2 <= BAJT_WLAN2 )
		b22=8;
	else if( b2 >= BAJT_WLAN2 || b2 <= BAJT_WLAN3 )
		b22=16;
*/
		
	switch(b2)
	{
		case 0:	
		
				classid=1;
				classidup=1;
        fp=fps[11];
        fpup=fps[23];
        iflan="$IF_LAN0";
        ifin="$IF_IN0";
				
				switch(b3)
				{
					case 0:
						ht1="2:";
						break;
					case 3:
						ht1="3:";
						break;
					case 5:
						ht1="4:";
						break;
					case 6:
						ht1="5:";
						break;
					case 2:
						ht1="6:";
						break;
				}
				break;

		case 1:	
		
				classid=1;
				classidup=1;
        fp=fps[12];
        fpup=fps[24];
        iflan="$IF_LAN1";
        ifin="$IF_IN1";
				
				switch(b3)
				{
					case 0:
						ht1="2:";
						break;
					case 2:
						ht1="3:";
						break;
					case 3:
						ht1="4:";
						break;
					case 4:
						ht1="5:";
						break;
					case 5:
						ht1="6:";
						break;
					case 6:
						ht1="7:";
						break;
					case 7:
						ht1="8:";
						break;
					case 8:
						ht1="9:";
						break;
					case 14:
						ht1="10:";
						break;
				}
				break;
	

		case 2:	
		
				classid=1;
				classidup=1;
        fp=fps[13];
        fpup=fps[25];
        iflan="$IF_LAN2";
        ifin="$IF_IN2";
				
				switch(b3)
				{
					case 0:
						ht1="2:";
						break;
					case 2:
						ht1="3:";
						break;
					case 4:
						ht1="4:";
						break;
					case 6:
						ht1="5:";
						break;
					case 8:
						ht1="6:";
						break;
					case 10:
						ht1="7:";
						break;
					case 12:
						ht1="8:";
						break;
					case 7:
						ht1="9:";
						break;
					case 14:
						ht1="10:";
						break;
					case 16:
						ht1="11:";
						break;
					case 18:
						ht1="12:";
						break;
					case 20:
						ht1="13:";
						break;
					case 21:
						ht1="14:";
						break;
					case 22:
						ht1="15:";
						break;
					case 23:
						ht1="16:";
						break;
					case 24:
						ht1="17:";
						break;
					case 25:
						ht1="18:";
						break;
					case 27:
						ht1="19:";
						break;
					case 17:
						ht1="20:";
						break;
					case 13:
						ht1="21:";
						break;
					case 11:
						ht1="22:";
						break;
					case 50:
						ht1="23:";
						break;
					case 88:
						ht1="24:";
						break;
					case 44:
						ht1="25:";
						break;
					case 222:
						ht1="26:";
						break;
					case 113:
						ht1="27:";
						break;
					case 55:
						ht1="28:";
						break;
					case 77:
						ht1="29:";
						break;
				}
				break;

		case 3:	
		
				classid=1;
				classidup=1;
        fp=fps[14];
        fpup=fps[26];
        iflan="$IF_LAN3";
        ifin="$IF_IN3";
				
				switch(b3)
				{
					case 0:
						ht1="2:";
						break;
					case 2:
						ht1="3:";
						break;
				}
				break;

		case 4:	
		
				classid=1;
				classidup=1;
        fp=fps[15];
        fpup=fps[26];
        iflan="$IF_LAN4";
        ifin="$IF_IN3";
				
				switch(b3)
				{
					case 0:
						ht1="4:";
						break;
					case 26:
						ht1="5:";
						break;
					case 28:
						ht1="6:";
						break;
				}
				break;

		case 5:	
		
				classid=1;
				classidup=1;
        fp=fps[16];
        fpup=fps[26];
        iflan="$IF_LAN5";
        ifin="$IF_IN3";
				
				switch(b3)
				{
					case 0:
						ht1="7:";
						break;
				}
				break;

		case 6:	
		
				classid=1;
				classidup=1;
        fp=fps[17];
        fpup=fps[26];
        iflan="$IF_LAN6";
        ifin="$IF_IN3";
				
				switch(b3)
				{
					case 0:
						ht1="8:";
						break;
				}
				break;

		case 7:	
		
				classid=1;
				classidup=1;
        fp=fps[18];
        fpup=fps[26];
        iflan="$IF_LAN7";
        ifin="$IF_IN3";
				
				switch(b3)
				{
					case 0:
						ht1="9:";
						break;
				}
				break;

		case 8:

				classid=1;
				classidup=1;
        fp=fps[19];
        fpup=fps[27];
        iflan="$IF_LAN8";
        ifin="$IF_IN4";

				switch (b3)
				{
					case 0:
						ht1="2:";
						break;
					case 1:
						ht1="3:";
						break;
					case 2:
						ht1="4:";
						break;
					case 3:
						ht1="5:";
						break;
					case 4:
						ht1="6:";
						break;
					case 5:
						ht1="7:";
						break;
					case 6:
						ht1="8:";
						break;
					case 7:
						ht1="9:";
						break;
					case 8:
						ht1="10:";
						break;
					case 9:
						ht1="11:";
						break;
					case 10:
						ht1="12:";
						break;
					case 11:
						ht1="13:";
						break;
					case 12:
						ht1="14:";
						break;
					case 13:
						ht1="15:";
						break;
					case 14:
						ht1="16:";
						break;
					case 15:
						ht1="17:";
						break;
					case 16:
						ht1="18:";
						break;
					case 17:
						ht1="19:";
						break;
					case 18:
						ht1="20:";
						break;
					case 19:
						ht1="21:";
						break;
					case 20:
						ht1="22:";
						break;
					case 21:
						ht1="23:";
						break;
					case 22:
						ht1="24:";
						break;
					case 23:
						ht1="25:";
						break;
					case 24:
						ht1="26:";
						break;
					case 25:
						ht1="27:";
						break;				
					case 26:
						ht1="28:";
						break;				
					case 27:
						ht1="29:";
						break;				
					case 28:
						ht1="30:";
						break;				
				}
				break;

		case 9:

				classid=1;
				classidup=1;
        fp=fps[19];
        fpup=fps[27];
        iflan="$IF_LAN8";
        ifin="$IF_IN4";

				switch (b3)
				{
					case 0:
						ht1="50:";
						break;
					case 1:
						ht1="51:";
						break;
					case 2:
						ht1="52:";
						break;
					case 3:
						ht1="53:";
						break;
					case 4:
						ht1="54:";
						break;
					case 5:
						ht1="55:";
						break;
					case 6:
						ht1="56:";
						break;
					case 7:
						ht1="57:";
						break;
					case 8:
						ht1="58:";
						break;
					case 9:
						ht1="59:";
						break;
					case 10:
						ht1="60:";
						break;
					case 11:
						ht1="61:";
						break;
					case 12:
						ht1="62:";
						break;
					case 13:
						ht1="63:";
						break;
					case 14:
						ht1="64:";
						break;
					case 15:
						ht1="65:";
						break;
					case 16:
						ht1="66:";
						break;
					case 17:
						ht1="67:";
						break;
					case 18:
						ht1="68:";
						break;
					case 19:
						ht1="69:";
						break;
					case 20:
						ht1="70:";
						break;
					case 21:
						ht1="71:";
						break;
					case 22:
						ht1="72:";
						break;
					case 23:
						ht1="73:";
						break;
					case 24:
						ht1="74:";
						break;
					case 25:
						ht1="75:";
						break;				
					case 26:
						ht1="76:";
						break;				
					case 27:
						ht1="77:";
						break;				
					case 28:
						ht1="78:";
						break;					
					case 29:
						ht1="79:";
						break;					
				}
				break;

		case 10:

				classid=1;
				classidup=1;
        fp=fps[19];
        fpup=fps[27];
        iflan="$IF_LAN8";
        ifin="$IF_IN4";

				switch (b3)
				{
					case 0:
						ht1="100:";
						break;
					case 1:
						ht1="101:";
						break;
					case 2:
						ht1="102:";
						break;
					case 3:
						ht1="103:";
						break;
					case 4:
						ht1="104:";
						break;
					case 5:
						ht1="105:";
						break;
					case 6:
						ht1="106:";
						break;
					case 7:
						ht1="107:";
						break;
					case 8:
						ht1="108:";
						break;
					case 9:
						ht1="109:";
						break;
					case 10:
						ht1="110:";
						break;
					case 11:
						ht1="111:";
						break;
					case 12:
						ht1="112:";
						break;
					case 13:
						ht1="113:";
						break;
					case 14:
						ht1="114:";
						break;
					case 15:
						ht1="115:";
						break;
					case 16:
						ht1="116:";
						break;
					case 17:
						ht1="117:";
						break;
					case 18:
						ht1="118:";
						break;
					case 19:
						ht1="119:";
						break;
					case 20:
						ht1="120:";
						break;
					case 21:
						ht1="121:";
						break;
					case 22:
						ht1="122:";
						break;
					case 23:
						ht1="123:";
						break;
					case 24:
						ht1="124:";
						break;
					case 25:
						ht1="125:";
						break;				
					case 26:
						ht1="126:";
						break;				
					case 27:
						ht1="127:";
						break;				
					case 28:
						ht1="128:";
						break;					
				}
				break;

		case 11:

				classid=1;
				classidup=1;
        fp=fps[19];
        fpup=fps[27];
        iflan="$IF_LAN8";
        ifin="$IF_IN4";

				switch (b3)
				{
					case 0:
						ht1="150:";
						break;
					case 1:
						ht1="151:";
						break;
					case 2:
						ht1="152:";
						break;
					case 3:
						ht1="153:";
						break;
					case 4:
						ht1="154:";
						break;
					case 5:
						ht1="155:";
						break;
					case 6:
						ht1="156:";
						break;
					case 7:
						ht1="157:";
						break;
					case 8:
						ht1="158:";
						break;
					case 9:
						ht1="159:";
						break;
					case 10:
						ht1="160:";
						break;
					case 11:
						ht1="161:";
						break;
					case 12:
						ht1="162:";
						break;
					case 13:
						ht1="163:";
						break;
					case 14:
						ht1="164:";
						break;
					case 15:
						ht1="165:";
						break;
					case 16:
						ht1="166:";
						break;
					case 17:
						ht1="167:";
						break;
					case 18:
						ht1="168:";
						break;
					case 19:
						ht1="169:";
						break;
					case 20:
						ht1="170:";
						break;
					case 21:
						ht1="171:";
						break;
					case 22:
						ht1="172:";
						break;
					case 23:
						ht1="173:";
						break;
					case 24:
						ht1="174:";
						break;
					case 25:
						ht1="175:";
						break;				
					case 26:
						ht1="176:";
						break;				
					case 27:
						ht1="177:";
						break;				
					case 28:
						ht1="178:";
						break;					
				}
				break;		

		case 16:

				classid=1;
				classidup=1;
        fp=fps[20];
        fpup=fps[28];
        iflan="$IF_LAN16";
        ifin="$IF_IN5";

				switch (b3)
				{
					case 0:
						ht1="2:";
						break;
					case 3:
						ht1="3:";
						break;			
				}
				break;		

		case 17:

				classid=1;
				classidup=1;
        fp=fps[20];
        fpup=fps[28];
        iflan="$IF_LAN16";
        ifin="$IF_IN5";

				switch (b3)
				{
					case 0:
						ht1="30:";
						break;
					case 1:
						ht1="31:";
						break;
					case 2:
						ht1="32:";
						break;
					case 3:
						ht1="33:";
						break;
					case 4:
						ht1="34:";
						break;
					case 5:
						ht1="35:";
						break;
					case 6:
						ht1="36:";
						break;
					case 7:
						ht1="37:";
						break;
					case 8:
						ht1="38:";
						break;
					case 9:
						ht1="39:";
						break;
					case 10:
						ht1="40:";
						break;
					case 11:
						ht1="41:";
						break;
					case 12:
						ht1="42:";
						break;
					case 13:
						ht1="43:";
						break;
					case 14:
						ht1="44:";
						break;
					case 15:
						ht1="45:";
						break;
					case 16:
						ht1="46:";
						break;
					case 17:
						ht1="47:";
						break;
					case 18:
						ht1="48:";
						break;
					case 19:
						ht1="49:";
						break;
					case 20:
						ht1="50:";
						break;
					case 21:
						ht1="51:";
						break;
					case 22:
						ht1="52:";
						break;
					case 23:
						ht1="53:";
						break;
					case 24:
						ht1="54:";
						break;
					case 25:
						ht1="55:";
						break;				
					case 26:
						ht1="56:";
						break;				
					case 27:
						ht1="57:";
						break;				
					case 28:
						ht1="58:";
						break;				
					case 29:
						ht1="59:";
						break;				
				}
				break;		

		case 18:

				classid=1;
				classidup=1;
        fp=fps[20];
        fpup=fps[28];
        iflan="$IF_LAN16";
        ifin="$IF_IN5";

				switch (b3)
				{
					case 0:
						ht1="60:";
						break;
					case 1:
						ht1="61:";
						break;
					case 2:
						ht1="62:";
						break;
					case 3:
						ht1="63:";
						break;
					case 4:
						ht1="64:";
						break;
					case 5:
						ht1="65:";
						break;
					case 6:
						ht1="66:";
						break;
					case 7:
						ht1="67:";
						break;
					case 8:
						ht1="68:";
						break;
					case 9:
						ht1="69:";
						break;
					case 10:
						ht1="70:";
						break;
					case 11:
						ht1="71:";
						break;
					case 12:
						ht1="72:";
						break;
					case 13:
						ht1="73:";
						break;
					case 14:
						ht1="74:";
						break;
					case 15:
						ht1="75:";
						break;
					case 16:
						ht1="76:";
						break;
					case 17:
						ht1="77:";
						break;
					case 18:
						ht1="78:";
						break;
					case 19:
						ht1="79:";
						break;
					case 20:
						ht1="80:";
						break;
					case 21:
						ht1="81:";
						break;
					case 22:
						ht1="82:";
						break;
					case 23:
						ht1="83:";
						break;
					case 24:
						ht1="84:";
						break;
					case 25:
						ht1="85:";
						break;				
					case 26:
						ht1="86:";
						break;				
					case 27:
						ht1="87:";
						break;				
					case 28:
						ht1="88:";
						break;					
					case 29:
						ht1="89:";
						break;						
				}
				break;		

		case 19:

				classid=1;
				classidup=1;
        fp=fps[20];
        fpup=fps[28];
        iflan="$IF_LAN16";
        ifin="$IF_IN5";

				switch (b3)
				{
					case 0:
						ht1="90:";
						break;
					case 1:
						ht1="91:";
						break;
					case 2:
						ht1="92:";
						break;
					case 3:
						ht1="93:";
						break;
					case 4:
						ht1="94:";
						break;
					case 5:
						ht1="95:";
						break;
					case 6:
						ht1="96:";
						break;
					case 7:
						ht1="97:";
						break;
					case 8:
						ht1="98:";
						break;
					case 9:
						ht1="99:";
						break;
					case 10:
						ht1="100:";
						break;
					case 11:
						ht1="101:";
						break;
					case 12:
						ht1="102:";
						break;
					case 13:
						ht1="103:";
						break;
					case 14:
						ht1="104:";
						break;
					case 15:
						ht1="105:";
						break;
					case 16:
						ht1="106:";
						break;
					case 17:
						ht1="107:";
						break;
					case 18:
						ht1="108:";
						break;
					case 19:
						ht1="109:";
						break;
					case 20:
						ht1="110:";
						break;
					case 21:
						ht1="111:";
						break;
					case 22:
						ht1="112:";
						break;
					case 23:
						ht1="113:";
						break;
					case 24:
						ht1="114:";
						break;
					case 25:
						ht1="115:";
						break;				
					case 26:
						ht1="116:";
						break;				
					case 27:
						ht1="117:";
						break;				
					case 28:
						ht1="118:";
						break;					
					case 29:
						ht1="119:";
						break;						
			
				}
				break;		

		case 22:

				classid=1;
				classidup=1;
        fp=fps[20];
        fpup=fps[28];
        iflan="$IF_LAN16";
        ifin="$IF_IN5";

				switch (b3)
				{
					case 0:
						ht1="120:";
						break;
					case 1:
						ht1="121:";
						break;
					case 2:
						ht1="122:";
						break;
					case 3:
						ht1="123:";
						break;
					case 4:
						ht1="124:";
						break;
					case 5:
						ht1="125:";
						break;
					case 6:
						ht1="126:";
						break;
					case 7:
						ht1="127:";
						break;
					case 8:
						ht1="128:";
						break;
					case 9:
						ht1="129:";
						break;
					case 10:
						ht1="130:";
						break;
					case 11:
						ht1="131:";
						break;
					case 12:
						ht1="132:";
						break;
					case 13:
						ht1="133:";
						break;
					case 14:
						ht1="134:";
						break;
					case 15:
						ht1="135:";
						break;
					case 16:
						ht1="136:";
						break;
					case 17:
						ht1="137:";
						break;
					case 18:
						ht1="138:";
						break;
					case 19:
						ht1="139:";
						break;
					case 20:
						ht1="140:";
						break;
					case 21:
						ht1="141:";
						break;
					case 22:
						ht1="142:";
						break;
					case 23:
						ht1="143:";
						break;
					case 24:
						ht1="144:";
						break;
					case 25:
						ht1="145:";
						break;				
					case 26:
						ht1="146:";
						break;				
					case 27:
						ht1="147:";
						break;				
					case 28:
						ht1="148:";
						break;					
					case 29:
						ht1="149:";
						break;						

				}
				break;		
	}
	
//	   classid_up=15;
																							      


    if ( strcmp(netdown,"MINO")==0  ) 
		{
        CEILD="$MINO_D";
        CEILU="$MINO_U";
        CEIL_P2P="$P2P1";
		}
    if ( strcmp(netdown,"STRL")==0  ) 
		{
        CEILD="$STRL_D";
        CEILU="$STRL_U";
        CEIL_P2P="$P2P1";
		}
    else if ( strcmp(netdown,"MINL")==0  ) 
			{
        CEILD="$MINL_D";
        CEILU="$MINL_U";
        CEIL_P2P="$P2P1";
			}
    else if ( strcmp(netdown,"STDL")==0  ) 
		{
        CEILD="$STDL_D";
        CEILU="$STDL_U";
        CEIL_P2P="$P2P2";
		}
    else if ( strcmp(netdown,"MEDL")==0  ) 
		{
        CEILD="$MEDL_D";
        CEILU="$MEDL_U";
        CEIL_P2P="$P2P3";
		}
    else if ( strcmp(netdown,"OPTL")==0  ) 
		{
        CEILD="$OPTL_D";
        CEILU="$OPTL_U";
        CEIL_P2P="$P2P4";
		}
    else if ( strcmp(netdown,"MINK")==0  ) 
		{
        CEILD="$MINK_D";
        CEILU="$MINK_U";
        CEIL_P2P="$P2P11";
		}
    else if ( strcmp(netdown,"STDK")==0  ) 
		{
        CEILD="$STDK_D";
        CEILU="$STDK_U";
        CEIL_P2P="$P2P12";
		}		
    else if ( strcmp(netdown,"MEDK")==0  ) 
		{
        CEILD="$MEDK_D";
        CEILU="$MEDK_U";
        CEIL_P2P="$P2P13";
		}
    else if ( strcmp(netdown,"OPTK")==0  ) 
		{
        CEILD="$OPTK_D";
				CEILU="$OPTK_U";
				CEIL_P2P="$P2P14";
		}
    else if ( strcmp(netdown,"P1000")==0  ) 
		{
        CEILD="$P1000_D";
        CEILU="$P1000_U";
        CEIL_P2P="$P2P5";
		}
    else if ( strcmp(netdown,"P2000")==0  ) 
		{
        CEILD="$P2000_D";
        CEILU="$P2000_U";
        CEIL_P2P="$P2P6";
		}
    else if ( strcmp(netdown,"S2000")==0  ) 
		{
        CEILD="$S2000_D";
        CEILU="$S2000_U";
        CEIL_P2P="$P2P7";
		}
   else if ( strcmp(netdown,"FA")==0  ) 
	 {
      CEILD="$FA_D";
			CEILU="$FA_U";
      CEIL_P2P="$P2P8";
		}
   else if ( strcmp(netdown,"FA3MBIT")==0  ) 
	 {
      CEILD="$FA3MBIT_D";
      CEILU="$FA3MBIT_U";
			CEIL_P2P="$P2P5MBIT";
		}
   else if ( strcmp(netdown,"FA5MBIT")==0  ) 
	 {
      CEILD="$FA5MBIT_D";
      CEILU="$FA5MBIT_U";
			CEIL_P2P="$P2P5MBIT";
		}
   else if ( strcmp(netdown,"FA10Mb")==0  ) 
	 {
      CEILD="$FA10Mb_D";
      CEILU="$FA10Mb_U";
      CEIL_P2P="$P2P10MBIT";
		}
   else if ( strcmp(netdown,"FA15Mb")==0  ) 
	 {
      CEILD="$FA15Mb_D";
      CEILU="$FA15Mb_U";
      CEIL_P2P="$P2P15MBIT";
		}
   else if ( strcmp(netdown,"FA30MBIT")==0  ) 
	 {
      CEILD="$FA30MBIT_D";
      CEILU="$FA30MBIT_U";
        CEIL_P2P="$P2P30MBIT";
		}
    else if ( strcmp(netdown,"P1000P")==0  ) 
		{
        CEILD="$P1000P_D";
        CEILU="$P1000P_U";
        CEIL_P2P="$P2P9";
		}
    else if ( strcmp(netdown,"P1500")==0  ) 
		{
        CEILD="$P1500_D";
        CEILU="$P1500_U";
        CEIL_P2P="$P2P10";
		}
    

   if ( strcmp(landown,"MINO")==0  ) {
       CEILDLAN="$MINO_D";
       CEILULAN="$MINO_U";
		}
   else if ( strcmp(netdown,"STRL")==0  ) 
		{
        CEILDLAN="$STRL_D";
        CEILULAN="$STRL_U";
		}
   else if ( strcmp(landown,"MINL")==0  ) 
	 {
       CEILDLAN="$MINL_D";
       CEILULAN="$MINL_U";
		}
   else if ( strcmp(landown,"STDL")==0  ) 
	 {
       CEILDLAN="$STDL_D";
       CEILULAN="$STDL_U";
		}
   else if ( strcmp(landown,"MEDL")==0  ) 
	 {
       CEILDLAN="$MEDL_D";
       CEILULAN="$MEDL_U";
		}
   else if ( strcmp(landown,"OPTL")==0  ) 
	 {
       CEILDLAN="$OPTL_D";
       CEILULAN="$OPTL_U";
		}
   else if ( strcmp(landown,"MINK")==0  ) 
	 {
      CEILDLAN="$MINK_D";
     CEILULAN="$MINK_U";
		}
    else if ( strcmp(landown,"STDK")==0  ) 
		{
      CEILDLAN="$STDK_D";
      CEILULAN="$STDK_U";
		}
    else if ( strcmp(landown,"MEDK")==0  ) 
		{
			CEILDLAN="$MEDK_D";
			CEILULAN="$MEDK_U";
		}
    else if ( strcmp(landown,"OPTK")==0  ) 
		{
         CEILDLAN="$OPTK_D";
        CEILULAN="$OPTK_U";
		}
   else if ( strcmp(landown,"P1000")==0  ) 
	 {
       CEILDLAN="$P1000_D";
       CEILULAN="$P1000_U";
		}
   else if ( strcmp(landown,"P2000")==0  ) 
	 {
       CEILDLAN="$P2000_D";
       CEILULAN="$P2000_U";
		}
   else if ( strcmp(landown,"S2000")==0  ) 
	 {
       CEILDLAN="$S2000_D";
       CEILULAN="$S2000_U";
		}
   else if ( strcmp(landown,"FA")==0  ) 
	 {
       CEILDLAN="$FA_D";
       CEILULAN="$FA_U";
		}
   else if ( strcmp(landown,"FA3MBIT")==0  ) 
	 {
       CEILDLAN="$FA3MBIT_D";
       CEILULAN="$FA3MBIT_U";
		}
	else if ( strcmp(landown,"FA5MBIT")==0  ) 
	 {
       CEILDLAN="$FA5MBIT_D";
       CEILULAN="$FA5MBIT_U";
		}
   else if ( strcmp(landown,"FA10Mb")==0  ) 
	 {
       CEILDLAN="$FA10Mb_D";
       CEILULAN="$FA10Mb_U";
		}
   else if ( strcmp(landown,"FA15Mb")==0  ) 
	 {
       CEILDLAN="$FA15Mb_D";
       CEILULAN="$FA15Mb_U";
		}
   else if ( strcmp(landown,"FA30MBIT")==0  ) 
	 {
       CEILDLAN="$FA30MBIT_D";
       CEILULAN="$FA30MBIT_U";
		}
    else if ( strcmp(landown,"P1000P")==0  ) 
		{
        CEILDLAN="$P1000P_D";
        CEILULAN="$P1000P_U";
        CEIL_P2P="$P2P9";
		}
    else if ( strcmp(landown,"P1500")==0  ) 
		{
        CEILDLAN="$P1500_D";
        CEILULAN="$P1500_U";
        CEIL_P2P="$P2P10";
		}

		i2=*i+3000;
    i3=*i+5000;
    i4=*i+7000;
//    mm=m+4000;
		
		sprintf(ht, "%s%s", ht1, ht2);
		
	//	printf ("%s %s %s %d %d ", CEILD, ht, ip, classid);

	
    fprintf(fp, "#---- %s -------------------------------------------------------------------------------------------# \n", 						host);
//	    printf( "#---- %s -------------------------------------------------------------------------------------------# \n", 						host);	
    fprintf(fp, "tc class add dev  %s parent %d:1000 classid %d:%d hfsc ls m2 1kbit ul m2 %s && \n", 																			iflan, classid, classid, *i, CEILDLAN);
		
    fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src $IP_LAN 	match ip dst %s flowid %d:%d && \n",   iflan, ht, ip, classid, *i);
		
		if ( strcmp(ipzewn,IP_NAT) != 0 )
			{
				fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src $JAWNET1 match ip dst %s flowid %d:%d && \n", 	iflan, ht, ip, classid, *i);
				fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src $JAWNET2 match ip dst %s flowid %d:%d && \n", 	iflan, ht, ip, classid, *i);
				fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src $JAWNET3 match ip dst %s flowid %d:%d && \n", 	iflan, ht, ip, classid, *i);
				fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src $AKKNET1 match ip dst %s flowid %d:%d && \n", 	iflan, ht, ip, classid, *i);
				fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src $AKKNET2 match ip dst %s flowid %d:%d && \n", 	iflan, ht, ip, classid, *i);
				fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src $ASN match ip dst %s flowid %d:%d     && \n", 	iflan, ht, ip, classid, *i);
				fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src $BMJ match ip dst %s flowid %d:%d     && \n", 	iflan, ht, ip, classid, *i);
				fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src $WNC match ip dst %s flowid %d:%d     && \n", 	iflan, ht, ip, classid, *i);
				fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src $BMK match ip dst %s flowid %d:%d     && \n", 	iflan, ht, ip, classid, *i);
				fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src $DRAMA	match ip dst %s flowid %d:%d   && \n", 	iflan, ht, ip, classid, *i);
				fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src $COMNET match ip dst %s flowid %d:%d  && \n", 	iflan, ht, ip, classid, *i);
				fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src $INTERPC match ip dst %s flowid %d:%d && \n", 	iflan, ht, ip, classid, *i);
				fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src $STI match ip dst %s flowid %d:%d     && \n", 	iflan, ht, ip, classid, *i);
				fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src $JOYNET match ip dst %s flowid %d:%d  && \n", 	iflan, ht, ip, classid, *i);
			}                                    																						
    fprintf(fp, "tc qdisc add dev  %s parent %d:%d pfifo limit 128 && \n",																																		iflan, classid, *i);
    fprintf(fp, "tc class add dev  %s parent %d:4000 	classid %d:%d hfsc ls m2 1kbit ul m2 %s && \n",																					iflan, classid, classid, i2, CEILD );
		
    fprintf(fp, "tc class add dev  %s parent %d:%d 		classid %d:%d hfsc ls m2 1kbit ul m2 %s && \n",																					iflan, classid, i2, classid, i3, CEILD);

    
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip dst %s match ip sport 80 0xffff flowid %d:%d && \n",  	iflan, ht, ip, classid, i3);
    
		fprintf(fp, "tc qdisc add dev %s parent %d:%d pfifo limit 128 && \n",                                   																	iflan, classid, i3);
    fprintf(fp, "tc class add dev %s parent %d:%d classid %d:%d hfsc ls m2 1kbit ul m1 %s d 60s m2 %s && \n", 																iflan, classid, i2, classid, i4, CEILD, CEIL_P2P);
    fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip dst %s flowid %d:%d && \n",  													iflan, ht, ip, classid, i4);
    fprintf(fp, "tc qdisc add dev %s parent %d:%d pfifo limit 128  \n",                                                          						iflan, classid, i4);
	    	    
        
    fprintf(fpup, "#---- %s -------------------------------------------------------------------------------------------# \n", 					host );
    fprintf(fpup, "tc class add dev %s parent %d:1000 classid %d:%d hfsc ls m2 1kbit ul m2 %s && \n", 																		ifin, classidup, classidup, *i, CEILULAN);
    fprintf(fpup, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src %s match ip dst $IP_LAN flowid %d:%d && \n",   ifin, ht, ip, classidup, *i);

		if ( strcmp(ipzewn,IP_NAT) != 0 )
			{
				fprintf(fpup, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src %s match ip dst $JAWNET1 flowid %d:%d && \n", 	ifin, ht, ip, classidup, *i);
				fprintf(fpup, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src %s match ip dst $JAWNET2 flowid %d:%d && \n", 	ifin, ht, ip, classidup, *i);
				fprintf(fpup, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src %s match ip dst $JAWNET3 flowid %d:%d && \n", 	ifin, ht, ip, classidup, *i);
				fprintf(fpup, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src %s match ip dst $WNC 		flowid %d:%d && \n", 	ifin, ht, ip, classidup, *i);
				fprintf(fpup, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src %s match ip dst $AKKNET1 flowid %d:%d && \n", 	ifin, ht, ip, classidup, *i);
				fprintf(fpup, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src %s match ip dst $AKKNET2 flowid %d:%d && \n", 	ifin, ht, ip, classidup, *i);
				fprintf(fpup, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src %s match ip dst $ASN 		flowid %d:%d && \n", 	ifin, ht, ip, classidup, *i);
				fprintf(fpup, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src %s match ip dst $BMJ 		flowid %d:%d && \n", 	ifin, ht, ip, classidup, *i);
				fprintf(fpup, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src %s match ip dst $BMK 		flowid %d:%d && \n", 	ifin, ht, ip, classidup, *i);
				fprintf(fpup, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src %s match ip dst $DRAMA 	flowid %d:%d && \n", 	ifin, ht, ip, classidup, *i);
				fprintf(fpup, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src %s match ip dst $COMNET 	flowid %d:%d && \n", 	ifin, ht, ip, classidup, *i);
				fprintf(fpup, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src %s match ip dst $INTERPC flowid %d:%d && \n", 	ifin, ht, ip, classidup, *i);
				fprintf(fpup, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src %s match ip dst $STI 		flowid %d:%d && \n", 	ifin, ht, ip, classidup, *i);
				fprintf(fpup, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src %s match ip dst $JOYNET 	flowid %d:%d && \n", 	ifin, ht, ip, classidup, *i);
			}                     
    fprintf(fpup, "tc qdisc add dev %s parent %d:%d pfifo limit 128 && \n", 																																ifin, classidup, *i);

    fprintf(fpup, "tc class add dev %s parent %d:4000 classid %d:%d hfsc ls m2 1kbit ul m2 %s && \n", 																			ifin, classidup, classidup, i2, CEILU);
    fprintf(fpup, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src %s flowid %d:%d  \n",							 					ifin, ht, ip, classidup, i2);
		free(ht);
}

void hfsc_head(str dev, int classid, FILE * fp)
{
	char **strarr;
	int i, j;
	char aim[10], k[10];
 

	char iface [][100] = 
		{
			{"0"},
			{"$IF_LAN0"},
			{"dst"},
			{"16"},
			{"10.0.0.0/24"},
			{"10.0.3.0/24"},
			{"10.0.5.0/24"},
			{"10.0.6.0/24"},
			{"10.0.2.0/24"},
			{"0"},
			{"$IF_IN0"},
			{"src"},
			{"12"},
			{"10.0.0.0/24"},
			{"10.0.3.0/24"},
			{"10.0.5.0/24"},
			{"10.0.6.0/24"},
			{"10.0.2.0/24"},
			{"0"},
			{"$IF_LAN1"},
			{"dst"},
			{"16"},
			{"10.1.0.0/24"},
			{"10.1.2.0/24"},
			{"10.1.3.0/24"},
			{"10.1.4.0/24"},
			{"10.1.5.0/24"},
			{"10.1.6.0/24"},
			{"10.1.7.0/24"},
			{"10.1.8.0/24"},
			{"10.1.14.0/24"},
			{"0"},
			{"$IF_IN1"},
			{"src"},
			{"12"},
			{"10.1.0.0/24"},
			{"10.1.2.0/24"},
			{"10.1.3.0/24"},
			{"10.1.4.0/24"},
			{"10.1.5.0/24"},
			{"10.1.6.0/24"},
			{"10.1.7.0/24"},
			{"10.1.8.0/24"},
			{"10.1.14.0/24"},
			{"0"},
			{"$IF_LAN2"},
			{"dst"},
			{"16"},
			{"10.2.0.0/24"},
			{"10.2.2.0/24"},
			{"10.2.4.0/24"},
			{"10.2.6.0/24"},
			{"10.2.8.0/24"},
			{"10.2.10.0/24"},
			{"10.2.12.0/24"},			
			{"10.2.7.0/24"},			
			{"10.2.14.0/24"},			
			{"10.2.16.0/24"},			
			{"10.2.18.0/24"},			
			{"10.2.20.0/24"},			
			{"10.2.21.0/24"},			
			{"10.2.22.0/24"},			
			{"10.2.23.0/24"},			
			{"10.2.24.0/24"},			
			{"10.2.25.0/24"},			
			{"10.2.27.0/24"},			
			{"10.2.17.0/24"},			
			{"10.2.13.0/24"},			
			{"10.2.11.0/24"},			
			{"10.2.50.0/24"},			
			{"10.2.88.0/24"},			
			{"10.2.44.0/24"},			
			{"10.2.222.0/24"},			
			{"10.2.113.0/24"},			
			{"10.2.55.0/24"},			
			{"10.2.77.0/24"},			
			{"0"},
			{"$IF_IN2"},
			{"src"},
			{"12"},
			{"10.2.0.0/24"},
			{"10.2.2.0/24"},
			{"10.2.4.0/24"},
			{"10.2.6.0/24"},
			{"10.2.8.0/24"},
			{"10.2.10.0/24"},
			{"10.2.12.0/24"},			
			{"10.2.7.0/24"},			
			{"10.2.14.0/24"},			
			{"10.2.16.0/24"},			
			{"10.2.18.0/24"},			
			{"10.2.20.0/24"},			
			{"10.2.21.0/24"},			
			{"10.2.22.0/24"},			
			{"10.2.23.0/24"},			
			{"10.2.24.0/24"},			
			{"10.2.25.0/24"},			
			{"10.2.27.0/24"},			
			{"10.2.17.0/24"},			
			{"10.2.13.0/24"},			
			{"10.2.11.0/24"},			
			{"10.2.50.0/24"},			
			{"10.2.88.0/24"},			
			{"10.2.44.0/24"},			
			{"10.2.222.0/24"},			
			{"10.2.113.0/24"},			
			{"10.2.55.0/24"},			
			{"10.2.77.0/24"},			
			{"0"},
			{"$IF_LAN3"},
			{"dst"},
			{"16"},
			{"10.3.0.0/24"},
			{"10.3.2.0/24"},
			{"0"},
			{"$IF_LAN4"},
			{"dst"},
			{"16"},
			{"10.4.0.0/24"},
			{"10.4.26.0/24"},
			{"10.4.28.0/24"},
			{"0"},
			{"$IF_LAN5"},
			{"dst"},
			{"16"},
			{"10.5.0.0/24"},
			{"0"},
			{"$IF_LAN6"},
			{"dst"},
			{"16"},
			{"10.6.0.0/24"},
			{"0"},
			{"$IF_LAN7"},
			{"dst"},
			{"16"},
			{"10.7.0.0/24"},
			{"0"},
			{"$IF_IN3"},
			{"src"},
			{"12"},
			{"10.3.0.0/24"},
			{"10.3.2.0/24"},
			{"10.4.0.0/24"},
			{"10.4.26.0/24"},
			{"10.4.28.0/24"},
			{"10.5.0.0/24"},
			{"10.6.0.0/24"},		
			{"10.7.0.0/24"},
			{"0"},
			{"$IF_LAN8"},
			{"dst"},
			{"16"},
			{"10.8.0.0/24"},   // 2:0
			{"10.8.1.0/24"},   // 3:0
			{"10.8.2.0/24"},   // 4:0
			{"10.8.3.0/24"},   // 5:0
			{"10.8.4.0/24"},   // 6:0
			{"10.8.5.0/24"},   // 7:0
			{"10.8.6.0/24"},   // 8:0
			{"10.8.7.0/24"},   // 9:0
			{"10.8.8.0/24"},   // 10:0
			{"10.8.9.0/24"},   // 11:00
			{"10.8.10.0/24"},
			{"10.8.11.0/24"},
			{"10.8.12.0/24"},
			{"10.8.13.0/24"},
			{"10.8.14.0/24"},
			{"10.8.15.0/24"},
			{"10.8.16.0/24"},
			{"10.8.17.0/24"},
			{"10.8.18.0/24"},
			{"10.8.19.0/24"},
			{"10.8.20.0/24"},
			{"10.8.21.0/24"},
			{"10.8.22.0/24"},
			{"10.8.23.0/24"},
			{"10.8.24.0/24"},
			{"10.8.25.0/24"},
			{"10.8.26.0/24"},
			{"10.8.27.0/24"},
			{"10.8.28.0/24"},
			{"10.8.29.0/24"},
			{"10.8.30.0/24"},
			{"10.8.31.0/24"},
			{"10.8.32.0/24"},
			{"10.8.33.0/24"},
			{"10.8.34.0/24"},
			{"10.8.35.0/24"},
			{"10.8.36.0/24"},
			{"10.8.37.0/24"},
			{"10.8.38.0/24"},
			{"10.8.39.0/24"},
			{"10.8.40.0/24"},
			{"10.8.41.0/24"},
			{"10.8.42.0/24"},
			{"10.8.43.0/24"},
			{"10.8.44.0/24"},
			{"10.8.45.0/24"},
			{"10.8.46.0/24"},
			{"10.8.47.0/24"},

			{"10.9.0.0/24"},   // 50:0
			{"10.9.1.0/24"},   // 51:0
			{"10.9.2.0/24"},   // 52:0
			{"10.9.3.0/24"},   // 53:0
			{"10.9.4.0/24"},   // 54:0
			{"10.9.5.0/24"},   // 55:0
			{"10.9.6.0/24"},   // 56:0
			{"10.9.7.0/24"},   // 57:0
			{"10.9.8.0/24"},   // 58:0
			{"10.9.9.0/24"},   // 59:00
			{"10.9.10.0/24"},
			{"10.9.11.0/24"},
			{"10.9.12.0/24"},
			{"10.9.13.0/24"},
			{"10.9.14.0/24"},
			{"10.9.15.0/24"},
			{"10.9.16.0/24"},
			{"10.9.17.0/24"},
			{"10.9.18.0/24"},
			{"10.9.19.0/24"},
			{"10.9.20.0/24"},
			{"10.9.21.0/24"},
			{"10.9.22.0/24"},
			{"10.9.23.0/24"},
			{"10.9.24.0/24"},
			{"10.9.25.0/24"},
			{"10.9.26.0/24"},
			{"10.9.27.0/24"},
			{"10.9.28.0/24"},
			{"10.9.29.0/24"},
			{"10.9.30.0/24"},
			{"10.9.31.0/24"},
			{"10.9.32.0/24"},
			{"10.9.33.0/24"},
			{"10.9.34.0/24"},
			{"10.9.35.0/24"},
			{"10.9.36.0/24"},
			{"10.9.37.0/24"},
			{"10.9.38.0/24"},
			{"10.9.39.0/24"},
			{"10.9.40.0/24"},
			{"10.9.41.0/24"},
			{"10.9.42.0/24"},
			{"10.9.43.0/24"},
			{"10.9.44.0/24"},
			{"10.9.45.0/24"},
			{"10.9.46.0/24"},
			{"10.9.47.0/24"},
			{"10.9.48.0/24"},
			{"10.9.49.0/24"},
			
			{"10.10.0.0/24"},   // 100:0
			{"10.10.1.0/24"},   // 101:0
			{"10.10.2.0/24"},   // 52:0
			{"10.10.3.0/24"},   // 53:0
			{"10.10.4.0/24"},   // 54:0
			{"10.10.5.0/24"},   // 55:0
			{"10.10.6.0/24"},   // 56:0
			{"10.10.7.0/24"},   // 57:0
			{"10.10.8.0/24"},   // 58:0
			{"10.10.9.0/24"},   // 59:00
			{"10.10.10.0/24"},
			{"10.10.11.0/24"},
			{"10.10.12.0/24"},
			{"10.10.13.0/24"},
			{"10.10.14.0/24"},
			{"10.10.15.0/24"},
			{"10.10.16.0/24"},
			{"10.10.17.0/24"},
			{"10.10.18.0/24"},
			{"10.10.19.0/24"},
			{"10.10.20.0/24"},
			{"10.10.21.0/24"},
			{"10.10.22.0/24"},
			{"10.10.23.0/24"},
			{"10.10.24.0/24"},
			{"10.10.25.0/24"},
			{"10.10.26.0/24"},
			{"10.10.27.0/24"},
			{"10.10.28.0/24"},
			{"10.10.29.0/24"},
			{"10.10.30.0/24"},
			{"10.10.31.0/24"},
			{"10.10.32.0/24"},
			{"10.10.33.0/24"},
			{"10.10.34.0/24"},
			{"10.10.35.0/24"},
			{"10.10.36.0/24"},
			{"10.10.37.0/24"},
			{"10.10.38.0/24"},
			{"10.10.39.0/24"},
			{"10.10.40.0/24"},
			{"10.10.41.0/24"},
			{"10.10.42.0/24"},
			{"10.10.43.0/24"},
			{"10.10.44.0/24"},
			{"10.10.45.0/24"},
			{"10.10.46.0/24"},
			{"10.10.47.0/24"},
			{"10.10.48.0/24"},
			{"10.10.49.0/24"},
		
			{"10.11.0.0/24"},   // 50:0
			{"10.11.1.0/24"},   // 51:0
			{"10.11.2.0/24"},   // 52:0
			{"10.11.3.0/24"},   // 53:0
			{"10.11.4.0/24"},   // 54:0
			{"10.11.5.0/24"},   // 55:0
			{"10.11.6.0/24"},   // 56:0
			{"10.11.7.0/24"},   // 57:0
			{"10.11.8.0/24"},   // 58:0
			{"10.11.9.0/24"},   // 59:00
			{"10.11.10.0/24"},
			{"10.11.11.0/24"},
			{"10.11.12.0/24"},
			{"10.11.13.0/24"},
			{"10.11.14.0/24"},
			{"10.11.15.0/24"},
			{"10.11.16.0/24"},
			{"10.11.17.0/24"},
			{"10.11.18.0/24"},
			{"10.11.19.0/24"},
			{"10.11.20.0/24"},
			{"10.11.21.0/24"},
			{"10.11.22.0/24"},
			{"10.11.23.0/24"},
			{"10.11.24.0/24"},
			{"10.11.25.0/24"},
			{"10.11.26.0/24"},
			{"10.11.27.0/24"},
			{"10.11.28.0/24"},
			{"10.11.29.0/24"},
			{"10.11.30.0/24"},
			{"10.11.31.0/24"},
			{"10.11.32.0/24"},
			{"10.11.33.0/24"},
			{"10.11.34.0/24"},
			{"10.11.35.0/24"},
			{"10.11.36.0/24"},
			{"10.11.37.0/24"},
			{"10.11.38.0/24"},
			{"10.11.39.0/24"},
			{"10.11.40.0/24"},
			{"10.11.41.0/24"},
			{"10.11.42.0/24"},
			{"10.11.43.0/24"},
			{"10.11.44.0/24"},
			{"10.11.45.0/24"},
			{"10.11.46.0/24"},
			{"10.11.47.0/24"},
			{"10.11.48.0/24"},
			{"10.11.49.0/24"},			

			{"0"},
			{"$IF_IN4"},
			{"src"},
			{"12"},
			{"10.8.0.0/24"},   // 2:0
			{"10.8.1.0/24"},   // 3:0
			{"10.8.2.0/24"},   // 4:0
			{"10.8.3.0/24"},   // 5:0
			{"10.8.4.0/24"},   // 6:0
			{"10.8.5.0/24"},   // 7:0
			{"10.8.6.0/24"},   // 8:0
			{"10.8.7.0/24"},   // 9:0
			{"10.8.8.0/24"},   // 10:0
			{"10.8.9.0/24"},   // 11:00
			{"10.8.10.0/24"},
			{"10.8.11.0/24"},
			{"10.8.12.0/24"},
			{"10.8.13.0/24"},
			{"10.8.14.0/24"},
			{"10.8.15.0/24"},
			{"10.8.16.0/24"},
			{"10.8.17.0/24"},
			{"10.8.18.0/24"},
			{"10.8.19.0/24"},
			{"10.8.20.0/24"},
			{"10.8.21.0/24"},
			{"10.8.22.0/24"},
			{"10.8.23.0/24"},
			{"10.8.24.0/24"},
			{"10.8.25.0/24"},
			{"10.8.26.0/24"},
			{"10.8.27.0/24"},
			{"10.8.28.0/24"},
			{"10.8.29.0/24"},
			{"10.8.30.0/24"},
			{"10.8.31.0/24"},
			{"10.8.32.0/24"},
			{"10.8.33.0/24"},
			{"10.8.34.0/24"},
			{"10.8.35.0/24"},
			{"10.8.36.0/24"},
			{"10.8.37.0/24"},
			{"10.8.38.0/24"},
			{"10.8.39.0/24"},
			{"10.8.40.0/24"},
			{"10.8.41.0/24"},
			{"10.8.42.0/24"},
			{"10.8.43.0/24"},
			{"10.8.44.0/24"},
			{"10.8.45.0/24"},
			{"10.8.46.0/24"},
			{"10.8.47.0/24"},

			{"10.9.0.0/24"},   // 50:0
			{"10.9.1.0/24"},   // 51:0
			{"10.9.2.0/24"},   // 52:0
			{"10.9.3.0/24"},   // 53:0
			{"10.9.4.0/24"},   // 54:0
			{"10.9.5.0/24"},   // 55:0
			{"10.9.6.0/24"},   // 56:0
			{"10.9.7.0/24"},   // 57:0
			{"10.9.8.0/24"},   // 58:0
			{"10.9.9.0/24"},   // 59:00
			{"10.9.10.0/24"},
			{"10.9.11.0/24"},
			{"10.9.12.0/24"},
			{"10.9.13.0/24"},
			{"10.9.14.0/24"},
			{"10.9.15.0/24"},
			{"10.9.16.0/24"},
			{"10.9.17.0/24"},
			{"10.9.18.0/24"},
			{"10.9.19.0/24"},
			{"10.9.20.0/24"},
			{"10.9.21.0/24"},
			{"10.9.22.0/24"},
			{"10.9.23.0/24"},
			{"10.9.24.0/24"},
			{"10.9.25.0/24"},
			{"10.9.26.0/24"},
			{"10.9.27.0/24"},
			{"10.9.28.0/24"},
			{"10.9.29.0/24"},
			{"10.9.30.0/24"},
			{"10.9.31.0/24"},
			{"10.9.32.0/24"},
			{"10.9.33.0/24"},
			{"10.9.34.0/24"},
			{"10.9.35.0/24"},
			{"10.9.36.0/24"},
			{"10.9.37.0/24"},
			{"10.9.38.0/24"},
			{"10.9.39.0/24"},
			{"10.9.40.0/24"},
			{"10.9.41.0/24"},
			{"10.9.42.0/24"},
			{"10.9.43.0/24"},
			{"10.9.44.0/24"},
			{"10.9.45.0/24"},
			{"10.9.46.0/24"},
			{"10.9.47.0/24"},
			{"10.9.48.0/24"},
			{"10.9.49.0/24"},
			
			{"10.10.0.0/24"},   // 100:0
			{"10.10.1.0/24"},   // 101:0
			{"10.10.2.0/24"},   // 52:0
			{"10.10.3.0/24"},   // 53:0
			{"10.10.4.0/24"},   // 54:0
			{"10.10.5.0/24"},   // 55:0
			{"10.10.6.0/24"},   // 56:0
			{"10.10.7.0/24"},   // 57:0
			{"10.10.8.0/24"},   // 58:0
			{"10.10.9.0/24"},   // 59:00
			{"10.10.10.0/24"},
			{"10.10.11.0/24"},
			{"10.10.12.0/24"},
			{"10.10.13.0/24"},
			{"10.10.14.0/24"},
			{"10.10.15.0/24"},
			{"10.10.16.0/24"},
			{"10.10.17.0/24"},
			{"10.10.18.0/24"},
			{"10.10.19.0/24"},
			{"10.10.20.0/24"},
			{"10.10.21.0/24"},
			{"10.10.22.0/24"},
			{"10.10.23.0/24"},
			{"10.10.24.0/24"},
			{"10.10.25.0/24"},
			{"10.10.26.0/24"},
			{"10.10.27.0/24"},
			{"10.10.28.0/24"},
			{"10.10.29.0/24"},
			{"10.10.30.0/24"},
			{"10.10.31.0/24"},
			{"10.10.32.0/24"},
			{"10.10.33.0/24"},
			{"10.10.34.0/24"},
			{"10.10.35.0/24"},
			{"10.10.36.0/24"},
			{"10.10.37.0/24"},
			{"10.10.38.0/24"},
			{"10.10.39.0/24"},
			{"10.10.40.0/24"},
			{"10.10.41.0/24"},
			{"10.10.42.0/24"},
			{"10.10.43.0/24"},
			{"10.10.44.0/24"},
			{"10.10.45.0/24"},
			{"10.10.46.0/24"},
			{"10.10.47.0/24"},
			{"10.10.48.0/24"},
			{"10.10.49.0/24"},
		
			{"10.11.0.0/24"},   // 50:0
			{"10.11.1.0/24"},   // 51:0
			{"10.11.2.0/24"},   // 52:0
			{"10.11.3.0/24"},   // 53:0
			{"10.11.4.0/24"},   // 54:0
			{"10.11.5.0/24"},   // 55:0
			{"10.11.6.0/24"},   // 56:0
			{"10.11.7.0/24"},   // 57:0
			{"10.11.8.0/24"},   // 58:0
			{"10.11.9.0/24"},   // 59:00
			{"10.11.10.0/24"},
			{"10.11.11.0/24"},
			{"10.11.12.0/24"},
			{"10.11.13.0/24"},
			{"10.11.14.0/24"},
			{"10.11.15.0/24"},
			{"10.11.16.0/24"},
			{"10.11.17.0/24"},
			{"10.11.18.0/24"},
			{"10.11.19.0/24"},
			{"10.11.20.0/24"},
			{"10.11.21.0/24"},
			{"10.11.22.0/24"},
			{"10.11.23.0/24"},
			{"10.11.24.0/24"},
			{"10.11.25.0/24"},
			{"10.11.26.0/24"},
			{"10.11.27.0/24"},
			{"10.11.28.0/24"},
			{"10.11.29.0/24"},
			{"10.11.30.0/24"},
			{"10.11.31.0/24"},
			{"10.11.32.0/24"},
			{"10.11.33.0/24"},
			{"10.11.34.0/24"},
			{"10.11.35.0/24"},
			{"10.11.36.0/24"},
			{"10.11.37.0/24"},
			{"10.11.38.0/24"},
			{"10.11.39.0/24"},
			{"10.11.40.0/24"},
			{"10.11.41.0/24"},
			{"10.11.42.0/24"},
			{"10.11.43.0/24"},
			{"10.11.44.0/24"},
			{"10.11.45.0/24"},
			{"10.11.46.0/24"},
			{"10.11.47.0/24"},
			{"10.11.48.0/24"},
			{"10.11.49.0/24"},			
			{"0"},
			{"$IF_LAN16"},
			{"dst"},
			{"16"},
			{"10.16.0.0/24"},   // 2:0
			{"10.16.1.0/24"},   // 3:0
			{"10.16.2.0/24"},   // 4:0
			{"10.16.3.0/24"},   // 5:0
			{"10.16.4.0/24"},   // 6:0
			{"10.16.5.0/24"},   // 7:0
			{"10.16.6.0/24"},   // 8:0
			{"10.16.7.0/24"},   // 9:0
			{"10.16.8.0/24"},   // 10:0
			{"10.16.9.0/24"},   // 11:00
			{"10.16.10.0/24"},
			{"10.16.11.0/24"},
			{"10.16.12.0/24"},
			{"10.16.13.0/24"},
			{"10.16.14.0/24"},
			{"10.16.15.0/24"},
			{"10.16.16.0/24"},
			{"10.16.17.0/24"},
			{"10.16.18.0/24"},
			{"10.16.19.0/24"},
			{"10.16.20.0/24"},
			{"10.16.21.0/24"},
			{"10.16.22.0/24"},
			{"10.16.23.0/24"},
			{"10.16.24.0/24"},
			{"10.16.25.0/24"},
			{"10.16.26.0/24"},
			{"10.16.27.0/24"},
			
			{"10.17.0.0/24"},   // 30:0
			{"10.17.1.0/24"},   // 31:0
			{"10.17.2.0/24"},   // 52:0
			{"10.17.3.0/24"},   // 53:0
			{"10.17.4.0/24"},   // 54:0
			{"10.17.5.0/24"},   // 55:0
			{"10.17.6.0/24"},   // 56:0
			{"10.17.7.0/24"},   // 57:0
			{"10.17.8.0/24"},   // 58:0
			{"10.17.9.0/24"},   // 59:00
			{"10.17.10.0/24"},
			{"10.17.11.0/24"},
			{"10.17.12.0/24"},
			{"10.17.13.0/24"},
			{"10.17.14.0/24"},
			{"10.17.15.0/24"},
			{"10.17.16.0/24"},
			{"10.17.17.0/24"},
			{"10.17.18.0/24"},
			{"10.17.19.0/24"},
			{"10.17.20.0/24"},
			{"10.17.21.0/24"},
			{"10.17.22.0/24"},
			{"10.17.23.0/24"},
			{"10.17.24.0/24"},
			{"10.17.25.0/24"},
			{"10.17.26.0/24"},
			{"10.17.27.0/24"},
			{"10.17.28.0/24"},
			{"10.17.29.0/24"},

			{"10.18.0.0/24"},   // 60:0
			{"10.18.1.0/24"},   // 61:0
			{"10.18.2.0/24"},   // 52:0
			{"10.18.3.0/24"},   // 53:0
			{"10.18.4.0/24"},   // 54:0
			{"10.18.5.0/24"},   // 55:0
			{"10.18.6.0/24"},   // 56:0
			{"10.18.7.0/24"},   // 57:0
			{"10.18.8.0/24"},   // 58:0
			{"10.18.9.0/24"},   // 59:00
			{"10.18.10.0/24"},
			{"10.18.11.0/24"},
			{"10.18.12.0/24"},
			{"10.18.13.0/24"},
			{"10.18.14.0/24"},
			{"10.18.15.0/24"},
			{"10.18.16.0/24"},
			{"10.18.17.0/24"},
			{"10.18.18.0/24"},
			{"10.18.19.0/24"},
			{"10.18.20.0/24"},
			{"10.18.21.0/24"},
			{"10.18.22.0/24"},
			{"10.18.23.0/24"},
			{"10.18.24.0/24"},
			{"10.18.25.0/24"},
			{"10.18.26.0/24"},
			{"10.18.27.0/24"},
			{"10.18.28.0/24"},
			{"10.18.29.0/24"},

			{"10.19.0.0/24"},   // 90:0
			{"10.19.1.0/24"},   // 91:0
			{"10.19.2.0/24"},   // 52:0
			{"10.19.3.0/24"},   // 53:0
			{"10.19.4.0/24"},   // 54:0
			{"10.19.5.0/24"},   // 55:0
			{"10.19.6.0/24"},   // 56:0
			{"10.19.7.0/24"},   // 57:0
			{"10.19.8.0/24"},   // 58:0
			{"10.19.9.0/24"},   // 59:00
			{"10.19.10.0/24"},
			{"10.19.11.0/24"},
			{"10.19.12.0/24"},
			{"10.19.13.0/24"},
			{"10.19.14.0/24"},
			{"10.19.15.0/24"},
			{"10.19.16.0/24"},
			{"10.19.17.0/24"},
			{"10.19.18.0/24"},
			{"10.19.19.0/24"},
			{"10.19.20.0/24"},
			{"10.19.21.0/24"},
			{"10.19.22.0/24"},
			{"10.19.23.0/24"},
			{"10.19.24.0/24"},
			{"10.19.25.0/24"},
			{"10.19.26.0/24"},
			{"10.19.27.0/24"},
			{"10.19.28.0/24"},
			{"10.19.29.0/24"},

			{"10.22.0.0/24"},   // 120:0
			{"10.22.1.0/24"},   // 121:0
			{"10.22.2.0/24"},   // 52:0
			{"10.22.3.0/24"},   // 53:0
			{"10.22.4.0/24"},   // 54:0
			{"10.22.5.0/24"},   // 55:0
			{"10.22.6/24"},   // 120:0
			{"10.22.7.0/24"},   // 121:0
			{"10.22.8.0/24"},   // 52:0
			{"10.22.9.0/24"},   // 53:0
			{"10.22.10.0/24"},   // 54:0
			{"10.22.11.0/24"},   // 55:0
			{"10.22.12.0/24"},   // 54:0
			{"10.22.13.0/24"},   // 55:0
			{"10.22.14.0/24"},   // 54:0
			{"10.22.15.0/24"},   // 55:0
			{"10.22.16.0/24"},   // 54:0
			{"10.22.17.0/24"},   // 55:0
			{"10.22.18.0/24"},   // 54:0
			{"10.22.19.0/24"},   // 55:0
			{"10.22.20.0/24"},   // 54:0
			{"10.22.21.0/24"},   // 55:0
			{"10.22.22.0/24"},   // 55:0
			{"10.22.23.0/24"},   // 55:0
			{"10.22.24.0/24"},   // 55:0
			{"10.22.25.0/24"},   // 55:0
			{"10.22.26.0/24"},   // 55:0
			{"10.22.27.0/24"},   // 55:0
			{"10.22.28.0/24"},   // 55:0
			{"10.22.29.0/24"},   // 55:0
		  {"0"},
			{"$IF_IN5"},
			{"src"},
			{"12"},
			{"10.16.0.0/24"},   // 2:0
			{"10.16.1.0/24"},   // 3:0
			{"10.16.2.0/24"},   // 4:0
			{"10.16.3.0/24"},   // 5:0
			{"10.16.4.0/24"},   // 6:0
			{"10.16.5.0/24"},   // 7:0
			{"10.16.6.0/24"},   // 8:0
			{"10.16.7.0/24"},   // 9:0
			{"10.16.8.0/24"},   // 10:0
			{"10.16.9.0/24"},   // 11:00
			{"10.16.10.0/24"},
			{"10.16.11.0/24"},
			{"10.16.12.0/24"},
			{"10.16.13.0/24"},
			{"10.16.14.0/24"},
			{"10.16.15.0/24"},
			{"10.16.16.0/24"},
			{"10.16.17.0/24"},
			{"10.16.18.0/24"},
			{"10.16.19.0/24"},
			{"10.16.20.0/24"},
			{"10.16.21.0/24"},
			{"10.16.22.0/24"},
			{"10.16.23.0/24"},
			{"10.16.24.0/24"},
			{"10.16.25.0/24"},
			{"10.16.26.0/24"},
			{"10.16.27.0/24"},
			
			{"10.17.0.0/24"},   // 30:0
			{"10.17.1.0/24"},   // 31:0
			{"10.17.2.0/24"},   // 52:0
			{"10.17.3.0/24"},   // 53:0
			{"10.17.4.0/24"},   // 54:0
			{"10.17.5.0/24"},   // 55:0
			{"10.17.6.0/24"},   // 56:0
			{"10.17.7.0/24"},   // 57:0
			{"10.17.8.0/24"},   // 58:0
			{"10.17.9.0/24"},   // 59:00
			{"10.17.10.0/24"},
			{"10.17.11.0/24"},
			{"10.17.12.0/24"},
			{"10.17.13.0/24"},
			{"10.17.14.0/24"},
			{"10.17.15.0/24"},
			{"10.17.16.0/24"},
			{"10.17.17.0/24"},
			{"10.17.18.0/24"},
			{"10.17.19.0/24"},
			{"10.17.20.0/24"},
			{"10.17.21.0/24"},
			{"10.17.22.0/24"},
			{"10.17.23.0/24"},
			{"10.17.24.0/24"},
			{"10.17.25.0/24"},
			{"10.17.26.0/24"},
			{"10.17.27.0/24"},
			{"10.17.28.0/24"},
			{"10.17.29.0/24"},

			{"10.18.0.0/24"},   // 60:0
			{"10.18.1.0/24"},   // 61:0
			{"10.18.2.0/24"},   // 52:0
			{"10.18.3.0/24"},   // 53:0
			{"10.18.4.0/24"},   // 54:0
			{"10.18.5.0/24"},   // 55:0
			{"10.18.6.0/24"},   // 56:0
			{"10.18.7.0/24"},   // 57:0
			{"10.18.8.0/24"},   // 58:0
			{"10.18.9.0/24"},   // 59:00
			{"10.18.10.0/24"},
			{"10.18.11.0/24"},
			{"10.18.12.0/24"},
			{"10.18.13.0/24"},
			{"10.18.14.0/24"},
			{"10.18.15.0/24"},
			{"10.18.16.0/24"},
			{"10.18.17.0/24"},
			{"10.18.18.0/24"},
			{"10.18.19.0/24"},
			{"10.18.20.0/24"},
			{"10.18.21.0/24"},
			{"10.18.22.0/24"},
			{"10.18.23.0/24"},
			{"10.18.24.0/24"},
			{"10.18.25.0/24"},
			{"10.18.26.0/24"},
			{"10.18.27.0/24"},
			{"10.18.28.0/24"},
			{"10.18.29.0/24"},

			{"10.19.0.0/24"},   // 90:0
			{"10.19.1.0/24"},   // 91:0
			{"10.19.2.0/24"},   // 52:0
			{"10.19.3.0/24"},   // 53:0
			{"10.19.4.0/24"},   // 54:0
			{"10.19.5.0/24"},   // 55:0
			{"10.19.6.0/24"},   // 56:0
			{"10.19.7.0/24"},   // 57:0
			{"10.19.8.0/24"},   // 58:0
			{"10.19.9.0/24"},   // 59:00
			{"10.19.10.0/24"},
			{"10.19.11.0/24"},
			{"10.19.12.0/24"},
			{"10.19.13.0/24"},
			{"10.19.14.0/24"},
			{"10.19.15.0/24"},
			{"10.19.16.0/24"},
			{"10.19.17.0/24"},
			{"10.19.18.0/24"},
			{"10.19.19.0/24"},
			{"10.19.20.0/24"},
			{"10.19.21.0/24"},
			{"10.19.22.0/24"},
			{"10.19.23.0/24"},
			{"10.19.24.0/24"},
			{"10.19.25.0/24"},
			{"10.19.26.0/24"},
			{"10.19.27.0/24"},
			{"10.19.28.0/24"},
			{"10.19.29.0/24"},
			{"10.22.0.0/24"},   // 120:0
			{"10.22.1.0/24"},   // 121:0
			{"10.22.2.0/24"},   // 52:0
			{"10.22.3.0/24"},   // 53:0
			{"10.22.4.0/24"},   // 54:0
			{"10.22.5.0/24"},   // 55:0
			{"10.22.6/24"},   // 120:0
			{"10.22.7.0/24"},   // 121:0
			{"10.22.8.0/24"},   // 52:0
			{"10.22.9.0/24"},   // 53:0
			{"10.22.10.0/24"},   // 54:0
			{"10.22.11.0/24"},   // 55:0
			{"10.22.12.0/24"},   // 54:0
			{"10.22.13.0/24"},   // 55:0
			{"10.22.14.0/24"},   // 54:0
			{"10.22.15.0/24"},   // 55:0
			{"10.22.16.0/24"},   // 54:0
			{"10.22.17.0/24"},   // 55:0
			{"10.22.18.0/24"},   // 54:0
			{"10.22.19.0/24"},   // 55:0
			{"10.22.20.0/24"},   // 54:0
			{"10.22.21.0/24"},   // 55:0
			{"10.22.22.0/24"},   // 55:0
			{"10.22.23.0/24"},   // 55:0
			{"10.22.24.0/24"},   // 55:0
			{"10.22.25.0/24"},   // 55:0
			{"10.22.26.0/24"},   // 55:0
			{"10.22.27.0/24"},   // 55:0
			{"10.22.28.0/24"},   // 55:0
			{"10.22.29.0/24"},   // 55:0
		  {"0"},

	};

	int rozmiar = (sizeof iface / sizeof *iface);
		

	fprintf(fp,  "tc qdisc del dev %s root 1> /dev/null &2>1 && \n", dev);
	fprintf(fp,  "tc qdisc add dev %s root handle 1:0  hfsc default 9999 && \n", dev);
	fprintf(fp,  "tc filter add dev %s parent 1:0 protocol ip u32 && \n", dev);
	
	for ( i=2; i<250; ++i)
	fprintf(fp,  "tc filter add dev %s parent 1:0 prio 2 handle %d:0 protocol ip u32 divisor 256 && \n", dev, i);


	for ( i=1; i< rozmiar; i++)
	{
				if ( strcmp(dev, iface[i]) == 0 )
					{
						++i;
						strcpy(aim, iface[i]);
						++i;
						strcpy(k, iface[i]);
						++i;
						j=2;
						while ( strcmp("0", iface[i]) != 0 &&  i!=rozmiar) 
							{
								fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 2 u32 ht 800:: match ip %s %s hashkey mask 0x000000ff at %s link %d:0 && \n", dev, aim, iface[i], k,j);
								++i;
								++j;
							}
					}
	}		
	fprintf(fp,   "tc class add dev %s parent 1:0 classid %d:1 hfsc ls m2 90Mbit ul m2 90Mbit && \n", dev, classid);
	fprintf(fp,   "tc class add dev %s parent 1:0 classid %d:2 hfsc ls m2 10Mbit ul m2 10Mbit && \n", dev, classid);			
	
	if ( strcmp(dev, "$IF_LAN8") == 0)
		{
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:1000 hfsc ls m2 30Mbit ul m2 20Mbit	&& \n", dev, classid, classid);
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:4000 hfsc ls m2 30Mbit ul m2 30Mbit	&& \n", dev, classid, classid);
		}
	else if ( strcmp(dev, "$IF_IN4") == 0)
		{
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:1000 hfsc ls m2 30Mbit ul m2 20Mbit	&& \n", dev, classid, classid);
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:4000 hfsc ls m2 30Mbit ul m2 30Mbit	&& \n", dev, classid, classid);
		}
	else if ( strcmp(dev, "$IF_LAN16") == 0)
		{
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:1000 hfsc ls m2 30Mbit ul m2 20Mbit	&& \n", dev, classid, classid);
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:4000 hfsc ls m2 30Mbit ul m2 30Mbit	&& \n", dev, classid, classid);
		}
	else if ( strcmp(dev, "$IF_IN5") == 0)
		{
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:1000 hfsc ls m2 30Mbit ul m2 20Mbit && \n", dev, classid, classid);
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:4000 hfsc ls m2 30Mbit ul m2 30Mbit && \n", dev, classid, classid);
		}
	else
		{
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:1000 hfsc ls m2 20Mbit ul m2 20Mbit && \n", dev, classid, classid);
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:4000 hfsc ls m2 30Mbit ul m2 30Mbit && \n", dev, classid, classid);
		}

	fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:9999 hfsc ls m2 256kbit && \n", dev, classid, classid);
	fprintf(fp,   "tc filter add dev %s protocol ip parent 1:0 prio 3 u32 match ip protocol 1 0xff flowid %d:2 && \n\n", dev, classid);

/*	
	if ( strcmp(dev, "$IF_IN0") == 0)
		{
			fprintf(fp,   "tc qdisc del dev $IF_LAN0 ingress && \n", dev);
			fprintf(fp,   "tc qdisc add dev $IF_LAN0 ingress && \n", dev);
			fprintf(fp,   "tc filter add dev $IF_LAN1 parent ffff:0 protocol ip prio 10 u32 match u32 0 0 flowid 1:1 action mirred egress redirect dev %s && \n", dev);
		}	
	else if ( strcmp(dev, "$IF_IN1") == 0)
		{
			fprintf(fp,   "tc qdisc del dev $IF_LAN1 ingress && \n", dev);
			fprintf(fp,   "tc qdisc add dev $IF_LAN1 ingress && \n", dev);
			fprintf(fp,   "tc filter add dev $IF_LAN1 parent ffff:0 protocol ip prio 10 u32 match u32 0 0 flowid 1:1 action mirred egress redirect dev %s && \n", dev);
		}	
	else if ( strcmp(dev, "$IF_IN2") == 0)
		{
			fprintf(fp,   "tc qdisc del dev $IF_LAN2 ingress && \n", dev);
			fprintf(fp,   "tc qdisc add dev $IF_LAN2 ingress && \n", dev);
			fprintf(fp,   "tc filter add dev $IF_LAN2 parent ffff:0 protocol ip prio 10 u32 match u32 0 0 flowid 1:1 action mirred egress redirect dev %s && \n", dev);
		}	
	else if ( strcmp(dev, "$IF_IN3") == 0)
		{
			fprintf(fp,   "tc qdisc del dev $IF_LAN3 ingress && \n", dev);
			fprintf(fp,   "tc qdisc add dev $IF_LAN3 ingress && \n", dev);
			fprintf(fp,   "tc filter add dev $IF_LAN1 parent ffff:0 protocol ip prio 10 u32 match u32 0 0 flowid 1:1 action mirred egress redirect dev %s && \n", dev);
			fprintf(fp,   "tc qdisc del dev $IF_LAN3 ingress && \n", dev);
			fprintf(fp,   "tc qdisc add dev $IF_LAN3 ingress && \n", dev);
			fprintf(fp,   "tc filter add dev $IF_LAN3 parent ffff:0 protocol ip prio 10 u32 match u32 0 0 flowid 1:1 action mirred egress redirect dev %s && \n", dev);
			fprintf(fp,   "tc qdisc del dev $IF_LAN4 ingress && \n", dev);
			fprintf(fp,   "tc qdisc add dev $IF_LAN4 ingress && \n", dev);
			fprintf(fp,   "tc filter add dev $IF_LAN4 parent ffff:0 protocol ip prio 10 u32 match u32 0 0 flowid 1:1 action mirred egress redirect dev %s && \n", dev);
			fprintf(fp,   "tc qdisc del dev $IF_LAN5 ingress && \n", dev);
			fprintf(fp,   "tc qdisc add dev $IF_LAN5 ingress && \n", dev);
			fprintf(fp,   "tc filter add dev $IF_LAN5 parent ffff:0 protocol ip prio 10 u32 match u32 0 0 flowid 1:1 action mirred egress redirect dev %s && \n", dev);
			fprintf(fp,   "tc qdisc del dev $IF_LAN6 ingress && \n", dev);
			fprintf(fp,   "tc qdisc add dev $IF_LAN6 ingress && \n", dev);
			fprintf(fp,   "tc filter add dev $IF_LAN6 parent ffff:0 protocol ip prio 10 u32 match u32 0 0 flowid 1:1 action mirred egress redirect dev %s && \n", dev);
			fprintf(fp,   "tc qdisc del dev $IF_LAN7 ingress && \n", dev);
			fprintf(fp,   "tc qdisc add dev $IF_LAN7 ingress && \n", dev);
			fprintf(fp,   "tc filter add dev $IF_LAN7 parent ffff:0 protocol ip prio 10 u32 match u32 0 0 flowid 1:1 action mirred egress redirect dev %s && \n", dev);
		}	
	else if ( strcmp(dev, "$IF_IN4") == 0)
		{
			fprintf(fp,   "tc qdisc del dev $IF_LAN8 ingress && \n", dev);
			fprintf(fp,   "tc qdisc add dev $IF_LAN8 ingress && \n", dev);
			fprintf(fp,   "tc filter add dev $IF_LAN8 parent ffff:0 protocol ip prio 10 u32 match u32 0 0 flowid 1:1 action mirred egress redirect dev %s && \n", dev);
		}	
	else if ( strcmp(dev, "$IF_IN5") == 0)
		{
			fprintf(fp,   "tc qdisc del dev $IF_LAN16 ingress && \n", dev);
			fprintf(fp,   "tc qdisc add dev $IF_LAN16 ingress && \n", dev);
			fprintf(fp,   "tc filter add dev $IF_LAN16 parent ffff:0 protocol ip prio 10 u32 match u32 0 0 flowid 1:1 action mirred egress redirect dev %s && \n", dev);
		}	
*/

}


void dhcp(Komputer komp, Ip ip, FILE *fp)
{
char gate[16];
int g;
									if ( strcmp( komp.dhcp, "Y") == 0  && strcmp( komp.mac, "ff:ff:ff:ff:ff:ff") != 0 && strcmp( komp.mac, "FF:FF:FF:FF:FF:FF") != 0 )
													{
														if ( ip.b2 < BAJT_WLAN1 ) 
																fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s;}\n", komp.host, komp.mac, komp.ip);
												
																	
														else if ( ip.b2 >= BAJT_WLAN1 ) 
															{
															
																switch (ip.b2)
																	{
																	
																		case 8: 		
																						sprintf(gate, "%d.%d.%d.254", ip.b1,ip.b2,ip.b3);
																						fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s;} \n", komp.host, komp.mac, komp.ip, gate     ); 
																						break;
																		case 9:
																						if (  ip.b3 >= 0 &&  ip.b3 <= 7 )
																							{
																								sprintf(gate, "%d.%d.7.254", ip.b1,ip.b2);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.248.0;} \n", komp.host, komp.mac, komp.ip, gate);
																							}
																						else  if ( ip.b3 == 27  ||  ip.b3 == 28  || ip.b3 == 29 ) 
																							{
																								g=brama29(ip.b4);
																								sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.248;} \n", komp.host, komp.mac, komp.ip, gate     );
																							}
																						else
																							{
																								sprintf(gate, "%d.%d.%d.254", ip.b1,ip.b2,ip.b3);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s;} \n", komp.host, komp.mac, komp.ip, gate     ); 
																							}
																						break;
																						
																		case 10:	
																		
																						if ( ip.b3 == 27  ||  ip.b3 == 28  || ip.b3 == 29  ) 
																							{
																								g=brama29(ip.b4);
																								sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.248;} \n", komp.host, komp.mac, komp.ip, gate     );
																							}
																						else
																							{
																								sprintf(gate, "%d.%d.%d.254", ip.b1,ip.b2,ip.b3);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s;} \n", komp.host, komp.mac, komp.ip, gate     ); 
																							}
																						break;
																		case 16:	
																						if ( ip.b3 == 0  ) 
																							{
																								sprintf(gate, "%d.%d.0.1", ip.b1,ip.b2,ip.b3);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s;} \n", komp.host, komp.mac, komp.ip, gate     ); 
																							}
																						else if ( ip.b3 == 1  ) 
																							{
																								sprintf(gate, "%d.%d.%d.254", ip.b1,ip.b2,ip.b3);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s;} \n", komp.host, komp.mac, komp.ip, gate     ); 
																							}
																						break;
																						
																		case 17:
																						if ( ip.b3 == 29 ) 
																							{
																								g=brama29(ip.b4);
																								sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.248;} \n", komp.host, komp.mac, komp.ip, gate     );
																							}
																						else
																							{
																								sprintf(gate, "%d.%d.%d.254", ip.b1,ip.b2,ip.b3);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s;} \n", komp.host, komp.mac, komp.ip, gate     ); 
																							}
																						break;
																									
																		case 18:
																						if ( ip.b3 == 29 ) 
																							{
																								g=brama29(ip.b4);
																								sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.248;} \n", komp.host, komp.mac, komp.ip, gate     );
																							}
																						else
																							{
																								sprintf(gate, "%d.%d.%d.254", ip.b1,ip.b2,ip.b3);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s;} \n", komp.host, komp.mac, komp.ip, gate     ); 
																							}
																						break;
										
																		case 19:
																						if ( ip.b3 == 29 ) 
																							{
																								g=brama29(ip.b4);
																								sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.248;} \n", komp.host, komp.mac, komp.ip, gate     );
																							}
																						else
																							{
																								sprintf(gate, "%d.%d.%d.254", ip.b1,ip.b2,ip.b3);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s;} \n", komp.host, komp.mac, komp.ip, gate     ); 
																							}
																						break;
										
																		case 20:
																						if ( ip.b3 == 29 ) 
																							{
																								g=brama29(ip.b4);
																								sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.248;} \n", komp.host, komp.mac, komp.ip, gate     );
																							}
																						else
																							{
																								sprintf(gate, "%d.%d.%d.254", ip.b1,ip.b2,ip.b3);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s;} \n", komp.host, komp.mac, komp.ip, gate     ); 
																							}
																						break;
																		case 21:
																						if ( ip.b3 == 29 ) 
																							{
																								g=brama29(ip.b4);
																								sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.248;} \n", komp.host, komp.mac, komp.ip, gate     );
																							}
																						else
																							{
																								sprintf(gate, "%d.%d.%d.254", ip.b1,ip.b2,ip.b3);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s;} \n", komp.host, komp.mac, komp.ip, gate     ); 
																							}
																						break;
																		case 22:
																						if ( ip.b3 == 29 ) 
																							{
																								g=brama29(ip.b4);
																								sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.248;} \n", komp.host, komp.mac, komp.ip, gate     );
																							}
																						else
																							{
																								sprintf(gate, "%d.%d.%d.254", ip.b1,ip.b2,ip.b3);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s;} \n", komp.host, komp.mac, komp.ip, gate     ); 
																							}
																						break;
																																					
															//			default:
															//							sprintf(gate, "%d.%d.0.1", ip.b1,ip.b2);															
															//							fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s;} \n", komp.host, komp.mac, komp.ip, gate );		
															//							break;
																	}
																		
															}					 
													}							 
			

}


void dhcp_head(FILE *fp)
{
		fprintf( fp, "AUTHORITATIVE;\n");
		fprintf( fp, "ddns-update-style ad-hoc; \n\n");
}

void dhcp_head2(int b2, FILE *fp)
{

	char subnet[16];
	char gate[16];
	char subnetmask[16]="255.255.255.0";
	char broadcast[16];
	char netmask[16]="255.255.0.0";
	
	sprintf(subnet,    "10.%d.0.0",     b2);
	sprintf(gate,      "10.%d.0.1",     b2);
	sprintf(broadcast, "10.%d.255.255", b2);


	if ( b2 < BAJT_WLAN1 )
		{
			fprintf(fp, "subnet %s netmask %s                              \n", subnet, netmask);
			fprintf(fp, "{                                                 \n");
			fprintf(fp, "deny unknown-clients;                             \n");
			fprintf(fp, "default-lease-time           %d;                  \n", D_LEASE_TIME   );
			fprintf(fp, "max-lease-time               %d;                  \n", MAX_LEASE_TIME );
			fprintf(fp, "option domain-name           \"netico.pl\";       \n");
			fprintf(fp, "option domain-name-servers   %s, %s, %s; 				 \n", DNS1, DNS2, DNS3 );
			fprintf(fp, "option subnet-mask           %s;                  \n", netmask  );
			fprintf(fp, "option broadcast-address     %s;                  \n", broadcast );
			fprintf(fp, "option routers               %s;                  \n", gate );
			fprintf(fp, "option netbios-name-servers  %s;                  \n", gate );
		}
	else if ( b2 >= BAJT_WLAN2 )
		{
			fprintf(fp, "subnet 10.16.0.0 netmask 255.248.0.0              \n");
			fprintf(fp, "{                                                 \n");
			fprintf(fp, "deny unknown-clients;                             \n");
			fprintf(fp, "default-lease-time           %d;                  \n", D_LEASE_TIME   );
			fprintf(fp, "max-lease-time               %d;                  \n", MAX_LEASE_TIME );
			fprintf(fp, "option domain-name           \"netico.pl\";       \n");
			fprintf(fp, "option domain-name-servers   %s, %s, %s; 				 \n", DNS1, DNS2, DNS3 );
			fprintf(fp, "option subnet-mask           %s;                  \n", subnetmask);
		 }                                         
	else
		{
			fprintf(fp, "subnet 10.8.0.0 netmask 255.248.0.0               \n");
			fprintf(fp, "{                                                 \n");
			fprintf(fp, "deny unknown-clients;                             \n");
			fprintf(fp, "default-lease-time           %d;                  \n", D_LEASE_TIME   );
			fprintf(fp, "max-lease-time               %d;                  \n", MAX_LEASE_TIME );
			fprintf(fp, "option domain-name           \"netico.pl\";       \n");
			fprintf(fp, "option domain-name-servers   %s, %s, %s; 				 \n", DNS1, DNS2, DNS3 );
			fprintf(fp, "option subnet-mask           %s;                  \n", subnetmask);
		 } 
		fprintf(fp, "                                                    \n");
}


void hosts_head(FILE *fp)
{
		fprintf(fp,  "127.0.0.1  \t  localhost                 \n" );
		fprintf(fp,  "%s \t  quark_lan.%s  \t  quark_lan \n", IP_LAN,     DOMAIN1 );
		fprintf(fp,  "%s \t  w3cache1.%s   \t  quark   	\n",IP_INET1,   DOMAIN1 );
		fprintf(fp,  "%s \t  w3cache10.%s  \t  quark  \n", IP_INET1_0, DOMAIN1 );
		fprintf(fp,  "%s \t  w3cache11.%s  \t  quark  \n", IP_INET1_1, DOMAIN1 );
		fprintf(fp,  "%s \t  w3cache12.%s  \t  quark  \n", IP_INET1_2, DOMAIN1 );
		fprintf(fp,  "%s \t  w3cache13.%s  \t  quark  \n", IP_INET1_3, DOMAIN1 );

		fprintf(fp,  "%s \t  w3cache2.%s   \t  quark  	\n",  IP_INET2, DOMAIN1 );
		fprintf(fp,  "%s \t  w3cache20.%s  \t  quark  \n", IP_INET2_0, DOMAIN1 );
		fprintf(fp,  "%s \t  w3cache21.%s  \t  quark  \n", IP_INET2_1, DOMAIN1 );
		fprintf(fp,  "%s \t  w3cache22.%s  \t  quark  \n", IP_INET2_2, DOMAIN1 );
		fprintf(fp,  "%s \t  w3cache23.%s  \t  quark  \n", IP_INET2_3, DOMAIN1 );
}


void mkfile(FILE *fp)
{
	fprintf(fp, "#!/bin/bash\n" );
  fprintf(fp, "source /etc/conf \n\n" );

	//if ( fchmod(fp, mode) < 0)
	//	perror("fchmod");
}


int gen (str file, int *n, int j, int k, int tmpbajt, FILE *fps[], char *arg)
{

  Komputer komp;
	Ip ip;
  FILE *fp, *fpnat, *fphfsc;
	int classid, oldbajt, g;
	char *iflan, *ifin;
	char gate[16], mac_source[20];
	char **tabip;	


  if ( (fp=fopen(file, "r") ) == NULL ) 
			{
				printf ("\n Nie mogê otworzyæ pliku: %s\n\n", file);
				exit(1);
			}
	else 
		{
			//printf (" Generating config files for \"%s\" ...\n", file);
			oldbajt=tmpbajt;
			while ( fscanf (fp, "%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t", komp.host,komp.mac, komp.ip, komp.ip_zewn, komp.net_speed, komp.lan_speed, komp.dhcp, komp.powiaz, komp.net, komp.proxy, komp.dg, komp.info) != EOF )
					{
						if ( strcmp( komp.host, "[HOST]") != 0 )
							{
							
									tabip=explode('.', komp.ip);
										
									ip.b1=atoi(tabip[0]); // kowersja ze stringa na int
									ip.b2=atoi(tabip[1]);
									ip.b3=atoi(tabip[2]);
									ip.b4=atoi(tabip[3]);
							//	printf ("%s\t\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s \n", komp.host, komp.mac, komp.ip, komp.ip_zewn, komp.net_speed, komp.lan_speed, komp.dhcp, komp.powiaz, komp.net, komp.proxy, komp.dg, komp.info);
								
									if ( strcmp(arg, "dhcp") !=0 ) 
										{
												fprintf(fps[31], "#---- %s ----------------------------------------------------------------------------------------------------------------------------------------# \n", komp.host);
												fprintf(fps[33], "%s  \t  %s.netico.pl         \t  %s \n", komp.ip, komp.host, komp.host);
								
												switch (ip.b2)
												{
														case 0:
																		fpnat=fps[0];
																		fphfsc=fps[11];
																		iflan="$IF_LAN0";
																		break;
											
														case 1:
																		fpnat=fps[1];
																		fphfsc=fps[12];
																		iflan="$IF_LAN1";
																		break;
														case 2:
																		classid=4;
																		fpnat=fps[2];
																		fphfsc=fps[13];
																		iflan="$IF_LAN2";
																		break;
														case 3:
																		classid=5;
																		fpnat=fps[3];
																		fphfsc=fps[14];
																		iflan="$IF_LAN3";
																		break;
														case 4:
																		classid=6;
																		fpnat=fps[4];
																		fphfsc=fps[15];
																		iflan="$IF_LAN4";
																		break;
														case 5:
																		classid=7;
																		fpnat=fps[5];
																		fphfsc=fps[16];
																		iflan="$IF_LAN5";
																		break;
														case 6:
																		classid=8;
																		fpnat=fps[6];
																		fphfsc=fps[17];
																		iflan="$IF_LAN6";
																		break;
														case 7:
																		classid=9;
																		fpnat=fps[7];
																		fphfsc=fps[18];
																		iflan="$IF_LAN7";
																		break;
														case 8:
																		classid=10;
																		fpnat=fps[8];
																		fphfsc=fps[19];
																		iflan="$IF_LAN8";
																		break;
														case 9:
																		classid=10;
																		fpnat=fps[8];
																		fphfsc=fps[19];
																		iflan="$IF_LAN8";
																		break;
														case 10:
																		classid=10;
																		fpnat=fps[8];
																		fphfsc=fps[19];
																		iflan="$IF_LAN8";
																		break;
														case 11:
																		classid=10;
																		fpnat=fps[8];
																		fphfsc=fps[19];
																		iflan="$IF_LAN8";
																		break;
														case 12:
																		classid=10;
																		fpnat=fps[8];
																		fphfsc=fps[19];
																		iflan="$IF_LAN8";
																		break;
														case 13:
																		classid=10;
																		fpnat=fps[8];
																		fphfsc=fps[19];
																		iflan="$IF_LAN8";
																		break;
														case 15:
																		classid=10;
																		fpnat=fps[8];
																		fphfsc=fps[19];
																		iflan="$IF_LAN8";
																		break;
														case 16:
																		classid=11;
																		fpnat=fps[9];
																		fphfsc=fps[20];
																		iflan="$IF_LAN16";
																		break;
														case 17:
																		classid=11;
																		fpnat=fps[9];
																		fphfsc=fps[20];
																		iflan="$IF_LAN16";
																		break;
														case 18:
																		classid=11;
																		fpnat=fps[9];
																		fphfsc=fps[20];
																		iflan="$IF_LAN16";
																		break;
														case 19:
																		classid=11;
																		fpnat=fps[9];
																		fphfsc=fps[20];
																		iflan="$IF_LAN16";
																		break;
														case 20:
																		classid=11;
																		fpnat=fps[9];
																		fphfsc=fps[20];
																		iflan="$IF_LAN16";
																		break;
														case 21:
																		classid=11;
																		fpnat=fps[9];
																		fphfsc=fps[20];
																		iflan="$IF_LAN16";
																		break;
														case 22:
																		classid=11;
																		fpnat=fps[9];
																		fphfsc=fps[20];
																		iflan="$IF_LAN16";
																		break;
														case 24:
																		classid=12;
																		fpnat=fps[10];
																		fphfsc=fps[21];
																		iflan="$IF_LAN24";
																		break;
														case 25:
																		classid=12;
																		fpnat=fps[10];
																		fphfsc=fps[21];
																		iflan="$IF_LAN24";
																		break;
														case 26:
																		classid=12;
																		fpnat=fps[10];
																		fphfsc=fps[21];
																		iflan="$IF_LAN24";
																		break;
														case 27:
																		classid=12;
																		fpnat=fps[10];
																		fphfsc=fps[21];
																		iflan="$IF_LAN24";
																		break;
														case 28:
																		classid=12;
																		fpnat=fps[10];
																		fphfsc=fps[21];
																		iflan="$IF_LAN24";
																		break;
														case 29:
																		classid=12;
																		fpnat=fps[10];
																		fphfsc=fps[21];
																		iflan="$IF_LAN24";
																		break;
														case 30:
																		classid=12;
																		fpnat=fps[10];
																		fphfsc=fps[21];
																		iflan="$IF_LAN24";
																		break;
												}

															
												fprintf(fpnat,  "#---- %s ----------------------------------------------------------------------------------------------------------------------------------------# \n", komp.host);
															
												if ( ip.b2 != oldbajt )
														if ( ip.b2 < 8  ||  ip.b2 == 8  ||  ip.b2 == 16  ||  ip.b2 == 24 )
															{
																oldbajt=ip.b2;
																fprintf ( fps[32], "} \n"  );
																dhcp_head2(ip.b2, fps[32]);
															}
																																																													
												dhcp( komp, ip, fps[32]);
												
													if ( strcmp(komp.powiaz,"Y") == 0 )
														{
															strcpy(mac_source,komp.mac);
															//printf ("\n%s\n", mac_source);
														}
													else 
															strcpy(mac_source, "ff:ff:ff:ff:ff:ff");
													
													if ( strcmp(komp.net,"Y") == 0 ) 
													{
															hfsc( komp.host, komp.ip, komp.ip_zewn, komp.net_speed, komp.lan_speed, n, fps);
															++*n;								

														
															if (  strcmp(komp.ip_zewn, "$IP_NAT") != 0 ) 
																{
																	interfaces (k, komp.ip_zewn, "$IF_INET3", "$NETMASK_I", fps[35]);
																	++k;
																}
																															 
														//	arptables(komp.mac, komp.host);
														//	statistics(komp.ip);
															masq(komp.ip, mac_source,  komp.ip_zewn, fpnat);
													
															if ( strcmp(komp.proxy, "Y") == 0 ) 
																	proxy(komp.ip, mac_source, fpnat);
														else 
																	bez_proxy(komp.ip, mac_source, fpnat);
															
															if ( strcmp(komp.dg, "Y") == 0 )
																	dansguardian(komp.ip, fps[34]);
											
													}								
													
													else if ( strcmp(komp.net, "N") == 0 )
														wylacz_net( komp.ip, mac_source, fpnat);
											
													if ( strcmp(komp.info,"Y") == 0 )
														info (komp.ip, komp.host, fps[36], fps[37]);
														
											}
										else
											{
												if ( ip.b2 != oldbajt )
														if ( ip.b2 < 8  ||  ip.b2 == 8  ||  ip.b2 == 16  ||  ip.b2 == 24 )
															{
																oldbajt=ip.b2;
																fprintf ( fps[32], "} \n"  );
																dhcp_head2(ip.b2, fps[32]);
															}
																																																													
												dhcp( komp, ip, fps[32]);
											}
							}
							
					}
						fclose (fp); /* zamknij plik */
		}

	return(oldbajt);
}

void read_conf (str file)
{
	str stala, wartosc;
  FILE *fp; 

  if ((fp=fopen(file, "r"))==NULL) 
			{
				printf ("\n Nie mogê otworzyæ pliku: %s\n\n", file);
				exit(1);
			}

	while ( fscanf (fp, "%s %s\n", stala, wartosc) != EOF )
			{
				//if ( strcmp(line,"#")!=0 )
						printf ("stala=%s  - %s \n", stala, wartosc);
			}
  fclose (fp); /* zamknij plik */

}

FILE *fwopen (str filename)
{
	FILE *fp;
	
	if ( ( fp=fopen(filename, "w") ) == NULL ) 
			{
				printf ("\n Nie mogê otworzyæ pliku: %s\n\n", filename);
				exit(1);
			}	
	else 
			return (fp);
}


