#!/bin/bash 
source /etc/conf 
#---- e_w³odarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:10:a7:0e:9c:c1 -s 10.0.2.1 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:10:a7:0e:9c:c1 -s 10.0.2.1 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:10:a7:0e:9c:c1 -s 10.0.2.1 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:10:a7:0e:9c:c1 -s 10.0.2.1 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_frelas ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:04:61:00:50:ba -s 10.0.2.10 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:04:61:00:50:ba -s 10.0.2.10 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:04:61:00:50:ba -s 10.0.2.10 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:04:61:00:50:ba -s 10.0.2.10 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#----  ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:60:52:0b:0e:ec -s 10.0.2.11 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:60:52:0b:0e:ec -s 10.0.2.11 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:60:52:0b:0e:ec -s 10.0.2.11 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:60:52:0b:0e:ec -s 10.0.2.11 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_ku³aga ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:05:1c:1e:ee:57 -s 10.0.2.12 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:05:1c:1e:ee:57 -s 10.0.2.12 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:05:1c:1e:ee:57 -s 10.0.2.12 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:05:1c:1e:ee:57 -s 10.0.2.12 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- £_kozikowski ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:08:a1:75:7a:8e -s 10.0.2.13 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:08:a1:75:7a:8e -s 10.0.2.13 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:08:a1:75:7a:8e -s 10.0.2.13 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:08:a1:75:7a:8e -s 10.0.2.13 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- d_wrona ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:7d:a3:fd:c4 -s 10.0.2.14 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:7d:a3:fd:c4 -s 10.0.2.14 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:7d:a3:fd:c4 -s 10.0.2.14 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:7d:a3:fd:c4 -s 10.0.2.14 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_czech ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:50:ba:32:ff:ed -s 10.0.2.15 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:50:ba:32:ff:ed -s 10.0.2.15 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:ba:32:ff:ed -s 10.0.2.15 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:ba:32:ff:ed -s 10.0.2.15 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- e_pabjan ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4d:09:50:dc -s 10.0.2.16 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4d:09:50:dc -s 10.0.2.16 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4d:09:50:dc -s 10.0.2.16 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4d:09:50:dc -s 10.0.2.16 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- r_rotkegel ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0a:cd:09:67:c0 -s 10.0.2.17 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0a:cd:09:67:c0 -s 10.0.2.17 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0a:cd:09:67:c0 -s 10.0.2.17 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0a:cd:09:67:c0 -s 10.0.2.17 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- j_dytko ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:10:a7:11:fa:3e -s 10.0.2.18 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:10:a7:11:fa:3e -s 10.0.2.18 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:10:a7:11:fa:3e -s 10.0.2.18 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:10:a7:11:fa:3e -s 10.0.2.18 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_tomaszewski ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:50:fc:31:d8:e0 -s 10.0.2.19 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:50:fc:31:d8:e0 -s 10.0.2.19 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:fc:31:d8:e0 -s 10.0.2.19 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:fc:31:d8:e0 -s 10.0.2.19 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_stefanowicz ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:10:a7:11:ff:99 -s 10.0.2.2 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:10:a7:11:ff:99 -s 10.0.2.2 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:10:a7:11:ff:99 -s 10.0.2.2 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:10:a7:11:ff:99 -s 10.0.2.2 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- l_sipaj³o ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:7d:b8:b2:4a -s 10.0.2.20 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:7d:b8:b2:4a -s 10.0.2.20 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:7d:b8:b2:4a -s 10.0.2.20 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:7d:b8:b2:4a -s 10.0.2.20 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- f_rudzki ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0f:ea:72:36:39 -s 10.0.2.21 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0f:ea:72:36:39 -s 10.0.2.21 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0f:ea:72:36:39 -s 10.0.2.21 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0f:ea:72:36:39 -s 10.0.2.21 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- p_£ojek ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:50:bf:ff:67:ff -s 10.0.2.22 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:50:bf:ff:67:ff -s 10.0.2.22 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:bf:ff:67:ff -s 10.0.2.22 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:bf:ff:67:ff -s 10.0.2.22 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_¦l±zak ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:50:bf:45:56:29 -s 10.0.2.23 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:50:bf:45:56:29 -s 10.0.2.23 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:bf:45:56:29 -s 10.0.2.23 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:bf:45:56:29 -s 10.0.2.23 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_chrostek ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 4c:00:10:e0:f3:7f -s 10.0.2.24 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 4c:00:10:e0:f3:7f -s 10.0.2.24 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 4c:00:10:e0:f3:7f -s 10.0.2.24 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 4c:00:10:e0:f3:7f -s 10.0.2.24 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- s_mzyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:04:61:53:a5:21 -s 10.0.2.25 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:04:61:53:a5:21 -s 10.0.2.25 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:04:61:53:a5:21 -s 10.0.2.25 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:04:61:53:a5:21 -s 10.0.2.25 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- e_pluta ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4d:04:6f:de -s 10.0.2.26 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4d:04:6f:de -s 10.0.2.26 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4d:04:6f:de -s 10.0.2.26 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4d:04:6f:de -s 10.0.2.26 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- j_lelonek ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4d:20:54:40 -s 10.0.2.27 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4d:20:54:40 -s 10.0.2.27 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4d:20:54:40 -s 10.0.2.27 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4d:20:54:40 -s 10.0.2.27 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- j_pawêzowska ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:30:4f:37:43:27 -s 10.0.2.28 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:30:4f:37:43:27 -s 10.0.2.28 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:30:4f:37:43:27 -s 10.0.2.28 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:30:4f:37:43:27 -s 10.0.2.28 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- d_dytko ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:7d:c8:59:ac -s 10.0.2.3 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:7d:c8:59:ac -s 10.0.2.3 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:7d:c8:59:ac -s 10.0.2.3 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:7d:c8:59:ac -s 10.0.2.3 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_kikas ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:20:18:28:b5:ce -s 10.0.2.30 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:20:18:28:b5:ce -s 10.0.2.30 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:20:18:28:b5:ce -s 10.0.2.30 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:20:18:28:b5:ce -s 10.0.2.30 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- k_wojciechowska ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:04:61:7e:60:bc -s 10.0.2.31 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:04:61:7e:60:bc -s 10.0.2.31 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:04:61:7e:60:bc -s 10.0.2.31 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:04:61:7e:60:bc -s 10.0.2.31 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- k_wojciechowska ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:04:61:7e:60:ba -s 10.0.2.32 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:04:61:7e:60:ba -s 10.0.2.32 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:04:61:7e:60:ba -s 10.0.2.32 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:04:61:7e:60:ba -s 10.0.2.32 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- r_czaja ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:7d:97:8a:29 -s 10.0.2.33 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:7d:97:8a:29 -s 10.0.2.33 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:7d:97:8a:29 -s 10.0.2.33 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:7d:97:8a:29 -s 10.0.2.33 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- p_dytko ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 4c:00:10:e0:b2:70 -s 10.0.2.4 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 4c:00:10:e0:b2:70 -s 10.0.2.4 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 4c:00:10:e0:b2:70 -s 10.0.2.4 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 4c:00:10:e0:b2:70 -s 10.0.2.4 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- £_krakowiak ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:10:a7:12:02:ce -s 10.0.2.5 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:10:a7:12:02:ce -s 10.0.2.5 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:10:a7:12:02:ce -s 10.0.2.5 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:10:a7:12:02:ce -s 10.0.2.5 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:08:54:09:d2:ca -s 10.0.2.6 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:08:54:09:d2:ca -s 10.0.2.6 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:08:54:09:d2:ca -s 10.0.2.6 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:08:54:09:d2:ca -s 10.0.2.6 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- l_siedlaczek ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:30:4f:23:af:ae -s 10.0.26.1 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:30:4f:23:af:ae -s 10.0.26.1 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:30:4f:23:af:ae -s 10.0.26.1 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:30:4f:23:af:ae -s 10.0.26.1 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- w_pilarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:a1:b0:08:92:19 -s 10.0.26.10 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:a1:b0:08:92:19 -s 10.0.26.10 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:a1:b0:08:92:19 -s 10.0.26.10 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:a1:b0:08:92:19 -s 10.0.26.10 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- r_waleczek ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:05:1c:10:57:c2 -s 10.0.26.12 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:05:1c:10:57:c2 -s 10.0.26.12 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:05:1c:10:57:c2 -s 10.0.26.12 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:05:1c:10:57:c2 -s 10.0.26.12 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_andrzej ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:11:2f:13:3b:81 -s 10.0.26.13 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:11:2f:13:3b:81 -s 10.0.26.13 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:11:2f:13:3b:81 -s 10.0.26.13 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:11:2f:13:3b:81 -s 10.0.26.13 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- d_pustolka ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:75:95:07:e4:1f -s 10.0.26.14 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:75:95:07:e4:1f -s 10.0.26.14 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:75:95:07:e4:1f -s 10.0.26.14 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:75:95:07:e4:1f -s 10.0.26.14 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- r_wilczewski ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:11:20:69 -s 10.0.26.15 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:11:20:69 -s 10.0.26.15 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:11:20:69 -s 10.0.26.15 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:11:20:69 -s 10.0.26.15 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- p_holik ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:c0:df:11:92:fe -s 10.0.26.16 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:c0:df:11:92:fe -s 10.0.26.16 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c0:df:11:92:fe -s 10.0.26.16 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c0:df:11:92:fe -s 10.0.26.16 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- £_nied¼wied¼ ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0b:6a:81:1a:28 -s 10.0.26.17 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0b:6a:81:1a:28 -s 10.0.26.17 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:6a:81:1a:28 -s 10.0.26.17 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:6a:81:1a:28 -s 10.0.26.17 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_burdach ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:50:bf:34:a0:ad -s 10.0.26.2 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:50:bf:34:a0:ad -s 10.0.26.2 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:bf:34:a0:ad -s 10.0.26.2 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:bf:34:a0:ad -s 10.0.26.2 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- e_bucka ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4d:05:c9:93 -s 10.0.26.3 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4d:05:c9:93 -s 10.0.26.3 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4d:05:c9:93 -s 10.0.26.3 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4d:05:c9:93 -s 10.0.26.3 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_lipiñska ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:b2:48:c7 -s 10.0.26.4 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:b2:48:c7 -s 10.0.26.4 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:b2:48:c7 -s 10.0.26.4 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:b2:48:c7 -s 10.0.26.4 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_bielski ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0b:2b:04:25:f8 -s 10.0.26.5 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0b:2b:04:25:f8 -s 10.0.26.5 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:04:25:f8 -s 10.0.26.5 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:04:25:f8 -s 10.0.26.5 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- r_grzegorczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4d:07:15:44 -s 10.0.26.6 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4d:07:15:44 -s 10.0.26.6 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4d:07:15:44 -s 10.0.26.6 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4d:07:15:44 -s 10.0.26.6 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_k³os ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:50:04:e8:d5:1c -s 10.0.26.7 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:50:04:e8:d5:1c -s 10.0.26.7 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:04:e8:d5:1c -s 10.0.26.7 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:04:e8:d5:1c -s 10.0.26.7 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_pomietlak ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:a1:b0:08:a2:53 -s 10.0.26.8 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:a1:b0:08:a2:53 -s 10.0.26.8 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:a1:b0:08:a2:53 -s 10.0.26.8 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:a1:b0:08:a2:53 -s 10.0.26.8 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- s_adamska ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:a1:b0:08:b5:39 -s 10.0.26.9 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:a1:b0:08:b5:39 -s 10.0.26.9 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:a1:b0:08:b5:39 -s 10.0.26.9 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:a1:b0:08:b5:39 -s 10.0.26.9 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- t_grodzki ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0e:a6:18:cd:34 -s 10.0.2.7 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0e:a6:18:cd:34 -s 10.0.2.7 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0e:a6:18:cd:34 -s 10.0.2.7 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0e:a6:18:cd:34 -s 10.0.2.7 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- p_jaromin ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:50:fc:31:db:03 -s 10.0.2.8 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:50:fc:31:db:03 -s 10.0.2.8 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:fc:31:db:03 -s 10.0.2.8 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:fc:31:db:03 -s 10.0.2.8 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- £_kurpanik ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:C1:26:0F:86:B7 -s 10.0.28.1 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:C1:26:0F:86:B7 -s 10.0.28.1 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:C1:26:0F:86:B7 -s 10.0.28.1 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:C1:26:0F:86:B7 -s 10.0.28.1 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- j_flasza ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:80:48:1d:1e:78 -s 10.0.28.10 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:80:48:1d:1e:78 -s 10.0.28.10 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:80:48:1d:1e:78 -s 10.0.28.10 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:80:48:1d:1e:78 -s 10.0.28.10 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- b_rohr ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 72:0a:e6:4a:71:e9 -s 10.0.28.11 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 72:0a:e6:4a:71:e9 -s 10.0.28.11 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 72:0a:e6:4a:71:e9 -s 10.0.28.11 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 72:0a:e6:4a:71:e9 -s 10.0.28.11 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- £_kurpanik ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0d:87:44:94:ea -s 10.0.28.2 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0d:87:44:94:ea -s 10.0.28.2 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0d:87:44:94:ea -s 10.0.28.2 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0d:87:44:94:ea -s 10.0.28.2 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_kryta ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:10:a7:11:fb:ad -s 10.0.28.3 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:10:a7:11:fb:ad -s 10.0.28.3 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:10:a7:11:fb:ad -s 10.0.28.3 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:10:a7:11:fb:ad -s 10.0.28.3 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- j_bienek ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0b:2b:0a:bf:6f -s 10.0.28.4 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0b:2b:0a:bf:6f -s 10.0.28.4 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:0a:bf:6f -s 10.0.28.4 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:0a:bf:6f -s 10.0.28.4 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- j_mierny ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:01:1c:02:13:e1 -s 10.0.28.5 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:01:1c:02:13:e1 -s 10.0.28.5 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:01:1c:02:13:e1 -s 10.0.28.5 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:01:1c:02:13:e1 -s 10.0.28.5 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- g_nowak ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:50:fc:31:db:04 -s 10.0.28.6 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:50:fc:31:db:04 -s 10.0.28.6 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:fc:31:db:04 -s 10.0.28.6 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:fc:31:db:04 -s 10.0.28.6 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- i_terka ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0b:2b:0a:96:e0 -s 10.0.28.7 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0b:2b:0a:96:e0 -s 10.0.28.7 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:0a:96:e0 -s 10.0.28.7 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:0a:96:e0 -s 10.0.28.7 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- i_terka ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:02:2a:b2:20:28 -s 10.0.28.8 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:02:2a:b2:20:28 -s 10.0.28.8 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:02:2a:b2:20:28 -s 10.0.28.8 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:02:2a:b2:20:28 -s 10.0.28.8 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_smuda ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:00:e8:ef:2d:76 -s 10.0.28.9 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:00:e8:ef:2d:76 -s 10.0.28.9 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:00:e8:ef:2d:76 -s 10.0.28.9 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:00:e8:ef:2d:76 -s 10.0.28.9 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_borodziuk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT -s 10.0.3.1 -j ACCEPT 
$IPTABLES -A FORWARD -s 10.0.3.1 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:e9:e3:35 -s 10.0.3.1 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:e9:e3:35 -s 10.0.3.1 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- g_pucha³a ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:04:4b:80:80:03 -s 10.0.3.10 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:04:4b:80:80:03 -s 10.0.3.10 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:04:4b:80:80:03 -s 10.0.3.10 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:04:4b:80:80:03 -s 10.0.3.10 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- b_witczak ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:c1:26:0f:80:a9 -s 10.0.3.11 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:c1:26:0f:80:a9 -s 10.0.3.11 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c1:26:0f:80:a9 -s 10.0.3.11 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c1:26:0f:80:a9 -s 10.0.3.11 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- e_czech ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0b:6a:4f:81:1b -s 10.0.3.12 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0b:6a:4f:81:1b -s 10.0.3.12 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:6a:4f:81:1b -s 10.0.3.12 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:6a:4f:81:1b -s 10.0.3.12 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_hajduk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:c0:df:05:b4:d1 -s 10.0.3.13 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:c0:df:05:b4:d1 -s 10.0.3.13 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c0:df:05:b4:d1 -s 10.0.3.13 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c0:df:05:b4:d1 -s 10.0.3.13 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_martowicz ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:c1:26:0f:76:a5 -s 10.0.3.14 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:c1:26:0f:76:a5 -s 10.0.3.14 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c1:26:0f:76:a5 -s 10.0.3.14 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c1:26:0f:76:a5 -s 10.0.3.14 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_szyroki ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0b:2b:01:8a:87 -s 10.0.3.15 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0b:2b:01:8a:87 -s 10.0.3.15 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:01:8a:87 -s 10.0.3.15 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:01:8a:87 -s 10.0.3.15 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_jarosz ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:11:2F:B9:3B:E7 -s 10.0.3.16 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:11:2F:B9:3B:E7 -s 10.0.3.16 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:11:2F:B9:3B:E7 -s 10.0.3.16 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:11:2F:B9:3B:E7 -s 10.0.3.16 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- d_rusek ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0b:2b:14:e0:6f -s 10.0.3.17 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0b:2b:14:e0:6f -s 10.0.3.17 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:14:e0:6f -s 10.0.3.17 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:14:e0:6f -s 10.0.3.17 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- d_kozio³ ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:18:e8:e5:c9 -s 10.0.3.18 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:18:e8:e5:c9 -s 10.0.3.18 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:18:e8:e5:c9 -s 10.0.3.18 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:18:e8:e5:c9 -s 10.0.3.18 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- w_kusiak ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:50:ba:31:01:1c -s 10.0.3.19 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:50:ba:31:01:1c -s 10.0.3.19 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:ba:31:01:1c -s 10.0.3.19 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:ba:31:01:1c -s 10.0.3.19 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_borodziuk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0e:7f:6f:82:4a -s 10.0.3.2 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0e:7f:6f:82:4a -s 10.0.3.2 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0e:7f:6f:82:4a -s 10.0.3.2 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0e:7f:6f:82:4a -s 10.0.3.2 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- h_flasz ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:c1:26:0f:7f:a4 -s 10.0.3.20 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:c1:26:0f:7f:a4 -s 10.0.3.20 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c1:26:0f:7f:a4 -s 10.0.3.20 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c1:26:0f:7f:a4 -s 10.0.3.20 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- d_s³owjew ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:8e:a2:1d -s 10.0.3.21 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:8e:a2:1d -s 10.0.3.21 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:8e:a2:1d -s 10.0.3.21 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:8e:a2:1d -s 10.0.3.21 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_piecha ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0a:cd:00:9b:7d -s 10.0.3.22 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0a:cd:00:9b:7d -s 10.0.3.22 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0a:cd:00:9b:7d -s 10.0.3.22 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0a:cd:00:9b:7d -s 10.0.3.22 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- h_flasz ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:10:a7:0e:78:67 -s 10.0.3.23 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:10:a7:0e:78:67 -s 10.0.3.23 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:10:a7:0e:78:67 -s 10.0.3.23 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:10:a7:0e:78:67 -s 10.0.3.23 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_borodziuk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:50:8b:ab:f6:f4 -s 10.0.3.3 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:50:8b:ab:f6:f4 -s 10.0.3.3 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:8b:ab:f6:f4 -s 10.0.3.3 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:8b:ab:f6:f4 -s 10.0.3.3 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- REMONT-BUD Ryszard Tabak ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:30:4f:27:c6:6e -s 10.0.3.4 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:30:4f:27:c6:6e -s 10.0.3.4 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:30:4f:27:c6:6e -s 10.0.3.4 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:30:4f:27:c6:6e -s 10.0.3.4 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- k_banarska ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:c0:df:05:b4:e7 -s 10.0.3.5 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:c0:df:05:b4:e7 -s 10.0.3.5 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c0:df:05:b4:e7 -s 10.0.3.5 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c0:df:05:b4:e7 -s 10.0.3.5 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- s_iwona ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:01:f8:0a -s 10.0.3.8 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:01:f8:0a -s 10.0.3.8 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:01:f8:0a -s 10.0.3.8 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:01:f8:0a -s 10.0.3.8 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_w±sik ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:10:a7:20:1f:32 -s 10.0.5.1 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:10:a7:20:1f:32 -s 10.0.5.1 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:10:a7:20:1f:32 -s 10.0.5.1 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:10:a7:20:1f:32 -s 10.0.5.1 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_szweda ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:11:15:d3 -s 10.0.5.10 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:11:15:d3 -s 10.0.5.10 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:11:15:d3 -s 10.0.5.10 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:11:15:d3 -s 10.0.5.10 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- p_niedba³a ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:01:ef:93 -s 10.0.5.11 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:01:ef:93 -s 10.0.5.11 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:01:ef:93 -s 10.0.5.11 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:01:ef:93 -s 10.0.5.11 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- g_nec ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:30:4f:2d:b7:b3 -s 10.0.5.12 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:30:4f:2d:b7:b3 -s 10.0.5.12 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:30:4f:2d:b7:b3 -s 10.0.5.12 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:30:4f:2d:b7:b3 -s 10.0.5.12 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:50:bf:56:cf:60 -s 10.0.5.13 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:50:bf:56:cf:60 -s 10.0.5.13 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:bf:56:cf:60 -s 10.0.5.13 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:bf:56:cf:60 -s 10.0.5.13 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- r_probierz ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0b:6a:50:45:da -s 10.0.5.14 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0b:6a:50:45:da -s 10.0.5.14 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:6a:50:45:da -s 10.0.5.14 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:6a:50:45:da -s 10.0.5.14 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- g_mucha ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 4c:00:10:61:0a:63 -s 10.0.5.2 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 4c:00:10:61:0a:63 -s 10.0.5.2 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 4c:00:10:61:0a:63 -s 10.0.5.2 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 4c:00:10:61:0a:63 -s 10.0.5.2 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_kwa¶niak ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:07:95:41:17:5d -s 10.0.5.3 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:07:95:41:17:5d -s 10.0.5.3 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:07:95:41:17:5d -s 10.0.5.3 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:07:95:41:17:5d -s 10.0.5.3 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- p_macek ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:8a:77:05 -s 10.0.5.4 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:8a:77:05 -s 10.0.5.4 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:8a:77:05 -s 10.0.5.4 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:8a:77:05 -s 10.0.5.4 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- b_kempka ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:c1:26:10:69:6c -s 10.0.5.5 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:c1:26:10:69:6c -s 10.0.5.5 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c1:26:10:69:6c -s 10.0.5.5 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c1:26:10:69:6c -s 10.0.5.5 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_rybicka ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:07:95:0f:b0:da -s 10.0.5.7 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:07:95:0f:b0:da -s 10.0.5.7 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:07:95:0f:b0:da -s 10.0.5.7 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:07:95:0f:b0:da -s 10.0.5.7 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- k_duraj ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4d:f3:13:56 -s 10.0.5.8 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4d:f3:13:56 -s 10.0.5.8 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4d:f3:13:56 -s 10.0.5.8 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4d:f3:13:56 -s 10.0.5.8 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- ¦_miros³awa ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:02:07:a0 -s 10.0.5.9 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:02:07:a0 -s 10.0.5.9 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:02:07:a0 -s 10.0.5.9 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:02:07:a0 -s 10.0.5.9 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- t_dawidowicz ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:d0:59:05:9f:43 -s 10.0.6.1 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:d0:59:05:9f:43 -s 10.0.6.1 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:d0:59:05:9f:43 -s 10.0.6.1 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:d0:59:05:9f:43 -s 10.0.6.1 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- j_lupa ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4d:04:b0:68 -s 10.0.6.10 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4d:04:b0:68 -s 10.0.6.10 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4d:04:b0:68 -s 10.0.6.10 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4d:04:b0:68 -s 10.0.6.10 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- s_polok ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 52:54:05:f7:83:f1 -s 10.0.6.11 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 52:54:05:f7:83:f1 -s 10.0.6.11 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 52:54:05:f7:83:f1 -s 10.0.6.11 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 52:54:05:f7:83:f1 -s 10.0.6.11 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 52:54:05:f9:31:a6 -s 10.0.6.12 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 52:54:05:f9:31:a6 -s 10.0.6.12 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 52:54:05:f9:31:a6 -s 10.0.6.12 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 52:54:05:f9:31:a6 -s 10.0.6.12 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- d_oleksiak ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0a:e6:8c:0a:ae -s 10.0.6.13 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0a:e6:8c:0a:ae -s 10.0.6.13 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0a:e6:8c:0a:ae -s 10.0.6.13 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0a:e6:8c:0a:ae -s 10.0.6.13 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- j_sowa ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 52:54:05:f9:34:a0 -s 10.0.6.14 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 52:54:05:f9:34:a0 -s 10.0.6.14 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 52:54:05:f9:34:a0 -s 10.0.6.14 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 52:54:05:f9:34:a0 -s 10.0.6.14 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- j_rubacha ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 52:54:05:f7:13:99 -s 10.0.6.15 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 52:54:05:f7:13:99 -s 10.0.6.15 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 52:54:05:f7:13:99 -s 10.0.6.15 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 52:54:05:f7:13:99 -s 10.0.6.15 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- w_piwowarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:01:02:f9:8f:5d -s 10.0.6.16 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:01:02:f9:8f:5d -s 10.0.6.16 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:01:02:f9:8f:5d -s 10.0.6.16 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:01:02:f9:8f:5d -s 10.0.6.16 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- k_zegar ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:04:61:53:93:8c -s 10.0.6.17 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:04:61:53:93:8c -s 10.0.6.17 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:04:61:53:93:8c -s 10.0.6.17 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:04:61:53:93:8c -s 10.0.6.17 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- c_szczygie³ ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:50:bf:d3:de:10 -s 10.0.6.18 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:50:bf:d3:de:10 -s 10.0.6.18 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:bf:d3:de:10 -s 10.0.6.18 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:bf:d3:de:10 -s 10.0.6.18 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- k_papuga ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 52:54:05:f4:2f:89 -s 10.0.6.19 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 52:54:05:f4:2f:89 -s 10.0.6.19 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 52:54:05:f4:2f:89 -s 10.0.6.19 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 52:54:05:f4:2f:89 -s 10.0.6.19 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- t_dawidowicz ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 52:54:05:de:23:2b -s 10.0.6.2 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 52:54:05:de:23:2b -s 10.0.6.2 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 52:54:05:de:23:2b -s 10.0.6.2 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 52:54:05:de:23:2b -s 10.0.6.2 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- e_mielczarek ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:01:f8:95 -s 10.0.6.20 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:01:f8:95 -s 10.0.6.20 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:01:f8:95 -s 10.0.6.20 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:01:f8:95 -s 10.0.6.20 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- d_bzik ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:02:44:51:c1:9a -s 10.0.6.21 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:02:44:51:c1:9a -s 10.0.6.21 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:02:44:51:c1:9a -s 10.0.6.21 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:02:44:51:c1:9a -s 10.0.6.21 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- j_walczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:01:f8:0a -s 10.0.6.22 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:01:f8:0a -s 10.0.6.22 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:01:f8:0a -s 10.0.6.22 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:01:f8:0a -s 10.0.6.22 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- n_el¿bieta ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:01:1c:02:13:d7 -s 10.0.6.23 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:01:1c:02:13:d7 -s 10.0.6.23 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:01:1c:02:13:d7 -s 10.0.6.23 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:01:1c:02:13:d7 -s 10.0.6.23 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- z_nowak ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:11:09:C0:3E:61 -s 10.0.6.24 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:11:09:C0:3E:61 -s 10.0.6.24 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:11:09:C0:3E:61 -s 10.0.6.24 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:11:09:C0:3E:61 -s 10.0.6.24 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0C:6E:AB:E8:8A -s 10.0.6.25 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0C:6E:AB:E8:8A -s 10.0.6.25 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0C:6E:AB:E8:8A -s 10.0.6.25 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0C:6E:AB:E8:8A -s 10.0.6.25 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:30:4F:29:5A:11 -s 10.0.6.26 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:30:4F:29:5A:11 -s 10.0.6.26 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:30:4F:29:5A:11 -s 10.0.6.26 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:30:4F:29:5A:11 -s 10.0.6.26 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- s_andrzej ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0b:2b:14:c9:8f -s 10.0.6.27 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0b:2b:14:c9:8f -s 10.0.6.27 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:14:c9:8f -s 10.0.6.27 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:14:c9:8f -s 10.0.6.27 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_warych ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0b:6a:8a:92:41 -s 10.0.6.28 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0b:6a:8a:92:41 -s 10.0.6.28 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:6a:8a:92:41 -s 10.0.6.28 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:6a:8a:92:41 -s 10.0.6.28 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- t_dawidowicz ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0c:6e:0f:c7:c5 -s 10.0.6.3 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0c:6e:0f:c7:c5 -s 10.0.6.3 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0c:6e:0f:c7:c5 -s 10.0.6.3 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0c:6e:0f:c7:c5 -s 10.0.6.3 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- EKO-DOM ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:A0:D2:13:45:60 -s 10.0.6.4 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:A0:D2:13:45:60 -s 10.0.6.4 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:A0:D2:13:45:60 -s 10.0.6.4 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:A0:D2:13:45:60 -s 10.0.6.4 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- g_pechta ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:11:18:7d -s 10.0.6.5 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:11:18:7d -s 10.0.6.5 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:11:18:7d -s 10.0.6.5 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:11:18:7d -s 10.0.6.5 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- w_wrona ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:50:04:3c:31:fa -s 10.0.6.6 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:50:04:3c:31:fa -s 10.0.6.6 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:04:3c:31:fa -s 10.0.6.6 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:04:3c:31:fa -s 10.0.6.6 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- p_radosz ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:04:61:78:19:e0 -s 10.0.6.7 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:04:61:78:19:e0 -s 10.0.6.7 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:04:61:78:19:e0 -s 10.0.6.7 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:04:61:78:19:e0 -s 10.0.6.7 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_golba ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0a:e6:c0:59:23 -s 10.0.6.8 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0a:e6:c0:59:23 -s 10.0.6.8 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0a:e6:c0:59:23 -s 10.0.6.8 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0a:e6:c0:59:23 -s 10.0.6.8 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- l_mularz ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:50:bf:21:f5:ff -s 10.0.6.9 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:50:bf:21:f5:ff -s 10.0.6.9 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:bf:21:f5:ff -s 10.0.6.9 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:bf:21:f5:ff -s 10.0.6.9 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_juszczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:ea:84:3a -s 10.1.14.10 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:ea:84:3a -s 10.1.14.10 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:ea:84:3a -s 10.1.14.10 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:ea:84:3a -s 10.1.14.10 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_matyjaszczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:29:0d:29:89 -s 10.1.14.11 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:29:0d:29:89 -s 10.1.14.11 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:29:0d:29:89 -s 10.1.14.11 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:29:0d:29:89 -s 10.1.14.11 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_wapiñska ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:eb:4b:f0 -s 10.1.14.12 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:eb:4b:f0 -s 10.1.14.12 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:eb:4b:f0 -s 10.1.14.12 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:eb:4b:f0 -s 10.1.14.12 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- j_ko³odziej ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:04:75:ef:3f:f5 -s 10.1.14.13 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:04:75:ef:3f:f5 -s 10.1.14.13 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:04:75:ef:3f:f5 -s 10.1.14.13 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:04:75:ef:3f:f5 -s 10.1.14.13 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- i_ko³odziejczuk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0b:6a:08:16:66 -s 10.1.14.14 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0b:6a:08:16:66 -s 10.1.14.14 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:6a:08:16:66 -s 10.1.14.14 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:6a:08:16:66 -s 10.1.14.14 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- £_ku¶ ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:01:f8:83 -s 10.1.14.15 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:01:f8:83 -s 10.1.14.15 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:01:f8:83 -s 10.1.14.15 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:01:f8:83 -s 10.1.14.15 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- z_piskorz ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:01:f4:f1 -s 10.1.14.16 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:01:f4:f1 -s 10.1.14.16 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:01:f4:f1 -s 10.1.14.16 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:01:f4:f1 -s 10.1.14.16 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- j_skrzypczak ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:87:dc:b3 -s 10.1.14.17 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:87:dc:b3 -s 10.1.14.17 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:87:dc:b3 -s 10.1.14.17 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:87:dc:b3 -s 10.1.14.17 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- k_fliska ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:30:4f:26:bf:b5 -s 10.1.14.18 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:30:4f:26:bf:b5 -s 10.1.14.18 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:30:4f:26:bf:b5 -s 10.1.14.18 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:30:4f:26:bf:b5 -s 10.1.14.18 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- b_masloch ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:a1:b0:08:b2:34 -s 10.1.14.19 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:a1:b0:08:b2:34 -s 10.1.14.19 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:a1:b0:08:b2:34 -s 10.1.14.19 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:a1:b0:08:b2:34 -s 10.1.14.19 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- t_nowak ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:08:a1:75:ac:0a -s 10.1.14.2 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:08:a1:75:ac:0a -s 10.1.14.2 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:08:a1:75:ac:0a -s 10.1.14.2 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:08:a1:75:ac:0a -s 10.1.14.2 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_tarnowski ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:01:f2:69 -s 10.1.14.20 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:01:f2:69 -s 10.1.14.20 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:01:f2:69 -s 10.1.14.20 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:01:f2:69 -s 10.1.14.20 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- p_kurzawa ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:02:44:4b:94:9b -s 10.1.14.21 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:02:44:4b:94:9b -s 10.1.14.21 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:02:44:4b:94:9b -s 10.1.14.21 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:02:44:4b:94:9b -s 10.1.14.21 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- d_wosab ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:40:f4:a6:51:0b -s 10.1.14.22 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:40:f4:a6:51:0b -s 10.1.14.22 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:40:f4:a6:51:0b -s 10.1.14.22 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:40:f4:a6:51:0b -s 10.1.14.22 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- r_krochmal ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0e:a6:90:4d:d9 -s 10.1.14.23 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0e:a6:90:4d:d9 -s 10.1.14.23 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0e:a6:90:4d:d9 -s 10.1.14.23 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0e:a6:90:4d:d9 -s 10.1.14.23 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_buras ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:d0:09:e9:85:08 -s 10.1.14.24 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:d0:09:e9:85:08 -s 10.1.14.24 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:d0:09:e9:85:08 -s 10.1.14.24 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:d0:09:e9:85:08 -s 10.1.14.24 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- k_gra¿yna ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:11:2f:3d:f0:01 -s 10.1.14.25 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:11:2f:3d:f0:01 -s 10.1.14.25 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:11:2f:3d:f0:01 -s 10.1.14.25 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:11:2f:3d:f0:01 -s 10.1.14.25 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- b_ostrouch ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0f:ea:b9:69:5b -s 10.1.14.26 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0f:ea:b9:69:5b -s 10.1.14.26 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0f:ea:b9:69:5b -s 10.1.14.26 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0f:ea:b9:69:5b -s 10.1.14.26 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- e_kochel ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0f:ea:42:55:ab -s 10.1.14.3 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0f:ea:42:55:ab -s 10.1.14.3 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0f:ea:42:55:ab -s 10.1.14.3 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0f:ea:42:55:ab -s 10.1.14.3 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- p_dziêbowski ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:50:BA:C6:A8:74 -s 10.1.14.4 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:50:BA:C6:A8:74 -s 10.1.14.4 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:BA:C6:A8:74 -s 10.1.14.4 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:BA:C6:A8:74 -s 10.1.14.4 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- j_zadora ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0b:2b:09:5b:72 -s 10.1.14.5 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0b:2b:09:5b:72 -s 10.1.14.5 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:09:5b:72 -s 10.1.14.5 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:09:5b:72 -s 10.1.14.5 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- BOMAR ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0c:6e:23:12:81 -s 10.1.14.6 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0c:6e:23:12:81 -s 10.1.14.6 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0c:6e:23:12:81 -s 10.1.14.6 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0c:6e:23:12:81 -s 10.1.14.6 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- w_gonera ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:c1:26:08:7f:82 -s 10.1.14.7 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:c1:26:08:7f:82 -s 10.1.14.7 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c1:26:08:7f:82 -s 10.1.14.7 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c1:26:08:7f:82 -s 10.1.14.7 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_chodorek ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:50:bf:da:b8:1f -s 10.1.14.8 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:50:bf:da:b8:1f -s 10.1.14.8 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:bf:da:b8:1f -s 10.1.14.8 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:bf:da:b8:1f -s 10.1.14.8 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- i_kupich ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 4c:00:10:e0:66:80 -s 10.1.14.9 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 4c:00:10:e0:66:80 -s 10.1.14.9 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 4c:00:10:e0:66:80 -s 10.1.14.9 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 4c:00:10:e0:66:80 -s 10.1.14.9 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:c0:26:90:0c:69 -s 10.1.16.1 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:c0:26:90:0c:69 -s 10.1.16.1 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c0:26:90:0c:69 -s 10.1.16.1 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c0:26:90:0c:69 -s 10.1.16.1 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 4c:00:10:e0:8d:7e -s 10.1.16.2 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 4c:00:10:e0:8d:7e -s 10.1.16.2 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 4c:00:10:e0:8d:7e -s 10.1.16.2 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 4c:00:10:e0:8d:7e -s 10.1.16.2 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:50:da:46:f1:5b -s 10.1.17.1 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:50:da:46:f1:5b -s 10.1.17.1 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:da:46:f1:5b -s 10.1.17.1 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:da:46:f1:5b -s 10.1.17.1 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_sulik ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:90:f5:08:4d:93 -s 10.1.17.2 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:90:f5:08:4d:93 -s 10.1.17.2 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:90:f5:08:4d:93 -s 10.1.17.2 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:90:f5:08:4d:93 -s 10.1.17.2 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:04:75:7a:08:76 -s 10.1.2.1 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:04:75:7a:08:76 -s 10.1.2.1 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:04:75:7a:08:76 -s 10.1.2.1 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:04:75:7a:08:76 -s 10.1.2.1 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- e_£uszcz ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:02:44:78:62:52 -s 10.1.2.10 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:02:44:78:62:52 -s 10.1.2.10 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:02:44:78:62:52 -s 10.1.2.10 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:02:44:78:62:52 -s 10.1.2.10 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- b_popiel ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:10:a7:04:de:9e -s 10.1.2.11 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:10:a7:04:de:9e -s 10.1.2.11 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:10:a7:04:de:9e -s 10.1.2.11 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:10:a7:04:de:9e -s 10.1.2.11 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:d0:b7:90:0c:3b -s 10.1.2.13 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:d0:b7:90:0c:3b -s 10.1.2.13 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:d0:b7:90:0c:3b -s 10.1.2.13 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:d0:b7:90:0c:3b -s 10.1.2.13 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bia³ek ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:01:03:26:7d:b0 -s 10.1.2.14 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:01:03:26:7d:b0 -s 10.1.2.14 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:01:03:26:7d:b0 -s 10.1.2.14 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:01:03:26:7d:b0 -s 10.1.2.14 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- r_noszczyñska ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0d:87:ba:3e:f6 -s 10.1.2.15 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0d:87:ba:3e:f6 -s 10.1.2.15 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0d:87:ba:3e:f6 -s 10.1.2.15 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0d:87:ba:3e:f6 -s 10.1.2.15 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- z_kumor ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0c:6e:5f:eb:51 -s 10.1.2.16 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0c:6e:5f:eb:51 -s 10.1.2.16 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0c:6e:5f:eb:51 -s 10.1.2.16 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0c:6e:5f:eb:51 -s 10.1.2.16 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- r_binert ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:30:4f:2b:10:18 -s 10.1.2.17 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:30:4f:2b:10:18 -s 10.1.2.17 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:30:4f:2b:10:18 -s 10.1.2.17 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:30:4f:2b:10:18 -s 10.1.2.17 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_ruciñska ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:04:61:59:10:1a -s 10.1.2.18 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:04:61:59:10:1a -s 10.1.2.18 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:04:61:59:10:1a -s 10.1.2.18 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:04:61:59:10:1a -s 10.1.2.18 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- w_górska ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 11:22:33:44:55:66 -s 10.1.2.19 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 11:22:33:44:55:66 -s 10.1.2.19 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 11:22:33:44:55:66 -s 10.1.2.19 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 11:22:33:44:55:66 -s 10.1.2.19 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:60:08:d2:9D:22 -s 10.1.2.2 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:60:08:d2:9D:22 -s 10.1.2.2 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:60:08:d2:9D:22 -s 10.1.2.2 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:60:08:d2:9D:22 -s 10.1.2.2 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- b_pilecki ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:c0:df:f4:d0:64 -s 10.1.2.20 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:c0:df:f4:d0:64 -s 10.1.2.20 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c0:df:f4:d0:64 -s 10.1.2.20 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c0:df:f4:d0:64 -s 10.1.2.20 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- p_£abaj ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:40:f4:79:f5:d4 -s 10.1.2.21 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:40:f4:79:f5:d4 -s 10.1.2.21 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:40:f4:79:f5:d4 -s 10.1.2.21 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:40:f4:79:f5:d4 -s 10.1.2.21 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- j_ja¿wiec ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:04:61:62:f1:5e -s 10.1.2.22 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:04:61:62:f1:5e -s 10.1.2.22 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:04:61:62:f1:5e -s 10.1.2.22 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:04:61:62:f1:5e -s 10.1.2.22 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- j_ja¿wiec ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:00:39:75:01:aa -s 10.1.2.23 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:00:39:75:01:aa -s 10.1.2.23 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:00:39:75:01:aa -s 10.1.2.23 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:00:39:75:01:aa -s 10.1.2.23 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- j_makie³a ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0b:2b:02:35:4b -s 10.1.2.24 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0b:2b:02:35:4b -s 10.1.2.24 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:02:35:4b -s 10.1.2.24 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:02:35:4b -s 10.1.2.24 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- p_sendek ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:50:ba:c5:95:fb -s 10.1.2.25 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:50:ba:c5:95:fb -s 10.1.2.25 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:ba:c5:95:fb -s 10.1.2.25 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:50:ba:c5:95:fb -s 10.1.2.25 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_czubik ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:c0:df:f3:9d:cb -s 10.1.2.26 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:c0:df:f3:9d:cb -s 10.1.2.26 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c0:df:f3:9d:cb -s 10.1.2.26 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c0:df:f3:9d:cb -s 10.1.2.26 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- s_jadamus ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:10:a7:0e:78:46 -s 10.1.2.27 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:10:a7:0e:78:46 -s 10.1.2.27 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:10:a7:0e:78:46 -s 10.1.2.27 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:10:a7:0e:78:46 -s 10.1.2.27 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- g_maladyn ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:02:44:78:62:8d -s 10.1.2.28 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:02:44:78:62:8d -s 10.1.2.28 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:02:44:78:62:8d -s 10.1.2.28 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:02:44:78:62:8d -s 10.1.2.28 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- p_baran ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:11:d8:17:bf:35 -s 10.1.2.29 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:11:d8:17:bf:35 -s 10.1.2.29 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:11:d8:17:bf:35 -s 10.1.2.29 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:11:d8:17:bf:35 -s 10.1.2.29 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:c0:df:f4:a6:84 -s 10.1.2.3 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:c0:df:f4:a6:84 -s 10.1.2.3 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c0:df:f4:a6:84 -s 10.1.2.3 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c0:df:f4:a6:84 -s 10.1.2.3 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_mosler ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0b:2b:14:dd:55 -s 10.1.2.30 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0b:2b:14:dd:55 -s 10.1.2.30 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:14:dd:55 -s 10.1.2.30 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:14:dd:55 -s 10.1.2.30 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_tadeusz ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:7d:70:0b:58 -s 10.1.2.31 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:7d:70:0b:58 -s 10.1.2.31 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:7d:70:0b:58 -s 10.1.2.31 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:7d:70:0b:58 -s 10.1.2.31 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:87:0a:2e -s 10.1.2.4 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:87:0a:2e -s 10.1.2.4 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:87:0a:2e -s 10.1.2.4 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:87:0a:2e -s 10.1.2.4 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:40:f4:a7:30:86 -s 10.1.2.5 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:40:f4:a7:30:86 -s 10.1.2.5 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:40:f4:a7:30:86 -s 10.1.2.5 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:40:f4:a7:30:86 -s 10.1.2.5 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0a:e6:79:07:1c -s 10.1.2.6 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0a:e6:79:07:1c -s 10.1.2.6 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0a:e6:79:07:1c -s 10.1.2.6 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0a:e6:79:07:1c -s 10.1.2.6 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- j_szóstak ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0c:6e:bb:2b:ef -s 10.1.2.7 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0c:6e:bb:2b:ef -s 10.1.2.7 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0c:6e:bb:2b:ef -s 10.1.2.7 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0c:6e:bb:2b:ef -s 10.1.2.7 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:7d:e2:c6:66 -s 10.1.27.1 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:7d:e2:c6:66 -s 10.1.27.1 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:7d:e2:c6:66 -s 10.1.27.1 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:7d:e2:c6:66 -s 10.1.27.1 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:40:f4:8e:f8:33 -s 10.1.27.2 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:40:f4:8e:f8:33 -s 10.1.27.2 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:40:f4:8e:f8:33 -s 10.1.27.2 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:40:f4:8e:f8:33 -s 10.1.27.2 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:7d:7d:c5:bb -s 10.1.27.3 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:7d:7d:c5:bb -s 10.1.27.3 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:7d:7d:c5:bb -s 10.1.27.3 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:7d:7d:c5:bb -s 10.1.27.3 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:7d:e2:c6:69 -s 10.1.27.4 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:7d:e2:c6:69 -s 10.1.27.4 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:7d:e2:c6:69 -s 10.1.27.4 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:7d:e2:c6:69 -s 10.1.27.4 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- i_asenkowicz ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:08:c7:7b:22:72 -s 10.1.27.5 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:08:c7:7b:22:72 -s 10.1.27.5 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:08:c7:7b:22:72 -s 10.1.27.5 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:08:c7:7b:22:72 -s 10.1.27.5 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- b_kazimierz ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:11:17:78 -s 10.1.2.9 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:11:17:78 -s 10.1.2.9 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:11:17:78 -s 10.1.2.9 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:11:17:78 -s 10.1.2.9 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- u_barczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0c:6e:f5:5e:16 -s 10.1.4.1 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0c:6e:f5:5e:16 -s 10.1.4.1 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0c:6e:f5:5e:16 -s 10.1.4.1 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0c:6e:f5:5e:16 -s 10.1.4.1 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:11:1a:19 -s 10.1.4.2 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:11:1a:19 -s 10.1.4.2 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:11:1a:19 -s 10.1.4.2 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:11:1a:19 -s 10.1.4.2 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_¯muda ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:30:4f:25:85:dc -s 10.1.4.3 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:30:4f:25:85:dc -s 10.1.4.3 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:30:4f:25:85:dc -s 10.1.4.3 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:30:4f:25:85:dc -s 10.1.4.3 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- r_mazurek ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:30:4f:22:92:9d -s 10.1.4.4 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:30:4f:22:92:9d -s 10.1.4.4 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:30:4f:22:92:9d -s 10.1.4.4 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:30:4f:22:92:9d -s 10.1.4.4 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_sandra ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:00:00:00:00:00 -s 10.1.44.2 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:00:00:00:00:00 -s 10.1.44.2 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:00:00:00:00:00 -s 10.1.44.2 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:00:00:00:00:00 -s 10.1.44.2 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_juszczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0b:2b:01:8a:6b -s 10.1.4.5 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0b:2b:01:8a:6b -s 10.1.4.5 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:01:8a:6b -s 10.1.4.5 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:01:8a:6b -s 10.1.4.5 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- b_kosien ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:e9:e3:66 -s 10.1.4.6 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:e9:e3:66 -s 10.1.4.6 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:e9:e3:66 -s 10.1.4.6 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:e9:e3:66 -s 10.1.4.6 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- s_siwiec ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0f:ea:44:e3:89 -s 10.1.4.8 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0f:ea:44:e3:89 -s 10.1.4.8 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0f:ea:44:e3:89 -s 10.1.4.8 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0f:ea:44:e3:89 -s 10.1.4.8 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- s_rudecki ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:11:1d:5c -s 10.1.4.9 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:11:1d:5c -s 10.1.4.9 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:11:1d:5c -s 10.1.4.9 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:11:1d:5c -s 10.1.4.9 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0b:2b:04:cc:02 -s 10.1.5.1 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0b:2b:04:cc:02 -s 10.1.5.1 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:04:cc:02 -s 10.1.5.1 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:04:cc:02 -s 10.1.5.1 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- t_pi³at ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:02:44:8f:1a:4b -s 10.1.5.2 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:02:44:8f:1a:4b -s 10.1.5.2 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:02:44:8f:1a:4b -s 10.1.5.2 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:02:44:8f:1a:4b -s 10.1.5.2 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- z_kuchnecki ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:02:2a:b2:23:b6 -s 10.1.5.3 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:02:2a:b2:23:b6 -s 10.1.5.3 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:02:2a:b2:23:b6 -s 10.1.5.3 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:02:2a:b2:23:b6 -s 10.1.5.3 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:7d:7f:27:90 -s 10.1.6.1 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:7d:7f:27:90 -s 10.1.6.1 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:7d:7f:27:90 -s 10.1.6.1 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:7d:7f:27:90 -s 10.1.6.1 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0c:6e:68:3c:4a -s 10.1.6.2 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0c:6e:68:3c:4a -s 10.1.6.2 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0c:6e:68:3c:4a -s 10.1.6.2 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0c:6e:68:3c:4a -s 10.1.6.2 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:05:1c:FE:e6:47 -s 10.1.6.3 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:05:1c:FE:e6:47 -s 10.1.6.3 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:05:1c:FE:e6:47 -s 10.1.6.3 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:05:1c:FE:e6:47 -s 10.1.6.3 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_róg ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0a:cd:04:cf:30 -s 10.1.6.4 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0a:cd:04:cf:30 -s 10.1.6.4 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0a:cd:04:cf:30 -s 10.1.6.4 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0a:cd:04:cf:30 -s 10.1.6.4 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- s_garstka ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:02:44:53:d7:0d -s 10.1.6.6 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:02:44:53:d7:0d -s 10.1.6.6 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:02:44:53:d7:0d -s 10.1.6.6 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:02:44:53:d7:0d -s 10.1.6.6 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- z_szczepanek ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:77:11:98 -s 10.1.6.7 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:77:11:98 -s 10.1.6.7 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:77:11:98 -s 10.1.6.7 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:77:11:98 -s 10.1.6.7 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- g_pieczonka ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0f:ea:27:00:01 -s 10.1.6.8 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0f:ea:27:00:01 -s 10.1.6.8 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0f:ea:27:00:01 -s 10.1.6.8 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0f:ea:27:00:01 -s 10.1.6.8 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- d_kania ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 4c:00:10:60:a9:13 -s 10.1.6.9 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 4c:00:10:60:a9:13 -s 10.1.6.9 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 4c:00:10:60:a9:13 -s 10.1.6.9 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 4c:00:10:60:a9:13 -s 10.1.6.9 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:60:52:03:41:03 -s 10.1.7.1 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:60:52:03:41:03 -s 10.1.7.1 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:60:52:03:41:03 -s 10.1.7.1 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:60:52:03:41:03 -s 10.1.7.1 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:40:f4:90:95:ce -s 10.1.7.2 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:40:f4:90:95:ce -s 10.1.7.2 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:40:f4:90:95:ce -s 10.1.7.2 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:40:f4:90:95:ce -s 10.1.7.2 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_bednarczyk ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0e:7f:7a:db:7f -s 10.1.7.3 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0e:7f:7a:db:7f -s 10.1.7.3 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0e:7f:7a:db:7f -s 10.1.7.3 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0e:7f:7a:db:7f -s 10.1.7.3 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- h_¯elazny ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0e:a6:cc:44:f9 -s 10.1.7.4 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0e:a6:cc:44:f9 -s 10.1.7.4 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0e:a6:cc:44:f9 -s 10.1.7.4 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0e:a6:cc:44:f9 -s 10.1.7.4 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_czyba ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:c1:26:10:64:a9 -s 10.1.8.1 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:c1:26:10:64:a9 -s 10.1.8.1 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c1:26:10:64:a9 -s 10.1.8.1 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:c1:26:10:64:a9 -s 10.1.8.1 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_pêdziñska-kulik ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:eb:91:be -s 10.1.8.2 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:eb:91:be -s 10.1.8.2 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:eb:91:be -s 10.1.8.2 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:eb:91:be -s 10.1.8.2 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- s_opyrcha³ ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:08:a1:75:9c:83 -s 10.1.8.3 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:08:a1:75:9c:83 -s 10.1.8.3 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:08:a1:75:9c:83 -s 10.1.8.3 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:08:a1:75:9c:83 -s 10.1.8.3 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- b_gola ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:30:4f:25:11:25 -s 10.1.8.4 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:30:4f:25:11:25 -s 10.1.8.4 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:30:4f:25:11:25 -s 10.1.8.4 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:30:4f:25:11:25 -s 10.1.8.4 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- SELLASOFT Mariusz Ry³o ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:a0:c9:bb:f3:0f -s 10.1.8.5 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:a0:c9:bb:f3:0f -s 10.1.8.5 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:a0:c9:bb:f3:0f -s 10.1.8.5 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:a0:c9:bb:f3:0f -s 10.1.8.5 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- a_mocny ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:30:4f:2d:e4:dd -s 10.1.8.6 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:30:4f:2d:e4:dd -s 10.1.8.6 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:30:4f:2d:e4:dd -s 10.1.8.6 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:30:4f:2d:e4:dd -s 10.1.8.6 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_£ukowicz ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0a:cd:01:93:00 -s 10.1.8.7 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0a:cd:01:93:00 -s 10.1.8.7 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0a:cd:01:93:00 -s 10.1.8.7 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0a:cd:01:93:00 -s 10.1.8.7 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- e_snarska ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:e0:4c:11:1a:2f -s 10.1.8.8 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:e0:4c:11:1a:2f -s 10.1.8.8 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:11:1a:2f -s 10.1.8.8 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:e0:4c:11:1a:2f -s 10.1.8.8 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- m_lebuda ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:0b:2b:14:ca:5c -s 10.1.8.9 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:0b:2b:14:ca:5c -s 10.1.8.9 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:14:ca:5c -s 10.1.8.9 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:0b:2b:14:ca:5c -s 10.1.8.9 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#---- s_iwona ----------------------------------------------------------------------------------------------------------------------------------------#
$IPTABLES -A INPUT-m mac --mac-source 00:00:00:00:00:00 -s 10.2.2.2 -j ACCEPT 
$IPTABLES -A FORWARD-m mac --mac-source 00:00:00:00:00:00 -s 10.2.2.2 -j ACCEPT 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:00:00:00:00:00 -s 10.2.2.2 -p tcp -m mport --dports 80,8080 -d $IP_INET1 -j RETURN 
$IPTABLES -t nat -A PREROUTING-m mac --mac-source 00:00:00:00:00:00 -s 10.2.2.2 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080
#----- Nie autoryzowany numer IP -----------------------------------------------------------------------------
$IPTABLES -t nat -A PREROUTING -s 80.53.51.248/29 -p tcp -m mport --dports 80,8080 -d IP_INET2 -j RETURN
$IPTABLES -t nat -A PREROUTING -s ! 10.0.0.100  -i $IF_LAN1 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET2:8081
$IPTABLES -t nat -A PREROUTING -s ! 10.0.0.100  -i $IF_LAN2 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET2:8081
$IPTABLES -A FORWARD -s $N_LAN1 -j DROP 
$IPTABLES -A FORWARD -s $N_LAN2 -j DROP
$IPTABLES -A INPUT -s $N_LAN1 -j ACCEPT
$IPTABLES -A INPUT -s $N_LAN2 -j ACCEPT
$IPTABLES -A INPUT -s $N_INET3 -j ACCEPT
$IPTABLES -A INPUT -s 80.53.51.248/29 -j ACCEPT
