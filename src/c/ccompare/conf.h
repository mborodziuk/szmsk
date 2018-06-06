#ifndef CONF_H
#define CONF_H

#define DBHOST		"localhost"
#define DBPORT		"5432"
#define DBNAME		"szmsk"
#define DBUSER		"szmsk"
#define DBPASSWD	"szmsk"
#define DBCON			"host=91.216.213.6 port=5432 dbname=szmsk user=szmsk password=szmsk";

#define ABONLENGTH			8

#define LANSPEED				"80" //Mbit

#define ARG1						"dhcp"
#define ARG2						"hfsc"
#define ARG3						"nat"

#define DNS1						"91.216.213.2"
#define DNS2 						"8.8.8.8"
#define DNS3 						"172.16.0.1"

#define DOMAIN1					"netico.pl"

#define IP_LAN  				"10.0.0.0/8"
#define IP_LAN0				  "172.16.0.1"
#define IP_LAN1				  "172.16.8.1"
#define IP_LAN2				  "172.16.16.1"
#define IP_LAN3				  "172.16.24.1"
#define IP_LAN4				  "172.16.32.254"
#define IP_LAN5				  "172.16.40.1"
#define IP_LAN6				  "172.16.48.1"
#define IP_LAN7				  "172.16.56.1"
#define IP_LAN8                           "172.16.7.254"
#define IP_LAN9                           "172.16.7.253"
#define IP_LAN10                          "172.16.39.254"
#define IP_LAN11                          "172.16.39.253"

#define IP_INET0				"91.216.213.1"
#define IP_INET1				"91.216.213.2"


#define IP_NAT 					"$IP_NAT"

#define NAT0						"/etc/nat/sh/nat-lan-00.sh"
#define NAT1						"/etc/nat/sh/nat-lan-01.sh"
#define NAT2						"/etc/nat/sh/nat-lan-02.sh"
#define NAT3						"/etc/nat/sh/nat-lan-03.sh"
#define NAT4						"/etc/nat/sh/nat-lan-04.sh"
#define NAT5						"/etc/nat/sh/nat-lan-05.sh"
#define NAT6						"/etc/nat/sh/nat-lan-06.sh"
#define NAT7						"/etc/nat/sh/nat-lan-07.sh"
#define NAT8						"/etc/nat/sh/nat-lan-08.sh"
#define NAT16						"/etc/nat/sh/nat-lan-16.sh"
#define NAT24						"/etc/nat/sh/nat-lan-24.sh"
#define NAT32						"/etc/nat/sh/nat-lan-32.sh"

#define CNT							"/etc/nat/sh/counter.sh"
#define DHCP						"/etc/dhcpd.conf"
#define HOSTS						"/etc/hosts"

#define HFSCD0					"/etc/hfsc/hfsc-down-00.sh"
#define HFSCD1					"/etc/hfsc/hfsc-down-01.sh"
#define HFSCD2					"/etc/hfsc/hfsc-down-02.sh"
#define HFSCD3					"/etc/hfsc/hfsc-down-03.sh"
#define HFSCD4					"/etc/hfsc/hfsc-down-04.sh"
#define HFSCD5					"/etc/hfsc/hfsc-down-05.sh"
#define HFSCD6					"/etc/hfsc/hfsc-down-06.sh"
#define HFSCD7					"/etc/hfsc/hfsc-down-07.sh"
#define HFSCD8					"/etc/hfsc/tmp/hfsc-down-08.sh"
#define HFSCD16					"/etc/hfsc/tmp/hfsc-down-16.sh"
#define HFSCD24					"/etc/hfsc/tmp/hfsc-down-24.sh"
#define HFSCD32					"/etc/hfsc/tmp/hfsc-down-32.sh"

#define HFSCU0					"/etc/hfsc/hfsc-up-00.sh"
#define HFSCU1					"/etc/hfsc/hfsc-up-01.sh"
#define HFSCU2					"/etc/hfsc/hfsc-up-02.sh"
#define HFSCU3					"/etc/hfsc/hfsc-up-03.sh"
#define HFSCU4					"/etc/hfsc/hfsc-up-04.sh"
#define HFSCU5					"/etc/hfsc/hfsc-up-05.sh"
#define HFSCU6					"/etc/hfsc/hfsc-up-06.sh"
#define HFSCU7					"/etc/hfsc/hfsc-up-07.sh"

#define HFSCD0N					"/etc/hfsc/hfsc-down-00n.sh"
#define HFSCD1N					"/etc/hfsc/hfsc-down-01n.sh"
#define HFSCD2N					"/etc/hfsc/hfsc-down-02n.sh"
#define HFSCD3N					"/etc/hfsc/hfsc-down-03n.sh"
#define HFSCD4N					"/etc/hfsc/hfsc-down-04n.sh"
#define HFSCD5N					"/etc/hfsc/hfsc-down-05n.sh"
#define HFSCD6N					"/etc/hfsc/hfsc-down-06n.sh"
#define HFSCD7N					"/etc/hfsc/hfsc-down-07n.sh"

#define HFSCU0N					"/etc/hfsc/hfsc-up-00n.sh"
#define HFSCU1N					"/etc/hfsc/hfsc-up-01n.sh"
#define HFSCU2N					"/etc/hfsc/hfsc-up-02n.sh"
#define HFSCU3N					"/etc/hfsc/hfsc-up-03n.sh"
#define HFSCU4N					"/etc/hfsc/hfsc-up-04n.sh"
#define HFSCU5N					"/etc/hfsc/hfsc-up-05n.sh"
#define HFSCU6N					"/etc/hfsc/hfsc-up-06n.sh"
#define HFSCU7N					"/etc/hfsc/hfsc-up-07n.sh"

#define DANS						"/etc/nat/conf/dansguardian/exceptioniplist"
#define ITF		  				"/etc/nat/sh/itf-users.sh"
#define INFO						"/etc/nat/sh/info.sh"
#define INFO_OFF	  		"/etc/nat/sh/info_off.sh"
#define ACTIVE					"/tmp/active"

#define BAJT_CORE				172
#define BAJT_PUBL       178

#define BAJT_MYSLOWICE	8
#define BAJT_OSWIECIM		9

#define BAJT_WLAN2			16
#define BAJT_WLAN3			24
#define BAJT_WLAN4			32
#define PIOCHNET_BAJT		22

#define D_LEASE_TIME 		86400
#define MAX_LEASE_TIME 	86400

#endif
