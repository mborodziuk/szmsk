create table ODBIORCY
    (
	ID_ODB		char(7)		not null,
	SYMBOL		varchar(30),
	NAZWA		varchar(40)	not null,
	ULICA		varchar(40)	not null,
	NR_BUD		smallint		not null,
	NR_MIESZK	smallint,
	MIASTO		varchar(40)	not null,
	KOD		varchar(10)	not null,
	NIP		varchar(15),    
	REGON		varchar(15),
 	AKTYWNY	tn,    
	PL_VAT		tn,    

	primary key (ID_ODB)
   );


create table TOWARY_SPRZEDAZ
    (
	ID_TOWS		char(8)		not null,
	SYMBOL		char(10),
	NAZWA		varchar(40)	not null,
	PKWIU		varchar(20),
	VAT		varchar(3),
	CENA		float		not null,
	OPIS		varchar(255),
	OKRES_GWAR	smallint,

	primary key (ID_TOWS)
    );	


create table PRZYCHODY
	(
 	ID_PRZYCH	char(7),
	OPIS		varchar(100),
	TYP		varchar(80),
	NR_DS		varchar(30),

	primary key (ID_PRZYCH),
	foreign key (NR_DS) references DOKUMENTY_SPRZEDAZ (NR_DS) on update cascade on delete no action
);


create table TYPY_PRZYCHODOW
	(
	ID_TPRZYCH	char(8)		not null,
	OPIS		varchar(80),

	primary key (ID_TPRZYCH)
	);


create table DOKUMENTY_SPRZEDAZ
    (
	NR_DS		varchar(15)	not null,
	NR_ODB 		char(7)		not null,
	DATA_SPRZED	date,
	TERM_PLAT	date,
	FORMA_PLAT	varchar(20),	
	TYP_DOK		varchar(10),
	STAN		char(15),

	primary key (NR_DS),
	foreign key (NR_ODB) references ODBIORCY (ID_ODB) on update cascade on delete no action
    );


create table POZYCJE_SPRZEDAZ
	(
	ID_TOWS		char(8)		not null,
	ILOSC		smallint		not null,
	NR_DS		varchar(15),

	foreign key (NR_DS) references DOKUMENTY_SPRZEDAZ (NR_DS)
	);

create table GWARANCJE_SPRZEDAZ
    (
	NR_GWAR     	varchar(15),
	ID_ODB		char(7),
	DATA_WYST	date,

	primary key (NR_GWAR)
    );

create table POZYCJE_GWARS
	(
	NR_FABR		varchar(15),
	ID_TOWS		varchar(8),
	NR_GWAR		varchar(15),

	foreign key (NR_GWAR) references GWARANCJE_SPRZEDAZ (NR_GWAR) on update cascade on delete no action	
	);



