#!/bin/bash
source /etc/conf

NAT0=/etc/nat/sh/nat-lan-00.sh
ARPTABLES=/etc/nat/sh/arptables.sh
DHCP=/etc/dhcpd.conf
HOSTS=/etc/hosts

HFSCD0=/etc/hfsc/hfsc-down-00.sh
HFSCU0=/etc/hfsc/hfsc-up-00.sh
ITF=/etc/nat/sh/itf-users.sh
INFO=/etc/nat/sh/info.sh
INFO_OFF=/etc/nat/sh/info_off.sh

BAJT_LAN1=0
BAJT_LAN2=8
BAJT_LAN3=16
BAJT_LAN4=24
BAJT_LAN5=254

PIOCHNET_BAJT=22


brama29 ()
{
    let "c = $1 / 8"
    let "b = $c * 8 +6"
    return $b
}
                
# Enable internet for user
masq()
{                                                                                                                                                                                                                                                                                                                                                           
    if [  ! $2 == "NULL" ];
        then m="-m mac --mac-source $2"
        else m=""
    fi
			    
    echo '$IPT -A INPUT  ' $m -s $1 -j ACCEPT >> $4
    echo '$IPT -A FORWARD' $m -s $1 -j ACCEPT >> $4
    echo '$IPT -A FORWARD' -d $1 -j ACCEPT >> $4
    

    if [ ! $3 == '$IP_NAT' ];
	then 
	    echo '$IPT -t nat -A POSTROUTING -s '$1' -o $IF_WAN0 -d ! $N_WAN0 -j SNAT --to '$3 >> $4
	    echo '$IPT -t nat -A PREROUTING -d' $3 '-j DNAT --to '$1 >> $4
    fi
}		      

arptables()
{
    echo -e "#---- $2 -----------------------------------------------------------------" >> $ARPTABLES 
    echo 'arptables -A INPUT -i $IF_LAN --source-mac '$1' -j ACCEPT' >> $ARPTABLES 
}

interfaces()
{
    echo -e 'ifconfig '$3:$1 "\t" $2 "\t \t" 'netmask '$4  >> $ITF
}


# Redirect to proxy
proxy ()
{
    if [  ! $2 == "NULL" ];
        then m="-m mac --mac-source $2"
        else m=""
    fi

			
    echo '$IPT -t nat -A PREROUTING' $m -s $1 -p tcp -m multiport --dports 80,8080 -d '$IP_LAN0' -j RETURN >> $3
    echo '$IPT -t nat -A PREROUTING' $m -s $1 -p tcp -m multiport --dports 80,8080 -j DNAT --to '$IP_LAN0:8080' >> $3
}

bez_proxy()
{
    if [  ! $2 == "NULL" ];
        then m="-m mac --mac-source $2"
        else m=""
    fi
			
 echo '$IPT -t nat -A PREROUTING' $m -s $1 -p tcp -m multiport --dports 80,8080 -j RETURN >> $3
}



wylacz_net()
{

    if [  ! $2 == "NULL" ];
        then m="-m mac --mac-source $2"
        else m=""
    fi
			
    #echo '$IPT -I FORWARD' $m -s $1 -d ! $IP_LAN -j DROP >> $3
    echo '$IPT -I FORWARD' $m -s $1 -j DROP >> $3
    echo '$IPT' -t nat -A PREROUTING -s $1 -p tcp -m multiport --dports 80,8080 -j DNAT --to '$IP_LAN_WWW:8083' >> $3

}       

info()
{
    if [  ! $2 == "NULL" ];
            then m="-m mac --mac-source $2"
        else m=""
    fi
    echo -e "#---- $3 -------------------------------------------------------------------------------------------------------#"         >> $INFO
    echo '$IPT' -t nat -I PREROUTING -s $1 -p tcp -m multiport --dports 80,8080 -j DNAT --to '$IP_LAN_WWW:8085' >> $INFO

    echo -e "#---- $3 -------------------------------------------------------------------------------------------------------#"         >> $INFO_OFF
    echo '$IPT' -t nat -D PREROUTING -s $1 -p tcp -m multiport --dports 80,8080 -j DNAT --to '$IP_LAN_WWW:8085' >> $INFO_OFF
	
}

statistics()
{
#	echo -e '$IPT -A proxy_in_counter -d '$1 	>> $CNT
#	echo -e '$IPT -A proxy_out_counter -s '$1	>> $CNT
	echo -e '$IPT -A COUNTER_IN -d '$1		>> $CNT
	echo -e '$IPT -A COUNTER_OUT -s '$1		>> $CNT
}



