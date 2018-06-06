create table KOMPUTERY
	(
	ID_KOMP		varchar(13)	not null,
	NAZWA_SMB	varchar(16),
	SYSTEM		varchar(30),

	ID_KONF		varchar(13)	not null,
	ID_TARYFY	varchar(13)	not null,
	ID_ABON		varchar(13)	not null,

	primary key (ID_KOMP),
	foreign key (ID_TARYFY) references TOWARY_SPRZEDAZ(ID_TOWS) on update cascade on delete no action
	);


create table ADRESY_IP
	(
	IP		varchar(15)	not null,
	ID_URZ		varchar(13)	not null,

	foreign key (ID_URZ) references KOMPUTERY(ID_KOMP) on update cascade on delete no action
	);


create table ADRESY_FIZYCZNE
	(
	MAC	char(17),
	IP	varchar(15)	not null
	);


create table KONFIGURACJE
	(
	ID_KONF		varchar(13)	not null,
	DHCP		tn,
	POWIAZ_IPMAC	tn,
	INET		tn,
	PROXY		tn,
	PRZEKIER_GG	tn,
	PRZEKIER_FTP	tn,
	PRZEKIER_EMULE	tn,
	PRZEKIER_INNE	tn,
	ANTYPORN	tn,

	primary key (ID_KONF)
	);


create table GRUPY
	(
	ID_GR		varchar(6)	not null,
	NAZWA		varchar(20)	not null,
	ANTYSPAM	tn,
	ANTYWIR		tn,

	primary key (ID_GR)
	);


create table KONTA
	(
	ID_KONTA	varchar(9)	not null,
	LOGIN		varchar(6)	not null,
	HASLO		varchar(100)	not null,
	DATA_UTW	date,
	POJEMNOSC	integer		not null,

	ID_GR		varchar(6)	not null,
	ID_ABON		varchar(13)	not null,

	primary key (ID_KONTA),
	foreign key (ID_ABON) references ABONENCI (ID_ABON) on update cascade on delete no action,
	foreign key (ID_GR) references GRUPY (ID_GR) on update cascade on delete no action
	);


create table ALIASY_EMAIL
	(
	ALIAS		varchar(30)	not null,
	DATA_UTW	date,
	ID_KONTA	varchar(9)	not null,
	
	primary key (ALIAS),
	foreign key (ID_KONTA) references KONTA (ID_KONTA) on update cascade on delete no action
	);


create table VHOST_WWW
	(
	ID_VHW		varchar(7)	not null,
	NAZWA		varchar(30)	not null,
	KATALOG		varchar(30)	not null,
	ID_KONTA	varchar(9)	not null,

	primary key (ID_VHW),
	foreign key (ID_KONTA) references KONTA (ID_KONTA) on update cascade on delete no action
	);


create table VHOST_FTP
	(
	ID_VHF		varchar(7)	not null,
	NAZWA		varchar(30)	not null,
	PORT		integer,
	ID_KONTA	varchar(9)	not null,

	primary key (ID_VHF),
	foreign key (ID_KONTA) references KONTA (ID_KONTA) on update cascade on delete no action
	);
	
