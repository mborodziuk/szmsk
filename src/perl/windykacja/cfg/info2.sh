#!/bin/bash 
 source /etc/conf 

#---- ABON3145      Bernaś Stanisława -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.24.69 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5523      Bliźnik Beata -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.148.136 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON2876      Daniel Włodarski -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.240.89 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3584      E-Media Śmiertka Teresa -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.18.133 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON1543      Gworek Jarosław -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.241.249 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON2345      Jurkowski Artur -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.243.81 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5758      Kobylańska Eliza -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.132.85 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5833      Krawczyk Rafał -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.24.213 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON1338      Kubica Waldemar -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.128.3 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5689      Kuci Katarzyna -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.24.71 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON2476      Małysiak Grażyna -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.136.67 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON1150      Orzechowski Kryspin -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.36.44 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON2355      Piskorz Witold -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.241.117 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3905      Roszkowski Grzegorz -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.32.184 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON6109      Ryśko Marcin -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.24.138 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON1294      Skrzypczyk Zbigniew -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.242.189 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4026      Skwarczyńska Elżbieta -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.32.45 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON1128      Socała Grażyna -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.36.53 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON2922      Tolarczyk Maria -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.32.199 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3410      Usługi Transportowe ID-TRANS Iwona Przystał -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.241.157 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON6349      Walus Agnieszka -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.24.113 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3246      Zadora Anna -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.32.197 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON1401      Z.P.H. DARBUT Dariusz Kajor -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.244.49 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3409      Zygało Krzysztof -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.9.48.6 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
