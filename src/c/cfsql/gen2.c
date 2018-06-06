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
				
				
	fprintf(fp,  "if ! $IPS -T %s %s 1> /dev/null \n", accept, ip);
	fprintf(fp,  "then $IPS -A %s %s \n", accept, ip);
	fprintf(fp,  "fi \n");
 
	if ( strcmp(ipzewn,IP_NAT) != 0 )
		{
//			fprintf(fp,  "$IPS -A %s %s \n", accept, ip);
			fprintf(fp,  "$IPT -t nat -D PREROUTING -t mangle -s %s -j MARK --set-mark 3 1> /dev/null \n", ip);
			fprintf(fp,  "$IPT -t nat -D POSTROUTING -s %s -o $IF_WAN1 ! -d $N_WAN1 -j SNAT --to %s  1> /dev/null \n", ip, ipzewn);
			fprintf(fp,  "$IPT -t nat -D PREROUTING -d %s -j DNAT --to %s   1> /dev/null  \n", ipzewn, ip);

			fprintf(fp,  "$IPT -t nat -I PREROUTING -t mangle -s %s -j MARK --set-mark 3 \n", ip);
			fprintf(fp,  "$IPT -t nat -I POSTROUTING -s %s -o $IF_WAN1 ! -d $N_WAN1 -j SNAT --to %s \n", ip, ipzewn);
			fprintf(fp,  "$IPT -t nat -I PREROUTING -d %s -j DNAT --to %s  \n", ipzewn, ip);
		}
}	


void interfaces(int i, str ipzewn, str iface, str netmask, FILE *fp)
{
		fprintf(fp,  "/sbin/ifconfig %s:%d \t %s \t \t netmask %s \n", iface, i, ipzewn, netmask);
}


