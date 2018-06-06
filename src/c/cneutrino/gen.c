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
	

int brama(int i, int bity)
{

		int a, b, c;
		a=pow(2,(32-bity));
	
    c = i / a;
    b = c*a+(a-2);
    return (b);
}
	

int brama29 (int i)
{
	int b, c;
	
    c = i / 8;
    b = c*8 +6;
    return (b);
}


// Enable internet for user
void masq(str ip, str mac, str ipzewn, FILE *fp, str accept)
{ 	
	Ip adres;
	char **tabip;
	char ipmac[100]="";
	
	if ( strcmp("ff:ff:ff:ff:ff:ff", mac) != 0 )
		{
			sprintf(ipmac, "%s%", ip);
			sprintf(ipmac, "%s %s", ipmac, mac);
		}
	else 
	{
			sprintf(ipmac, "%s", ip);
		}		
	        
	tabip=explode('.', ip);
	adres.b1=atoi(tabip[0]); // kowersja ze stringa na int
	adres.b2=atoi(tabip[1]);
	adres.b3=atoi(tabip[2]);
	adres.b4=atoi(tabip[3]);
	
	if ( adres.b1 != BAJT_CORE )
	{
	    fprintf(fp,  "if ! $IPS -T %s %s > /dev/null 2> /dev/null \n", accept, ip);
	    fprintf(fp,  "then $IPS -A %s %s \n", accept, ip);
	    fprintf(fp,  "fi \n");
	}
	if ( strcmp(ipzewn,IP_NAT) != 0 )
		{
//			fprintf(fp,  "$IPS -A %s %s \n", accept, ip);
//			fprintf(fp,  "$IPT -t nat -D PREROUTING -t mangle -s %s -j MARK --set-mark 3 1> /dev/null \n", ip);
			fprintf(fp,  "$IPT -t nat -D POSTROUTING -s %s ! -o $IF_MAN0 ! -d $N_WAN0 -j SNAT --to %s  1> /dev/null \n", ip, ipzewn);
			fprintf(fp,  "$IPT -t nat -D PREROUTING -d %s -j DNAT --to %s   1> /dev/null  \n", ipzewn, ip);

//			fprintf(fp,  "$IPT -t nat -I PREROUTING -t mangle -s %s -j MARK --set-mark 3 \n", ip);
			fprintf(fp,  "$IPT -t nat -I POSTROUTING -s %s ! -o $IF_MAN0 ! -d $N_WAN0 -j SNAT --to %s \n", ip, ipzewn);
			fprintf(fp,  "$IPT -t nat -I PREROUTING -d %s -j DNAT --to %s  \n", ipzewn, ip);
		}
}	


void interfaces(int i, str ipzewn, str iface, str netmask, FILE *fp)
{
		fprintf(fp,  "/sbin/ifconfig lo:%d \t %s \t \t netmask %s \n", i, ipzewn, netmask);
}


// Redirect to proxy
void proxy (str ip, str mac, FILE * fp, str cache)
{

	char ipmac[100]="";
	
	if ( strcmp("ff:ff:ff:ff:ff:ff", mac) != 0 )
		{
			sprintf(ipmac, "%s%%s", ip, mac);
		}

	fprintf(fp,  "if ! $IPS -T %s %s  > /dev/null 2> /dev/null \n", cache, ip);
	fprintf(fp,  "then $IPS -A %s %s \n", cache, ip);
	fprintf(fp,  "fi \n");
		
}



void bezproxy (str ip, str mac, FILE * fp, str bezcache)
{
	char napis[100]="";
	char napis2[100]="-m mac --mac-source ";
	
	if ( strcmp("ff:ff:ff:ff:ff:ff", mac) != 0 )
		{
			sprintf(napis, "%s %s", napis2, mac);
		}
		
	fprintf(fp,  "if ! $IPS -T %s %s  > /dev/null 2> /dev/null \n", bezcache, ip);
	fprintf(fp,  "then $IPS -A %s %s \n", bezcache, ip);
	fprintf(fp,  "fi \n");
}


void wylacz_net(str ip, str mac, FILE * fp, str drop)
{
	char napis[100]="";
	char napis2[100]="-m mac --mac-source ";
	
	if ( strcmp("ff:ff:ff:ff:ff:ff", mac) != 0 )
		{
			sprintf(napis, "%s %s", napis2, mac);
		}

	fprintf(fp,  "if ! $IPS -T %s %s  > /dev/null 2> /dev/null \n", drop, ip);
	fprintf(fp,  "then $IPS -A %s %s \n", drop, ip);
	fprintf(fp,  "fi \n");
}       


void info(str ip, str host, FILE *info, FILE *info_off)
{

		fprintf(info, "#---- %s -----------------------------------------------------------------------------------------------------------# 	\n", host);	
		fprintf(info, "$IPT -t nat -I PREROUTING -s %s -p tcp -m multiport --dports 80,8080 -j DNAT --to $IP_LAN_WWW:8085  			\n", ip);	
		
		fprintf(info_off, "#---- %s -------------------------------------------------------------------------------------------------------# 	\n", host);	
		fprintf(info_off, "$IPT -t nat -D PREROUTING -s %s -p tcp -m multiport --dports 80,8080 -j DNAT --to $IP_LAN_WWW:8085  			\n", ip);	
}


void dansguardian (str ip, str mac, FILE * fp, str dansg)
{

	char napis[100]="";
	char napis2[100]="-m mac --mac-source ";
	
	if ( strcmp("ff:ff:ff:ff:ff:ff", mac) != 0 )
		{
			sprintf(napis, "%s %s", napis2, mac);
		}

	fprintf(fp,  "if ! $IPS -T %s %s  > /dev/null 2> /dev/null \n", dansg, ip);
	fprintf(fp,  "then $IPS -A %s %s \n", dansg, ip);
	fprintf(fp,  "fi \n");
}


void hfsc(str host, str ip, str ipzewn, str netdown, str landown, int *i, FILE *fps[])
{
	FILE *fp, *fpup;
	int b1, b2, b3, b4, classid, classidup, b22, i2, i3, i4, i5;
	char *ht1, *ht2, *hfsc_file, *hfscup_file, *iflan, *ifin, *CEILD, *CEILU, *CEILD_P2P, *CEILDLAN, *CEILULAN, *CEILD_MAX;
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
	
	classid=1;
	classidup=1;
  fp=fps[11];
  fpup=fps[23];
  iflan="$IF_MAN0";
  ifin="$IF_IN0";

	switch(b2)
	{
		case 9:	
				switch(b3)
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

case 29:
ht1="31:";
break;

case 30:
ht1="32:";
break;

case 31:
ht1="33:";
break;

case 32:
ht1="34:";
break;

case 33:
ht1="35:";
break;

case 34:
ht1="36:";
break;

case 35:
ht1="37:";
break;



case 36:
ht1="38:";
break;

case 37:
ht1="39:";
break;

case 38:
ht1="40:";
break;

case 39:
ht1="41:";
break;

case 40:
ht1="42:";
break;

case 41:
ht1="43:";
break;

case 42:
ht1="44:";
break;

case 43:
ht1="45:";
break;

case 44:
ht1="46:";
break;

case 45:
ht1="47:";
break;

case 46:
ht1="48:";
break;

case 47:
ht1="49:";
break;

case 48:
ht1="50:";
break;

case 49:
ht1="51:";
break;

case 50:
ht1="52:";
break;

case 51:
ht1="53:";
break;

case 52:
ht1="54:";
break;

case 53:
ht1="55:";
break;



case 54:
ht1="56:";
break;

case 55:
ht1="57:";
break;

case 56:
ht1="58:";
break;

case 57:
ht1="59:";
break;

case 58:
ht1="60:";
break;

case 59:
ht1="61:";
break;

case 60:
ht1="62:";
break;

case 61:
ht1="63:";
break;

case 62:
ht1="64:";
break;

case 63:
ht1="65:";
break;

case 64:
ht1="66:";
break;





case 128:
ht1="67:";
break;

case 129:
ht1="68:";
break;

case 130:
ht1="69:";
break;

case 131:
ht1="70:";
break;

case 132:
ht1="71:";
break;

case 133:
ht1="72:";
break;

case 134:
ht1="73:";
break;

case 135:
ht1="74:";
break;

case 136:
ht1="75:";
break;

case 137:
ht1="76:";
break;

case 138:
ht1="77:";
break;
				
case 139:
ht1="78:";
break;
				
case 140:
ht1="79:";
break;

case 141:
ht1="80:";
break;

case 142:
ht1="81:";
break;

case 143:
ht1="82:";
break;

case 144:
ht1="83:";
break;

case 145:
ht1="84:";
break;

case 146:
ht1="85:";
break;

case 147:
ht1="149:";
break;
case 148:
ht1="150:";
break;
case 149:
ht1="151:";
break;
case 150:
ht1="152:";
break;
                                                                                                                                        			
					case 224:
						ht1="86:";
						break;
					case 225:
						ht1="87:";
						break;
					case 226:
						ht1="88:";
						break;
					case 227:
						ht1="89:";
						break;
					case 240:
						ht1="90:";
						break;
					case 241:
        					ht1="91:";
        					break;
        				case 242:
        					ht1="92:";
        					break;
        				case 243:
	        				ht1="93:";
        					break;
        				case 244:
        					ht1="94:";
        					break;
	    				case 245:
		    				ht1="95:";
						break;
				}
				break;
		case 37:	
				switch(b3)
				{
					case 0:
						ht1="96:";
						break;
					case 1:
						ht1="97:";
						break;
					case 2:
						ht1="98:";
						break;
					case 3:
						ht1="99:";
						break;
					}
				break;

		case 32:	
				switch(b3)
				{
					case 0:
						ht1="100:";
						break;
				}
				break;

		case 33:	
				switch(b3)
				{
					case 3:
						ht1="196:";
						break;
					case 4:
						ht1="101:";
						break;
					case 6:
						ht1="102:";
						break;
					case 7:
						ht1="103:";
						break;
					case 8:
						ht1="104:";
						break;
					case 9:
						ht1="105:";
						break;
					case 10:
						ht1="106:";
						break;
					case 11:
						ht1="107:";
						break;
					case 12:
						ht1="108:";
						break;
					case 13:
						ht1="109:";
						break;
					case 16:
						ht1="110:";
						break;
					case 17:
						ht1="111:";
						break;
					case 18:
						ht1="112:";
						break;
					case 19:
						ht1="113:";
						break;
					case 20:
						ht1="114:";
						break;
					case 21:
						ht1="115:";
						break;
					case 22:
						ht1="116:";
						break;
					case 24:
						ht1="117:";
						break;
					case 25:
						ht1="118:";
						break;
					case 26:
						ht1="119:";
						break;
					case 27:
						ht1="120:";
						break;
					case 28:
						ht1="121:";
						break;
					case 29:
						ht1="122:";
						break;
				}
				break;

		case 36:	
				switch(b3)
				{
					case 0:
						ht1="123:";
						break;
					case 5:
						ht1="124:";
						break;
					case 8:
						ht1="125:";
						break;
					case 10:
						ht1="126:";
						break;
					case 17:
						ht1="127:";
						break;
					case 13:
						ht1="128:";
						break;
					case 16:
						ht1="129:";
						break;
					case 27:
						ht1="130:";
						break;
           case 28:
           ht1="131:";
                break;
                  case 29:
                                       ht1="132:";
                                                break;                                                                                                                                        
                                }
				break;

		case 40:

				switch (b3)
				{
					case 0:
						ht1="133:";
						break;
					case 1:
						ht1="193:";
						break;
					case 2:
						ht1="194:";
						break;
					case 4:
						ht1="134:";
						break;
					case 5:
						ht1="135:";
						break;
					case 7:
						ht1="136:";
						break;
					case 12:
						ht1="137:";
						break;
					case 16:
						ht1="138:";
						break;
					case 17:
						ht1="139:";
						break;
					case 18:
						ht1="140:";
						break;
					case 20:
						ht1="141:";
						break;
					case 21:
						ht1="142:";
						break;
					case 24:
						ht1="143:";
						break;
					case 25:
						ht1="144:";
						break;
					case 26:
						ht1="145:";
						break;
					case 27:
						ht1="146:";
						break;
					case 28:
						ht1="147:";
						break;
					case 29:
						ht1="148:";
						break;
				}
				break;
		case 48:
				switch(b3)
				{		
					case 0:
						ht1="153:";
						break;
					case 1:
						ht1="154:";
						break;
					case 2:
						ht1="155:";
						break;
					case 3:
						ht1="156:";
						break;
					case 4:
						ht1="157:";
						break;
						
					case 5:
						ht1="158:";
						break;				
					case 6:
						ht1="159:";
						break;				
					case 7:
						ht1="160:";
						break;	
					case 8:
						ht1="161:";
						break;
						
					case 9:
						ht1="162:";
						break;			
						
					case 10:
						ht1="163:";
						break;				
					case 11:
						ht1="164:";
						break;				
					case 12:
						ht1="165:";
						break;				
					case 13:
						ht1="166:";
						break;										
					case 14:
						ht1="167:";
						break;				
					case 15:
						ht1="168:";
						break;				
					case 16:
						ht1="169:";
						break;				
					case 17:
						ht1="170:";
						break;										
					case 18:
						ht1="171:";
						break;										
					case 19:
						ht1="172:";
						break;				
					case 20:
						ht1="173:";
						break;				
					case 21:
						ht1="174:";
						break;				
					case 22:
						ht1="175:";
						break;				
					case 23:
						ht1="176:";
						break;										
					case 24:
						ht1="177:";
						break;				
					case 25:
						ht1="178:";
						break;				
					case 26:
						ht1="179:";
						break;				
					case 27:
						ht1="180:";
						break;										
						
					case 28:
						ht1="181:";
						break;										
					case 29:
						ht1="182:";
						break;
				}
				break;


		case 49:
				switch (b3)
				{
					case 0:
						ht1="183:";
						break;
					case 1:
						ht1="184:";
						break;
					case 2:
						ht1="185:";
						break;
					case 3:
						ht1="186:";
						break;
					case 4:
						ht1="187:";
						break;
					case 5:
						ht1="188:";
						break;
					case 6:
						ht1="189:";
						break;
					case 7:
						ht1="190:";
						break;
				}
				break;		

		case 56:
				switch (b3)
				{
					case 6:
						ht1="195:";
						break;
				}
				break;
		case 217:
				switch (b3)
				{
				    case 221:
					ht1="197:";
					break;
				}
				break;				

		}
