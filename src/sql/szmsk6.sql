
create table TRASY 
(
    id_ts	char(6)		not null,	
    opis	varchar(50)	not null,
    km		int		not null,
    primary key (id_ts)
);

create table JAZDY
(
    id_jzd	varchar(7)	not null,
    data	date		not null,
    id_ts	varchar(6)	not null,
    nr_rej	char(7)		not null,
    id_cel      char(6)         not null,
        
    primary key (id_jzd),
    foreign key (id_ts)  references TRASY   (id_ts)  on update cascade on delete no action,
    foreign key (id_cel) references CELE    (id_cel) on update cascade on delete no action,
    foreign key (nr_rej) references POJAZDY (nr_rej) on update cascade on delete no action
                
);

create table CELE
(
    id_cel	char(6)		not null,  
    opis	varchar(30),
    
    primary key(id_cel)
);

create table POJAZDY
(
    nr_rej	char(7)		not null,
    marka	varchar(15)	not null,
    model	varchar(15)	not null,
    poj		int,	
    vin		varchar(20),
    
    primary key (nr_rej)
);


create table KOSZTY_EKS_POJAZDU
(
    nr_dz	varchar(15) 	not null,
    opis	varchar(50),
    nr_rej	char(7),
    
    foreign key (nr_rej) references POJAZDY (nr_rej) on update cascade on delete no action    
);