// Redirect to proxy
void proxy (str ip, str mac, FILE * fp, str cache)
{

	char ipmac[100]="";
	
	if ( strcmp("ff:ff:ff:ff:ff:ff", mac) != 0 )
		{
			sprintf(ipmac, "%s%%s", ip, mac);
		}

	fprintf(fp,  "if ! $IPS -T %s %s  1> /dev/null \n", cache, ip);
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
		
	fprintf(fp,  "if ! $IPS -T %s %s  1> /dev/null \n", bezcache, ip);
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

	fprintf(fp,  "if ! $IPS -T %s %s  1> /dev/null \n", drop, ip);
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

	fprintf(fp,  "if ! $IPS -T %s %s  1> /dev/null \n", dansg, ip);
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
        fp=fps[11];
        fpup=fps[23];
        iflan="$IF_LAN0";
        ifin="$IF_IN0";
				
				switch(b3)
				{
					case 0:
						ht1="7:";
						break;
					case 2:
						ht1="8:";
						break;
					case 3:
						ht1="9:";
						break;
					case 4:
						ht1="10:";
						break;
					case 5:
						ht1="11:";
						break;
					case 6:
						ht1="12:";
						break;
					case 7:
						ht1="13:";
						break;
					case 8:
						ht1="14:";
						break;
					case 14:
						ht1="15:";
						break;
				}
				break;
	

		case 2:	
		
				classid=1;
				classidup=1;
        fp=fps[11];
        fpup=fps[23];
        iflan="$IF_LAN0";
        ifin="$IF_IN0";
				
				switch(b3)
				{
					case 0:
						ht1="16:";
						break;
					case 2:
						ht1="17:";
						break;
					case 4:
						ht1="18:";
						break;
					case 6:
						ht1="19:";
						break;
					case 8:
						ht1="20:";
						break;
					case 10:
						ht1="21:";
						break;
					case 12:
						ht1="22:";
						break;
					case 7:
						ht1="23:";
						break;
					case 14:
						ht1="24:";
						break;
					case 16:
						ht1="25:";
						break;
					case 18:
						ht1="26:";
						break;
					case 20:
						ht1="27:";
						break;
					case 21:
						ht1="28:";
						break;
					case 22:
						ht1="29:";
						break;
					case 23:
						ht1="30:";
						break;
					case 24:
						ht1="31:";
						break;
					case 25:
						ht1="32:";
						break;
					case 27:
						ht1="33:";
						break;
					case 17:
						ht1="34:";
						break;
					case 13:
						ht1="35:";
						break;
					case 11:
						ht1="36:";
						break;
					case 50:
						ht1="37:";
						break;
					case 88:
						ht1="38:";
						break;
					case 44:
						ht1="39:";
						break;
					case 222:
						ht1="40:";
						break;
					case 113:
						ht1="41:";
						break;
					case 55:
						ht1="42:";
						break;
					case 77:
						ht1="43:";
						break;
				}
				break;

		case 3:	
		
				classid=1;
				classidup=1;
        fp=fps[11];
        fpup=fps[23];
        iflan="$IF_LAN0";
        ifin="$IF_IN0";
				
				switch(b3)
				{
					case 0:
						ht1="44:";
						break;
					case 2:
						ht1="45:";
						break;
				}
				break;

		case 4:	
		
				classid=1;
				classidup=1;
        fp=fps[11];
        fpup=fps[23];
        iflan="$IF_LAN0";
        ifin="$IF_IN0";
				
				switch(b3)
				{
					case 0:
						ht1="46:";
						break;
					case 26:
						ht1="47:";
						break;
					case 28:
						ht1="48:";
						break;
				}
				break;

		case 5:	
		
				classid=1;
				classidup=1;
        fp=fps[11];
        fpup=fps[23];
        iflan="$IF_LAN0";
        ifin="$IF_IN0";
				
				switch(b3)
				{
					case 0:
						ht1="49:";
						break;
				}
				break;

		case 6:	
		
				classid=1;
				classidup=1;
        fp=fps[11];
        fpup=fps[23];
        iflan="$IF_LAN0";
        ifin="$IF_IN0";
				
				switch(b3)
				{
					case 0:
						ht1="50:";
						break;
				}
				break;

		case 7:	
		
				classid=1;
				classidup=1;
        fp=fps[11];
        fpup=fps[23];
        iflan="$IF_LAN0";
        ifin="$IF_IN0";
				
				switch(b3)
				{
					case 0:
						ht1="51:";
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
					case 29:
						ht1="31:";
						break;			
						
					case 137:
						ht1="32:";
						break;				
					case 138:
						ht1="33:";
						break;				
					case 139:
						ht1="34:";
						break;				
					case 140:
						ht1="35:";
						break;										
					case 141:
						ht1="36:";
						break;				
					case 142:
						ht1="37:";
						break;				
					case 143:
						ht1="38:";
						break;				
					case 144:
						ht1="39:";
						break;										
					case 145:
						ht1="40:";
						break;										
					case 146:
						ht1="41:";
						break;				
					case 147:
						ht1="42:";
						break;				
					case 148:
						ht1="43:";
						break;				
					case 149:
						ht1="44:";
						break;				
					case 150:
						ht1="45:";
						break;										
					case 151:
						ht1="46:";
						break;				
					case 152:
						ht1="47:";
						break;				
					case 153:
						ht1="48:";
						break;				
					case 154:
						ht1="49:";
						break;										
						
					case 155:
						ht1="50:";
						break;										
					case 156:
						ht1="51:";
						break;				
					case 157:
						ht1="52:";
						break;				
					case 158:
						ht1="53:";
						break;				
					case 159:
						ht1="54:";
						break;				
					case 160:
						ht1="55:";
						break;										
					case 161:
						ht1="56:";
						break;				
					case 162:
						ht1="57:";
						break;				
					case 163:
						ht1="58:";
						break;				
					case 164:
						ht1="59:";
						break;				
					case 165:
						ht1="60:";
						break;										
					case 166:
						ht1="61:";
						break;				
					case 167:
						ht1="62:";
						break;				
					case 168:
						ht1="63:";
						break;				
					case 169:
						ht1="64:";
						break;				
					case 170:
						ht1="65:";
						break;										
					case 171:
						ht1="66:";
						break;				
					case 172:
						ht1="67:";
						break;				
					case 173:
						ht1="68:";
						break;				
					case 174:
						ht1="69:";
						break;				
					case 175:
						ht1="70:";
						break;										
					case 176:
						ht1="71:";
						break;				
					case 177:
						ht1="72:";
						break;				
					case 178:
						ht1="73:";
						break;				
					case 179:
						ht1="74:";
						break;	
						
					case 180:
						ht1="75:";
						break;										
					case 181:
						ht1="76:";
						break;				
					case 182:
						ht1="77:";
						break;				
					case 183:
						ht1="78:";
						break;				
					case 184:
						ht1="79:";
						break;										
					case 185:
						ht1="80:";
						break;										
					case 186:
						ht1="81:";
						break;				
					case 187:
						ht1="82:";
						break;				
					case 188:
						ht1="83:";
						break;				
					case 189:
						ht1="84:";
						break;				
						
					case 190:
						ht1="85:";
						break;										
					case 191:
						ht1="86:";
						break;				
					case 192:
						ht1="87:";
						break;				
					case 193:
						ht1="88:";
						break;				
					case 194:
						ht1="89:";
						break;										
					case 195:
						ht1="90:";
						break;										
					case 196:
						ht1="91:";
						break;				
					case 197:
						ht1="92:";
						break;				
					case 198:
						ht1="93:";
						break;				
					case 199:
						ht1="94:";
						break;
						
					case 200:
						ht1="95:";
						break;										
					case 201:
						ht1="96:";
						break;				
					case 202:
						ht1="97:";
						break;				
					case 203:
						ht1="98:";
						break;				
					case 204:
						ht1="99:";
						break;				
					case 205:
						ht1="100:";
						break;										
					case 206:
						ht1="101:";
						break;				
					case 207:
						ht1="102:";
						break;				
					case 208:
						ht1="103:";
						break;				
					case 209:
						ht1="104:";
						break;	
						
					case 210:
						ht1="105:";
						break;										
					case 211:
						ht1="106:";
						break;				
					case 212:
						ht1="107:";
						break;				
					case 213:
						ht1="108:";
						break;				
					case 214:
						ht1="109:";
						break;				
					case 215:
						ht1="110:";
						break;										
					case 216:
						ht1="111:";
						break;				
					case 217:
						ht1="112:";
						break;				
					case 218:
						ht1="113:";
						break;				
					case 219:
						ht1="114:";
						break;	
						
					case 220:
						ht1="115:";
						break;										
					case 221:
						ht1="116:";
						break;				
					case 222:
						ht1="117:";
						break;				
					case 223:
						ht1="118:";
						break;				
					case 224:
						ht1="119:";
						break;				
					case 225:
						ht1="120:";
						break;										
					case 226:
						ht1="121:";
						break;				
					case 227:
						ht1="122:";
						break;				
					case 228:
						ht1="123:";
						break;				
					case 229:
						ht1="124:";
						break;	
						
					case 230:
						ht1="125:";
						break;										
					case 231:
						ht1="126:";
						break;				
					case 232:
						ht1="127:";
						break;				
					case 233:
						ht1="128:";
						break;				
					case 234:
						ht1="129:";
						break;										
					case 235:
						ht1="130:";
						break;										
					case 236:
						ht1="131:";
						break;				
					case 237:
						ht1="132:";
						break;				
					case 238:
						ht1="133:";
						break;				
					case 239:
						ht1="134:";
						break;				
						
					case 240:
						ht1="135:";
						break;										
					case 241:
						ht1="136:";
						break;				
					case 242:
						ht1="137:";
						break;				
					case 243:
						ht1="138:";
						break;				
					case 244:
						ht1="139:";
						break;										
					case 245:
						ht1="140:";
						break;										
					case 246:
						ht1="141:";
						break;				
					case 247:
						ht1="142:";
						break;				
					case 248:
						ht1="143:";
						break;				
					case 249:
						ht1="144:";
						break;			
						
					case 250:
						ht1="145:";
						break;										
					case 251:
						ht1="146:";
						break;				
					case 252:
						ht1="147:";
						break;				
					case 253:
						ht1="148:";
						break;				
					case 254:
						ht1="149:";
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
					case 29:
						ht1="179:";
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
						ht1="200:";
						break;
					case 1:
						ht1="201:";
						break;
					case 2:
						ht1="202:";
						break;
					case 3:
						ht1="203:";
						break;
					case 4:
						ht1="204:";
						break;
					case 5:
						ht1="205:";
						break;
					case 6:
						ht1="206:";
						break;
					case 7:
						ht1="207:";
						break;
					case 8:
						ht1="208:";
						break;
					case 9:
						ht1="209:";
						break;
					case 10:
						ht1="210:";
						break;
					case 11:
						ht1="211:";
						break;
					case 12:
						ht1="212:";
						break;
					case 13:
						ht1="213:";
						break;
					case 14:
						ht1="214:";
						break;
					case 15:
						ht1="215:";
						break;
					case 16:
						ht1="216:";
						break;
					case 17:
						ht1="217:";
						break;
					case 18:
						ht1="218:";
						break;
					case 19:
						ht1="219:";
						break;
					case 20:
						ht1="220:";
						break;
					case 21:
						ht1="221:";
						break;
					case 22:
						ht1="222:";
						break;
					case 23:
						ht1="223:";
						break;
					case 24:
						ht1="224:";
						break;
					case 25:
						ht1="225:";
						break;				
					case 26:
						ht1="226:";
						break;				
					case 27:
						ht1="227:";
						break;				
					case 28:
						ht1="228:";
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
    else if ( strcmp(netdown,"P1000")==0  ) 
		{
        CEILD="$P1000_D";
        CEILU="$P1000_U";
        CEILD_P2P="$P1000_P2P";
        CEILD_MAX="$P1000_MAX";
		}
    else if ( strcmp(netdown,"P2000")==0  ) 
		{
        CEILD="$P2000_D";
        CEILU="$P2000_U";
        CEILD_P2P="$P2000_P2P";
        CEILD_MAX="$P2000_MAX";
		}
    else if ( strcmp(netdown,"P4000")==0  ) 
		{
        CEILD="$P4000_D";
        CEILU="$P4000_U";
        CEILD_P2P="$P4000_P2P";
        CEILD_MAX="$P4000_MAX";
		}
    else if ( strcmp(netdown,"P6000")==0  ) 
		{
        CEILD="$P6000_D";
        CEILU="$P6000_U";
        CEILD_P2P="$P6000_P2P";
        CEILD_MAX="$P6000_MAX";
		}
    else if ( strcmp(netdown,"P8000")==0  ) 
		{
        CEILD="$P8000_D";
        CEILU="$P8000_U";
        CEILD_P2P="$P8000_P2P";
        CEILD_MAX="$P8000_MAX";
		}
    else if ( strcmp(netdown,"P10000")==0  ) 
		{
        CEILD="$P10000_D";
        CEILU="$P10000_U";
        CEILD_P2P="$P10000_P2P";
        CEILD_MAX="$P10000_MAX";
		}
    else if ( strcmp(netdown,"P12000")==0  ) 
		{
        CEILD="$P12000_D";
        CEILU="$P12000_U";
        CEILD_P2P="$P12000_P2P";
        CEILD_MAX="$P12000_MAX";
		}
    else if ( strcmp(netdown,"S2000")==0  ) 
		{
        CEILD="$S2000_D";
        CEILU="$S2000_U";
        CEILD_P2P="$S2000_P2P";
        CEILD_MAX="$S2000_MAX";
		}
    else if ( strcmp(netdown,"S3000")==0  ) 
		{
        CEILD="$S3000_D";
        CEILU="$S3000_U";
        CEILD_P2P="$S3000_P2P";
        CEILD_MAX="$S3000_MAX";
		}
    else if ( strcmp(netdown,"S4000")==0  ) 
		{
        CEILD="$S4000_D";
        CEILU="$S4000_U";
        CEILD_P2P="$S4000_P2P";
        CEILD_MAX="$S4000_MAX";
				
		}
    else if ( strcmp(netdown,"S5000")==0  ) 
		{
        CEILD="$S5000_D";
        CEILU="$S5000_U";
        CEILD_P2P="$S5000_P2P";
        CEILD_MAX="$S5000_MAX";				
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
   else if ( strcmp(landown,"P4000")==0  ) 
	 {
       CEILDLAN="$P4000_D";
       CEILULAN="$P4000_U";
		}
   else if ( strcmp(landown,"P6000")==0  ) 
	 {
       CEILDLAN="$P6000_D";
       CEILULAN="$P6000_U";
		}
   else if ( strcmp(landown,"P8000")==0  ) 
	 {
       CEILDLAN="$P8000_D";
       CEILULAN="$P8000_U";
		}
   else if ( strcmp(landown,"P10000")==0  ) 
	 {
       CEILDLAN="$P10000_D";
       CEILULAN="$P10000_U";
		}
   else if ( strcmp(landown,"P12000")==0  ) 
	 {
       CEILDLAN="$P12000_D";
       CEILULAN="$P12000_U";
		}
	else if ( strcmp(landown,"S2000")==0  ) 
	 {
       CEILDLAN="$S2000_D";
       CEILULAN="$S2000_U";
		}
	else if ( strcmp(landown,"S3000")==0  ) 
	 {
       CEILDLAN="$S3000_D";
       CEILULAN="$S3000_U";
		}
	else if ( strcmp(landown,"S4000")==0  ) 
	 {
       CEILDLAN="$S4000_D";
       CEILULAN="$S4000_U";
		}
	else if ( strcmp(landown,"S5000")==0  ) 
	 {
       CEILDLAN="$S5000_D";
       CEILULAN="$S5000_U";
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
		

		i2=*i+3000;
    i3=*i+5000;
    i4=*i+7000;
//    mm=m+4000;
		
		sprintf(ht, "%s%s", ht1, ht2);
		
	//	printf ("%s %s %s %d %d ", CEILD, ht, ip, classid);

	
    fprintf(fp, "#---- %s -------------------------------------------------------------------------------------------# \n", 						host);
//	    printf( "#---- %s -------------------------------------------------------------------------------------------# \n", 						host);	
    fprintf(fp, "tc class add dev  %s parent %d:100 classid %d:%d hfsc ls m2 1kbit ul m2 %s && \n", 																			iflan, classid, classid, *i, CEILDLAN);
		
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
    fprintf(fp, "tc class add dev  %s parent %d:3100 	classid %d:%d hfsc ls m2 1kbit ul m2 %s && \n",																					iflan, classid, classid, i2, CEILD_MAX );
		
    fprintf(fp, "tc class add dev  %s parent %d:%d 		classid %d:%d hfsc ls m2 1kbit ul m1 %s d 300s m2 %s && \n",																					iflan, classid, i2, classid, i3, CEILD_MAX, CEILD);

    
		fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip dst %s match ip sport 80 0xffff flowid %d:%d && \n",  	iflan, ht, ip, classid, i3);
    
		fprintf(fp, "tc qdisc add dev %s parent %d:%d pfifo limit 128 && \n",                                   																	iflan, classid, i3);
    fprintf(fp, "tc class add dev %s parent %d:%d classid %d:%d hfsc ls m2 1kbit ul m1 %s d 300s m2 %s && \n", 																iflan, classid, i2, classid, i4, CEILD, CEILD_P2P);
    fprintf(fp, "tc filter add dev %s protocol ip parent 1:0 prio 4 u32 ht %s match ip dst %s flowid %d:%d && \n",  													iflan, ht, ip, classid, i4);
    fprintf(fp, "tc qdisc add dev %s parent %d:%d pfifo limit 128  \n",                                                          						iflan, classid, i4);
	    	    
        
    fprintf(fpup, "#---- %s -------------------------------------------------------------------------------------------# \n", 					host );
    fprintf(fpup, "tc class add dev %s parent %d:100 classid %d:%d hfsc ls m2 1kbit ul m2 %s && \n", 																		ifin, classidup, classidup, *i, CEILULAN);
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

    fprintf(fpup, "tc class add dev %s parent %d:3100 classid %d:%d hfsc ls m2 1kbit ul m2 %s && \n", 																			ifin, classidup, classidup, i2, CEILU);
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
			{"10.0.0.0/24"}, //2
			{"10.0.3.0/24"}, //3
			{"10.0.5.0/24"}, //4
			{"10.0.6.0/24"}, //5
			{"10.0.2.0/24"}, //6
			
			{"10.1.0.0/24"}, //7
			{"10.1.2.0/24"}, //8
			{"10.1.3.0/24"}, //9
			{"10.1.4.0/24"}, //10
			{"10.1.5.0/24"}, //11
			{"10.1.6.0/24"}, //12
			{"10.1.7.0/24"}, //13
			{"10.1.8.0/24"}, //14
			{"10.1.14.0/24"},//15

			{"10.2.0.0/24"},//16
			{"10.2.2.0/24"},//17
			{"10.2.4.0/24"},//18
			{"10.2.6.0/24"},//19
			{"10.2.8.0/24"},//20
			{"10.2.10.0/24"}, //21
			{"10.2.12.0/24"},	//22		
			{"10.2.7.0/24"},	//23		
			{"10.2.14.0/24"},	//24		
			{"10.2.16.0/24"},	//25		
			{"10.2.18.0/24"},	//26		
			{"10.2.20.0/24"},	//27
			{"10.2.21.0/24"},	//28		
			{"10.2.22.0/24"},	//29		
			{"10.2.23.0/24"},	//30		
			{"10.2.24.0/24"},	//31		
			{"10.2.25.0/24"},	//32		
			{"10.2.27.0/24"},	//33		
			{"10.2.17.0/24"},	//34		
			{"10.2.13.0/24"},	//35		
			{"10.2.11.0/24"},	//36		
			{"10.2.50.0/24"},	//37		
			{"10.2.88.0/24"},	//38		
			{"10.2.44.0/24"},	//39		
			{"10.2.222.0/24"},//40			
			{"10.2.113.0/24"},//41			
			{"10.2.55.0/24"},	//42		
			{"10.2.77.0/24"},	//43		

			{"10.3.0.0/24"},  //44
			{"10.3.2.0/24"},  //45
			{"10.4.0.0/24"},  //46
			{"10.4.26.0/24"}, //47
			{"10.4.28.0/24"}, //48
			{"10.5.0.0/24"},  //49
			{"10.6.0.0/24"},  //50		
			{"10.7.0.0/24"},  //51
			
			{"0"},
			{"$IF_IN0"},
			{"src"},
			{"12"},
			{"10.0.0.0/24"},
			{"10.0.3.0/24"},
			{"10.0.5.0/24"},
			{"10.0.6.0/24"},
			{"10.0.2.0/24"},
			
			{"10.1.0.0/24"},
			{"10.1.2.0/24"},
			{"10.1.3.0/24"},
			{"10.1.4.0/24"},
			{"10.1.5.0/24"},
			{"10.1.6.0/24"},
			{"10.1.7.0/24"},
			{"10.1.8.0/24"},
			{"10.1.14.0/24"},

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

			{"10.8.137.0/24"},
			{"10.8.138.0/24"},
			{"10.8.139.0/24"},

			{"10.8.140.0/24"},
			{"10.8.141.0/24"},
			{"10.8.142.0/24"},
			{"10.8.143.0/24"},
			{"10.8.144.0/24"},
			{"10.8.145.0/24"},
			{"10.8.146.0/24"},
			{"10.8.147.0/24"},
			{"10.8.148.0/24"},
			{"10.8.149.0/24"},
			
			{"10.8.150.0/24"},
			{"10.8.151.0/24"},
			{"10.8.152.0/24"},
			{"10.8.153.0/24"},
			{"10.8.154.0/24"},
			{"10.8.155.0/24"},
			{"10.8.156.0/24"},
			{"10.8.157.0/24"},
			{"10.8.158.0/24"},
			{"10.8.159.0/24"},
			
			{"10.8.160.0/24"},
			{"10.8.161.0/24"},
			{"10.8.162.0/24"},
			{"10.8.163.0/24"},
			{"10.8.164.0/24"},
			{"10.8.165.0/24"},
			{"10.8.166.0/24"},
			{"10.8.167.0/24"},
			{"10.8.168.0/24"},
			{"10.8.169.0/24"},
			
			{"10.8.170.0/24"},
			{"10.8.171.0/24"},
			{"10.8.172.0/24"},
			{"10.8.173.0/24"},
			{"10.8.174.0/24"},
			{"10.8.175.0/24"},
			{"10.8.176.0/24"},
			{"10.8.177.0/24"},
			{"10.8.178.0/24"},
			{"10.8.179.0/24"},
			{"10.8.180.0/24"},
			
			{"10.8.181.0/24"},
			{"10.8.182.0/24"},
			{"10.8.183.0/24"},
			{"10.8.184.0/24"},
			{"10.8.185.0/24"},
			{"10.8.186.0/24"},
			{"10.8.187.0/24"},
			{"10.8.188.0/24"},
			{"10.8.189.0/24"},
			
			{"10.8.190.0/24"},
			{"10.8.191.0/24"},
			{"10.8.192.0/24"},
			{"10.8.193.0/24"},
			{"10.8.194.0/24"},
			{"10.8.195.0/24"},
			{"10.8.196.0/24"},
			{"10.8.197.0/24"},
			{"10.8.198.0/24"},
			{"10.8.199.0/24"},
			
			{"10.8.200.0/24"},
			{"10.8.201.0/24"},
			{"10.8.202.0/24"},
			{"10.8.203.0/24"},
			{"10.8.204.0/24"},
			{"10.8.205.0/24"},
			{"10.8.206.0/24"},
			{"10.8.207.0/24"},
			{"10.8.208.0/24"},
			{"10.8.209.0/24"},
			
			{"10.8.210.0/24"},
			{"10.8.211.0/24"},
			{"10.8.212.0/24"},
			{"10.8.213.0/24"},
			{"10.8.214.0/24"},
			{"10.8.215.0/24"},
			{"10.8.216.0/24"},
			{"10.8.217.0/24"},
			{"10.8.218.0/24"},
			{"10.8.219.0/24"},
			
			{"10.8.220.0/24"},
			{"10.8.221.0/24"},
			{"10.8.222.0/24"},
			{"10.8.223.0/24"},
			{"10.8.224.0/24"},
			{"10.8.225.0/24"},
			{"10.8.226.0/24"},
			{"10.8.227.0/24"},
			{"10.8.228.0/24"},
			{"10.8.229.0/24"},
			
			{"10.8.230.0/24"},
			{"10.8.231.0/24"},
			{"10.8.232.0/24"},
			{"10.8.233.0/24"},
			{"10.8.234.0/24"},
			{"10.8.235.0/24"},
			{"10.8.236.0/24"},
			{"10.8.237.0/24"},
			{"10.8.238.0/24"},
			{"10.8.239.0/24"},
			
			{"10.8.240.0/24"},
			{"10.8.241.0/24"},
			{"10.8.242.0/24"},
			{"10.8.243.0/24"},
			{"10.8.244.0/24"},
			{"10.8.245.0/24"},
			{"10.8.246.0/24"},
			{"10.8.247.0/24"},
			{"10.8.248.0/24"},
			{"10.8.249.0/24"},
			
			{"10.8.250.0/24"},
			{"10.8.251.0/24"},
			{"10.8.252.0/24"},
			{"10.8.253.0/24"},
			{"10.8.254.0/24"},

			
			{"10.9.0.0/24"},   // 200:0
			{"10.9.1.0/24"},   // 201:0
			{"10.9.2.0/24"},   
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
			{"10.8.29.0/24"}
			,
			{"10.8.137.0/24"},
			{"10.8.138.0/24"},
			{"10.8.139.0/24"},

			{"10.8.140.0/24"},
			{"10.8.141.0/24"},
			{"10.8.142.0/24"},
			{"10.8.143.0/24"},
			{"10.8.144.0/24"},
			{"10.8.145.0/24"},
			{"10.8.146.0/24"},
			{"10.8.147.0/24"},
			{"10.8.148.0/24"},
			{"10.8.149.0/24"},
			
			{"10.8.150.0/24"},
			{"10.8.151.0/24"},
			{"10.8.152.0/24"},
			{"10.8.153.0/24"},
			{"10.8.154.0/24"},
			{"10.8.155.0/24"},
			{"10.8.156.0/24"},
			{"10.8.157.0/24"},
			{"10.8.158.0/24"},
			{"10.8.159.0/24"},
			
			{"10.8.160.0/24"},
			{"10.8.161.0/24"},
			{"10.8.162.0/24"},
			{"10.8.163.0/24"},
			{"10.8.164.0/24"},
			{"10.8.165.0/24"},
			{"10.8.166.0/24"},
			{"10.8.167.0/24"},
			{"10.8.168.0/24"},
			{"10.8.169.0/24"},
			
			{"10.8.170.0/24"},
			{"10.8.171.0/24"},
			{"10.8.172.0/24"},
			{"10.8.173.0/24"},
			{"10.8.174.0/24"},
			{"10.8.175.0/24"},
			{"10.8.176.0/24"},
			{"10.8.177.0/24"},
			{"10.8.178.0/24"},
			{"10.8.179.0/24"},
			{"10.8.180.0/24"},
			
			{"10.8.181.0/24"},
			{"10.8.182.0/24"},
			{"10.8.183.0/24"},
			{"10.8.184.0/24"},
			{"10.8.185.0/24"},
			{"10.8.186.0/24"},
			{"10.8.187.0/24"},
			{"10.8.188.0/24"},
			{"10.8.189.0/24"},
			
			{"10.8.190.0/24"},
			{"10.8.191.0/24"},
			{"10.8.192.0/24"},
			{"10.8.193.0/24"},
			{"10.8.194.0/24"},
			{"10.8.195.0/24"},
			{"10.8.196.0/24"},
			{"10.8.197.0/24"},
			{"10.8.198.0/24"},
			{"10.8.199.0/24"},
			
			{"10.8.200.0/24"},
			{"10.8.201.0/24"},
			{"10.8.202.0/24"},
			{"10.8.203.0/24"},
			{"10.8.204.0/24"},
			{"10.8.205.0/24"},
			{"10.8.206.0/24"},
			{"10.8.207.0/24"},
			{"10.8.208.0/24"},
			{"10.8.209.0/24"},
			
			{"10.8.210.0/24"},
			{"10.8.211.0/24"},
			{"10.8.212.0/24"},
			{"10.8.213.0/24"},
			{"10.8.214.0/24"},
			{"10.8.215.0/24"},
			{"10.8.216.0/24"},
			{"10.8.217.0/24"},
			{"10.8.218.0/24"},
			{"10.8.219.0/24"},
			
			{"10.8.220.0/24"},
			{"10.8.221.0/24"},
			{"10.8.222.0/24"},
			{"10.8.223.0/24"},
			{"10.8.224.0/24"},
			{"10.8.225.0/24"},
			{"10.8.226.0/24"},
			{"10.8.227.0/24"},
			{"10.8.228.0/24"},
			{"10.8.229.0/24"},
			
			{"10.8.230.0/24"},
			{"10.8.231.0/24"},
			{"10.8.232.0/24"},
			{"10.8.233.0/24"},
			{"10.8.234.0/24"},
			{"10.8.235.0/24"},
			{"10.8.236.0/24"},
			{"10.8.237.0/24"},
			{"10.8.238.0/24"},
			{"10.8.239.0/24"},
			
			{"10.8.240.0/24"},
			{"10.8.241.0/24"},
			{"10.8.242.0/24"},
			{"10.8.243.0/24"},
			{"10.8.244.0/24"},
			{"10.8.245.0/24"},
			{"10.8.246.0/24"},
			{"10.8.247.0/24"},
			{"10.8.248.0/24"},
			{"10.8.249.0/24"},
			
			{"10.8.250.0/24"},
			{"10.8.251.0/24"},
			{"10.8.252.0/24"},
			{"10.8.253.0/24"},
			{"10.8.254.0/24"},


			{"10.9.0.0/24"},   // 200:0
			{"10.9.1.0/24"},   // 201:0
			{"10.9.2.0/24"},   
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
			{"10.22.6.0/24"},   // 120:0
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
			{"10.22.6.0/24"},   // 120:0
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
	fprintf(fp,   "tc class add dev %s parent 1:0 classid %d:1 hfsc ls m2 500Mbit ul m2 700Mbit && \n", dev, classid);
	fprintf(fp,   "tc class add dev %s parent 1:0 classid %d:2 hfsc ls m2 200Mbit ul m2 300Mbit && \n", dev, classid);			
	
	if ( strcmp(dev, "$IF_LAN8") == 0)
		{
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:100 hfsc ls m2 50Mbit ul m2 70Mbit	&& \n", dev, classid, classid);
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:3100 hfsc ls m2 50Mbit ul m2 70Mbit	&& \n", dev, classid, classid);
		}
	else if ( strcmp(dev, "$IF_IN4") == 0)
		{
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:100 hfsc ls m2 50Mbit ul m2 70Mbit	&& \n", dev, classid, classid);
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:3100 hfsc ls m2 50Mbit ul m2 70Mbit	&& \n", dev, classid, classid);
		}
	else if ( strcmp(dev, "$IF_LAN16") == 0)
		{
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:100 hfsc ls m2 50Mbit ul m2 70Mbit	&& \n", dev, classid, classid);
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:3100 hfsc ls m2 50Mbit ul m2 70Mbit	&& \n", dev, classid, classid);
		}
	else if ( strcmp(dev, "$IF_IN5") == 0)
		{
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:100 hfsc ls m2 50Mbit ul m2 70Mbit && \n", dev, classid, classid);
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:3100 hfsc ls m2 50Mbit ul m2 70Mbit && \n", dev, classid, classid);
		}
	else
		{
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:100 hfsc ls m2 300Mbit ul m2 500Mbit && \n", dev, classid, classid);
			fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:3100 hfsc ls m2 300Mbit ul m2 500Mbit && \n", dev, classid, classid);
		}

	fprintf(fp,   "tc class add dev %s parent %d:1 classid %d:9999 hfsc ls m2 256kbit && \n", dev, classid, classid);
	fprintf(fp,   "tc filter add dev %s protocol ip parent 1:0 prio 3 u32 match ip protocol 1 0xff flowid %d:2 && \n\n", dev, classid);

	
	if ( strcmp(dev, "$IF_IN0") == 0)
		{
			fprintf(fp,   "tc qdisc del dev $IF_LAN0 ingress \n", dev);
			fprintf(fp,   "tc qdisc add dev $IF_LAN0 ingress && \n", dev);
			fprintf(fp,   "tc filter add dev $IF_LAN0 parent ffff:0 protocol ip prio 10 u32 match u32 0 0 flowid 1:1 action mirred egress redirect dev %s && \n", dev);
		}	

	else if ( strcmp(dev, "$IF_IN4") == 0)
		{
			fprintf(fp,   "tc qdisc del dev $IF_LAN8 ingress \n", dev);
			fprintf(fp,   "tc qdisc add dev $IF_LAN8 ingress && \n", dev);
			fprintf(fp,   "tc filter add dev $IF_LAN8 parent ffff:0 protocol ip prio 10 u32 match u32 0 0 flowid 1:1 action mirred egress redirect dev %s && \n", dev);
		}	
	else if ( strcmp(dev, "$IF_IN5") == 0)
		{
			fprintf(fp,   "tc qdisc del dev $IF_LAN16 ingress \n", dev);
			fprintf(fp,   "tc qdisc add dev $IF_LAN16 ingress && \n", dev);
			fprintf(fp,   "tc filter add dev $IF_LAN16 parent ffff:0 protocol ip prio 10 u32 match u32 0 0 flowid 1:1 action mirred egress redirect dev %s && \n", dev);
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
													else 
													{
														if ( ip.b2 < BAJT_WLAN1 )
															{
																sprintf(gate, "%d.%d.0.1", ip.b1,ip.b2);
																fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.0.0;}\n", komp.host, komp.mac, komp.ip, gate);
															}
														else if ( ip.b2 >= BAJT_WLAN1 ) 
															{
															
																switch (ip.b2)
																	{
																	
																		case 8: 		
																						if ( ip.b3 >= 32  && ip.b3 < 112 ) 
																							{
																								g=brama(ip.b4, 26);
																								sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.192;} \n", komp.host, komp.mac, komp.ip, gate     );
																							}	
																						else	if ( ip.b3 >= 112  && ip.b3 < 176 ) 
																							{
																								g=brama(ip.b4, 27);
																								sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.224;} \n", komp.host, komp.mac, komp.ip, gate     );
																							}																						
																						else if ( ip.b3 >= 176  && ip.b3 < 224 ) 
																							{
																								g=brama(ip.b4, 28);
																								sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.240;} \n", komp.host, komp.mac, komp.ip, gate     );
																							}
																						else if ( ip.b3 == 27  ||  ip.b3 == 28  || ip.b3 == 29 || ip.b3 == 30 || ( ip.b3 >= 224 && ip.b3 < 240)  ) 
																							{
																								g=brama(ip.b4, 29);
																								sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.248;} \n", komp.host, komp.mac, komp.ip, gate     );
																							}
																						else if ( ip.b3 >= 240  && ip.b3 < 255) 
																							{
																								g=brama(ip.b4, 30);
																								sprintf(gate, "%d.%d.%d.%d", ip.b1,ip.b2,ip.b3,g);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.255.252;} \n", komp.host, komp.mac, komp.ip, gate     );
																							}
																						else
																							{
																								sprintf(gate, "%d.%d.%d.254", ip.b1,ip.b2,ip.b3);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s;} \n", komp.host, komp.mac, komp.ip, gate     ); 
																							}
																						break;
																		case 9:
																						if (  ip.b3 >= 0 &&  ip.b3 <= 7 )
																							{
																								sprintf(gate, "%d.%d.7.254", ip.b1,ip.b2);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s; option subnet-mask 255.255.248.0;} \n", komp.host, komp.mac, komp.ip, gate);
																							}
																						else  if ( ip.b3 == 27  ||  ip.b3 == 28  || ip.b3 == 29 ) 
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
																						
																		case 10:	
																		
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
																		case 11: 		
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

																						
																						
																		case 16:	
																								sprintf(gate, "%d.%d.%d.254", ip.b1,ip.b2,ip.b3);
																								fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s;} \n", komp.host, komp.mac, komp.ip, gate     ); 
																						break;
																						
																		case 17:
																						if ( ip.b3 == 29 ) 
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
																									
																		case 18:
																						if ( ip.b3 == 29 ) 
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
										
																		case 19:
																						if ( ip.b3 == 29 ) 
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
										
																		case 20:
																						if ( ip.b3 == 29 ) 
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
																		case 21:
																						if ( ip.b3 == 29 ) 
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
																		case 22:
																						if ( ip.b3 == 29 ) 
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
																																					
															//			default:
															//							sprintf(gate, "%d.%d.0.1", ip.b1,ip.b2);															
															//							fprintf(fp,  "host %s \t\t {hardware ethernet %s; fixed-address %s; option routers %s;} \n", komp.host, komp.mac, komp.ip, gate );		
															//							break;
																	}
																}
																		
															}					 
													}							 
			

}