//	   classid_up=15;
																							      


    if ( strcmp(netdown,"STRL")==0  ) 
		{
        CEILD="$STRL_D";
        CEILU="$STRL_U";
        CEILD_P2P="$STRL_P2P";
        CEILD_MAX="$STRL_MAX";
		}
    else if ( strcmp(netdown,"MINL")==0  ) 
			{
        CEILD="$MINL_D";
        CEILU="$MINL_U";
        CEILD_P2P="$MINL_P2P";
        CEILD_MAX="$MINL_MAX";
			}
    else if ( strcmp(netdown,"STDL")==0  ) 
		{
        CEILD="$STDL_D";
        CEILU="$STDL_U";
        CEILD_P2P="$STDL_P2P";
        CEILD_MAX="$STDL_MAX";
		}
    else if ( strcmp(netdown,"MEDL")==0  ) 
		{
        CEILD="$MEDL_D";
        CEILU="$MEDL_U";
        CEILD_P2P="$MEDL_P2P";
        CEILD_MAX="$MEDL_MAX";
		}
    else if ( strcmp(netdown,"OPTL")==0  ) 
		{
        CEILD="$OPTL_D";
        CEILU="$OPTL_U";
        CEILD_P2P="$OPTL_P2P";
        CEILD_MAX="$OPTL_MAX";
		}
    else if ( strcmp(netdown,"MINK")==0  ) 
		{
        CEILD="$MINK_D";
        CEILU="$MINK_U";
        CEILD_P2P="$MINK_P2P";
        CEILD_MAX="$MINK_MAX";
		}
    else if ( strcmp(netdown,"STDK")==0  ) 
		{
        CEILD="$STDK_D";
        CEILU="$STDK_U";
        CEILD_P2P="$STDK_P2P";
        CEILD_MAX="$STDK_MAX";
		}		
    else if ( strcmp(netdown,"MEDK")==0  ) 
		{
        CEILD="$MEDK_D";
        CEILU="$MEDK_U";
        CEILD_P2P="$MEDK_P2P";
        CEILD_MAX="$MEDK_MAX";
		}
    else if ( strcmp(netdown,"OPTK")==0  ) 
		{
        CEILD="$OPTK_D";
				CEILU="$OPTK_U";
				CEILD_P2P="$OPTK_P2P";
        CEILD_MAX="$OPTK_MAX";				
		}
    else if ( strcmp(netdown,"EXTK")==0  ) 
		{
        CEILD="$EXTK_D";
				CEILU="$EXTK_U";
				CEILD_P2P="$EXTK_P2P";
        CEILD_MAX="$EXTK_MAX";
		}
    else if ( strcmp(netdown,"MINM")==0  ) 
		{
        CEILD="$MINM_D";
        CEILU="$MINM_U";
        CEILD_P2P="$MINM_P2P";
        CEILD_MAX="$MINM_MAX";
		}
    else if ( strcmp(netdown,"STDM")==0  ) 
		{
        CEILD="$STDM_D";
        CEILU="$STDM_U";
        CEILD_P2P="$STDM_P2P";
        CEILD_MAX="$STDM_MAX";
		}		
    else if ( strcmp(netdown,"MEDM")==0  ) 
		{
        CEILD="$MEDM_D";
        CEILU="$MEDM_U";
        CEILD_P2P="$MEDM_P2P";
        CEILD_MAX="$MEDM_MAX";
		}
    else if ( strcmp(netdown,"OPTM")==0  ) 
		{
        CEILD="$OPTM_D";
				CEILU="$OPTM_U";
				CEILD_P2P="$OPTM_P2P";
        CEILD_MAX="$OPTM_MAX";
		}
    else if ( strcmp(netdown,"EXTM")==0  ) 
		{
        CEILD="$EXTM_D";
				CEILU="$EXTM_U";
				CEILD_P2P="$EXTM_P2P";
        CEILD_MAX="$EXTM_MAX";
		}
		
    else if ( strcmp(netdown,"MINN")==0  ) 
		{
        CEILD="$MINN_D";
        CEILU="$MINN_U";
        CEILD_P2P="$MINN_P2P";
        CEILD_MAX="$MINN_MAX";
		}
    else if ( strcmp(netdown,"STDN")==0  ) 
		{
        CEILD="$STDN_D";
        CEILU="$STDN_U";
        CEILD_P2P="$STDN_P2P";
        CEILD_MAX="$STDN_MAX";
		}		
    else if ( strcmp(netdown,"MEDN")==0  ) 
		{
        CEILD="$MEDN_D";
        CEILU="$MEDN_U";
        CEILD_P2P="$MEDN_P2P";
        CEILD_MAX="$MEDN_MAX";
		}
    else if ( strcmp(netdown,"OPTN")==0  ) 
		{
        CEILD="$OPTN_D";
				CEILU="$OPTN_U";
				CEILD_P2P="$OPTN_P2P";
        CEILD_MAX="$OPTN_MAX";
		}
    else if ( strcmp(netdown,"EXTN")==0  ) 
		{
        CEILD="$EXTN_D";
				CEILU="$EXTN_U";
				CEILD_P2P="$EXTN_P2P";
        CEILD_MAX="$EXTN_MAX";
		}

		
    else if ( strcmp(netdown,"MINO")==0  ) 
		{
        CEILD="$MINO_D";
        CEILU="$MINO_U";
        CEILD_P2P="$MINO_P2P";
        CEILD_MAX="$MINO_MAX";
		}
    else if ( strcmp(netdown,"STDO")==0  ) 
		{
        CEILD="$STDO_D";
        CEILU="$STDO_U";
        CEILD_P2P="$STDO_P2P";
        CEILD_MAX="$STDO_MAX";
		}		
    else if ( strcmp(netdown,"MEDO")==0  ) 
		{
        CEILD="$MEDO_D";
        CEILU="$MEDO_U";
        CEILD_P2P="$MEDO_P2P";
        CEILD_MAX="$MEDO_MAX";
		}
    else if ( strcmp(netdown,"OPTO")==0  ) 
		{
        CEILD="$OPTO_D";
				CEILU="$OPTO_U";
				CEILD_P2P="$OPTO_P2P";
        CEILD_MAX="$OPTO_MAX";
		}
    else if ( strcmp(netdown,"EXTO")==0  ) 
		{
        CEILD="$EXTO_D";
				CEILU="$EXTO_U";
				CEILD_P2P="$EXTO_P2P";
        CEILD_MAX="$EXTO_MAX";
		}


// pakiety PRO
else if ( strcmp(netdown,"P1")==0  )
{
CEILD="$P1_D";
CEILU="$P1_U";
CEILD_P2P="$P1_P2P";
CEILD_MAX="$P1_MAX";
}
else if ( strcmp(netdown,"P2")==0  )
{
CEILD="$P2_D";
CEILU="$P2_U";
CEILD_P2P="$P2_P2P";
CEILD_MAX="$P2_MAX";
}
else if ( strcmp(netdown,"P4")==0  )
{
CEILD="$P4_D";
CEILU="$P4_U";
CEILD_P2P="$P4_P2P";
CEILD_MAX="$P4_MAX";
}
else if ( strcmp(netdown,"P6")==0  )
{
CEILD="$P6_D";
CEILU="$P6_U";
CEILD_P2P="$P6_P2P";
CEILD_MAX="$P6_MAX";
}
else if ( strcmp(netdown,"P8")==0  )
{
CEILD="$P8_D";
CEILU="$P8_U";
CEILD_P2P="$P8_P2P";
CEILD_MAX="$P8_MAX";
}
else if ( strcmp(netdown,"P10")==0  )
{
CEILD="$P10_D";
CEILU="$P10_U";
CEILD_P2P="$P10_P2P";
CEILD_MAX="$P10_MAX";
}
else if ( strcmp(netdown,"P12")==0  )
{
CEILD="$P12_D";
CEILU="$P12_U";
CEILD_P2P="$P12_P2P";
CEILD_MAX="$P12_MAX";
}
else if ( strcmp(netdown,"P16")==0  )
{
CEILD="$P16_D";
CEILU="$P16_U";
CEILD_P2P="$P16_P2P";
CEILD_MAX="$P16_MAX";
}
else if ( strcmp(netdown,"P20")==0  )
{
CEILD="$P20_D";
CEILU="$P20_U";
CEILD_P2P="$P20_P2P";
CEILD_MAX="$P20_MAX";
}

                                                        	

