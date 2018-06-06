create table DOSTAWCY
   (    
	ID_DOST		char(7)		not null,
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

	primary key (ID_DOST)
    );
		   

create table TOWARY_ZAKUP
    (
	ID_TOWZ		char(8)		not null,
 	SYMBOL		char(10),
	NAZWA		varchar(40)	not null,
	PKWIU		varchar(15),
	VAT		varchar(3),
	CENA		float		not null,
	OPIS		varchar(255),
	OKRES_GWAR	smallint,

	primary key (ID_TOWZ)    
);


create table WYDATKI
	(
 	ID_WYD		char(7)		not null,
	OPIS		varchar(100),
	TYP		varchar(80),
	NR_DZ		varchar(30),

	primary key (ID_WYD),
	foreign key (NR_DZ) references DOKUMENTY_ZAKUP (NR_DZ) on update cascade on delete no action
);


create table TYPY_WYDATKOW
	(
	ID_TWYD		char(8)		not null,
	OPIS		varchar(80),

	primary key (ID_TWYD)
	);


create table DOKUMENTY_ZAKUP
    (
	NR_DZ		varchar(15)	not null,
	NR_DOST		char(7)		not null,
	DATA_ZAK	date,
	TERM_PLAT	date,
	FORMA_PLAT	varchar(8),
	TYP_DOK		varchar(10),
	STAN		char(15),	

	primary key (NR_DZ),
	foreign key (NR_DOST) references DOSTAWCY (ID_DOST) on update cascade on delete no action
);


create table POZYCJE_ZAKUP
	(
	ID_TOWZ		char(8)		not null,
	ILOSC		smallint		not null,
	NR_DZ		varchar(15),

	foreign key (NR_DZ) references DOKUMENTY_ZAKUP (NR_DZ)
	);
	

create table GWARANCJE_ZAKUP
    (
	NR_GWAR	varchar(15),
	ID_DOST		char(7)		not null,
	DATA_WYST	date,

	primary key (NR_GWAR)
    );


create table POZYCJE_GWARZ
	(
	NR_FABR		varchar(15),
	ID_TOWZ		varchar(8),
	NR_GWAR	varchar(15),

	foreign key (NR_GWAR) references GWARANCJE_ZAKUP (NR_GWAR) on update cascade on delete no action	
	);