void dhcp_head(FILE *fp)
{
		fprintf( fp, "AUTHORITATIVE;\n");
		fprintf( fp, "ddns-update-style ad-hoc; \n\n");
}

void dhcp_head2(int b2, FILE *fp, int b1)
{

	char subnet[16];
	char gate[16];
	char subnetmask[16]="255.255.255.0";
	char broadcast[16];
	char netmask[16]="255.255.0.0";
	
	sprintf(subnet,    "10.%d.0.0",     b2);
	sprintf(gate,      "10.%d.0.1",     b2);
	sprintf(broadcast, "10.%d.255.255", b2);


	
	
	if ( b1 != BAJT_CORE)
		{
			if ( b2 < BAJT_WLAN1 )
				{
				        fprintf(fp, "shared-network netico               \n");
					fprintf(fp, "{               \n");              		       
					fprintf(fp, "subnet 10.0.0.0 netmask 255.248.0.0               \n");
					fprintf(fp, "{                                                 \n");
					fprintf(fp, "deny unknown-clients;                             \n");
					fprintf(fp, "default-lease-time           %d;                  \n", D_LEASE_TIME   );
					fprintf(fp, "max-lease-time               %d;                  \n", MAX_LEASE_TIME );
					fprintf(fp, "option domain-name           \"netico.pl\";       \n");
					fprintf(fp, "option domain-name-servers   %s, %s, %s; 				 \n", DNS1, DNS2, DNS3 );
					fprintf(fp, "option subnet-mask           %s;                  \n", subnetmask);
					fprintf(fp, "option ntp-servers  %s;           								       \n", DNS1 );
				}
			else if ( b2 >= BAJT_WLAN1 && b2 < BAJT_WLAN2 )
				{
					fprintf(fp, "subnet 10.8.0.0 netmask 255.248.0.0               \n");
					fprintf(fp, "{                                                 \n");
					fprintf(fp, "deny unknown-clients;                             \n");
					fprintf(fp, "default-lease-time           %d;                  \n", D_LEASE_TIME   );
					fprintf(fp, "max-lease-time               %d;                  \n", MAX_LEASE_TIME );
					fprintf(fp, "option domain-name           \"netico.pl\";       \n");
					fprintf(fp, "option domain-name-servers   %s, %s, %s; 				 \n", DNS1, DNS2, DNS3 );
					fprintf(fp, "option subnet-mask           %s;                  \n", subnetmask);
					fprintf(fp, "option ntp-servers  %s;           								       \n", DNS1 );
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
					fprintf(fp, "option ntp-servers  %s;           								       \n", DNS1 );
				}
			}	
		else 
		{
			fprintf(fp, "subnet 172.16.8.0 netmask 255.255.248.0              \n");
			fprintf(fp, "{                                                 \n");
			fprintf(fp, "deny unknown-clients;                             \n");
			fprintf(fp, "default-lease-time           %d;                  \n", D_LEASE_TIME   );
			fprintf(fp, "max-lease-time               %d;                  \n", MAX_LEASE_TIME );
			fprintf(fp, "option domain-name           \"netico.pl\";       \n");
			fprintf(fp, "option domain-name-servers   %s, %s, %s; 				 \n", DNS1, DNS2, DNS3 );
			fprintf(fp, "option subnet-mask           255.255.248.0;                  \n");
			fprintf(fp, "option routers               172.16.8.1;                  \n" );
			fprintf(fp, "option ntp-servers  %s;           								       \n", DNS1 );
		} 
		fprintf(fp, "                                                    \n");
}