htb()
{

    B1=`echo $ip | cut -d '.' -f 1`
    B2=`echo $ip | cut -d '.' -f 2`
    B3=`echo $ip | cut -d '.' -f 3`
    B4=`echo $ip | cut -d '.' -f 4`
                    
a=`expr $B4 / 16`

if [ $a > 9 ]; then
    if [ $a == 10 ]; then
        a='A'
    elif [ $a == 11 ]; then
        a='B'
    elif [ $a == 12 ]; then
        a='C'
    elif [ $a == 13 ]; then
        a='D'
    elif [ $a == 14 ]; then
        a='E'
    elif [ $a == 15 ]; then
        a='F'
    fi
fi

b=`expr $B4 % 16`
    if [ $b > 9 ]; then
        if [ $b == 10 ]; then
            b='A'
        elif [ $b == 11 ]; then
            b='B'
        elif [ $b == 12 ]; then
            b='C'
        elif [ $b == 13 ]; then
	    b='D'
        elif [ $b == 14 ]; then
            b='E'
        elif [ $b == 15 ]; then
            b='F'
        fi
    fi
                                                                                                                                                        
                                                        	                
        if [ $B2 -ge $BAJT_LAN1 ] && [ $B2 -lt $BAJT_LAN2 ] ; then
            classid=1
            hfsc_file=$HFSCD0
            classidup=1
            hfscup_file=$HFSCU0
            iflan='$IF_LAN0'
            ifin='$IF_IN0'
            
            if [ $B2 -eq 0 ] && [ $B3 -eq 0 ]; then
                ht=2:0x$a$b
            elif [ $B2 -eq 0 ] && [ $B3 -eq 1 ]; then
                ht=3:0x$a$b
            elif [ $B2 -eq 0 ] && [ $B3 -eq 2 ]; then
                ht=4:0x$a$b
            elif [ $B2 -eq 0 ] && [ $B3 -eq 3 ]; then
                ht=5:0x$a$b
            elif [ $B2 -eq 0 ] && [ $B3 -eq 4 ]; then
                ht=6:0x$a$b
            elif [ $B2 -eq 0 ] && [ $B3 -eq 5 ]; then
               ht=7:0x$a$b
           elif [  $B2 -eq 0 ] && [ $B3 -eq 6 ]; then
               ht=8:0x$a$b
           elif [  $B2 -eq 0 ] && [ $B3 -eq 7 ]; then
              ht=9:0x$a$b
           elif [  $B2 -eq 0 ] && [ $B3 -eq 8 ]; then
             ht=10:0x$a$b
            elif [  $B2 -eq 0 ] && [ $B3 -eq 9 ]; then
              ht=11:0x$a$b
             elif [  $B2 -eq 0 ] && [ $B3 -eq 10 ]; then
               ht=12:0x$a$b
          elif [  $B2 -eq 0 ] && [ $B3 -eq 11 ]; then
                ht=13:0x$a$b
												    
          elif [  $B2 -eq 1 ] && [ $B3 -eq 0 ]; then
             ht=30:0x$a$b
            elif [ $B2 -eq 1 ] && [ $B3 -eq 1 ]; then
                ht=31:0x$a$b
            elif [ $B2 -eq 1 ] && [ $B3 -eq 2 ]; then
                ht=32:0x$a$b
            elif [ $B2 -eq 1 ] && [ $B3 -eq 3 ]; then
                ht=33:0x$a$b
            elif [ $B2 -eq 1 ] && [ $B3 -eq 4 ]; then
                ht=34:0x$a$b
            elif [ $B2 -eq 1 ] && [ $B3 -eq 5 ]; then
               ht=35:0x$a$b
          elif [  $B2 -eq 1 ] && [ $B3 -eq 6 ]; then
                 ht=36:0x$a$b
            elif [  $B2 -eq 1 ] && [ $B3 -eq 7 ]; then
              ht=37:0x$a$b
            elif [  $B2 -eq 1 ] && [ $B3 -eq 8 ]; then
               ht=38:0x$a$b
	    elif [  $B2 -eq 1 ] && [ $B3 -eq 9 ]; then
                  ht=39:0x$a$b
            elif [  $B2 -eq 1 ] && [ $B3 -eq 10 ]; then
                  ht=40:0x$a$b
            elif [  $B2 -eq 1 ] && [ $B3 -eq 11 ]; then
                  ht=41:0x$a$b
            elif [  $B2 -eq 1 ] && [ $B3 -eq 12 ]; then
                  ht=42:0x$a$b
            elif [  $B2 -eq 1 ] && [ $B3 -eq 13 ]; then
                  ht=43:0x$a$b
            elif [  $B2 -eq 1 ] && [ $B3 -eq 14 ]; then
                  ht=44:0x$a$b
            elif [  $B2 -eq 1 ] && [ $B3 -eq 15 ]; then
        	ht=45:0x$a$b
            elif [  $B2 -eq 1 ] && [ $B3 -eq 16 ]; then
                  ht=46:0x$a$b
          elif [  $B2 -eq 1 ] && [ $B3 -eq 17 ]; then
                ht=47:0x$a$b
            elif [  $B2 -eq 1 ] && [ $B3 -eq 18 ]; then
              ht=48:0x$a$b
           elif [  $B2 -eq 1 ] && [ $B3 -eq 19 ]; then
	        ht=49:0x$a$b                                                                                                                                                                                    
            elif [  $B2 -eq 1 ] && [ $B3 -eq 20 ]; then
                  ht=50:0x$a$b
              elif [  $B2 -eq 1 ] && [ $B3 -eq 21 ]; then
                ht=51:0x$a$b
            elif [  $B2 -eq 1 ] && [ $B3 -eq 22 ]; then
                  ht=52:0x$a$b
              elif [  $B2 -eq 1 ] && [ $B3 -eq 23 ]; then
                ht=53:0x$a$b
            elif [  $B2 -eq 1 ] && [ $B3 -eq 24 ]; then
              ht=54:0x$a$b
          elif [  $B2 -eq 1 ] && [ $B3 -eq 25 ]; then
              ht=55:0x$a$b
          elif [  $B2 -eq 1 ] && [ $B3 -eq 26 ]; then
            ht=56:0x$a$b
          elif [  $B2 -eq 1 ] && [ $B3 -eq 27 ]; then
              ht=57:0x$a$b
          elif [  $B2 -eq 1 ] && [ $B3 -eq 28 ]; then
            ht=58:0x$a$b
           elif [  $B2 -eq 1 ] && [ $B3 -eq 29 ]; then
               ht=59:0x$a$b
                                                                                                                                                                                                                                                                                                            
            elif [ $B2 -eq 2 ] && [ $B3 -eq 0 ]; then
                ht=60:0x$a$b
            elif [ $B2 -eq 2 ] && [ $B3 -eq 1 ]; then
                ht=61:0x$a$b
            elif [ $B2 -eq 2 ] && [ $B3 -eq 2 ]; then
                ht=62:0x$a$b
            elif [ $B2 -eq 2 ] && [ $B3 -eq 3 ]; then
                ht=63:0x$a$b
            elif [ $B2 -eq 2 ] && [ $B3 -eq 4 ]; then
               ht=64:0x$a$b
          elif [  $B2 -eq 2 ] && [ $B3 -eq 5 ]; then
             ht=65:0x$a$b
            elif [  $B2 -eq 2 ] && [ $B3 -eq 6 ]; then
              ht=66:0x$a$b
            elif [  $B2 -eq 2 ] && [ $B3 -eq 7 ]; then
              ht=67:0x$a$b

            elif [  $B2 -eq 3 ] && [ $B3 -eq 0 ]; then
                ht=90:0x$a$b
            elif [  $B2 -eq 3 ] && [ $B3 -eq 1 ]; then
                ht=91:0x$a$b
            elif [  $B2 -eq 3 ] && [ $B3 -eq 2 ]; then
                ht=92:0x$a$b
            elif [  $B2 -eq 3 ] && [ $B3 -eq 3 ]; then
                ht=93:0x$a$b
            elif [  $B2 -eq 3 ] && [ $B3 -eq 4 ]; then
                ht=94:0x$a$b
            elif [  $B2 -eq 3 ] && [ $B3 -eq 5 ]; then
                ht=95:0x$a$b
            elif [  $B2 -eq 3 ] && [ $B3 -eq 6 ]; then
                ht=96:0x$a$b
            elif [  $B2 -eq 3 ] && [ $B3 -eq 7 ]; then
                ht=97:0x$a$b
            elif [  $B2 -eq 3 ] && [ $B3 -eq 8 ]; then
                ht=98:0x$a$b
            elif [  $B2 -eq 3 ] && [ $B3 -eq 9 ]; then
                ht=99:0x$a$b
            elif [  $B2 -eq 3 ] && [ $B3 -eq 10 ]; then
                ht=100:0x$a$b
            elif [  $B2 -eq 3 ] && [ $B3 -eq 11 ]; then
                ht=101:0x$a$b
            elif [  $B2 -eq 3 ] && [ $B3 -eq 12 ]; then
                ht=102:0x$a$b
            elif [  $B2 -eq 3 ] && [ $B3 -eq 13 ]; then
                ht=103:0x$a$b
                                                                                                                                                                                                                                                                                                                                                            
            elif [  $B2 -eq 4 ] && [ $B3 -eq 0 ]; then
                ht=120:0x$a$b
            elif [  $B2 -eq 4 ] && [ $B3 -eq 1 ]; then
                ht=121:0x$a$b
            elif [  $B2 -eq 4 ] && [ $B3 -eq 2 ]; then
                ht=122:0x$a$b
            elif [  $B2 -eq 4 ] && [ $B3 -eq 3 ]; then
                ht=123:0x$a$b
            elif [  $B2 -eq 4 ] && [ $B3 -eq 4 ]; then
                ht=124:0x$a$b
            elif [  $B2 -eq 4 ] && [ $B3 -eq 5 ]; then
                ht=125:0x$a$b
            elif [  $B2 -eq 4 ] && [ $B3 -eq 6 ]; then
                ht=126:0x$a$b
            elif [  $B2 -eq 4 ] && [ $B3 -eq 7 ]; then
                ht=127:0x$a$b
            elif [  $B2 -eq 4 ] && [ $B3 -eq 8 ]; then
                ht=128:0x$a$b
            elif [  $B2 -eq 4 ] && [ $B3 -eq 9 ]; then
                ht=129:0x$a$b
            elif [  $B2 -eq 4 ] && [ $B3 -eq 10 ]; then
                ht=130:0x$a$b
            elif [  $B2 -eq 4 ] && [ $B3 -eq 11 ]; then
                ht=131:0x$a$b
            elif [  $B2 -eq 4 ] && [ $B3 -eq 12 ]; then
                ht=132:0x$a$b
            elif [  $B2 -eq 4 ] && [ $B3 -eq 13 ]; then
                ht=133:0x$a$b
	    elif [  $B2 -eq 4 ] && [ $B3 -eq 14 ]; then
		ht=134:0x$a$b
            elif [  $B2 -eq 4 ] && [ $B3 -eq 15 ]; then
              ht=135:0x$a$b
            elif [  $B2 -eq 4 ] && [ $B3 -eq 16 ]; then
              ht=136:0x$a$b
            elif [  $B2 -eq 4 ] && [ $B3 -eq 17 ]; then
              ht=137:0x$a$b
            elif [  $B2 -eq 4 ] && [ $B3 -eq 18 ]; then
              ht=138:0x$a$b
             elif [  $B2 -eq 4 ] && [ $B3 -eq 19 ]; then
              ht=139:0x$a$b
	    elif [  $B2 -eq 4 ] && [ $B3 -eq 20 ]; then
                ht=140:0x$a$b
            elif [  $B2 -eq 4 ] && [ $B3 -eq 21 ]; then
                ht=141:0x$a$b
            elif [  $B2 -eq 4 ] && [ $B3 -eq 22 ]; then
                ht=142:0x$a$b
            elif [  $B2 -eq 4 ] && [ $B3 -eq 23 ]; then
                ht=143:0x$a$b
            elif [  $B2 -eq 4 ] && [ $B3 -eq 24 ]; then
                ht=144:0x$a$b
            elif [  $B2 -eq 4 ] && [ $B3 -eq 25 ]; then
                  ht=145:0x$a$b
          elif [  $B2 -eq 4 ] && [ $B3 -eq 26 ]; then
                    ht=146:0x$a$b
            elif [  $B2 -eq 4 ] && [ $B3 -eq 27 ]; then
              ht=147:0x$a$b
          elif [  $B2 -eq 4 ] && [ $B3 -eq 28 ]; then
                ht=148:0x$a$b
         elif [  $B2 -eq 4 ] && [ $B3 -eq 29 ]; then
               ht=149:0x$a$b
       fi                                  
	
  
	fi               
	                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
    classid_up=15
																							      
    i=$5
    i2=$(($5+3000))
    i3=$(($5+5000))
    i4=$(($5+7000))
    

    m=$6
    mm=$(($6+4000))
    

    if [ "$3" == MINO ]; then
	CEILD='$MINO_D'
	CEILU='$MINO_U'
	CEIL_P2P='$P2P1'
    elif [ "$3" == MINL ]; then
        CEILD='$MINL_D'
        CEILU='$MINL_U'
        CEIL_P2P='$P2P1'
    elif [ "$3" == STDL ]; then
        CEILD='$STDL_D'
        CEILU='$STDL_U'
        CEIL_P2P='$P2P2'
    elif [ "$3" == MEDL ]; then
        CEILD='$MEDL_D'
	CEILU='$MEDL_U'
	CEIL_P2P='$P2P3'
    elif [ "$3" == OPTL ]; then
        CEILD='$OPTL_D'
	CEILU='$OPTL_U'
	CEIL_P2P='$P2P4'
    elif [ "$3" == MINK ]; then
        CEILD='$MINK_D'
        CEILU='$MINK_U'
        CEIL_P2P='$P2P11'
    elif [ "$3" == STDK ]; then
        CEILD='$STDK_D'
        CEILU='$STDK_U'
        CEIL_P2P='$P2P12'
    elif [ "$3" == MEDK ]; then
        CEILD='$MEDK_D'
        CEILU='$MEDK_U'
        CEIL_P2P='$P2P13'
    elif [ "$3" == OPTK ]; then
        CEILD='$OPTK_D'
        CEILU='$OPTK_U'
        CEIL_P2P='$P2P14'                                                                                                            
    elif [ "$3" == P1000 ]; then
        CEILD='$P1000_D'
        CEILU='$P1000_U'
        CEIL_P2P='$P2P5'                	
    elif [ "$3" == P2000 ]; then
        CEILD='$P2000_D'
        CEILU='$P2000_U'
        CEIL_P2P='$P2P6'
    elif [ "$3" == P4000 ]; then
        CEILD='$P4000_D'
        CEILU='$P4000_U'
        CEIL_P2P='$P2P15'
    elif [ "$3" == P6000 ]; then
        CEILD='$P6000_D'
        CEILU='$P6000_U'
        CEIL_P2P='$P2P16'
    elif [ "$3" == P8000 ]; then
        CEILD='$P8000_D'
        CEILU='$P8000_U'
        CEIL_P2P='$P2P17'                                          
    elif [ "$3" == S2000 ]; then
        CEILD='$S2000_D'
	CEILU='$S2000_U'
	CEIL_P2P='$P2P7'
    elif [ "$3" == S3000 ]; then
        CEILD='$S3000_D'
        CEILU='$S3000_U'
        CEIL_P2P='$P2P18'
    elif [ "$3" == S4000 ]; then
        CEILD='$S4000_D'
        CEILU='$S4000_U'
        CEIL_P2P='$P2P19'
    elif [ "$3" == S5000 ]; then
        CEILD='$S5000_D'
        CEILU='$S5000_U'
        CEIL_P2P='$P2P20'
                                                                                    
   elif [ "$3" == FA ]; then
       CEILD='$FA_D'
       CEILU='$FA_U'
       CEIL_P2P='$P2P8'
   elif [ "$3" == FA3MBIT ]; then
       CEILD='$FA3MBIT_D'
       CEILU='$FA3MBIT_U'
       CEIL_P2P='$P2P3MBIT'
   elif [ "$3" == FA5MBIT ]; then
       CEILD='$FA5MBIT_D'
       CEILU='$FA5MBIT_U'
       CEIL_P2P='$P2P5MBIT'
   elif [ "$3" == FA10MBIT ]; then
       CEILD='$FA10MBIT_D'
       CEILU='$FA10MBIT_U'
       CEIL_P2P='$P2P10MBIT'
		   
    fi
     		    		    
    if [ "$4" == MINO ]; then
        CEILDLAN='$MINO_D'
        CEILULAN='$MINO_U'
    elif [ "$4" == MINL ]; then
        CEILDLAN='$MINL_D'
        CEILULAN='$MINL_U'
    elif [ "$4" == STDL ]; then
        CEILDLAN='$STDL_D'
        CEILULAN='$STDL_U'
    elif [ "$4" == MEDL ]; then
	CEILDLAN='$MEDL_D'
	CEILULAN='$MEDL_U'
    elif [ "$4" == OPTL ]; then
        CEILDLAN='$OPTL_D'
	CEILULAN='$OPTL_U'
    elif [ "$4" == STDK ]; then
        CEILDLAN='$STDK_D'
	CEILULAN='$STDK_U'
    elif [ "$4" == MEDK ]; then
	CEILDLAN='$MEDK_D'
	CEILULAN='$MEDK_U'
    elif [ "$4" == OPTK ]; then
	CEILDLAN='$OPTK_D'
        CEILULAN='$OPTK_U'                                                  	
    elif [ "$4" == P1000 ]; then
        CEILDLAN='$P1000_D'
        CEILULAN='$P1000_U'
    elif [ "$4" == P2000 ]; then
        CEILDLAN='$P2000_D'
        CEILULAN='$P2000_U'
    elif [ "$4" == P4000 ]; then
        CEILDLAN='$P4000_D'
        CEILULAN='$P4000_U'
    elif [ "$4" == P6000 ]; then
        CEILDLAN='$P6000_D'
        CEILULAN='$P6000_U'
    elif [ "$4" == P8000 ]; then
        CEILDLAN='$P8000_D'
        CEILULAN='$P8000_U'                                                                
    elif [ "$4" == S2000 ]; then
        CEILDLAN='$S2000_D'
        CEILULAN='$S2000_U'
    elif [ "$4" == S3000 ]; then
        CEILDLAN='$S3000_D'
        CEILULAN='$S3000_U'
    elif [ "$4" == S4000 ]; then
        CEILDLAN='$S4000_D'
        CEILULAN='$S4000_U'
    elif [ "$4" == S5000 ]; then
        CEILDLAN='$S5000_D'
        CEILULAN='$S5000_U'     
    elif [ "$4" == FA ]; then
        CEILDLAN='$FA_D'
        CEILULAN='$FA_U'		    
    elif [ "$4" == FA3MBIT ]; then
        CEILDLAN='$FA3MBIT_D'
        CEILULAN='$FA3MBIT_U'		    
    elif [ "$4" == FA5MBIT ]; then
        CEILDLAN='$FA5MBIT_D'
        CEILULAN='$FA5MBIT_U'		    
    elif [ "$4" == FA10MBIT ]; then
        CEILDLAN='$FA10MBIT_D'
        CEILULAN='$FA10MBIT_U'		    

    fi
															    
    
    echo -e "#---- $1 -------------------------------------------------------------------------------------------#"		 		>> $hfsc_file
    echo -e 'tc class add dev  '$iflan' parent '$classid':1000 classid '$classid':'$i' hfsc ls m2 1kbit ul m2 '$CEILDLAN 			>> $hfsc_file
    echo -e 'tc filter add dev '$iflan' protocol ip parent 1:0 prio 4 u32 ht '$ht' match ip src $IP_LAN match ip dst '$2' flowid '$classid':'$i >> $hfsc_file


    echo -e 'tc qdisc add dev  '$iflan' parent '$classid':'$i' pfifo limit 128' 								>> $hfsc_file



# Opcja Minl
    echo -e 'tc class add dev  '$iflan' parent '$classid':4000 classid '$classid':'$i2' hfsc ls m2 1kbit ul m2 '$CEILD              >> $hfsc_file
    
    echo -e 'tc class add dev  '$iflan' parent '$classid':'$i2' classid '$classid':'$i3' hfsc ls m2 1kbit ul m2 '$CEILD                                    >> $hfsc_file
    echo -e 'tc filter add dev '$iflan' protocol ip parent 1:0 prio 4 u32 ht '$ht' match ip dst '$2' match ip sport 80 0xffff flowid '$classid':'$i3       >> $hfsc_file
    echo -e 'tc qdisc add dev ' $iflan' parent '$classid':'$i3' pfifo limit 128'                                                                           >> $hfsc_file


    echo -e 'tc class add dev  '$iflan' parent '$classid':'$i2' classid '$classid':'$i4' hfsc ls m2 1kbit ul m1 '$CEILD' d 60s m2 '$CEIL_P2P      >> $hfsc_file
    echo -e 'tc filter add dev '$iflan' protocol ip parent 1:0 prio 4 u32 ht '$ht' match ip dst '$2' flowid '$classid':'$i4                     >> $hfsc_file
    echo -e 'tc qdisc add dev ' $iflan' parent '$classid':'$i4' pfifo limit 128'                                                                >> $hfsc_file
	    	    
	    
        
    echo -e "#---- $1 -------------------------------------------------------------------------------------------#"                                  >> $hfscup_file
    echo -e 'tc class add dev '$ifin' parent '$classidup':1000 classid '$classidup':'$i' hfsc ls m2 1kbit ul m2 '$CEILULAN                              >> $hfscup_file
    echo -e 'tc filter add dev '$ifin' protocol ip parent 1:0 prio 4 u32 ht '$ht' match ip src '$2' match ip dst $IP_LAN flowid '$classidup':'$i      >> $hfscup_file

                                
    echo -e 'tc qdisc add dev '$ifin' parent '$classidup':'$i' pfifo limit 128'                                                                       >> $hfscup_file

    echo -e 'tc class add dev '$ifin' parent '$classidup':4000 classid '$classidup':'$i2' hfsc ls m2 1kbit ul m2 '$CEILU                                >> $hfscup_file
    echo -e 'tc filter add dev '$ifin' protocol ip parent 1:0 prio 4 u32 ht '$ht' match ip src '$2' flowid '$classidup':'$i2                           >> $hfscup_file
    echo -e 'tc qdisc add dev '$ifin' parent '$classidup':'$i2' pfifo limit 128' 								     >> $hfscup_file
				    
}