//// Pakiety Fiber PRO
else if ( strcmp(netdown,"FP10")==0  )
{
CEILD="$FP10_D";
CEILU="$FP10_U";
CEILD_P2P="$FP10_P2P";
CEILD_MAX="$FP10_MAX";
}
else if ( strcmp(netdown,"FP20")==0  )
{
CEILD="$FP20_D";
CEILU="$FP20_U";
CEILD_P2P="$FP20_P2P";
CEILD_MAX="$FP20_MAX";
}
else if ( strcmp(netdown,"FP30")==0  )
{
CEILD="$FP30_D";
CEILU="$FP30_U";
CEILD_P2P="$FP30_P2P";
CEILD_MAX="$FP30_MAX";
}
else if ( strcmp(netdown,"FP50")==0  )
{
CEILD="$FP50_D";
CEILU="$FP50_U";
CEILD_P2P="$FP50_P2P";
CEILD_MAX="$FP50_MAX";
}
else if ( strcmp(netdown,"FP70")==0  )
{
CEILD="$FP70_D";
CEILU="$FP70_U";
CEILD_P2P="$FP70_P2P";
CEILD_MAX="$FP70_MAX";
}
else if ( strcmp(netdown,"FP12")==0  )
{
CEILD="$FP12_D";
CEILU="$FP12_U";
CEILD_P2P="$FP12_P2P";
CEILD_MAX="$FP12_MAX";
}
else if ( strcmp(netdown,"FP24")==0  )
{
CEILD="$FP24_D";
CEILU="$FP24_U";
CEILD_P2P="$FP24_P2P";
CEILD_MAX="$FP24_MAX";
}
else if ( strcmp(netdown,"FP36")==0  )
{
CEILD="$FP36_D";
CEILU="$FP36_U";
CEILD_P2P="$FP36_P2P";
CEILD_MAX="$FP36_MAX";
}
else if ( strcmp(netdown,"FP60")==0  )
{
CEILD="$FP60_D";
CEILU="$FP60_U";
CEILD_P2P="$FP60_P2P";
CEILD_MAX="$FP60_MAX";
}
else if ( strcmp(netdown,"FP80")==0  )
{
CEILD="$FP80_D";
CEILU="$FP80_U";
CEILD_P2P="$FP80_P2P";
CEILD_MAX="$FP80_MAX";
}

else if ( strcmp(netdown,"S2")==0  )
{
CEILD="$S2_D";
CEILU="$S2_U";
CEILD_P2P="$S2_P2P";
CEILD_MAX="$S2_MAX";
}
else if ( strcmp(netdown,"S3")==0  )
{
CEILD="$S3_D";
CEILU="$S3_U";
CEILD_P2P="$S3_P2P";
CEILD_MAX="$S3_MAX";
}
else if ( strcmp(netdown,"S4")==0  )
{
CEILD="$S4_D";
CEILU="$S4_U";
CEILD_P2P="$S4_P2P";
CEILD_MAX="$S4_MAX";
}
else if ( strcmp(netdown,"S5")==0  )
{
CEILD="$S50_D";
CEILU="$S5_U";
CEILD_P2P="$S5_P2P";
CEILD_MAX="$S5_MAX";
}
else if ( strcmp(netdown,"S6633")==0  )
{
CEILD="$S6633_D";
CEILU="$S6633_U";
CEILD_P2P="$S6633_P2P";
CEILD_MAX="$S6633_MAX";
}
else if ( strcmp(netdown,"FA")==0  )
{
CEILD="$FA_D";
CEILU="$FA_U";
CEILD_P2P="$FA_P2P";
CEILD_MAX="$FA_MAX";
}
else if ( strcmp(netdown,"GE")==0  )
{
CEILD="$GE_D";
CEILU="$GE_U";
CEILD_P2P="$GE_P2P";
CEILD_MAX="$GE_MAX";
}

// pakiety RADIO 09.2012
else if ( strcmp(netdown,"MIN2")==0  )
{
CEILD="$MIN2_D";
CEILU="$MIN2_U";
CEILD_P2P="$MIN2_P2P";
CEILD_MAX="$MIN2_MAX";
}
else if ( strcmp(netdown,"STD7")==0  )
{
CEILD="$STD7_D";
CEILU="$STD7_U";
CEILD_P2P="$STD7_P2P";
CEILD_MAX="$STD7_MAX";
}
else if ( strcmp(netdown,"MED12")==0  )
{
CEILD="$MED12_D";
CEILU="$MED12_U";
CEILD_P2P="$MED12_P2P";
CEILD_MAX="$MED12_MAX";
}
else if ( strcmp(netdown,"OPT15")==0  )
{
CEILD="$OPT15_D";
CEILU="$OPT15_U";
CEILD_P2P="$OPT15_P2P";
CEILD_MAX="$OPT15_MAX";
}
else if ( strcmp(netdown,"EXT20")==0  )
{
CEILD="$EXT20_D";
CEILU="$EXT20_U";
CEILD_P2P="$EXT20_P2P";
CEILD_MAX="$EXT20_MAX";
}


// pakiety swiatlo 09.2012
else if ( strcmp(netdown,"MIN9")==0  )
{
CEILD="$MIN9_D";
CEILU="$MIN9_U";
CEILD_P2P="$MIN9_P2P";
CEILD_MAX="$MIN9_MAX";
}
else if ( strcmp(netdown,"STD34")==0  )
{
CEILD="$STD34_D";
CEILU="$STD34_U";
CEILD_P2P="$STD34_P2P";
CEILD_MAX="$STD34_MAX";
}
else if ( strcmp(netdown,"STD28")==0  )
{
CEILD="$STD28_D";
CEILU="$STD28_U";
CEILD_P2P="$STD28_P2P";
CEILD_MAX="$STD28_MAX";
}
else if ( strcmp(netdown,"MED46")==0  )
{
CEILD="$MED46_D";
CEILU="$MED46_U";
CEILD_P2P="$MED46_P2P";
CEILD_MAX="$MED46_MAX";
}
else if ( strcmp(netdown,"MED56")==0  )
{
CEILD="$MED56_D";
CEILU="$MED56_U";
CEILD_P2P="$MED56_P2P";
CEILD_MAX="$MED56_MAX";
}
else if ( strcmp(netdown,"OPT78")==0  )
{
CEILD="$OPT78_D";
CEILU="$OPT78_U";
CEILD_P2P="$OPT78_P2P";
CEILD_MAX="$OPT78_MAX";
}
else if ( strcmp(netdown,"EXT100")==0  )
{
CEILD="$EXT100_D";
CEILU="$EXT100_U";
CEILD_P2P="$EXT100_P2P";
CEILD_MAX="$EXT100_MAX";
}


   else if ( strcmp(netdown,"FA")==0  ) 
	 {
      CEILD="$FA_D";
			CEILU="$FA_U";
      CEILD_P2P="$FA_P2P";
        CEILD_MAX="$FA_MAX";
		}
   else if ( strcmp(netdown,"GE")==0  ) 
	 {
      CEILD="$GE_D";
			CEILU="$GE_U";
      CEILD_P2P="$GE_P2P";
        CEILD_MAX="$GE_MAX";
		}
   else if ( strcmp(netdown,"FA3Mb")==0  ) 
	 {
      CEILD="$FA3Mb_D";
      CEILU="$FA3Mb_U";
			CEILD_P2P="$FA3Mb_P2P";
        CEILD_MAX="$FA3Mb_MAX";
		}
   else if ( strcmp(netdown,"FA5Mb")==0  ) 
	 {
      CEILD="$FA5Mb_D";
      CEILU="$FA5Mb_U";
			CEILD_P2P="$FA5Mb_P2P";
        CEILD_MAX="$Fa5Mb_MAX";
		}
   else if ( strcmp(netdown,"FA10Mb")==0  ) 
	 {
      CEILD="$FA10Mb_D";
      CEILU="$FA10Mb_U";
      CEILD_P2P="$FA10Mb_P2P";
        CEILD_MAX="$FA10Mb_MAX";
		}
   else if ( strcmp(netdown,"FA15Mb")==0  ) 
	 {
      CEILD="$FA15Mb_D";
      CEILU="$FA15Mb_U";
      CEILD_P2P="$FA15Mb_P2P";
        CEILD_MAX="$FA15Mb_MAX";
		}
   else if ( strcmp(netdown,"FA30Mb")==0  ) 
	 {
      CEILD="$FA30Mb_D";
      CEILU="$FA30Mb_U";
      CEILD_P2P="$FA30Mb_P2P";
      CEILD_MAX="$FA30Mb_MAX";
		}
    else
         {
         CEILD="$STDN_D";
         CEILU="$STDN_U";
         CEILD_P2P="$STDN_P2P";
         CEILD_MAX="$STDN_MAX";
        printf("\n B l e d n i e  u s t a w i o n a   p r e d k o s c >>%s<<  d l a  a b o n e n t a >>%s<< !!! \n\n", netdown,   host);
                 
         }
                                                     
