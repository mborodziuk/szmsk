#!/bin/bash
 source /etc/conf 

#---- ABON1663      Abou Zaid Ahmed -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.242.21 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.242.21 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.242.21  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.242.21 
fi 
#---- ABON3760      Bliźniak Radosław -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.244.125 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.244.125 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.244.125  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.244.125 
fi 
#---- ABON1352      B&R Sp. z o.o. -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.52.7 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.52.7 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.52.7  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.52.7 
fi 
#---- ABON5983      Bromboszcz Michał -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.32.189 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.32.189 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.32.189  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.32.189 
fi 
#---- ABON2537      Bryndza Leszek -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.36.87 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.36.87 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.36.87  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.36.87 
fi 
#---- ABON1157      Chapczyńska Edyta -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.36.103 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.36.103 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.36.103  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.36.103 
fi 
#---- ABON3800      Chmiel Robert -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.244.113 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.244.113 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.244.113  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.244.113 
fi 
#---- ABON5391      Chuchrojob Izabela -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.240.29 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.240.29 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.240.29  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.240.29 
fi 
#---- ABON4005      Dębski Wiesław -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.224.50 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.224.50 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.224.50  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.224.50 
fi 
#---- ABON4005      Dębski Wiesław -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.148.131 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.148.131 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.148.131  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.148.131 
fi 
#---- ABON3435      Drabczyk Katarzyna -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.136.99 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.136.99 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.136.99  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.136.99 
fi 
#---- ABON4151      Dubiel Dagmara -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.148.135 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.148.135 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.148.135  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.148.135 
fi 
#---- ABON6266      Fitomed Sklep Zielarsko Medyczny  Beata Binert -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.224.19 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.224.19 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.224.19  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.224.19 
fi 
#---- ABON2564      Frączek Anna -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.44.41 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.44.41 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.44.41  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.44.41 
fi 
#---- ABON1659      Gębczyk Paweł -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.243.73 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.243.73 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.243.73  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.243.73 
fi 
#---- ABON2425      Gębołyś Łukasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.144.38 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.144.38 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.144.38  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.144.38 
fi 
#---- ABON1902      Greczner Grzegorz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.128.99 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.128.99 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.128.99  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.128.99 
fi 
#---- ABON2822      Gryzełko Leszek -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.242.141 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.242.141 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.242.141  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.242.141 
fi 
#---- ABON2546      Gwóźdź Daniel -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.240.61 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.240.61 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.240.61  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.240.61 
fi 
#---- ABON1528      HG Sp. z o.o. -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.243.229 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.243.229 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.243.229  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.243.229 
fi 
#---- ABON4925      Hilo Investments Sp. z o.o. -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  178.217.222.1 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  178.217.222.1 
fi 
if ! $IPS -T HOSTS_DROP_109  178.217.222.1  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  178.217.222.1 
fi 
#---- ABON1717      Jarzyna Szymon -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.129.20 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.129.20 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.129.20  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.129.20 
fi 
#---- ABON2838      Jeż Bartłomiej -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.36.34 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.36.34 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.36.34  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.36.34 
fi 
#---- ABON3679      Jodłowski Łukasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.148.134 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.148.134 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.148.134  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.148.134 
fi 
#---- ABON3679      Jodłowski Łukasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.224.53 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.224.53 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.224.53  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.224.53 
fi 
#---- ABON1516      Kaszyński Michał -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.140.3 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.140.3 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.140.3  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.140.3 
fi 
#---- ABON3628      Kowalik Daniel -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.48.7 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.48.7 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.48.7  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.48.7 
fi 
#---- ABON3503      Księżarczyk Mateusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.36.109 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.36.109 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.36.109  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.36.109 
fi 
#---- ABON1693      Kułas Piotr -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.36.13 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.36.13 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.36.13  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.36.13 
fi 
#---- ABON2037      Kunkel Małgorzata -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.245.109 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.245.109 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.245.109  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.245.109 
fi 
#---- ABON4137      Kurkiewicz Monika -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.32.196 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.32.196 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.32.196  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.32.196 
fi 
#---- ABON4745      Latocha Donata -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.245.85 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.245.85 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.245.85  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.245.85 
fi 
#---- ABON3226      Majerski Roman -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.241.101 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.241.101 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.241.101  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.241.101 
fi 
#---- ABON4082      Mańka Paulina -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.36.18 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.36.18 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.36.18  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.36.18 
fi 
#---- ABON3721      Maroszek Patryk -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.243.97 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.243.97 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.243.97  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.243.97 
fi 
#---- ABON3721      Maroszek Patryk -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.243.97 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.243.97 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.243.97  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.243.97 
fi 
#---- ABON1550      Matla Arkadiusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.241.245 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.241.245 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.241.245  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.241.245 
fi 
#---- ABON4684      Mikos Magdalena -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.245.101 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.245.101 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.245.101  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.245.101 
fi 
#---- ABON4284      Mruk Tomasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.128.140 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.128.140 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.128.140  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.128.140 
fi 
#---- ABON1844      Mucha Paweł -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.33.36 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.33.36 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.33.36  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.33.36 
fi 
#---- ABON2339      Musialik Waldemar -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.245.17 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.245.17 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.245.17  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.245.17 
fi 
#---- ABON2986      Naras Paweł -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.241.169 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.241.169 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.241.169  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.241.169 
fi 
#---- ABON5008      Nigbor  Dariusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.245.117 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.245.117 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.245.117  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.245.117 
fi 
#---- ABON1703      Nowak Agnieszka -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.32.99 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.32.99 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.32.99  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.32.99 
fi 
#---- ABON3325      Obstarczyk Bożena -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.241.213 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.241.213 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.241.213  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.241.213 
fi 
#---- ABON1744      Olejarz Robert -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.132.232 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.132.232 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.132.232  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.132.232 
fi 
#---- ABON3726      Paluch Rafał -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.224.44 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.224.44 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.224.44  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.224.44 
fi 
#---- ABON3309      Pencak Krzysztof -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.242.13 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.242.13 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.242.13  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.242.13 
fi 
#---- ABON1501      Pędziwiatr Bożena -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.148.35 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.148.35 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.148.35  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.148.35 
fi 
#---- ABON5212      Rodak Przemysław -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.245.81 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.245.81 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.245.81  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.245.81 
fi 
#---- ABON4728      Rostek Agnieszka -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.136.35 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.136.35 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.136.35  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.136.35 
fi 
#---- ABON2799      Sobczak Renata -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.148.133 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.148.133 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.148.133  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.148.133 
fi 
#---- ABON2799      Sobczak Renata -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.224.52 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.224.52 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.224.52  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.224.52 
fi 
#---- ABON4109      Stolarczyk Kamila -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.128.73 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.128.73 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.128.73  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.128.73 
fi 
#---- ABON4699      Szczepanek  Olimpia -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.32.141 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.32.141 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.32.141  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.32.141 
fi 
#---- ABON3828      Szczepanek Piotr -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.32.137 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.32.137 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.32.137  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.32.137 
fi 
#---- ABON3274      Szczepański Tomasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.224.41 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.224.41 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.224.41  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.224.41 
fi 
#---- ABON4220      Szlachta Agnieszka -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.128.53 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.128.53 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.128.53  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.128.53 
fi 
#---- ABON4483      Śliwińska Barbara -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.144.5 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.144.5 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.144.5  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.144.5 
fi 
#---- ABON3737      Tomasik Bogdan -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.244.101 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.244.101 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.244.101  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.244.101 
fi 
#---- ABON5486      Werstak Wiesław -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.128.10 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.128.10 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.128.10  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.128.10 
fi 
#---- ABON2666      Wolańska Stanisława -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.36.98 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.36.98 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.36.98  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.36.98 
fi 
#---- ABON4736      Wziątek Jadwiga -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.240.13 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.240.13 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.240.13  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.240.13 
fi 
#---- ABON3370      Zemła Andrzej -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.240.37 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.240.37 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.240.37  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.240.37 
fi 
#---- ABON3925      Znaleźniak Gerard -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_109  10.9.33.7 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_109  10.9.33.7 
fi 
if ! $IPS -T HOSTS_DROP_109  10.9.33.7  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_109  10.9.33.7 
fi 