dansguardian()
{

    echo $1 >> $DANS
}


generate ()
{
echo " Generating config files for \"$1\" ..."
cfg=$1
i=$2
j=$3
k=$4
OLD_BAJT=`cat /tmp/byte`
OLD_BAJT2=`cat /tmp/byte2`
while read host mac ip ipzewn netdown landown dhcp powiaz net cache dg info
    do
	if [ "$host" != "" ] && [ "$host" != "[HOST]" ]; then            
	    
	    echo "#---- $host ----------------------------------------------------------------------------------------------------------------------------------------#" >>$CNT
	    echo -e "$ip  \t  $host.$DOMAIN2         \t  $host" >> $HOSTS

	    B1=`echo $ip | cut -d '.' -f 1`	
	    B2=`echo $ip | cut -d '.' -f 2`
	    B3=`echo $ip | cut -d '.' -f 3`
	    B4=`echo $ip | cut -d '.' -f 4`
                
		

 			nat_file=$NAT0
        
	    
        echo "#---- $host ----------------------------------------------------------------------------------------------------------------------------------------#" >>$nat_file
            	                
	    if [ "$B2" != "$OLD_BAJT" ]; then

        	if  [ "$B2" == 0 ] || [ "$B2" == 8 ] || [ "$B2" == 16 ] || [ "$B2" == 24 ]; then    	
	            echo $B2 > /tmp/byte
							echo $B3 > /tmp/byte2
	            OLD_BAJT="$B2"
		    OLD_BAJT2="$B3"
	            echo "}" >> $DHCP
	            dhcp $B2 $B3
                                                                                                                                                                    
	        fi
    	    fi
	    
	    if [ $B1 -ne 172 ] && [ "$dhcp" == "Y" ] && [ "$mac" != "ff:ff:ff:ff:ff:ff" ]; then	    		

	
                if [ $B2 -eq $BAJT_LAN1 ]; then
                    echo -e "host $host \t\t {hardware ethernet $mac; fixed-address $ip; option routers $B1.$B2.0.1; option subnet-mask 255.255.0.0;}" >> $DHCP                
	                                   	
                fi	    
	    fi
	    
	    

	    if [ "$powiaz" == "Y" ]; 
		then
		    mac_source=$mac
		else 
		    mac_source="NULL";
	    fi
	
	
    if [ "$net" == 'Y' ]; then
	    
    	if [ $B1 -ne 172 ]; then
    	    htb $host $ip $netdown $landown $i $n
	    let "i+=1"
	    let "n+=1"
	fi 

        if [ ! "$ipzewn" == '$IP_NAT' ]; then
                interfaces $k $ipzewn '$IF_WAN0' '$NETMASK_I'
                let "k+=1"
        fi                                                        
	                                       
	arptables $mac $host
	statistics $ip
        masq $ip $mac_source $ipzewn $nat_file
    
        if [ "$cache" == 'Y' ] && [ "$PROXY" == 'Y' ]; 
	    then proxy $ip $mac_source $nat_file;
	    else bez_proxy $ip $mac_source $nat_file;
    	fi
        if [ "$dg" == "N" ]; then
            dansguardian $ip;
        fi
    								
	elif [ "$net" == "N" ]; then
	    wylacz_net $ip $mac_source $nat_file;
	fi

        if [ "$info" == "Y" ]; then
            info $ip $mac $host
        fi
				    
    fi	
    
    done < $1
}