/////////////////
		
	if ( strcmp(landown,"MINL")==0  ) 
	 {
       CEILDLAN="$MINL_D";
       CEILULAN="$MINL_U";
		}
	else if ( strcmp(landown,"STRL")==0  ) 
	 {
       CEILDLAN="$STRL_D";
       CEILULAN="$STRL_U";
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
    else if ( strcmp(landown,"EXTK")==0  ) 
		{
        CEILDLAN="$EXTK_D";
        CEILULAN="$EXTK_U";
		}
   else if ( strcmp(landown,"MINM")==0  ) 
	 {
      CEILDLAN="$MINM_D";
      CEILULAN="$MINM_U";
		}
    else if ( strcmp(landown,"STDM")==0  ) 
		{
      CEILDLAN="$STDM_D";
      CEILULAN="$STDM_U";
		}
    else if ( strcmp(landown,"MEDM")==0  ) 
		{
			CEILDLAN="$MEDM_D";
			CEILULAN="$MEDM_U";
		}
    else if ( strcmp(landown,"OPTM")==0  ) 
		{
        CEILDLAN="$OPTM_D";
        CEILULAN="$OPTM_U";
		}
    else if ( strcmp(landown,"EXTM")==0  ) 
		{
        CEILDLAN="$EXTM_D";
        CEILULAN="$EXTM_U";
		}
 
		else if ( strcmp(landown,"MINN")==0  ) 
	 {
      CEILDLAN="$MINN_D";
      CEILULAN="$MINN_U";
		}
    else if ( strcmp(landown,"STDN")==0  ) 
		{
      CEILDLAN="$STDN_D";
      CEILULAN="$STDN_U";
		}
    else if ( strcmp(landown,"MEDN")==0  ) 
		{
			CEILDLAN="$MEDN_D";
			CEILULAN="$MEDN_U";
		}
    else if ( strcmp(landown,"OPTN")==0  ) 
		{
        CEILDLAN="$OPTN_D";
        CEILULAN="$OPTN_U";
		}
    else if ( strcmp(landown,"EXTN")==0  ) 
		{
        CEILDLAN="$EXTN_D";
        CEILULAN="$EXTN_U";
		}
		
		else if ( strcmp(landown,"MINO")==0  ) 
	 {
      CEILDLAN="$MINO_D";
      CEILULAN="$MINO_U";
		}
    else if ( strcmp(landown,"STDO")==0  ) 
		{
      CEILDLAN="$STDO_D";
      CEILULAN="$STDO_U";
		}
    else if ( strcmp(landown,"MEDO")==0  ) 
		{
			CEILDLAN="$MEDO_D";
			CEILULAN="$MEDO_U";
		}
    else if ( strcmp(landown,"OPTO")==0  ) 
		{
        CEILDLAN="$OPTO_D";
        CEILULAN="$OPTO_U";
		}
    else if ( strcmp(landown,"EXTO")==0  ) 
		{
        CEILDLAN="$EXTO_D";
        CEILULAN="$EXTO_U";
		}


/// Radio PRO
else if ( strcmp(landown,"P1")==0  )
{
CEILDLAN="$P1_D";
CEILULAN="$P1_U";
}
else if ( strcmp(landown,"P2")==0  )
{
CEILDLAN="$P2_D";
CEILULAN="$P2_U";
}
else if ( strcmp(landown,"P4")==0  )
{
CEILDLAN="$P4_D";
CEILULAN="$P4_U";
}
else if ( strcmp(landown,"P6")==0  )
{
CEILDLAN="$P6_D";
CEILULAN="$P6_U";
}
else if ( strcmp(landown,"P8")==0  )
{
CEILDLAN="$P8_D";
CEILULAN="$P8_U";
}
else if ( strcmp(landown,"P10")==0  )
{
CEILDLAN="$P10_D";
CEILULAN="$P10_U";
}
else if ( strcmp(landown,"P12")==0  )
{
CEILDLAN="$P12_D";
CEILULAN="$P12_U";
}
else if ( strcmp(landown,"P16")==0  )
{
CEILDLAN="$P16_D";
CEILULAN="$P16_U";
}
else if ( strcmp(landown,"P20")==0  )
{
CEILDLAN="$P20_D";
CEILULAN="$P20_U";
}


/// Fiber PRO
else if ( strcmp(landown,"FP10")==0  )
{
CEILDLAN="$FP10_D";
CEILULAN="$FP10_U";
}
else if ( strcmp(landown,"FP20")==0  )
{
CEILDLAN="$FP20_D";
CEILULAN="$FP20_U";
}
else if ( strcmp(landown,"FP30")==0  )
{
CEILDLAN="$FP30_D";
CEILULAN="$FP30_U";
}
else if ( strcmp(landown,"FP50")==0  )
{
CEILDLAN="$FP50_D";
CEILULAN="$FP50_U";
}
else if ( strcmp(landown,"FP70")==0  )
{
CEILDLAN="$FP70_D";
CEILULAN="$FP70_U";
}
else if ( strcmp(landown,"FP12")==0  )
{
CEILDLAN="$FP12_D";
CEILULAN="$FP12_U";
}
else if ( strcmp(landown,"FP24")==0  )
{
CEILDLAN="$FP24_D";
CEILULAN="$FP24_U";
}
else if ( strcmp(landown,"FP36")==0  )
{
CEILDLAN="$FP36_D";
CEILULAN="$FP36_U";
}
else if ( strcmp(landown,"FP60")==0  )
{
CEILDLAN="$FP60_D";
CEILULAN="$FP60_U";
}
else if ( strcmp(landown,"FP80")==0  )
{
CEILDLAN="$FP80_D";
CEILULAN="$FP80_U";
}

                                                                    		
else if ( strcmp(landown,"S2")==0  )
{
CEILDLAN="$S2_D";
CEILULAN="$S2_U";
}
else if ( strcmp(landown,"S3")==0  )
{
CEILDLAN="$S3_D";
CEILULAN="$S3_U";
}
else if ( strcmp(landown,"S4")==0  )
{
CEILDLAN="$S4_D";
CEILULAN="$S4_U";
}
else if ( strcmp(landown,"S5")==0  )
{
CEILDLAN="$S5_D";
CEILULAN="$S5_U";
}
else if ( strcmp(landown,"S6633")==0  )
{
CEILDLAN="$S6633_D";
CEILULAN="$S6633_U";
}
else if ( strcmp(landown,"FA")==0  )
{
CEILDLAN="$FA_D";
CEILULAN="$FA_U";
}
else if ( strcmp(landown,"GE")==0  )
{
CEILDLAN="$GE_D";
CEILULAN="$GE_U";
}

// pakiery radio 09.2012
else if ( strcmp(landown,"MIN2")==0  )
{
CEILDLAN="$MIN2_D";
CEILULAN="$MIN2_U";
}
else if ( strcmp(landown,"STD7")==0  )
{
CEILDLAN="$STD7_D";
CEILULAN="$STD7_U";
}
else if ( strcmp(landown,"MED12")==0  )
{
CEILDLAN="$MED12_D";
CEILULAN="$MED12_U";
}
else if ( strcmp(landown,"OPT15")==0  )
{
CEILDLAN="$OPT15_D";
CEILULAN="$OPT15_U";
}
else if ( strcmp(landown,"EXT20")==0  )
{
CEILDLAN="$EXT20_D";
CEILULAN="$EXT20_U";
}

// pakiery SWIATLO 09.2012
else if ( strcmp(landown,"MIN9")==0  )
{
CEILDLAN="$MIN9_D";
CEILULAN="$MIN9_U";
}
else if ( strcmp(landown,"STD34")==0  )
{
CEILDLAN="$STD34_D";
CEILULAN="$STD34_U";
}

else if ( strcmp(landown,"STD28")==0  )
{
CEILDLAN="$STD28_D";
CEILULAN="$STD28_U";
}
else if ( strcmp(landown,"MED46")==0  )
{
CEILDLAN="$MED46_D";
CEILULAN="$MED46_U";
}


else if ( strcmp(landown,"MED56")==0  )
{
CEILDLAN="$MED56_D";
CEILULAN="$MED56_U";
}
else if ( strcmp(landown,"OPT78")==0  )
{
CEILDLAN="$OPT78_D";
CEILULAN="$OPT78_U";
}
else if ( strcmp(landown,"EXT100")==0  )
{
CEILDLAN="$EXT100_D";
CEILULAN="$EXT100_U";
}

	
   else if ( strcmp(landown,"FA")==0  ) 
	 {
       CEILDLAN="$FA_D";
       CEILULAN="$FA_U";
		}
		else if ( strcmp(landown,"GE")==0  ) 
	 {
       CEILDLAN="$GE_D";
       CEILULAN="$GE_U";
		}
   else if ( strcmp(landown,"FA3Mb")==0  ) 
	 {
       CEILDLAN="$FA3Mb_D";
       CEILULAN="$FA3Mb_U";
		}
	else if ( strcmp(landown,"FA5Mb")==0  ) 
	 {
       CEILDLAN="$FA5Mb_D";
       CEILULAN="$FA5Mb_U";
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
   else if ( strcmp(landown,"FA30Mb")==0  ) 
	 {
       CEILDLAN="$FA30Mb_D";
       CEILULAN="$FA30Mb_U";
	}
   else 
            {
             CEILDLAN="$FA5Mb_D";
             CEILULAN="$FA5Mb_U";
        printf("\n B l e d n i e  u s t a w i o n a   p r e d k o s c >>%s<<  d l a  a b o n e n t a >>%s<< !!! \n\n", landown,   host);
                 
             }                                          		

    i2=*i+2500;
    i3=*i+5000;
    i4=*i+7500;
//    mm=m+4000;
		
		sprintf(ht, "%s%s", ht1, ht2);
		
	//	printf ("%s %s %s %d %d ", CEILD, ht, ip, classid);

	
    fprintf(fp, "#---- %s -------------------------------------------------------------------------------------------# \n", 						host);
//	    printf( "#---- %s -------------------------------------------------------------------------------------------# \n", 						host);	
    fprintf(fp, "tc class add dev  %s parent %d:10 classid %d:%d hfsc ls m2 1kbit ul m2 %s && \n", 																			iflan, classid, classid, *i, CEILDLAN);
		
    fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src $IP_LAN 	match ip dst %s flowid %d:%d && \n",   iflan, ht, ip, classid, *i);
		
	/*	if ( strcmp(ipzewn,IP_NAT) != 0 )
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
			}         */
			
    fprintf(fp, "tc qdisc add dev  %s parent %d:%d pfifo limit 128 && \n",																																		iflan, classid, *i);
    fprintf(fp, "tc class add dev  %s parent %d:2500 	classid %d:%d hfsc ls m2 1kbit ul m2 %s && \n",																					iflan, classid, classid, i2, CEILD_MAX );
		
    fprintf(fp, "tc class add dev  %s parent %d:%d 		classid %d:%d hfsc ls m2 1kbit ul m1 %s d 300s m2 %s && \n",																					iflan, classid, i2, classid, i3, CEILD_MAX, CEILD);

    
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip dst %s match ip sport 80 0xffff flowid %d:%d && \n",  	iflan, ht, ip, classid, i3);
    
		fprintf(fp, "tc qdisc add dev %s parent %d:%d pfifo limit 128 && \n",                                   																	iflan, classid, i3);
    fprintf(fp, "tc class add dev %s parent %d:%d classid %d:%d hfsc ls m2 1kbit ul m1 %s d 300s m2 %s && \n", 																iflan, classid, i2, classid, i4, CEILD, CEILD_P2P);
    fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip dst %s flowid %d:%d && \n",  													iflan, ht, ip, classid, i4);
    fprintf(fp, "tc qdisc add dev %s parent %d:%d pfifo limit 128  \n",                                                          						iflan, classid, i4);
	    	    
        
    fprintf(fpup, "#---- %s -------------------------------------------------------------------------------------------# \n", 					host );
    fprintf(fpup, "tc class add dev %s parent %d:10 classid %d:%d hfsc ls m2 1kbit ul m2 %s && \n", 																		ifin, classidup, classidup, *i, CEILULAN);
    fprintf(fpup, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip src %s match ip dst $IP_LAN flowid %d:%d && \n",   ifin, ht, ip, classidup, *i);

	/*	if ( strcmp(ipzewn,IP_NAT) != 0 )
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
			}    */                 
    fprintf(fpup, "tc qdisc add dev %s parent %d:%d pfifo limit 128 && \n", 																																ifin, classidup, *i);

    fprintf(fpup, "tc class add dev %s parent %d:2500 classid %d:%d hfsc ls m2 1kbit ul m2 %s && \n", 																			ifin, classidup, classidup, i2, CEILU);
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
			{"$IF_MAN0"},
			{"dst"},
			{"16"},

			{"10.9.0.0/24"}, //2
			{"10.9.1.0/24"}, //3
			{"10.9.2.0/24"}, //4
			{"10.9.3.0/24"}, //5
			{"10.9.4.0/24"}, //6
			
			{"10.9.5.0/24"}, //7
			{"10.9.6.0/24"}, //8
			{"10.9.7.0/24"}, //9
			{"10.9.8.0/24"}, //1
			{"10.9.9.0/24"}, //11
			{"10.9.10.0/24"}, //12
			{"10.9.11.0/24"}, //13
			{"10.9.12.0/24"}, //14
			{"10.9.13.0/24"},//15

			{"10.9.14.0/24"},//16
			{"10.9.15.0/24"},//17
			{"10.9.16.0/24"},//18
			{"10.9.17.0/24"},//19
			{"10.9.18.0/24"},//20
			{"10.9.19.0/24"}, //21
			{"10.9.20.0/24"},	//22		
			{"10.9.21.0/24"},	//23		
			{"10.9.22.0/24"},	//24		
			{"10.9.23.0/24"},	//25		
			{"10.9.24.0/24"},	//26		
			{"10.9.25.0/24"},	//27
			{"10.9.26.0/24"},	//28		
			{"10.9.27.0/24"},	//29		
			{"10.9.28.0/24"},	//30		
			{"10.9.29.0/24"},	//31		
			{"10.9.30.0/24"},	//32		
			{"10.9.31.0/24"},	//33		
			{"10.9.32.0/24"},	//34		
			{"10.9.33.0/24"},	//35		
			{"10.9.34.0/24"},	//36		
			{"10.9.35.0/24"},	//37		
			{"10.9.36.0/24"},	//38		
			{"10.9.37.0/24"},	//39		
			{"10.9.38.0/24"},//40			
			{"10.9.39.0/24"},//41			
			{"10.9.40.0/24"},	//42		
			{"10.9.41.0/24"},	//43		

			{"10.9.42.0/24"},  //44
			{"10.9.43.0/24"},  //45
			{"10.9.44.0/24"},  //46
			{"10.9.45.0/24"}, //47
			{"10.9.46.0/24"}, //48
			{"10.9.47.0/24"},  //49
			{"10.9.48.0/24"},  //50
			{"10.9.49.0/24"},  //51

			{"10.9.50.0/24"},   // 2:0
			{"10.9.51.0/24"},   // 3:0
			{"10.9.52.0/24"},   // 4:0
			{"10.9.53.0/24"},   // 5:0
			{"10.9.54.0/24"},   // 6:0
			{"10.9.55.0/24"},   // 7:0
			{"10.9.56.0/24"},   // 8:0
			{"10.9.57.0/24"},   // 9:0
			{"10.9.58.0/24"},   // 10:0
			{"10.9.59.0/24"},   // 11:00
			{"10.9.60.0/24"},
			{"10.9.61.0/24"},
			{"10.9.62.0/24"},
			{"10.9.63.0/24"},
			{"10.9.64.0/24"},

                        {"10.9.128.0/24"},
                        {"10.9.129.0/24"},
                        {"10.9.130.0/24"},
                        {"10.9.131.0/24"},
                        {"10.9.132.0/24"},
                        {"10.9.133.0/24"},
                        {"10.9.134.0/24"},
                        {"10.9.135.0/24"},
                        {"10.9.136.0/24"},
                        {"10.9.137.0/24"},
                        {"10.9.138.0/24"},
                        {"10.9.139.0/24"},
                        {"10.9.140.0/24"},
                        {"10.9.141.0/24"},
                        {"10.9.142.0/24"},
                        {"10.9.143.0/24"},
                        {"10.9.144.0/24"},
                        {"10.9.145.0/24"},
                        {"10.9.146.0/24"},
                        
                                                                                                			
			{"10.9.224.0/24"},
			{"10.9.225.0/24"},
			{"10.9.226.0/24"},
			{"10.9.227.0/24"},
			
			{"10.9.240.0/24"},
			{"10.9.241.0/24"},
			{"10.9.242.0/24"},
			{"10.9.243.0/24"},
			{"10.9.244.0/24"},
			{"10.9.245.0/24"},
			
			{"10.37.0.0/24"},
			{"10.37.1.0/24"},
			{"10.37.2.0/24"},
			{"10.37.3.0/24"},

			{"10.32.0.0/24"},
			{"10.33.4.0/24"},
			{"10.33.6.0/24"},
			{"10.33.7.0/24"},
			{"10.33.8.0/24"},
			{"10.33.9.0/24"},
			{"10.33.10.0/24"},
			{"10.33.11.0/24"},
			{"10.33.12.0/24"},
			{"10.33.13.0/24"},
			{"10.33.16.0/24"},
			{"10.33.17.0/24"},
			{"10.33.18.0/24"},
			
			{"10.33.19.0/24"},
			{"10.33.20.0/24"},
			{"10.33.21.0/24"},
			{"10.33.22.0/24"},
			{"10.33.24.0/24"},
			{"10.33.25.0/24"},
			{"10.33.26.0/24"},
			{"10.33.27.0/24"},
			{"10.33.28.0/24"},
			{"10.33.29.0/24"},
			
			{"10.36.0.0/24"},
			{"10.36.5.0/24"},
			{"10.36.8.0/24"},
			{"10.36.10.0/24"},
			{"10.36.17.0/24"},
			{"10.36.13.0/24"},
			{"10.36.16.0/24"},
			{"10.36.27.0/24"},
			{"10.36.28.0/24"},
			{"10.36.29.0/24"},
			
			{"10.40.0.0/24"},
			{"10.40.4.0/24"},
			{"10.40.5.0/24"},
			{"10.40.7.0/24"},
			{"10.40.12.0/24"},
			{"10.40.16.0/24"},
			{"10.40.17.0/24"},
			{"10.40.18.0/24"},
			{"10.40.20.0/24"},
			{"10.40.21.0/24"},
			{"10.40.24.0/24"},
			{"10.40.25.0/24"},
			{"10.40.26.0/24"},
			{"10.40.27.0/24"},
			{"10.40.28.0/24"},
			{"10.40.29.0/24"},

                        {"10.9.147.0/24"},
                        {"10.9.148.0/24"},
	                {"10.9.149.0/24"},
                        {"10.9.150.0/24"},                                                                                    
		
			{"10.48.0.0/24"},
			{"10.48.1.0/24"},
			{"10.48.2.0/24"},
			{"10.48.3.0/24"},
			{"10.48.4.0/24"},
			{"10.48.5.0/24"},
			{"10.48.6.0/24"},
			{"10.48.7.0/24"},
			{"10.48.8.0/24"},
			{"10.48.9.0/24"},
			
			{"10.48.10.0/24"},
			{"10.48.11.0/24"},
			{"10.48.12.0/24"},
			{"10.48.13.0/24"},
			{"10.48.14.0/24"},
			{"10.48.15.0/24"},
			{"10.48.16.0/24"},
			{"10.48.17.0/24"},
			{"10.48.18.0/24"},
			{"10.48.19.0/24"},
			
			{"10.48.20.0/24"},
			{"10.48.21.0/24"},
			{"10.48.22.0/24"},
			{"10.48.23.0/24"},
			{"10.48.24.0/24"},
			{"10.48.25.0/24"},
			{"10.48.26.0/24"},
			{"10.48.27.0/24"},
			{"10.48.28.0/24"},
			{"10.48.29.0/24"},
			
			{"10.49.0.0/24"},
			{"10.49.1.0/24"},
			{"10.49.2.0/24"},
			{"10.49.3.0/24"},
			{"10.49.4.0/24"},
			{"10.49.5.0/24"},
			{"10.49.6.0/24"},
			{"10.49.7.0/24"},
			{"10.49.8.0/24"},
			{"10.49.9.0/24"},
			{"10.40.1.0/24"},
			{"10.40.2.0/24"}, //194
			{"10.56.6.0/24"}, //195
			{"10.33.3.0/24"}, //196
			{"178.217.221.0/24"},				
			{"0"},
			{"$IF_IN0"},
			{"src"},
			{"12"},
			{"10.9.0.0/24"}, //2
			{"10.9.1.0/24"}, //3
			{"10.9.2.0/24"}, //4
			{"10.9.3.0/24"}, //5
			{"10.9.4.0/24"}, //6
			
			{"10.9.5.0/24"}, //7
			{"10.9.6.0/24"}, //8
			{"10.9.7.0/24"}, //9
			{"10.9.8.0/24"}, //1
			{"10.9.9.0/24"}, //11
			{"10.9.10.0/24"}, //12
			{"10.9.11.0/24"}, //13
			{"10.9.12.0/24"}, //14
			{"10.9.13.0/24"},//15

			{"10.9.14.0/24"},//16
			{"10.9.15.0/24"},//17
			{"10.9.16.0/24"},//18
			{"10.9.17.0/24"},//19
			{"10.9.18.0/24"},//20
			{"10.9.19.0/24"}, //21
			{"10.9.20.0/24"},	//22		
			{"10.9.21.0/24"},	//23		
			{"10.9.22.0/24"},	//24		
			{"10.9.23.0/24"},	//25		
			{"10.9.24.0/24"},	//26		
			{"10.9.25.0/24"},	//27
			{"10.9.26.0/24"},	//28		
			{"10.9.27.0/24"},	//29		
			{"10.9.28.0/24"},	//30		
			{"10.9.29.0/24"},	//31		
			{"10.9.30.0/24"},	//32		
			{"10.9.31.0/24"},	//33		
			{"10.9.32.0/24"},	//34		
			{"10.9.33.0/24"},	//35		
			{"10.9.34.0/24"},	//36		
			{"10.9.35.0/24"},	//37		
			{"10.9.36.0/24"},	//38		
			{"10.9.37.0/24"},	//39		
			{"10.9.38.0/24"},//40			
			{"10.9.39.0/24"},//41			
			{"10.9.40.0/24"},	//42		
			{"10.9.41.0/24"},	//43		

			{"10.9.42.0/24"},  //44
			{"10.9.43.0/24"},  //45
			{"10.9.44.0/24"},  //46
			{"10.9.45.0/24"}, //47
			{"10.9.46.0/24"}, //48
			{"10.9.47.0/24"},  //49
			{"10.9.48.0/24"},  //50		
			{"10.9.49.0/24"},  //51

			{"10.9.50.0/24"},   // 2:0
			{"10.9.51.0/24"},   // 3:0
			{"10.9.52.0/24"},   // 4:0
			{"10.9.53.0/24"},   // 5:0
			{"10.9.54.0/24"},   // 6:0
			{"10.9.55.0/24"},   // 7:0
			{"10.9.56.0/24"},   // 8:0
			{"10.9.57.0/24"},   // 9:0
			{"10.9.58.0/24"},   // 10:0
			{"10.9.59.0/24"},   // 11:00
			{"10.9.60.0/24"},
			{"10.9.61.0/24"},
			{"10.9.62.0/24"},
			{"10.9.63.0/24"},
			{"10.9.64.0/24"},
			
			{"10.9.128.0/24"},
			{"10.9.129.0/24"},
			{"10.9.130.0/24"},
			{"10.9.131.0/24"},
			{"10.9.132.0/24"},
			{"10.9.133.0/24"},
			{"10.9.134.0/24"},
			{"10.9.135.0/24"},
			{"10.9.136.0/24"},
			{"10.9.137.0/24"},
			{"10.9.138.0/24"},
			{"10.9.139.0/24"},
			{"10.9.140.0/24"},
			{"10.9.141.0/24"},
			{"10.9.142.0/24"},
			{"10.9.143.0/24"},
			{"10.9.144.0/24"},
			{"10.9.145.0/24"},
			{"10.9.146.0/24"},
                                                                                                			
                        {"10.9.224.0/24"},
                        {"10.9.225.0/24"},
                        {"10.9.226.0/24"},
                        {"10.9.227.0/24"},
                        {"10.9.240.0/24"},
                        {"10.9.241.0/24"},
                        {"10.9.242.0/24"},
                        {"10.9.243.0/24"},
                        {"10.9.244.0/24"},
                        {"10.9.245.0/24"},
                        
                        {"10.37.0.0/24"},
			{"10.37.1.0/24"},
			{"10.37.2.0/24"},
			{"10.37.3.0/24"},

			{"10.32.0.0/24"},
		
			{"10.33.4.0/24"},
			{"10.33.6.0/24"},
			{"10.33.7.0/24"},
			{"10.33.8.0/24"},
			{"10.33.9.0/24"},
			{"10.33.10.0/24"},
			{"10.33.11.0/24"},
			{"10.33.12.0/24"},
			{"10.33.13.0/24"},
			{"10.33.16.0/24"},
			{"10.33.17.0/24"},
			{"10.33.18.0/24"},
			
			{"10.33.19.0/24"},
			{"10.33.20.0/24"},
			{"10.33.21.0/24"},
			{"10.33.22.0/24"},
			{"10.33.24.0/24"},
			{"10.33.25.0/24"},
			{"10.33.26.0/24"},
			{"10.33.27.0/24"},
			{"10.33.28.0/24"},
			{"10.33.29.0/24"},
			
			{"10.36.0.0/24"},
			{"10.36.5.0/24"},
			{"10.36.8.0/24"},
			{"10.36.10.0/24"},
			{"10.36.17.0/24"},
			{"10.36.13.0/24"},
			{"10.36.16.0/24"},
			{"10.36.27.0/24"},
			{"10.36.28.0/24"},
			{"10.36.29.0/24"},
			
			{"10.40.0.0/24"},
			{"10.40.4.0/24"},
			{"10.40.5.0/24"},
			{"10.40.7.0/24"},
			{"10.40.12.0/24"},
			{"10.40.16.0/24"},
			{"10.40.17.0/24"},
			{"10.40.18.0/24"},
			{"10.40.20.0/24"},
			{"10.40.21.0/24"},
			{"10.40.24.0/24"},
			{"10.40.25.0/24"},
			{"10.40.26.0/24"},
			{"10.40.27.0/24"},
			{"10.40.28.0/24"},
			{"10.40.29.0/24"},

                        {"10.9.147.0/24"},
                        {"10.9.148.0/24"},
                        {"10.9.149.0/24"},
                        {"10.9.150.0/24"},
                                                                                                
		
			{"10.48.0.0/24"},
			{"10.48.1.0/24"},
			{"10.48.2.0/24"},
			{"10.48.3.0/24"},
			{"10.48.4.0/24"},
			{"10.48.5.0/24"},
			{"10.48.6.0/24"},
			{"10.48.7.0/24"},
			{"10.48.8.0/24"},
			{"10.48.9.0/24"},
			
			{"10.48.10.0/24"},
			{"10.48.11.0/24"},
			{"10.48.12.0/24"},
			{"10.48.13.0/24"},
			{"10.48.14.0/24"},
			{"10.48.15.0/24"},
			{"10.48.16.0/24"},
			{"10.48.17.0/24"},
			{"10.48.18.0/24"},
			{"10.48.19.0/24"},
			
			{"10.48.20.0/24"},
			{"10.48.21.0/24"},
			{"10.48.22.0/24"},
			{"10.48.23.0/24"},
			{"10.48.24.0/24"},
			{"10.48.25.0/24"},
			{"10.48.26.0/24"},
			{"10.48.27.0/24"},
			{"10.48.28.0/24"},
			{"10.48.29.0/24"},
			
			{"10.49.0.0/24"},
			{"10.49.1.0/24"},
			{"10.49.2.0/24"},
			{"10.49.3.0/24"},
			{"10.49.4.0/24"},
			{"10.49.5.0/24"},
			{"10.49.6.0/24"},
			{"10.49.7.0/24"},
			{"10.49.8.0/24"},
			{"10.49.9.0/24"},
			{"10.40.1.0/24"},
			{"10.40.2.0/24"}, //194
			{"10.56.6.0/24"}, //195
			{"10.33.3.0/24"},
			{"178.217.221.0/24"},
			{"0"},

	};

	int rozmiar = (sizeof iface / sizeof *iface);
		
	fprintf(fp, "source /etc/conf-pakiety \n\n" );
	
	fprintf(fp,  "tc qdisc del dev %s root 1> /dev/null &2>1 \n", dev);
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

	fprintf(fp,   "tc class add dev %s parent 1:0 classid %d:1 hfsc ls m2 2500Mbit ul m2 3000Mbit && \n", dev, classid);
	fprintf(fp,   "tc class add dev %s parent 1:0 classid %d:2 hfsc ls m2 40Mbit ul m2 50Mbit && \n", dev, classid);			
	
	if ( strcmp(dev, "$IF_LAN8") == 0)
		{
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:10 hfsc ls m2 50Mbit ul m2 70Mbit	&& \n", dev, classid, classid);
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:2500 hfsc ls m2 50Mbit ul m2 70Mbit	&& \n", dev, classid, classid);
		}
	else if ( strcmp(dev, "$IF_IN4") == 0)
		{
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:10 hfsc ls m2 50Mbit ul m2 70Mbit	&& \n", dev, classid, classid);
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:2500 hfsc ls m2 50Mbit ul m2 70Mbit	&& \n", dev, classid, classid);
		}
	else if ( strcmp(dev, "$IF_LAN16") == 0)
		{
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:10 hfsc ls m2 50Mbit ul m2 70Mbit	&& \n", dev, classid, classid);
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:2500 hfsc ls m2 50Mbit ul m2 70Mbit	&& \n", dev, classid, classid);
		}
	else if ( strcmp(dev, "$IF_IN5") == 0)
		{
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:10 hfsc ls m2 50Mbit ul m2 70Mbit && \n", dev, classid, classid);
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:2500 hfsc ls m2 50Mbit ul m2 70Mbit && \n", dev, classid, classid);
		}
	else
		{
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:10 hfsc ls m2 300Mbit ul m2 500Mbit && \n", dev, classid, classid);
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:2500 hfsc ls m2 2000Mbit ul m2 2500Mbit && \n", dev, classid, classid);
		}

	fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:9999 hfsc ls m2 512kbit && \n", dev, classid, classid);
	fprintf(fp,   "tc filter add dev %s protocol ip parent 1:0 prio 3 u32 match ip protocol 1 0xff flowid %d:2 && \n", dev, classid);
	fprintf(fp,   "tc filter add dev %s protocol ip parent 1:0 prio 3 u32 match ip protocol 2 0xff flowid %d:2 && \n", dev, classid);	
        fprintf(fp,   "tc filter add dev %s protocol ip parent 1:0 prio 3 u32 match ip protocol 89 0xff flowid %d:2 && \n", dev, classid);
        fprintf(fp,   "tc filter add dev %s protocol ip parent 1:0 prio 3 u32 match ip protocol 112 0xff flowid %d:2 && \n\n", dev, classid);
		
	
	if ( strcmp(dev, "$IF_IN0") == 0)
		{
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $JAWNET1   flowid %d:10 && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $JAWNET2   flowid %d:10 && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $JAWNET3   flowid %d:10 && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $JAWNET4   flowid %d:10 && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $AKKNET1   flowid %d:10 && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $AKKNET2   flowid %d:10 && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $ASN   flowid %d:10     && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $BMJ   flowid %d:10     && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $WNC   flowid %d:10     && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $BMK   flowid %d:10     && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $DRAMA     flowid %d:10   && \n",  dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $COMNET1   flowid %d:10  && \n",   dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $COMNET2   flowid %d:10 && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $INTERPC   flowid %d:10 && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $STI   flowid %d:10     && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $JOYNET   flowid %d:10  && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $INTERPLUS   flowid %d:10 && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $COMPNET   flowid %d:10 && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $KOPNET   flowid %d:10 && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $MIKROCHIP   flowid %d:10 && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $HARDCOM   flowid %d:10 && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $IMPERIUM   flowid %d:10 && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $K3   flowid %d:10     && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $MMJ   flowid %d:10     && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $PROXNET   flowid %d:10     && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $SILESIAMULTIMEDIA   flowid %d:10     && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $SSH     flowid %d:10   && \n",  dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $EUROFUX1   flowid %d:10  && \n",   dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $EUROFUX2   flowid %d:10 && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $SOFTPRO2   flowid %d:10 && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $GALILEUSZ   flowid %d:10     && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $ZVIDNET   flowid %d:10  && \n",    dev, classid);
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $FUSION   flowid %d:10 && \n",    dev, classid);
		
			fprintf(fp,   "tc qdisc del dev $IF_MAN0 ingress \n", dev);
			fprintf(fp,   "tc qdisc add dev $IF_MAN0 ingress && \n", dev);
			fprintf(fp,   "tc filter add dev $IF_MAN0 parent ffff:0 protocol ip prio 10 u32 match u32 0 0 flowid 1:1 action mirred egress redirect dev %s && \n", dev);
		}
	else
	{
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $JAWNET1   flowid %d:10 && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $JAWNET2   flowid %d:10 && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $JAWNET3   flowid %d:10 && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $JAWNET4   flowid %d:10 && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $AKKNET1   flowid %d:10 && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $AKKNET2   flowid %d:10 && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $ASN   flowid %d:10     && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $BMJ   flowid %d:10     && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $WNC   flowid %d:10     && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $BMK   flowid %d:10     && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $DRAMA     flowid %d:10   && \n",  dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $COMNET1   flowid %d:10  && \n",   dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $COMNET2   flowid %d:10 && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $INTERPC   flowid %d:10 && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $STI   flowid %d:10     && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $JOYNET   flowid %d:10  && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $INTERPLUS   flowid %d:10 && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $COMPNET   flowid %d:10 && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $KOPNET   flowid %d:10 && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $MIKROCHIP   flowid %d:10 && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $HARDCOM   flowid %d:10 && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $IMPERIUM   flowid %d:10 && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $K3   flowid %d:10     && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $MMJ   flowid %d:10     && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $PROXNET   flowid %d:10     && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $SILESIAMULTIMEDIA   flowid %d:10     && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $SSH     flowid %d:10   && \n",  dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $EUROFUX1   flowid %d:10  && \n",   dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $EUROFUX2   flowid %d:10 && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $SOFTPRO2   flowid %d:10 && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $GALILEUSZ   flowid %d:10     && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $ZVIDNET   flowid %d:10  && \n",    dev, classid);
	fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 match ip src $FUSION   flowid %d:10 && \n",    dev, classid);
	}
}


void dhcp(Komputer komp, Ip ip, FILE *fp)
{
char gate[16];
int g;
									if ( strcmp( komp.dhcp, "Y") == 0  && strcmp( komp.mac, "ff:ff:ff:ff:ff:ff") != 0 && strcmp( komp.mac, "FF:FF:FF:FF:FF:FF") != 0 )
													{
													
													if ( ip.b1 == BAJT_CORE ) 
														fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s;}\n", komp.host, komp.mac, komp.ip);
            												else if ( ip.b1 == BAJT_PUBL ) 
            													if ( ip.b4 < 128 )
            													{
            													    g=brama(ip.b4, 30);
            													    sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);                                                                                                                             
                                                    								    fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.252;}\n", komp.host, komp.mac, komp.ip, gate);
                                                    								}
                                                    								else
                                                    								{
                                                    								    g=brama(ip.b4, 29);
                                                    								    sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);                                                                                                                               
                                                    								    fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.248;}\n", komp.host, komp.mac, komp.ip, gate);
                                                    								}    	
													else 
													{
														if ( ip.b2 < BAJT_WLAN1 )
															{
            															if ( ip.b3 >=0 && ip.b3 < 10  )
                                                                                                                                 {
                                                                                                                                    g=brama(ip.b4, 25);
                                                                                                                                    sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
                                                                                                                                    fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.128;} \n", komp.host, komp.mac, komp.ip, gate );
                                                                                                                                 }
                                                                                                                                else  if ( ip.b3 >= 10  && ip.b3 <= 19 )
                                                                                                                                 {
                                                                                                                                    g=brama(ip.b4, 26);
                                                                                                                                    sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
                                                                                                                                    fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.192;} \n", komp.host, komp.mac, komp.ip, gate     );
                                                                                                                                 }
                                                                                                                                else    if ( (ip.b3 >= 20 && ip.b3 <=119) )
                                                                                                                                 {
                                                                                                                                    g=brama(ip.b4, 27);
                                                                                                                                    sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
                                                                                                                                    fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.224;} \n", komp.host, komp.mac, komp.ip, gate     );
                                                                                                                            	}
                                                                                                                                else if ( (ip.b3 >= 120 && ip.b3 <= 212) )
                                                                                                                                {
                                                                                                                                   g=brama(ip.b4, 28);
                                                                                                                                    sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
                                                                                                                                     fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.240;} \n", komp.host, komp.mac, komp.ip, gate     );
                                                                                                                                }
                                                                                                                                else if ( ip.b3 >= 213 && ip.b3 <= 224  )
                                                                                                                                {
                                                                                                                                     g=brama(ip.b4, 29);
                                                                                                                                     sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
                                                                                                                                     fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.248;} \n", komp.host, komp.mac, komp.ip, gate     );
                                                                                                                                }
                                                                                                                                else if ( ip.b3 >= 225  && ip.b3 < 255)
                                                                                                                                {
                                                                                                                                    g=brama(ip.b4, 30);
                                                                                                                                    sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
                                                                                                                            	    fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.252;} \n", komp.host, komp.mac, komp.ip, gate     );
                                                                                                                                }
																else
																{
																    sprintf(gate, "%d.%d.%d.254", ip.b1,ip.b2,ip.b3);
																    sprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s;} \n", komp.host, komp.mac, komp.ip, gate     ); 
																}
															}
														else if ( ip.b2 >= BAJT_WLAN1 ) 
															{
															
																switch (ip.b2)
																	{
																	
																		case 32:
																						if (  ip.b3 >= 0 &&  ip.b3 <= 7 )
																							{
																								sprintf(gate, "%d.%d.255.254", ip.b1,ip.b2);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.0.0;} \n", komp.host, komp.mac, komp.ip, gate);
																							}
																						break;
																						
																		case 33:	
																		
																						if ( ip.b3 == 27  ||  ip.b3 == 28  || ip.b3 == 29  ) 
																							{
																								g=brama(ip.b4, 29);
																								sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.248;} \n", komp.host, komp.mac, komp.ip, gate     );
																							}
																						else
																							{
																								sprintf(gate, "%d.%d.%d.254", ip.b1,ip.b2,ip.b3);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s;} \n", komp.host, komp.mac, komp.ip, gate     ); 
																							}
																						break;
																		case 36: 		
																						if ( ip.b3 == 27  ||  ip.b3 == 28  || ip.b3 == 29 || ip.b3 == 30  ) 
																							{
																								g=brama(ip.b4, 29);
																								sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.248;} \n", komp.host, komp.mac, komp.ip, gate     );
																							}
																						else
																							{
																								sprintf(gate, "%d.%d.%d.254", ip.b1,ip.b2,ip.b3);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s;} \n", komp.host, komp.mac, komp.ip, gate     ); 
																							}
																						break;

																						
																						
																		case 37:	
																								sprintf(gate, "%d.%d.%d.254", ip.b1,ip.b2,ip.b3);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s;} \n", komp.host, komp.mac, komp.ip, gate     ); 
																						break;
																						
																		case 40:
																						if ( ip.b3 >= 0 &&  ip.b3 <= 7 ) 
																							{
																								sprintf(gate, "%d.%d.7.254", ip.b1,ip.b2);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.248.0;} \n", komp.host, komp.mac, komp.ip, gate);
																							}
																						else if ( ip.b3 >= 8 &&  ip.b3 <= 11 ) 
																							{
																								sprintf(gate, "%d.%d.11.254", ip.b1,ip.b2);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.248.0;} \n", komp.host, komp.mac, komp.ip, gate);
																							}
																						else
																							{
																								sprintf(gate, "%d.%d.%d.254", ip.b1,ip.b2,ip.b3);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s;} \n", komp.host, komp.mac, komp.ip, gate     ); 
																							}
																						break;
																									
																		case 41:
																						if (  ip.b3 == 27 || ip.b3 == 28 || ip.b3 == 29  ) 
																							{
																								g=brama(ip.b4, 29);
																								sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.248;} \n", komp.host, komp.mac, komp.ip, gate     );
																							}
																						else
																							{
																								sprintf(gate, "%d.%d.%d.254", ip.b1,ip.b2,ip.b3);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s;} \n", komp.host, komp.mac, komp.ip, gate     ); 
																							}
																						break;
										
																		case 48:
																						if ( ip.b3 == 27 || ip.b3 == 28 || ip.b3 == 29 ) 
																							{
																								g=brama(ip.b4, 29);
																								sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.248;} \n", komp.host, komp.mac, komp.ip, gate     );
																							}
																						else
																							{
																								sprintf(gate, "%d.%d.%d.254", ip.b1,ip.b2,ip.b3);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s;} \n", komp.host, komp.mac, komp.ip, gate     ); 
																							}
																						break;
										
																		case 49:
																						if ( ip.b3 == 1 ) 
																							{
																								g=brama(ip.b4, 29);
																								sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.248;} \n", komp.host, komp.mac, komp.ip, gate     );
																							}
																						else
																							{
																								sprintf(gate, "%d.%d.%d.254", ip.b1,ip.b2,ip.b3);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s;} \n", komp.host, komp.mac, komp.ip, gate     ); 
																							}
																						break;
																																					
																		default:
																						sprintf(gate, "%d.%d.%d.254", ip.b1,ip.b2, ip.b3);															
																						fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.0;} \n", komp.host, komp.mac, komp.ip, gate );		
																						break;
																	}
																}
																		
															}					 
													}							 
			

}


