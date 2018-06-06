#!/bin/bash
 source /etc/conf 

#---- ABON3305      Adamiec Agnieszka -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.39.100 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.39.100 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.39.100  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.39.100 
fi 
#---- ABON4739      AKSE Sp. z o.o. -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.244.169 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.244.169 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.244.169  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.244.169 
fi 
#---- ABON2290      Amonowicz Marcin -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.44.148 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.44.148 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.44.148  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.44.148 
fi 
#---- ABON4330      Andrysek Dawid -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.26.78 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.26.78 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.26.78  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.26.78 
fi 
#---- ABON4981      AP Inwestor Sp. z o.o. -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.160.206 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.160.206 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.160.206  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.160.206 
fi 
#---- ABON3996      Bara Michał -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.33.99 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.33.99 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.33.99  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.33.99 
fi 
#---- ABON4468      Baranowska Maria -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.8.171 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.8.171 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.8.171  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.8.171 
fi 
#---- ABON2805      Barczyk Adam -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.153.66 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.153.66 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.153.66  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.153.66 
fi 
#---- ABON4522      Bartoszek Mirosław -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.132.201 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.132.201 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.132.201  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.132.201 
fi 
#---- ABON2568      Bezuszko Arkadiusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.133.41 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.133.41 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.133.41  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.133.41 
fi 
#---- ABON4404      Bibiela Sebastian -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.24.220 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.24.220 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.24.220  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.24.220 
fi 
#---- ABON2574      Biela Katarzyna -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.36.105 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.36.105 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.36.105  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.36.105 
fi 
#---- ABON4572      Bieńko Aleksandra -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.146.7 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.146.7 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.146.7  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.146.7 
fi 
#---- ABON4930      Biguszewska Magdalena -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.128.125 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.128.125 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.128.125  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.128.125 
fi 
#---- ABON3538      Biłka Dagmara -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.132.163 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.132.163 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.132.163  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.132.163 
fi 
#---- ABON2725      Biznes-Media Agencja Reklamy i Publicystyki Urszula Serafińska -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.32.247 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.32.247 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.32.247  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.32.247 
fi 
#---- ABON4193      Błaszczyk Andrzej -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.10.204 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.10.204 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.10.204  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.10.204 
fi 
#---- ABON2581      Bochenek Krzysztof -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.32.187 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.32.187 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.32.187  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.32.187 
fi 
#---- ABON1817      Boiński Tomasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.32.73 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.32.73 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.32.73  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.32.73 
fi 
#---- ABON3987      Bolechowski Radosław -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.32.84 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.32.84 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.32.84  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.32.84 
fi 
#---- ABON3131      Boś Ilona -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.132.115 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.132.115 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.132.115  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.132.115 
fi 
#---- ABON2518      Brzeziński Sebastian -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.133.27 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.133.27 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.133.27  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.133.27 
fi 
#---- ABON3814      Buczek Monika -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.60.7 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.60.7 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.60.7  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.60.7 
fi 
#---- ABON4459      Byś Robert -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.158.7 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.158.7 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.158.7  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.158.7 
fi 
#---- ABON0370      Chmieliński Janusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.224.49 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.224.49 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.224.49  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.224.49 
fi 
#---- ABON4973      Consent Sp. z o.o. -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.160.197 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.160.197 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.160.197  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.160.197 
fi 
#---- ABON3689      Czapski Janusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.39.139 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.39.139 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.39.139  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.39.139 
fi 
#---- ABON6279      Czernicka Vel Walińska Maja -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.133.20 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.133.20 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.133.20  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.133.20 
fi 
#---- ABON4128      Damczyk Iwona -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.153.80 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.153.80 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.153.80  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.153.80 
fi 
#---- ABON4358      Dąbrowska Patrycja -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.146.5 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.146.5 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.146.5  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.146.5 
fi 
#---- ABON5988      Dembski Sylwester -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.16.119 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.16.119 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.16.119  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.16.119 
fi 
#---- ABON4566      Dłubis Katarzyna -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.38.4 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.38.4 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.38.4  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.38.4 
fi 
#---- ABON2004      Dobosz Tomasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.31.160 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.31.160 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.31.160  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.31.160 
fi 
#---- ABON2004      Dobosz Tomasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.31.161 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.31.161 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.31.161  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.31.161 
fi 
#---- ABON2004      Dobosz Tomasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.31.159 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.31.159 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.31.159  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.31.159 
fi 
#---- ABON3365      Dylong Klaudia -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.44.242 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.44.242 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.44.242  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.44.242 
fi 
#---- ABON3981      Dziuk Anna -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.32.83 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.32.83 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.32.83  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.32.83 
fi 
#---- ABON5959      EFFECT Mateusz Masternak -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.9.195 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.9.195 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.9.195  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.9.195 
fi 
#---- ABON2607      Elżanowska Edyta -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.25.17 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.25.17 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.25.17  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.25.17 
fi 
#---- ABON2607      Elżanowska Edyta -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.136.118 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.136.118 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.136.118  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.136.118 
fi 
#---- ABON5677      EWANDER RECYCLING Sp. z o.o. -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_123  178.217.223.109 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_123  178.217.223.109 
fi 
if ! $IPS -T HOSTS_DROP_123  178.217.223.109  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_123  178.217.223.109 
fi 
#---- ABON3352      Firma Usługowo-Handlowo-Hotelarska Agnieszka Obcowska -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_123  178.217.223.17 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_123  178.217.223.17 
fi 
if ! $IPS -T HOSTS_DROP_123  178.217.223.17  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_123  178.217.223.17 
fi 
#---- ABON3072      Flasz Jacek -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.32.45 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.32.45 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.32.45  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.32.45 
fi 
#---- ABON2529      Foltyn Sylwester -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.209.197 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.209.197 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.209.197  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.209.197 
fi 
#---- ABON5638      Gadomska Hanna -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.24.245 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.24.245 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.24.245  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.24.245 
fi 
#---- ABON4916      Gawor Roland -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.36.14 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.36.14 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.36.14  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.36.14 
fi 
#---- ABON3668      G�rak Tomasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.8.68 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.8.68 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.8.68  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.8.68 
fi 
#---- ABON2358      Grabowski Adrian -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.36.38 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.36.38 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.36.38  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.36.38 
fi 
#---- ABON3615      Granek Agnieszka -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.128.86 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.128.86 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.128.86  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.128.86 
fi 
#---- ABON5412      Gruba Sebastian -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.240.253 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.240.253 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.240.253  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.240.253 
fi 
#---- ABON3772      Grządziel Jarosław -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.32.215 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.32.215 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.32.215  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.32.215 
fi 
#---- ABON5162      Habryka Krzysztof -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.242.117 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.242.117 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.242.117  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.242.117 
fi 
#---- ABON0206      Helak Sebastian -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.128.34 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.128.34 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.128.34  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.128.34 
fi 
#---- ABON3975      Heleniak Alina -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.146.34 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.146.34 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.146.34  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.146.34 
fi 
#---- ABON4405      Hupacz Robert -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.26.215 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.26.215 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.26.215  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.26.215 
fi 
#---- ABON2056      Imiolczyk Witold -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.32.211 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.32.211 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.32.211  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.32.211 
fi 
#---- ABON0900      Jamrozik Tadeusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.39.36 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.39.36 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.39.36  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.39.36 
fi 
#---- ABON5703      Janicki Tomasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.26.125 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.26.125 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.26.125  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.26.125 
fi 
#---- ABON3143      Janicki Tomasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.242.181 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.242.181 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.242.181  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.242.181 
fi 
#---- ABON3610      Janosz Angelika -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.146.2 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.146.2 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.146.2  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.146.2 
fi 
#---- ABON2186      Janosz Anna -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.31.174 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.31.174 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.31.174  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.31.174 
fi 
#---- ABON5768      Jasiulek Adam -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.31.182 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.31.182 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.31.182  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.31.182 
fi 
#---- ABON6355      Jopek Natalia -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.27.26 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.27.26 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.27.26  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.27.26 
fi 
#---- ABON2523      J�zefczak Joanna -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.31.144 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.31.144 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.31.144  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.31.144 
fi 
#---- ABON4519      Kaczmarek Joanna -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.132.200 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.132.200 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.132.200  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.132.200 
fi 
#---- ABON3450      Kamracki Damian -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.153.40 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.153.40 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.153.40  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.153.40 
fi 
#---- ABON3334      Kapler Ireneusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.140.114 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.140.114 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.140.114  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.140.114 
fi 
#---- ABON5029      Karp Grzegorz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.9.74 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.9.74 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.9.74  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.9.74 
fi 
#---- ABON4705      Kasperczyk Piotr -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.132.153 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.132.153 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.132.153  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.132.153 
fi 
#---- ABON4482      Kaszyca Beata -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.26.149 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.26.149 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.26.149  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.26.149 
fi 
#---- ABON4347      Kisilewicz Michał -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.16.142 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.16.142 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.16.142  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.16.142 
fi 
#---- ABON1261      Klonowski Marcin -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.38.43 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.38.43 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.38.43  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.38.43 
fi 
#---- ABON1336      Kołdej Karol -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.36.140 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.36.140 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.36.140  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.36.140 
fi 
#---- ABON5518      Kopeć Anna -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.18.135 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.18.135 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.18.135  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.18.135 
fi 
#---- ABON3278      Korczyńska Agata -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.136.169 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.136.169 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.136.169  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.136.169 
fi 
#---- ABON4991      Kowalski Krzysztof -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.24.30 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.24.30 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.24.30  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.24.30 
fi 
#---- ABON3336      Kowalski Marcin -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.24.26 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.24.26 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.24.26  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.24.26 
fi 
#---- ABON4682      Kozera Agnieszka -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.60.208 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.60.208 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.60.208  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.60.208 
fi 
#---- ABON3849      Kozioł Mariusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.24.131 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.24.131 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.24.131  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.24.131 
fi 
#---- ABON4244      Kozyra Bożena -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.44.154 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.44.154 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.44.154  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.44.154 
fi 
#---- ABON6053      Krajewski Damian -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.14.226 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.14.226 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.14.226  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.14.226 
fi 
#---- ABON3425      Kr�l Dariusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.36.73 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.36.73 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.36.73  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.36.73 
fi 
#---- ABON5359      Kr�l Jakub -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.11.107 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.11.107 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.11.107  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.11.107 
fi 
#---- ABON2497      Kr�lak Piotr -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.31.165 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.31.165 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.31.165  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.31.165 
fi 
#---- ABON0521      Krupa Mariusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.16.100 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.16.100 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.16.100  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.16.100 
fi 
#---- ABON0248      Kryla Dariusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.128.163 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.128.163 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.128.163  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.128.163 
fi 
#---- ABON4068      Krzywda Łukasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.132.134 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.132.134 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.132.134  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.132.134 
fi 
#---- ABON4053      Księżnik Łukasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.152.103 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.152.103 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.152.103  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.152.103 
fi 
#---- ABON4701      Kuczowolska Grażyna -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.44.247 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.44.247 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.44.247  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.44.247 
fi 
#---- ABON3916      Kudera Rafał -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.26.89 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.26.89 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.26.89  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.26.89 
fi 
#---- ABON0201      Kuss Bartłomiej -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.36.40 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.36.40 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.36.40  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.36.40 
fi 
#---- ABON5393      Kużdżał Marcin -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.136.213 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.136.213 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.136.213  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.136.213 
fi 
#---- ABON5444      Latusek Grzegorz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.39.113 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.39.113 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.39.113  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.39.113 
fi 
#---- ABON4015      Likus Rafał -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.208.117 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.208.117 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.208.117  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.208.117 
fi 
#---- ABON4316      Linder Dariusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.10.10 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.10.10 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.10.10  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.10.10 
fi 
#---- ABON4364      Liszka Mirosława -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.128.88 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.128.88 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.128.88  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.128.88 
fi 
#---- ABON4106      Łach Paweł -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.44.206 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.44.206 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.44.206  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.44.206 
fi 
#---- ABON3935      Łakoma Kamil -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.12.140 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.12.140 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.12.140  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.12.140 
fi 
#---- ABON3935      Łakoma Kamil -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.12.140 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.12.140 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.12.140  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.12.140 
fi 
#---- ABON3868      Macek Tomasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.153.78 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.153.78 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.153.78  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.153.78 
fi 
#---- ABON3791      Maciążek Piotr -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.244.245 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.244.245 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.244.245  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.244.245 
fi 
#---- ABON2584      Malec Irena -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.39.103 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.39.103 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.39.103  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.39.103 
fi 
#---- ABON5603      Masalska Sabina -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.39.114 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.39.114 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.39.114  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.39.114 
fi 
#---- ABON4427      Masłowska Katarzyna -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.52.131 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.52.131 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.52.131  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.52.131 
fi 
#---- ABON3518      Matura Magdalena -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.128.85 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.128.85 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.128.85  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.128.85 
fi 
#---- ABON5480      Matysiak Agnieszka -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.44.228 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.44.228 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.44.228  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.44.228 
fi 
#---- ABON4135      Michalik Sylwia -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.25.133 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.25.133 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.25.133  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.25.133 
fi 
#---- ABON0795      Morkisz Maria -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.38.73 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.38.73 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.38.73  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.38.73 
fi 
#---- ABON2722      Nawrocki Michał -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.8.150 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.8.150 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.8.150  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.8.150 
fi 
#---- ABON4306      Netreba Ireneusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.240.81 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.240.81 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.240.81  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.240.81 
fi 
#---- ABON2283      Nieborak Robert -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.242.145 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.242.145 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.242.145  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.242.145 
fi 
#---- ABON6127      Noras Agata -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.25.3 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.25.3 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.25.3  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.25.3 
fi 
#---- ABON3884      Nowak Andrzej -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.132.89 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.132.89 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.132.89  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.132.89 
fi 
#---- ABON3720      Nowak Bartłomiej -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.140.38 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.140.38 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.140.38  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.140.38 
fi 
#---- ABON2662      Nowak Dagmara -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.241.221 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.241.221 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.241.221  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.241.221 
fi 
#---- ABON3445      Nowak Marcin -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.153.38 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.153.38 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.153.38  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.153.38 
fi 
#---- ABON2831      Nowak Monika -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.36.13 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.36.13 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.36.13  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.36.13 
fi 
#---- ABON1842      Nowok Krzysztof -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.32.180 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.32.180 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.32.180  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.32.180 
fi 
#---- ABON4919      Ochmańska Ewa -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.60.179 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.60.179 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.60.179  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.60.179 
fi 
#---- ABON5855      Odrowąż Ewa -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.32.181 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.32.181 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.32.181  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.32.181 
fi 
#---- ABON4360      Odrzywolska Sylwia -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.140.118 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.140.118 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.140.118  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.140.118 
fi 
#---- ABON2708      Olbrych Anna -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.128.104 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.128.104 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.128.104  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.128.104 
fi 
#---- ABON3729      Olszowski Tomasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.26.84 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.26.84 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.26.84  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.26.84 
fi 
#---- ABON2498      Osmelak Krzysztof -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.52.164 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.52.164 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.52.164  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.52.164 
fi 
#---- ABON5243      Owczarek Robert -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.140.119 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.140.119 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.140.119  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.140.119 
fi 
#---- ABON3919      Pajączkowski Dawid -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.12.146 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.12.146 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.12.146  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.12.146 
fi 
#---- ABON4020      Pakulski Bartosz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.153.47 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.153.47 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.153.47  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.153.47 
fi 
#---- ABON4020      Pakulski Bartosz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.153.45 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.153.45 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.153.45  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.153.45 
fi 
#---- ABON4297      Palka Anna -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.9.69 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.9.69 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.9.69  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.9.69 
fi 
#---- ABON3778      Paluch Tomasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.128.139 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.128.139 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.128.139  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.128.139 
fi 
#---- ABON4969      PARGET Kowalski Michał -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.9.252 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.9.252 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.9.252  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.9.252 
fi 
#---- ABON5194      Pawlak Joanna -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.133.43 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.133.43 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.133.43  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.133.43 
fi 
#---- ABON4807      Pawlik Damian -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.9.50 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.9.50 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.9.50  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.9.50 
fi 
#---- ABON4563      Pier�g Magdalena -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.128.122 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.128.122 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.128.122  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.128.122 
fi 
#---- ABON2153      Pietryjas Łukasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.31.164 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.31.164 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.31.164  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.31.164 
fi 
#---- ABON2864      Pilarska Barbara -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.210.196 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.210.196 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.210.196  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.210.196 
fi 
#---- ABON2864      Pilarska Barbara -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.210.196 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.210.196 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.210.196  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.210.196 
fi 
#---- ABON3696      Pinkert Jadwiga -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.12.167 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.12.167 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.12.167  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.12.167 
fi 
#---- ABON2943      Piotrowska Agnieszka -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.26.73 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.26.73 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.26.73  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.26.73 
fi 
#---- ABON2943      Piotrowska Agnieszka -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.26.73 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.26.73 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.26.73  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.26.73 
fi 
#---- ABON5783      Pisarzowski Łukasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.31.178 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.31.178 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.31.178  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.31.178 
fi 
#---- ABON4555      Piwkowski Robert -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.133.25 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.133.25 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.133.25  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.133.25 
fi 
#---- ABON3930      Płatek Fatima -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.44.44 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.44.44 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.44.44  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.44.44 
fi 
#---- ABON3210      Polczyk Sebastian -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.241.1 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.241.1 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.241.1  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.241.1 
fi 
#---- ABON3741      Połoch Mirosław -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.153.73 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.153.73 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.153.73  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.153.73 
fi 
#---- ABON1925      Pomykała Mateusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.39.136 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.39.136 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.39.136  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.39.136 
fi 
#---- ABON3421      P.P.H.U. 'Alxmar' Mariola Nowak -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.241.109 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.241.109 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.241.109  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.241.109 
fi 
#---- ABON2385      Prokop-Kot Aleksandra -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.210.164 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.210.164 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.210.164  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.210.164 
fi 
#---- ABON1059      Rachel Rafał -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.132.170 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.132.170 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.132.170  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.132.170 
fi 
#---- ABON1797      Rodzyn Arkadiusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.25.38 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.25.38 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.25.38  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.25.38 
fi 
#---- ABON1797      Rodzyn Arkadiusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.136.38 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.136.38 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.136.38  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.136.38 
fi 
#---- ABON2218      Roj-Jendrysik Zuzanna -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.44.143 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.44.143 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.44.143  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.44.143 
fi 
#---- ABON1823      Romanik Wiesława -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.132.84 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.132.84 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.132.84  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.132.84 
fi 
#---- ABON4901      Romańczuk Natalia -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.31.173 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.31.173 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.31.173  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.31.173 
fi 
#---- ABON2890      Rutkowska Izabela -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.136.198 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.136.198 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.136.198  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.136.198 
fi 
#---- ABON2783      Sabel Grażyna -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.36.35 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.36.35 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.36.35  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.36.35 
fi 
#---- ABON1630      Sabel-Skolik Żaneta -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.36.36 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.36.36 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.36.36  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.36.36 
fi 
#---- ABON3900      SANESCO-MED Adam Becker -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.160.198 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.160.198 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.160.198  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.160.198 
fi 
#---- ABON4407      Sarnociński Janusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.242.57 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.242.57 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.242.57  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.242.57 
fi 
#---- ABON5091      Sidło Barbara -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.25.139 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.25.139 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.25.139  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.25.139 
fi 
#---- ABON4475      Sikora Iwona -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.26.150 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.26.150 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.26.150  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.26.150 
fi 
#---- ABON5015      Sklep Ogólnospożywczy U EWY Ewa Król -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.140.148 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.140.148 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.140.148  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.140.148 
fi 
#---- ABON4392      Skorta Mariusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.136.104 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.136.104 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.136.104  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.136.104 
fi 
#---- ABON4392      Skorta Mariusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.25.10 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.25.10 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.25.10  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.25.10 
fi 
#---- ABON3858      Sk�ra Tadeusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.133.18 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.133.18 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.133.18  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.133.18 
fi 
#---- ABON4289      Skórnóg Michał -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.44.207 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.44.207 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.44.207  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.44.207 
fi 
#---- ABON0260      Skrabarczyk Grzegorz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.136.92 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.136.92 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.136.92  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.136.92 
fi 
#---- ABON3574      Skup Złomu i Metali Paulina Śliwa -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.10.135 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.10.135 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.10.135  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.10.135 
fi 
#---- ABON4938      Słoma  Robert -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.36.174 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.36.174 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.36.174  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.36.174 
fi 
#---- ABON2881      Słowik Władysław -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.133.68 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.133.68 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.133.68  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.133.68 
fi 
#---- ABON2686      Sobczak Daria -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.136.147 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.136.147 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.136.147  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.136.147 
fi 
#---- ABON4192      Sobierajski Robert -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.210.198 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.210.198 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.210.198  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.210.198 
fi 
#---- ABON1383      Sobota Arkadiusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.136.40 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.136.40 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.136.40  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.136.40 
fi 
#---- ABON1383      Sobota Arkadiusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.25.39 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.25.39 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.25.39  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.25.39 
fi 
#---- ABON3213      Socha Marcin -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.48.6 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.48.6 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.48.6  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.48.6 
fi 
#---- ABON1833      Soja Maria -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.36.7 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.36.7 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.36.7  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.36.7 
fi 
#---- ABON2991      Sojka Magdalena -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.242.229 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.242.229 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.242.229  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.242.229 
fi 
#---- ABON0808      Solecki Przemysław -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.38.79 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.38.79 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.38.79  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.38.79 
fi 
#---- ABON4559      Sosnowski Artur -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.136.211 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.136.211 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.136.211  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.136.211 
fi 
#---- ABON5067      Sośnierz Wojciech -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.136.2 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.136.2 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.136.2  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.136.2 
fi 
#---- ABON5067      Sośnierz Wojciech -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.25.42 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.25.42 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.25.42  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.25.42 
fi 
#---- ABON4677      Stolarczyk Natalia -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.32.47 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.32.47 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.32.47  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.32.47 
fi 
#---- ABON3535      Strączek Krzysztof -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.244.161 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.244.161 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.244.161  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.244.161 
fi 
#---- ABON4356      Suder Anna -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.25.135 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.25.135 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.25.135  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.25.135 
fi 
#---- ABON1764      Sumińska Jolanta -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.44.37 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.44.37 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.44.37  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.44.37 
fi 
#---- ABON5079      SUNNY HOUSE Sp. z o.o. -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.12.216 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.12.216 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.12.216  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.12.216 
fi 
#---- ABON0558      Szczepaniak Wojciech -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.208.115 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.208.115 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.208.115  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.208.115 
fi 
#---- ABON3887      Szczerbiński Krzysztof -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.146.3 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.146.3 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.146.3  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.146.3 
fi 
#---- ABON3466      Szczyrba Jarosław -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.38.82 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.38.82 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.38.82  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.38.82 
fi 
#---- ABON2672      Szubis Łukasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.240.49 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.240.49 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.240.49  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.240.49 
fi 
#---- ABON2495      Szymczyk Karolina -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.31.175 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.31.175 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.31.175  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.31.175 
fi 
#---- ABON6157      Szymiec Damian -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.27.38 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.27.38 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.27.38  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.27.38 
fi 
#---- ABON2897      Szyndler Jacek -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.36.37 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.36.37 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.36.37  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.36.37 
fi 
#---- ABON4267      Śmigielski Sławomir -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.240.181 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.240.181 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.240.181  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.240.181 
fi 
#---- ABON4476      Świerczek Kamil -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.38.52 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.38.52 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.38.52  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.38.52 
fi 
#---- ABON5920      Świerguła Gabriela -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.133.70 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.133.70 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.133.70  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.133.70 
fi 
#---- ABON3353      Świtka Łukasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.24.28 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.24.28 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.24.28  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.24.28 
fi 
#---- ABON4031      TALCO Sp. z o.o. -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.244.221 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.244.221 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.244.221  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.244.221 
fi 
#---- ABON4166      TYNKSYSTEM Julia Tarnowska -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.26.97 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.26.97 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.26.97  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.26.97 
fi 
#---- ABON3566      Urbaniec Tomasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.136.8 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.136.8 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.136.8  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.136.8 
fi 
#---- ABON3566      Urbaniec Tomasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.25.44 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.25.44 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.25.44  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.25.44 
fi 
#---- ABON3231      Urbanik Dorota -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.241.233 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.241.233 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.241.233  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.241.233 
fi 
#---- ABON3926      Wal Izabela -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.133.28 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.133.28 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.133.28  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.133.28 
fi 
#---- ABON3806      Wasilewska Katarzyna -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.128.137 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.128.137 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.128.137  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.128.137 
fi 
#---- ABON3952      Weber Sylwester -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.8.164 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.8.164 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.8.164  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.8.164 
fi 
#---- ABON4429      Wencel Tomasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.24.208 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.24.208 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.24.208  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.24.208 
fi 
#---- ABON5045      Wilcke Beata -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.60.245 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.60.245 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.60.245  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.60.245 
fi 
#---- ABON2459      Wilczewski Rafał -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.40.24 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.40.24 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.40.24  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.40.24 
fi 
#---- ABON0737      Wojtyczka Michał -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.44.152 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.44.152 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.44.152  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.44.152 
fi 
#---- ABON0863      Wójcik Sławomir -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.132.35 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.132.35 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.132.35  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.132.35 
fi 
#---- ABON3794      Wrona Anna -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.132.52 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.132.52 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.132.52  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.132.52 
fi 
#---- ABON3774      Wr�bel Magdalena -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.8.163 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.8.163 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.8.163  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.8.163 
fi 
#---- ABON1864      Zawadka Łukasz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.160.130 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.160.130 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.160.130  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.160.130 
fi 
#---- ABON4083      Zawadzki Janusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.136.4 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.136.4 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.136.4  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.136.4 
fi 
#---- ABON4083      Zawadzki Janusz -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.136.4 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.136.4 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.136.4  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.136.4 
fi 
#---- ABON3859      Zbierański Robert -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.39.108 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.39.108 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.39.108  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.39.108 
fi 
#---- ABON4226      Zimnowicz Piotr -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.128.102 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.128.102 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.128.102  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.128.102 
fi 
#---- ABON2691      Zygmuntowicz Danuta -------------------------------------------------------------------------------------------------------# 
if   $IPS -T HOSTS_ACCEPT_108  10.8.26.184 > /dev/null 2> /dev/null 
then $IPS -D HOSTS_ACCEPT_108  10.8.26.184 
fi 
if ! $IPS -T HOSTS_DROP_108  10.8.26.184  > /dev/null 2> /dev/null 
then $IPS -A HOSTS_DROP_108  10.8.26.184 
fi 