dhcp()
{
SUBNET="10.$1.$2.0"
GATE="10.$1.$2.1"
SUBNETMASK="255.255.255.0"
BROADCAST="10.$1.$2.255"
NETMASK="255.255.255.0"

if [ $1 -ge $BAJT_LAN1 ] && [ $1 -lt $BAJT_LAN2 ]; then
    echo -e "subnet 10.0.0.0 netmask 255.255.0.0                                  " >> $DHCP
    echo -e "{                                                                     " >> $DHCP
    echo -e "deny unknown-clients;                                                 " >> $DHCP
    echo -e "default-lease-time           216000;  #259200;  # 3 x 24 h            " >> $DHCP
    echo -e "max-lease-time               432000; #604800;  # 7 x 24 h             " >> $DHCP
    echo -e 'option domain-name           "netico.pl";                         '     >> $DHCP
    echo -e "option domain-name-servers   $DNS1, $DNS2; "     >> $DHCP
    echo -e "option subnet-mask           255.255.255.0;                           " >> $DHCP
                            
fi

echo -e "                                                                     " >> $DHCP
}



hfsc_head()
{

echo -e '#!/bin/bash' > $1
echo -e 'source /etc/conf' >> $1
echo -e 'source /etc/conf-pakiety' >> $1

echo -e "tc qdisc del dev $2 root 1> /dev/null &2>1" >> $1
echo -e "tc qdisc add dev $2 root handle 1:0  hfsc default 9999" >> $1
echo -e "tc filter add dev $2 parent 1:0 protocol ip u32" >> $1

echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 2:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 3:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 4:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 5:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 6:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 7:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 8:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 9:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 10:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 11:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 12:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 13:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 14:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 15:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 16:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 17:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 18:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 19:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 20:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 21:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 22:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 23:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 24:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 25:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 26:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 27:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 28:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 29:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 30:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 31:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 32:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 33:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 34:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 35:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 36:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 37:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 38:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 39:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 40:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 41:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 42:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 43:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 44:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 45:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 46:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 47:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 48:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 49:0 protocol ip u32 divisor 256" >> $1
echo -e "tc filter add dev $2 parent 1:0 prio 2 handle 50:0 protocol ip u32 divisor 256" >> $1




if [ $2 == '$IF_LAN0' ]; then
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.0.0/24 hashkey mask 0x000000ff at 16 link 2:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.1.0/24 hashkey mask 0x000000ff at 16 link 3:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.2.0/24 hashkey mask 0x000000ff at 16 link 4:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.3.0/24 hashkey mask 0x000000ff at 16 link 5:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.4.0/24 hashkey mask 0x000000ff at 16 link 6:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.5.0/24 hashkey mask 0x000000ff at 16 link 7:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.6.0/24 hashkey mask 0x000000ff at 16 link 8:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.7.0/24 hashkey mask 0x000000ff at 16 link 9:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.8.0/24 hashkey mask 0x000000ff at 16 link 10:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.9.0/24 hashkey mask 0x000000ff at 16 link 11:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.10.0/24 hashkey mask 0x000000ff at 16 link 12:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.11.0/24 hashkey mask 0x000000ff at 16 link 13:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.12.0/24 hashkey mask 0x000000ff at 16 link 14:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.13.0/24 hashkey mask 0x000000ff at 16 link 15:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.14.0/24 hashkey mask 0x000000ff at 16 link 16:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.15.0/24 hashkey mask 0x000000ff at 16 link 17:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.16.0/24 hashkey mask 0x000000ff at 16 link 18:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.17.0/24 hashkey mask 0x000000ff at 16 link 19:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.18.0/24 hashkey mask 0x000000ff at 16 link 20:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.19.0/24 hashkey mask 0x000000ff at 16 link 21:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.20.0/24 hashkey mask 0x000000ff at 16 link 22:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.21.0/24 hashkey mask 0x000000ff at 16 link 23:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.22.0/24 hashkey mask 0x000000ff at 16 link 24:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.23.0/24 hashkey mask 0x000000ff at 16 link 25:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.24.0/24 hashkey mask 0x000000ff at 16 link 26:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.25.0/24 hashkey mask 0x000000ff at 16 link 27:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.26.0/24 hashkey mask 0x000000ff at 16 link 28:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip dst 10.0.27.0/24 hashkey mask 0x000000ff at 16 link 29:0" >> $1



elif [ $2 == '$IF_IN0' ]; then
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.0.0/24 hashkey mask 0x000000ff at 12 link 2:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.1.0/24 hashkey mask 0x000000ff at 12 link 3:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.2.0/24 hashkey mask 0x000000ff at 12 link 4:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.3.0/24 hashkey mask 0x000000ff at 12 link 5:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.4.0/24 hashkey mask 0x000000ff at 12 link 6:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.5.0/24 hashkey mask 0x000000ff at 12 link 7:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.6.0/24 hashkey mask 0x000000ff at 12 link 8:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.7.0/24 hashkey mask 0x000000ff at 12 link 9:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.8.0/24 hashkey mask 0x000000ff at 12 link 10:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.9.0/24 hashkey mask 0x000000ff at 12 link 11:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.10.0/24 hashkey mask 0x000000ff at 12 link 12:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.11.0/24 hashkey mask 0x000000ff at 12 link 13:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.12.0/24 hashkey mask 0x000000ff at 12 link 14:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.13.0/24 hashkey mask 0x000000ff at 12 link 15:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.14.0/24 hashkey mask 0x000000ff at 12 link 16:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.15.0/24 hashkey mask 0x000000ff at 12 link 17:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.16.0/24 hashkey mask 0x000000ff at 12 link 18:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.17.0/24 hashkey mask 0x000000ff at 12 link 19:0" >> $1

echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.18.0/24 hashkey mask 0x000000ff at 12 link 20:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.19.0/24 hashkey mask 0x000000ff at 12 link 21:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.20.0/24 hashkey mask 0x000000ff at 12 link 22:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.21.0/24 hashkey mask 0x000000ff at 12 link 23:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.22.0/24 hashkey mask 0x000000ff at 12 link 24:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.23.0/24 hashkey mask 0x000000ff at 12 link 25:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.24.0/24 hashkey mask 0x000000ff at 12 link 26:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.25.0/24 hashkey mask 0x000000ff at 12 link 27:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.26.0/24 hashkey mask 0x000000ff at 12 link 28:0" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 2 u32 ht 800:: match ip src 10.0.27.0/24 hashkey mask 0x000000ff at 12 link 29:0" >> $1



echo -e "tc class add dev $2 parent 1:0 classid $3:1 hfsc ls m2 90Mbit ul m2 90Mbit" >> $1

echo -e "tc class add dev $2 parent 1:0 classid $3:2 hfsc ls m2 10Mbit ul m2 10Mbit" >> $1

echo -e "tc class add dev $2 parent $3:1 classid $3:1000 hfsc ls m2 90Mbit ul m2 90Mbit" >> $1
echo -e "tc class add dev $2 parent $3:1 classid $3:4000 hfsc ls m2 70Mbit ul m2 70Mbit" >> $1

echo -e "tc class add dev $2 parent $3:1 classid $3:9999 hfsc ls m2 256kbit" >> $1
echo -e "tc filter add dev $2 protocol ip parent 1:0 prio 3 u32 match ip protocol 1 0xff flowid $3:2" >> $1

}