void dhcp_head(FILE *fp)
{
		fprintf( fp, "AUTHORITATIVE;\n");
		fprintf( fp, "ddns-update-style interim; \n\n");
}

void dhcp_head2(int b2, FILE *fp, int b1, int b3, int b4)
{
	char subnet[16];
	char gate[16];
	char subnetmask[16]="255.255.255.0";
	char broadcast[16];
	char netmask[16]="255.255.0.0";
	
	sprintf(subnet,    "10.%d.0.0",     b2);
	sprintf(gate,      "10.%d.0.1",     b2);
	sprintf(broadcast, "10.%d.255.255", b2);

	if ( b1 != BAJT_CORE && b1 != BAJT_PUBL )
		{
			if ( b2 < BAJT_WLAN1 )
				{
				        fprintf(fp, "shared-network netico               \n");
					fprintf(fp, "{               \n");              		       
					fprintf(fp, "subnet 10.9.0.0 netmask 255.255.0.0               \n");
					fprintf(fp, "{                                                 \n");
					fprintf(fp, "deny unknown-clients;                             \n");
					fprintf(fp, "default-lease-time           %d;                  \n", D_LEASE_TIME   );
					fprintf(fp, "max-lease-time               %d;                  \n", MAX_LEASE_TIME );
					fprintf(fp, "option domain-name           \"netico.pl\";       \n");
					fprintf(fp, "option domain-name-servers   %s, %s; 				 \n", DNS1, DNS2 );
					fprintf(fp, "option subnet-mask           %s;                  \n", subnetmask);
					fprintf(fp, "option ntp-servers  %s;           								       \n", DNS1 );
				}
			else if ( b2 >= BAJT_WLAN1 && b2 < BAJT_WLAN2 )
				{
					fprintf(fp, "subnet 10.32.0.0 netmask 255.248.0.0               \n");
					fprintf(fp, "{                                                 \n");
					fprintf(fp, "deny unknown-clients;                             \n");
					fprintf(fp, "default-lease-time           %d;                  \n", D_LEASE_TIME   );
					fprintf(fp, "max-lease-time               %d;                  \n", MAX_LEASE_TIME );
					fprintf(fp, "option domain-name           \"netico.pl\";       \n");
					fprintf(fp, "option domain-name-servers   %s, %s; 				 \n", DNS1, DNS2 );
					fprintf(fp, "option subnet-mask           %s;                  \n", subnetmask);
					fprintf(fp, "option ntp-servers  %s;           								       \n", DNS1 );
				} 

				else if ( b2 >= BAJT_WLAN2 && b2 < BAJT_WLAN3 )
				{
					fprintf(fp, "subnet 10.40.0.0 netmask 255.248.0.0               \n");
					fprintf(fp, "{                                                 \n");
					fprintf(fp, "deny unknown-clients;                             \n");
					fprintf(fp, "default-lease-time           %d;                  \n", D_LEASE_TIME   );
					fprintf(fp, "max-lease-time               %d;                  \n", MAX_LEASE_TIME );
					fprintf(fp, "option domain-name           \"netico.pl\";       \n");
					fprintf(fp, "option domain-name-servers   %s, %s; 				 \n", DNS1, DNS2 );
					fprintf(fp, "option subnet-mask           %s;                  \n", subnetmask);
					fprintf(fp, "option ntp-servers  %s;           								       \n", DNS1 );
				} 
				
			else if ( b2 >= BAJT_WLAN3 && b2 < BAJT_WLAN4 )
				{
					fprintf(fp, "subnet 10.48.0.0 netmask 255.248.0.0               \n");
					fprintf(fp, "{                                                 \n");
					fprintf(fp, "deny unknown-clients;                             \n");
					fprintf(fp, "default-lease-time           %d;                  \n", D_LEASE_TIME   );
					fprintf(fp, "max-lease-time               %d;                  \n", MAX_LEASE_TIME );
					fprintf(fp, "option domain-name           \"netico.pl\";       \n");
					fprintf(fp, "option domain-name-servers   %s, %s; 				 \n", DNS1, DNS2 );
					fprintf(fp, "option subnet-mask           %s;                  \n", subnetmask);
					fprintf(fp, "option ntp-servers  %s;           								       \n", DNS1 );
				} 
	
				else if (  b2 >= BAJT_WLAN4)
				{
					fprintf(fp, "subnet 10.56.0.0 netmask 255.248.0.0              \n");
					fprintf(fp, "{                                                 \n");
					fprintf(fp, "deny unknown-clients;                             \n");
					fprintf(fp, "default-lease-time           %d;                  \n", D_LEASE_TIME   );
					fprintf(fp, "max-lease-time               %d;                  \n", MAX_LEASE_TIME );
					fprintf(fp, "option domain-name           \"netico.pl\";       \n");
					fprintf(fp, "option domain-name-servers   %s, %s; 				 \n", DNS1, DNS2 );
					fprintf(fp, "option subnet-mask           %s;                  \n", subnetmask);
					fprintf(fp, "option ntp-servers  %s;           								       \n", DNS1 );
				}
			}	
		else if ( b1 == BAJT_CORE )
		{
		if ( b2 == 16 )
		    {
			fprintf(fp, "subnet 172.16.32.0 netmask 255.255.224.0              \n");
			fprintf(fp, "{                                                 \n");
			fprintf(fp, "deny unknown-clients;                             \n");
			fprintf(fp, "default-lease-time           %d;                  \n", D_LEASE_TIME   );
			fprintf(fp, "max-lease-time               %d;                  \n", MAX_LEASE_TIME );
			fprintf(fp, "option domain-name           \"netico.pl\";       \n");
			fprintf(fp, "option domain-name-servers   %s, %s; 				 \n", DNS1, DNS2 );
			fprintf(fp, "option subnet-mask           255.255.224.0;                  \n");
			fprintf(fp, "option routers               172.16.32.254;                  \n" );
			fprintf(fp, "option ntp-servers  %s;           								       \n", DNS1 );
		    }
                   else if ( b2 == 17 )
                   {
                      fprintf(fp, "subnet 172.17.0.0 netmask 255.255.0.0              \n");
                      fprintf(fp, "{                                                 \n");
                      fprintf(fp, "deny unknown-clients;                             \n");
                       fprintf(fp, "default-lease-time           %d;                  \n", D_LEASE_TIME   );
                      fprintf(fp, "max-lease-time               %d;                  \n", MAX_LEASE_TIME );
                     fprintf(fp, "option domain-name           \"netico.pl\";       \n");
                        fprintf(fp, "option domain-name-servers   %s, %s;                                \n", DNS1, DNS2 );
                       fprintf(fp, "option subnet-mask           255.255.0.0;                  \n");
                      fprintf(fp, "option routers               172.17.0.1;                  \n" );
                     fprintf(fp, "option ntp-servers  %s;                                                                           \n", DNS1 );
                     }
                     else
                         {
                          fprintf(fp, "subnet 172.30.0.0 netmask 255.255.0.0              \n");
                           fprintf(fp, "{                                                 \n");
                            fprintf(fp, "deny unknown-clients;                             \n");
                            fprintf(fp, "default-lease-time           %d;                  \n", D_LEASE_TIME   );
                            fprintf(fp, "max-lease-time               %d;                  \n", MAX_LEASE_TIME );
                            fprintf(fp, "option domain-name           \"netico.pl\";       \n");
                            fprintf(fp, "option domain-name-servers   %s, %s;                                \n", DNS1, DNS2 );
                            fprintf(fp, "option subnet-mask           255.255.0.0;                  \n");
                            fprintf(fp, "option routers               172.16.8.1;                  \n" );
                            fprintf(fp, "option ntp-servers  %s;                                                                           \n", DNS1 );
	                }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        	
		    
		} 

                else if ( b1 == BAJT_PUBL )
                {
                        fprintf(fp, "subnet 178.217.221.0 netmask 255.255.255.0               \n");
                        fprintf(fp, "{                                                 \n");
                        fprintf(fp, "deny unknown-clients;                             \n");
                        fprintf(fp, "default-lease-time           %d;                  \n", D_LEASE_TIME   );
                	fprintf(fp, "max-lease-time               %d;                  \n", MAX_LEASE_TIME );
                        fprintf(fp, "option domain-name           \"netico.pl\";       \n");
                	fprintf(fp, "option domain-name-servers   %s, %s;                                \n", DNS1, DNS2 );
                    	fprintf(fp, "option subnet-mask           %s;                  \n", subnetmask);
                        fprintf(fp, "option ntp-servers  %s;                                                                           \n", DNS1 );                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                }
                                                            
		fprintf(fp, "                                                    \n");
}

