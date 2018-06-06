#ifndef CONF_H
#define CONF_H

#define DBHOST		"localhost"
#define DBPORT		"5432"
#define DBNAME		"szmsk"
#define DBUSER		"szmsk"
#define DBPASSWD	"szmsk"

#define ARG1						"dhcp"
#define ARG2						"hfsc"
#define ARG3						"nat"

#define DNS1						"172.16.0.1"
#define DNS2 						"8.8.8.8"
#define DNS3 						"91.206.65.73"

#define DOMAIN1					"netico.pl"

#define IP_LAN  				"10.0.0.0/8"
#define IP_LAN0				  "172.16.0.1"
#define IP_INET1			"91.216.213.1"
#define IP_INET1_0			"91.216.213.2"
#define IP_INET1_1			"83.19.61.52"
#define IP_INET1_2			"83.19.61.53"
#define IP_INET1_3			"83.19.61.54"

#define IP_INET2			"83.16.112.34"
#define IP_INET2_0			"83.16.112.35"
#define IP_INET2_1			"83.16.112.36"
#define IP_INET2_2			"83.16.112.37"
#define IP_INET2_3			"83.16.112.38"

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
#define HFSCD1					"/etc/hfsc/tmp/hfsc-down-01.sh"
#define HFSCD2					"/etc/hfsc/tmp/hfsc-down-02.sh"
#define HFSCD3					"/etc/hfsc/tmp/hfsc-down-03.sh"
#define HFSCD4					"/etc/hfsc/tmp/hfsc-down-04.sh"
#define HFSCD5					"/etc/hfsc/tmp/hfsc-down-05.sh"
#define HFSCD6					"/etc/hfsc/tmp/hfsc-down-06.sh"
#define HFSCD7					"/etc/hfsc/tmp/hfsc-down-07.sh"
#define HFSCD8					"/etc/hfsc/tmp/hfsc-down-08.sh"
#define HFSCD16					"/etc/hfsc/tmp/hfsc-down-16.sh"
#define HFSCD24					"/etc/hfsc/tmp/hfsc-down-24.sh"
#define HFSCD32					"/etc/hfsc/tmp/hfsc-down-32.sh"

#define HFSCD1N					"/etc/hfsc/hfsc.down1n.sh"
#define HFSCD2N					"/etc/hfsc/hfsc.down2n.sh"
#define HFSCD3N					"/etc/hfsc/hfsc.down3n.sh"
#define HFSCD4N					"/etc/hfsc/hfsc.down4n.sh"
#define HFSCD5N					"/etc/hfsc/hfsc.down5n.sh"

#define HFSCU0					"/etc/hfsc/hfsc-up-00.sh"
#define HFSCU1					"/etc/hfsc/tmp/hfsc-up-01.sh"
#define HFSCU2					"/etc/hfsc/tmp/hfsc-up-02.sh"
#define HFSCU3					"/etc/hfsc/tmp/hfsc-up-03.sh"
#define HFSCU4					"/etc/hfsc/tmp/hfsc-up-04.sh"
#define HFSCU5					"/etc/hfsc/tmp/hfsc-up-05.sh"
#define HFSCU6					"/etc/hfsc/tmp/hfsc-up-06.sh"
#define HFSCU7					"/etc/hfsc/tmp/hfsc-up-07.sh"

#define HFSCUN					"/etc/hfsc/hfsc-up_n.sh"



#define DANS						"/etc/nat/conf/dansguardian/exceptioniplist"
#define ITF		  				"/etc/nat/sh/itf-users.sh"
#define INFO						"/etc/nat/sh/info.sh"
#define INFO_OFF	  		"/etc/nat/sh/info_off.sh"
#define ACTIVE					"/tmp/active"

#define BAJT_CORE			172
#define BAJT_PUBL                       178

#define BAJT_WLAN1			8
#define BAJT_WLAN2			16
#define BAJT_WLAN3			24
#define BAJT_WLAN4			32
#define PIOCHNET_BAJT		22

#define D_LEASE_TIME 		86400
#define MAX_LEASE_TIME 	86400

#endif