mkfiles()
{
rm $1; touch $1; chmod 744 $1
}

#---- Main program ---------------------------------------------------------------------------

ACTIVE=`cat /tmp/active`
if [ $ACTIVE == 0 ]; then
    echo '1' > /tmp/active

i=1001
l=4001
j=10
k=10

#rm $DANS; touch $DANS

mkfiles $ARPTABLES

mkfiles $NAT0; 

mkfiles $INFO
mkfiles $INFO_OFF

rm $DHCP

mkfiles $HFSCD0
mkfiles $HFSCU0
mkfiles $ITF


#echo ------------------------------------------------------------------
echo -e 'AUTHORITATIVE;'                > $DHCP
echo -e "ddns-update-style ad-hoc;    " >>  $DHCP
echo '32' > /tmp/byte
echo '0' > /tmp/byte2

dhcp 32 0

echo -e "127.0.0.1  \t  localhost                  	    "  > $HOSTS
echo -e "$IP_LAN0  \t  $HOSTNAME.$DOMAIN2  \t  $HOSTNAME  " >> $HOSTS
echo -e "$IP_INET1 \t  w3cache1.$DOMAIN2  \t  quark  " >> $HOSTS

echo -e "#!/bin/bash" 		>  $NAT0
echo -e "source /etc/conf" 	>> $NAT0