void dhcp_head3(FILE *fp)
{
			fprintf(fp, "}\n");
				fprintf(fp, "subnet 91.216.213.0 netmask 255.255.255.0              \n");
			fprintf(fp, "{                                                 \n");
			fprintf(fp, "deny unknown-clients;                             \n");
			fprintf(fp, "default-lease-time           %d;                  \n", D_LEASE_TIME   );
			fprintf(fp, "max-lease-time               %d;                  \n", MAX_LEASE_TIME );
			fprintf(fp, "next-server   79.110.194.9 ;      \n");
			fprintf(fp, "filename \"/tvtest/pxelinux.0\"    ;       \n");		
			fprintf(fp, "option domain-name           \"netico.pl\";       \n");
			fprintf(fp, "option domain-name-servers   %s, %s; 				 \n", DNS1, DNS2 );
			fprintf(fp, "option subnet-mask           255.255.255.0;                  \n");
			fprintf(fp, "option routers               91.216.213.1;                  \n" );
			fprintf(fp, "option ntp-servers  %s; \n", DNS1);
	
	    
			fprintf(fp, "host abon_tv_ibm_main          {hardware ethernet 00:14:5e:81:24:0a; fixed-address 91.216.213.5;}  \n");
                        fprintf(fp, "host abon_tv_ibm__backup       {hardware ethernet 00:14:5e:81:26:72; fixed-address 91.216.213.5;}  \n");		
                        fprintf(fp, "host abon_tv_old               {hardware ethernet 00:16:17:6d:a3:10; fixed-address 91.216.213.5;}  \n");		
			fprintf(fp, "}\n");
		fprintf(fp, "}\n");
			
}