void hosts_head(FILE *fp)
{
		fprintf(fp,  "127.0.0.1  \t  localhost                 \n" );
		fprintf(fp,  "%s \t  quark_lan.%s  \t  quark_lan \n", IP_LAN,     DOMAIN1 );
                fprintf(fp,  "%s \t  quark_lan.%s  \t  quark_lan \n", IP_LAN0,     DOMAIN1 );
				
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
	char *iflan, *ifin, *accept, *drop, *cache, *bezcache, *dansg;
	char gate[16], mac_source[20];
	char **tabip;	


char ipsets [][100] =
    {
			{"HOSTS_ACCEPT_100 "},
			{"HOSTS_ACCEPT_101 "},
			{"HOSTS_ACCEPT_102 "},
			{"HOSTS_ACCEPT_103 "},
			{"HOSTS_ACCEPT_104 "},
			{"HOSTS_ACCEPT_105 "},
			{"HOSTS_ACCEPT_106 "},
			{"HOSTS_ACCEPT_107 "},
			{"HOSTS_ACCEPT_108 "},
			{"HOSTS_ACCEPT_109 "},
			{"HOSTS_ACCEPT_110 "},
			{"HOSTS_ACCEPT_111 "},
			{"HOSTS_ACCEPT_112 "},
			{"HOSTS_ACCEPT_113 "},
			{"HOSTS_ACCEPT_114 "},
			{"HOSTS_ACCEPT_115 "},
			{"HOSTS_ACCEPT_116 "},
			{"HOSTS_ACCEPT_117 "},
			{"HOSTS_ACCEPT_118 "},
			{"HOSTS_ACCEPT_119 "},
			{"HOSTS_ACCEPT_120 "},
			{"HOSTS_ACCEPT_121 "},
			{"HOSTS_ACCEPT_122 "},
			{"HOSTS_ACCEPT_123 "},
		      
        {"HOSTS_DROP_100 "},
        {"HOSTS_DROP_101 "},
        {"HOSTS_DROP_102 "},
        {"HOSTS_DROP_103 "},
        {"HOSTS_DROP_104 "},
        {"HOSTS_DROP_105 "},
        {"HOSTS_DROP_106 "},
        {"HOSTS_DROP_107 "},
        {"HOSTS_DROP_108 "},
        {"HOSTS_DROP_109 "},
        {"HOSTS_DROP_110 "},
        {"HOSTS_DROP_111 "},
        {"HOSTS_DROP_112 "},
        {"HOSTS_DROP_113 "},
        {"HOSTS_DROP_114 "},
        {"HOSTS_DROP_115 "},
        {"HOSTS_DROP_116 "},
        {"HOSTS_DROP_117 "},
        {"HOSTS_DROP_118 "},
        {"HOSTS_DROP_119 "},
        {"HOSTS_DROP_120 "},
        {"HOSTS_DROP_121 "},
        {"HOSTS_DROP_122 "},
        {"HOSTS_DROP_123 "},

        {"HOSTS_PROXY_100 "},
        {"HOSTS_PROXY_101 "},
        {"HOSTS_PROXY_102 "},
        {"HOSTS_PROXY_103 "},
        {"HOSTS_PROXY_104 "},
        {"HOSTS_PROXY_105 "},
        {"HOSTS_PROXY_106 "},
        {"HOSTS_PROXY_107 "},
        {"HOSTS_PROXY_108 "},
        {"HOSTS_PROXY_109 "},
        {"HOSTS_PROXY_110 "},
        {"HOSTS_PROXY_111 "},
        {"HOSTS_PROXY_112 "},
        {"HOSTS_PROXY_113 "},
        {"HOSTS_PROXY_114 "},
        {"HOSTS_PROXY_115 "},
        {"HOSTS_PROXY_116 "},
        {"HOSTS_PROXY_117 "},
        {"HOSTS_PROXY_118 "},
				{"HOSTS_PROXY_119 "},
        {"HOSTS_PROXY_120 "},
        {"HOSTS_PROXY_121 "},
        {"HOSTS_PROXY_122 "},
        {"HOSTS_PROXY_123 "},
																																																		
        {"HOSTS_BEZPROXY_100 "},
        {"HOSTS_BEZPROXY_101 "},
        {"HOSTS_BEZPROXY_102 "},
        {"HOSTS_BEZPROXY_103 "},
        {"HOSTS_BEZPROXY_104 "},
        {"HOSTS_BEZPROXY_105 "},
        {"HOSTS_BEZPROXY_106 "},
        {"HOSTS_BEZPROXY_107 "},
        {"HOSTS_BEZPROXY_108 "},
        {"HOSTS_BEZPROXY_109 "},
        {"HOSTS_BEZPROXY_110 "},
        {"HOSTS_BEZPROXY_111 "},
        {"HOSTS_BEZPROXY_112 "},
        {"HOSTS_BEZPROXY_113 "},
        {"HOSTS_BEZPROXY_114 "},
        {"HOSTS_BEZPROXY_115 "},
        {"HOSTS_BEZPROXY_116 "},
        {"HOSTS_BEZPROXY_117 "},
        {"HOSTS_BEZPROXY_118 "},
        {"HOSTS_BEZPROXY_119 "},
        {"HOSTS_BEZPROXY_120 "},
        {"HOSTS_BEZPROXY_121 "},
        {"HOSTS_BEZPROXY_122 "},
        {"HOSTS_BEZPROXY_123 "},
																								
        {"HOSTS_DANSG_100 "},
        {"HOSTS_DANSG_101 "},
        {"HOSTS_DANSG_102 "},
        {"HOSTS_DANSG_103 "},
        {"HOSTS_DANSG_104 "},
        {"HOSTS_DANSG_105 "},
        {"HOSTS_DANSG_106 "},
        {"HOSTS_DANSG_107 "},
        {"HOSTS_DANSG_108 "},
        {"HOSTS_DANSG_109 "},
        {"HOSTS_DANSG_110 "},
        {"HOSTS_DANSG_111 "},
        {"HOSTS_DANSG_112 "},
        {"HOSTS_DANSG_113 "},
        {"HOSTS_DANSG_114 "},
        {"HOSTS_DANSG_115 "},
        {"HOSTS_DANSG_116 "},
        {"HOSTS_DANSG_117 "},
				{"HOSTS_DANSG_118 "},
        {"HOSTS_DANSG_119 "},
				{"HOSTS_DANSG_120 "},
        {"HOSTS_DANSG_121 "},
        {"HOSTS_DANSG_122 "},
        {"HOSTS_DANSG_123 "},					
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
								
												switch (ip.b2)
												{
														case 0:
																		fpnat=fps[0];
																		accept=ipsets[0];
																		drop=ipsets[24];
																		cache=ipsets[48];
																		bezcache=ipsets[72];
																		dansg=ipsets[96];
																		
																		fphfsc=fps[11];
																		iflan="$IF_LAN0";
																		break;
											
														case 1:
														    		accept=ipsets[1];
																		drop=ipsets[25];
																		cache=ipsets[49];
																		bezcache=ipsets[73];
																		dansg=ipsets[97];
																										      
																		fpnat=fps[0];
																		fphfsc=fps[11];
																		iflan="$IF_LAN0";
																		break;
														case 2:
						    										accept=ipsets[2];
														        drop=ipsets[26];
																		cache=ipsets[50];
																		bezcache=ipsets[74];
																		dansg=ipsets[98];
																		
																		classid=4;
																		fpnat=fps[0];
																		fphfsc=fps[11];
																		iflan="$IF_LAN0";
																		break;
														case 3:
						    										accept=ipsets[3];
														        drop=ipsets[27];
																		cache=ipsets[51];
																		bezcache=ipsets[75];
																		dansg=ipsets[99];

																		classid=5;
																		fpnat=fps[0];
																		fphfsc=fps[11];
																		iflan="$IF_LAN0";
																		break;
														case 4:
						    										accept=ipsets[4];
														        drop=ipsets[28];
																		cache=ipsets[52];
																		bezcache=ipsets[76];
																		dansg=ipsets[100];

																		classid=6;
																		fpnat=fps[0];
																		fphfsc=fps[11];
																		iflan="$IF_LAN0";
																		break;
														case 5:
						    										accept=ipsets[5];
														        drop=ipsets[29];
																		cache=ipsets[53];
																		bezcache=ipsets[77];
																		dansg=ipsets[101];

																		classid=7;
																		fpnat=fps[0];
																		fphfsc=fps[11];
																		iflan="$IF_LAN0";
																		break;
														case 6:
						    										accept=ipsets[6];
														        drop=ipsets[30];
																		cache=ipsets[54];
																		bezcache=ipsets[78];
																		dansg=ipsets[102];

																		classid=8;
																		fpnat=fps[0];
																		fphfsc=fps[11];
																		iflan="$IF_LAN0";
																		break;
														case 7:
						    										accept=ipsets[7];
														        drop=ipsets[31];
																		cache=ipsets[55];
																		bezcache=ipsets[79];
																		dansg=ipsets[103];

																		classid=9;
																		fpnat=fps[0];
																		fphfsc=fps[11];
																		iflan="$IF_LAN0";
																		break;
														case 8:
						    										accept=ipsets[8];
														        drop=ipsets[32];
																		cache=ipsets[56];
																		bezcache=ipsets[80];
																		dansg=ipsets[104];

																		classid=10;
																		fpnat=fps[8];
																		fphfsc=fps[19];
																		iflan="$IF_LAN8";
																		break;
														case 9:
						    										accept=ipsets[9];
														        drop=ipsets[33];
																		cache=ipsets[57];
																		bezcache=ipsets[81];
																		dansg=ipsets[105];

																		classid=10;
																		fpnat=fps[8];
																		fphfsc=fps[19];
																		iflan="$IF_LAN8";
																		break;
														case 10:
						    										accept=ipsets[10];
														        drop=ipsets[34];
																		cache=ipsets[58];
																		bezcache=ipsets[82];
																		dansg=ipsets[106];

																		classid=10;
																		fpnat=fps[8];
																		fphfsc=fps[19];
																		iflan="$IF_LAN8";
																		break;
														case 11:
						    										accept=ipsets[11];
														        drop=ipsets[35];
																		cache=ipsets[59];
																		bezcache=ipsets[83];
																		dansg=ipsets[107];

																		classid=10;
																		fpnat=fps[8];
																		fphfsc=fps[19];
																		iflan="$IF_LAN8";
																		break;
														case 12:
						    										accept=ipsets[12];
														        drop=ipsets[36];
																		cache=ipsets[60];
																		bezcache=ipsets[84];
																		dansg=ipsets[108];

																		classid=10;
																		fpnat=fps[8];
																		fphfsc=fps[19];
																		iflan="$IF_LAN8";
																		break;
														case 13:
						    										accept=ipsets[13];
														        drop=ipsets[37];
																		cache=ipsets[61];
																		bezcache=ipsets[85];
																		dansg=ipsets[109];

																		classid=10;
																		fpnat=fps[8];
																		fphfsc=fps[19];
																		iflan="$IF_LAN8";
																		break;
														case 14:
						    										accept=ipsets[14];
														        drop=ipsets[38];
																		cache=ipsets[62];
																		bezcache=ipsets[86];
																		dansg=ipsets[110];

																		classid=10;
																		fpnat=fps[8];
																		fphfsc=fps[19];
																		iflan="$IF_LAN8";
																		break;
														case 15:
														
						    										accept=ipsets[15];
														        drop=ipsets[39];
																		cache=ipsets[63];
																		bezcache=ipsets[87];
																		dansg=ipsets[111];

																		classid=10;
																		fpnat=fps[8];
																		fphfsc=fps[19];
																		iflan="$IF_LAN8";
																		break;

													case 16:
						    										accept=ipsets[16];
														        drop=ipsets[40];
																		cache=ipsets[64];
																		bezcache=ipsets[88];
																		dansg=ipsets[112];

																		classid=11;
																		fpnat=fps[9];
																		fphfsc=fps[20];
																		iflan="$IF_LAN16";
																		break;
														case 17:
						    										accept=ipsets[17];
														        drop=ipsets[41];
																		cache=ipsets[65];
																		bezcache=ipsets[89];
																		dansg=ipsets[113];

																		classid=11;
																		fpnat=fps[9];
																		fphfsc=fps[20];
																		iflan="$IF_LAN16";
																		break;
														case 18:
						    										accept=ipsets[18];
														        drop=ipsets[42];
																		cache=ipsets[66];
																		bezcache=ipsets[90];
																		dansg=ipsets[114];

																		classid=11;
																		fpnat=fps[9];
																		fphfsc=fps[20];
																		iflan="$IF_LAN16";
																		break;
														case 19:
						    										accept=ipsets[19];
														        drop=ipsets[43];
																		cache=ipsets[67];
																		bezcache=ipsets[91];
																		dansg=ipsets[115];

																		classid=11;
																		fpnat=fps[9];
																		fphfsc=fps[20];
																		iflan="$IF_LAN16";
																		break;
														case 20:
						    										accept=ipsets[20];
														        drop=ipsets[44];
																		cache=ipsets[68];
																		bezcache=ipsets[92];
																		dansg=ipsets[116];

																		classid=11;
																		fpnat=fps[9];
																		fphfsc=fps[20];
																		iflan="$IF_LAN16";
																		break;
														case 21:
						    										accept=ipsets[21];
														        drop=ipsets[45];
																		cache=ipsets[69];
																		bezcache=ipsets[93];
																		dansg=ipsets[117];

																		classid=11;
																		fpnat=fps[9];
																		fphfsc=fps[20];
																		iflan="$IF_LAN16";
																		break;
														case 22:
						    										accept=ipsets[22];
														        drop=ipsets[46];
																		cache=ipsets[70];
																		bezcache=ipsets[94];
																		dansg=ipsets[118];

																		classid=11;
																		fpnat=fps[9];
																		fphfsc=fps[20];
																		iflan="$IF_LAN16";
																		break;
												}

															
												fprintf(fpnat,  "#---- %s ----------------------------------------------------------------------------------------------------------------------------------------# \n", komp.host);
																							
												if ( ip.b2 != oldbajt )
														if (  ip.b2 == 8  ||  ip.b2 == 16   )
															{
																oldbajt=ip.b2;
																fprintf ( fps[32], "} \n"  );
																dhcp_head2(ip.b2, fps[32], ip.b1);
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
														else 
																	bezproxy(komp.ip, mac_source, fpnat, bezcache);
													}								
													
													else if ( strcmp(komp.net, "N") == 0  && ip.b1 != BAJT_CORE )
														wylacz_net( komp.ip, mac_source, fpnat, drop);
											
													if ( strcmp(komp.info,"Y") == 0  && ip.b1 != BAJT_CORE )
														info (komp.ip, komp.host, fps[36], fps[37]);
														
											}
									else if ( strcmp(arg, ARG1)==0 ) 
											{
												if ( ip.b2 != oldbajt )
														if ( ip.b2 < 8  ||  ip.b2 == 8  ||  ip.b2 == 16  ||  ip.b1 == BAJT_CORE )
															{
																oldbajt=ip.b2;
																fprintf ( fps[32], "} \n"  );
																dhcp_head2(ip.b2, fps[32], ip.b1);
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


