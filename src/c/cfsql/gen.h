#ifndef GEN_H
#define GEN_H



enum tn {Y, y, N, n};

typedef char *str;

typedef struct
{
    char *host;
    char *mac;
    char *ip;
    char *ip_zewn;
    char *download;
    char *upload;
    char *download_max;
    char *download_p2p;
    char *download_noc;
    char *upload_noc;

    char *dhcp;
    char *powiaz;
    char *net;
    char *proxy;
    char *dg;
    char *info;
} Comp;

typedef struct
{
    char host[50];
    char mac[50];
    char ip[50];
    char ip_zewn[50];
    char net_speed[50];
    char lan_speed[50];

    char dhcp[50];
    char powiaz[50];
    char net[50];
    char proxy[50];
    char dg[50];
    char info[50];
} Komputer;

typedef struct
{
    int b1;
		int b2;
		int b3;
		int b4;
} Ip;

//void gen (char[]);
//void hfsc_head (str, FILE *);




#endif