void hosts_head(FILE *fp)
{
		fprintf(fp,  "127.0.0.1  \t  localhost                 \n" );
		fprintf(fp,  "%s \t  neutrino_lan.%s  \t  neutrino_lan \n", IP_LAN,     DOMAIN1 );
                fprintf(fp,  "%s \t  neutrino_lan.%s  \t  neutrino_lan \n", IP_LAN0,     DOMAIN1 );
				
		fprintf(fp,  "%s \t  neutrino.%s   \t  neutrino   	\n",IP_INET1,   DOMAIN1 );
		fprintf(fp,  "%s \t  neutrino.%s  \t  neutrino  \n", IP_INET1_0, DOMAIN1 );
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
	char *iflan, *ifin, *accept, *drop, *cache, *bezcache, *dansg;
	char gate[16], mac_source[20];
	char **tabip;	


char ipsets [][100] =
    {
			{"HOSTS_ACCEPT_100 "}, //0
			{"HOSTS_ACCEPT_101 "}, //1
			{"HOSTS_ACCEPT_102 "}, //2
			{"HOSTS_ACCEPT_103 "}, //3
			{"HOSTS_ACCEPT_104 "}, //4
			{"HOSTS_ACCEPT_105 "}, //5
			{"HOSTS_ACCEPT_110 "}, //6
			{"HOSTS_ACCEPT_107 "}, //7
			{"HOSTS_ACCEPT_108 "}, //8
			{"HOSTS_ACCEPT_109 "}, //9

		      
        {"HOSTS_DROP_100 "},//10
        {"HOSTS_DROP_101 "},//11
        {"HOSTS_DROP_102 "},//12
        {"HOSTS_DROP_103 "},//13
        {"HOSTS_DROP_104 "},//14
        {"HOSTS_DROP_105 "},//15
        {"HOSTS_DROP_110 "},//16
        {"HOSTS_DROP_107 "},//17
        {"HOSTS_DROP_108 "},//18
        {"HOSTS_DROP_109 "},//19

        {"HOSTS_PROXY_100 "},//20
        {"HOSTS_PROXY_101 "},//21
        {"HOSTS_PROXY_102 "},//22
        {"HOSTS_PROXY_103 "},//23
        {"HOSTS_PROXY_104 "},//24
        {"HOSTS_PROXY_105 "},//25
        {"HOSTS_PROXY_110 "},//26
        {"HOSTS_PROXY_107 "},//27
        {"HOSTS_PROXY_108 "},//28
        {"HOSTS_PROXY_109 "},//29
																																																		
        {"HOSTS_BEZPROXY_100 "},//30
        {"HOSTS_BEZPROXY_101 "},//31
        {"HOSTS_BEZPROXY_102 "},//32
        {"HOSTS_BEZPROXY_103 "},//33
        {"HOSTS_BEZPROXY_104 "},//34
        {"HOSTS_BEZPROXY_105 "},//35
        {"HOSTS_BEZPROXY_110 "},//36
        {"HOSTS_BEZPROXY_107 "},//37
        {"HOSTS_BEZPROXY_108 "},//38
        {"HOSTS_BEZPROXY_109 "},//39
																								
        {"HOSTS_DANSG_100 "},//40
        {"HOSTS_DANSG_101 "},//41
        {"HOSTS_DANSG_102 "},//42
        {"HOSTS_DANSG_103 "},//43
        {"HOSTS_DANSG_104 "},//44
        {"HOSTS_DANSG_105 "},//45
        {"HOSTS_DANSG_110 "},//46
        {"HOSTS_DANSG_107 "},//47
        {"HOSTS_DANSG_108 "},//48
        {"HOSTS_DANSG_109 "},//49
    };
	
	
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
								
									if ( strcmp(arg, "all") ==0 ) 
										{
												fprintf(fps[31], "#---- %s ----------------------------------------------------------------------------------------------------------------------------------------# \n", komp.host);
										fprintf(fps[33], "%s  \t  %s.netico.pl         \t  %s \n", komp.ip, komp.host, komp.host);
								
										fpnat=fps[0];
										fphfsc=fps[11];
										iflan="$IF_MAN0";
								
												switch (ip.b2)
												{
														case 9:
																		accept=ipsets[0];
																		drop=ipsets[10];
																		cache=ipsets[20];
																		bezcache=ipsets[30];
																		dansg=ipsets[40];
																		break;
														case 32:
														    		accept=ipsets[1];
																		drop=ipsets[11];
																		cache=ipsets[21];
																		bezcache=ipsets[31];
																		dansg=ipsets[41];
																		break;
														case 33:
						    										accept=ipsets[2];
														        drop=ipsets[12];
																		cache=ipsets[22];
																		bezcache=ipsets[32];
																		dansg=ipsets[42];
																		break;
														case 36:
						    										accept=ipsets[3];
														        drop=ipsets[13];
																		cache=ipsets[23];
																		bezcache=ipsets[33];
																		dansg=ipsets[43];
																		break;
														case 37:
						    										accept=ipsets[4];
														        drop=ipsets[14];
																		cache=ipsets[24];
																		bezcache=ipsets[34];
																		dansg=ipsets[44];
																		break;
														case 40:
						    										accept=ipsets[5];
														        drop=ipsets[15];
																		cache=ipsets[25];
																		bezcache=ipsets[35];
																		dansg=ipsets[45];
																		break;
														case 41:
						    										accept=ipsets[6];
														        drop=ipsets[16];
																		cache=ipsets[26];
																		bezcache=ipsets[36];
																		dansg=ipsets[46];
																		break;
														case 48:
						    										accept=ipsets[7];
														        drop=ipsets[17];
																		cache=ipsets[27];
																		bezcache=ipsets[37];
																		dansg=ipsets[47];
																		break;
														case 49:
						    										accept=ipsets[8];
														        drop=ipsets[18];
																		cache=ipsets[28];
																		bezcache=ipsets[38];
																		dansg=ipsets[48];
																		break;
														case 56:
						    												accept=ipsets[9];
														    				drop=ipsets[19];
																		cache=ipsets[29];
																		bezcache=ipsets[39];
																		dansg=ipsets[49];
																		break;
                                                                                                                case 217:
                                                                                                                                                accept=ipsets[6];
                                                                                                                    	                        drop=ipsets[16];
                                                                                                                                                cache=ipsets[26];
                                                                                                                                    		bezcache=ipsets[36];
                                                                                                                                                dansg=ipsets[46];
                                                                                                                                                break;
                                                                                                }

															
												fprintf(fpnat,  "#---- %s ----------------------------------------------------------------------------------------------------------------------------------------# \n", komp.host);
																							
												if ( ip.b2 != oldbajt )
														if (  ip.b2 == 16  ||  ip.b2 == 17  || ip.b2 == 33  ||  ip.b2 == 32  ||  ip.b2 == 40  ||  ip.b2 == 48  ||  ip.b2 == 56   || ip.b1 == BAJT_PUBL )
															{
																oldbajt=ip.b2;
																fprintf ( fps[32], "} \n"  );
																dhcp_head2(ip.b2, fps[32], ip.b1, ip.b3, ip.b4);
															}
																																																													
												dhcp( komp, ip, fps[32]);
												
													if ( strcmp(komp.powiaz,"Y") == 0  && ip.b1 != BAJT_CORE )
														{
															strcpy(mac_source,komp.mac);
															//printf ("\n%s\n", mac_source);
														}
													else 
															strcpy(mac_source, "ff:ff:ff:ff:ff:ff");
													
													if ( strcmp(komp.net,"Y") == 0  && ip.b1 != BAJT_CORE ) 
													{
															hfsc( komp.host, komp.ip, komp.ip_zewn, komp.net_speed, komp.lan_speed, n, fps);
															++*n;								
															if (  strcmp(komp.ip_zewn, "$IP_NAT") != 0 ) 
																{
																	interfaces (k, komp.ip_zewn, "$IF_WAN1", "$NETMASK_I", fps[35]);
																	++k;
																}
																															 
														//	arptables(komp.mac, komp.host);
														//	statistics(komp.ip);
															masq(komp.ip, mac_source,  komp.ip_zewn, fpnat, accept);
													
															if ( strcmp(komp.proxy, "Y") == 0  &&  strcmp(komp.dg, "N") == 0 )
																	proxy(komp.ip, mac_source, fpnat, cache);
															else if ( strcmp(komp.proxy, "Y") == 0  &&  strcmp(komp.dg, "Y") == 0 )
																	dansguardian(komp.ip, mac_source, fpnat, dansg);
														//	else 
														//			bezproxy(komp.ip, mac_source, fpnat, bezcache);
													}								
													
													else if ( strcmp(komp.net, "N") == 0  && ip.b1 != BAJT_CORE )
														wylacz_net( komp.ip, mac_source, fpnat, drop);
													else if ( strcmp(komp.net, "Y") == 0 && strcmp(komp.ip_zewn, "$IP_NAT") != 0  && ip.b1 == BAJT_CORE )
													{                                           
                                                                                                          masq(komp.ip, mac_source,  komp.ip_zewn, fpnat, accept);
                                                                            				}                                                                                                                                                                                                                        
													if ( strcmp(komp.info,"Y") == 0  && ip.b1 != BAJT_CORE )
														info (komp.ip, komp.host, fps[36], fps[37]);
														
											}
									else if ( strcmp(arg, ARG1)==0 ) 
											{
												if ( ip.b2 != oldbajt )
														if ( ip.b2 == 8  ||  ip.b2 == 16  ||  ip.b1 == BAJT_CORE || ip.b1 == BAJT_PUBL )
															{
																oldbajt=ip.b2;
																fprintf ( fps[32], "} \n"  );
																dhcp_head2(ip.b2, fps[32], ip.b1, ip.b3, ip.b4);
															}
																																														
												dhcp( komp, ip, fps[32]);
											}
								  else if ( strcmp(arg, ARG2)==0  && ip.b1 != BAJT_CORE )
											{
												if ( strcmp(komp.net,"Y") == 0 ) 
												{
													hfsc( komp.host, komp.ip, komp.ip_zewn, komp.net_speed, komp.lan_speed, n, fps);
													++*n;
												}
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