hfsc_head $HFSCD0  '$IF_LAN0'  1

hfsc_head $HFSCU0   '$IF_IN0'    1

echo -e "#!/bin/bash"           >  $INFO
echo -e "source /etc/conf"      >> $INFO

echo -e "#!/bin/bash"           >  $INFO_OFF
echo -e "source /etc/conf"      >> $INFO_OFF


echo -e 'source /etc/conf' >> $ARPTABLES
echo -e 'arptables -F' >> $ARPTABLES
echo -e 'arptables -A INPUT -i $IF_LAN -s 192.168.0.0/16 -j ACCEPT' >>  $ARPTABLES
echo -e 'arptables -A INPUT -i $IF_LAN -s 194.145.184.0/21 -j ACCEPT' >> $ARPTABLES
echo -e 'arptables -A INPUT -i $IF_LAN -s 172.16.0.0/12 -j ACCEPT' >> $ARPTABLES


echo ""

echo -e "#!/bin/bash"           >  $ITF
echo -e "source /etc/conf"      >> $ITF


generate /etc/nat/cfg.komputery $i $j $k


echo -e "}" >> $DHCP


#/etc/nat/sh/arptables.sh
echo " Reconfiguring Aliases ..."
/etc/nat/sh/itf-users.sh

echo " Restarting DHCP ..."
echo ""
/etc/rc.d/rc.dhcpd restart

echo " Restarting NAT ..."
/etc/nat/rc.masq

echo "Restarting  H F S C"
/etc/hfsc/rc.hfsc

#/etc/rc.d/rc.dansguardian restart 1>/dev/null 2>&1
echo '0' > /tmp/active
else
    echo ''
    echo " Jest juz uruchomiona jedna instancja generatora."
    echo " Czekaj az zostanie zakonczona."
    echo ''
fi
