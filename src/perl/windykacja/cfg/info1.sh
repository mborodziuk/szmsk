#!/bin/bash 
 source /etc/conf 

#---- ABON0530      Andrzejewski Ireneusz -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.136.84 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5943      Augustyn Wojciech -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.25.145 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5943      Augustyn Wojciech -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.32.89 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5753      Bara Katarzyna -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.16.53 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4468      Baranowska Maria -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.8.171 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4241      Barchańska Iwona -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.39.111 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON0682      Bednarczyk Krystyna -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.13.146 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON0507      Bialic Robert -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.140.98 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4764      Biegun Ewa -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.10.189 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4764      Biegun Ewa -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.10.169 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON0409      Błeszyński Leszek -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.8.132 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3324      Brzeziński Mateusz -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.36.16 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4402      Ceglarek Dariusz -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.16.106 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON6439      Chempińska Diana -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s ...25 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4463      Chojnowska Anna -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.39.143 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON2988      Ciastoń Andrzej -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.11.115 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3807      Czajka Małgorzata -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.52.203 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4318      Czarnecki Grzegorz -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.11.82 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON0238      Dreja Bartłomiej -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.32.115 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3782      Dreja Bartłomiej -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.25.6 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON0238      Dreja Bartłomiej -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.136.101 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4600      Drozd Mateusz -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.60.238 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4922      Dygant Łukasz -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.38.230 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON6321      Dymanus Paweł -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.15.211 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5063      Frąckowiak Michał -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.19.38 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3303      F.U.H. AUTOKOMIS GALAKTYKA Małgorzata Pieszak -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.243.149 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4988      Gawron Mariola -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.33.7 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON6328      Gdula Arkadiusz -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.31.223 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON1458      Gemza Adam -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.44.135 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3173      Giermański Robert -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.243.5 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3872      Gruca Zbigniew -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.60.69 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3742      Gruca Zbigniew -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.60.11 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4898      Guja Iwona -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.24.226 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5524      Gumprecht Małgorzata -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.17.224 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5108      Hinkelmann Przemysław -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.31.177 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4064      Jagucak Małgorzata -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.31.151 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON0613      Jakubowska Lidia -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.44.147 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON0613      Jakubowska Lidia -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.44.147 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4528      Jaworska Felicja -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.25.40 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4528      Jaworska Felicja -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.136.41 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4528      Jaworska Felicja -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.32.41 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON0455      Jaworska Izabela -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.44.208 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4077      Kaczmarczyk Dominika -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.128.71 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4262      Kaczmarek Antoni -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.18.235 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3683      Kałuziak Jacek -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.209.213 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5400      Karwat Agata -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.17.222 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON2501      Kawucha Zbigniew -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.13.165 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON2501      Kawucha Zbigniew -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s ...6 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3810      Klapkarek Michał -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.25.47 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3810      Klapkarek Michał -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.136.12 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4611      Klockiewicz Beata -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.26.102 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5625      Kłopotowski Adrian -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.25.222 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4143      Kmiecik Kamila -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.25.31 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4143      Kmiecik Kamila -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.136.73 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4300      Knapik Krystian -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.44.236 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON6116      Kocoń Anna -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.24.201 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5182      Kocurek Klaudia -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.26.33 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4465      Kowalczyk Iwona -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.24.134 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON6122      Kregel Monika -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.16.124 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3137      Kr�lak Dawid -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.26.76 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4126      Kściuk Bolesław -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.11.4 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5375      Kubica Mirosław -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.9.59 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON2766      Kulawik Mariusz -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.132.68 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON0213      Kułakowski Stanisław -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.33.101 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5210      Kuźnicki  Klaudiusz -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.24.76 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON6247      Lassok Anna -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.12.88 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3172      Latos Elżbieta -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.8.70 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON6058      Leman Anna -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.10.230 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4590      Łabudzik Katarzyna -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.13.131 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3995      Łagocki Andrzej -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.9.185 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5538      Łazarski Artur -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.9.199 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4787      Łyczek Ewa -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.17.18 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5229      Majewski Rafał -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.19.55 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5003      Marczak Jacek -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.24.228 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4456      Mikstacka Bożena -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.16.229 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON6227      MS Biuro Sp. z o.o. -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.31.166 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON0242      Mucha Sandra -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.40.99 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4425      Niewiński Paweł -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.241.93 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3714      Nowak Jolanta -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.140.36 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5801      Od�j Anita -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.140.44 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON6047      Oleś Dawid -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.11.133 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3702      PAN PIKTO Łukasz Jurkiewicz -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.56.10 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3114      Panek Marcin -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.11.108 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON2297      Pawlikowski Jan -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.140.178 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3100      PHT TRANSHAND Iwona Borcz -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.128.21 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3494      Pomykało Leszek -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.136.66 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3494      Pomykało Leszek -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.25.27 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON6365      Radecka Patrycja -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.19.9 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3523      RETRO GAMES Adam Wojciechowski -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.26.88 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5476      Ror Artur -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.153.103 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5733      Skotniczna Beata -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.18.225 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5438      Sokołowski Damian -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.24.46 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON6083      Sumiński Seweryn -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.24.18 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON0670      Szwaj Łukasz -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.15.90 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON0524      Trzaskawka Rita-Anna -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.140.41 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON2741      Waleryś Anna -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.52.226 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5903      Wojtowicz Dominika -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.128.105 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON2784      Wrona Daniel -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.153.153 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3441      Wrześniewska Beata -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.32.207 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON3164      Zacher Stanisław -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.8.12 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5724      Zandecka Maria -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.16.226 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON4596      Zarębski Jacek -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.17.205 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 
#---- ABON5181      Żywioł Bożena -------------------------------------------------------------------------------------------------------# 
$IPT -t nat -I PREROUTING -s 10.8.16.47 -p tcp --dport 80 -j DNAT --to $IP_LAN_WWW:8085 