create table SRODKI_TRWALE
	(
	ID_ST		varchar(10)	not null,
	ID_TOWZ		char(8)		not null,
	NR_GWAR	varchar(15),
	ID_BUD		char(8),

	primary key(ID_ST),
	foreign key (ID_BUD) references BUDYNKI (ID_BUD) on update cascade on delete no action,
	foreign key (NR_GWAR) references GWARANCJE_ZAKUP (NR_GWAR) on update cascade on delete no action,
	foreign key (ID_TOWZ) references TOWARY_ZAKUP(ID_TOWZ) on update cascade on delete no action
	);


create table WPLATY
(
	ID_WPL		char(7)		not null,
	ID_TOWUSL	char(8),
	DATA_WPLATY	date,
	KWOTA		float,
	FORMA		varchar(8)

);


create table WYPLATY
(
	ID_BENEF		char(8)		not null,
	ID_TOWUSL	char(8),
	DATA		date,
	KWOTA		float,
	FORMA		varchar(8)
);


create table PRACOWNICY
(
	ID_PRAC		char(7)			not null,
	IMIE		char(20)		not null,
	NAZWISKO	char(20)		not null,
	ULICA		char(20)		not null,
	NR_BUD		smallint,
	NR_MIESZK	smallint,
	KOD		char(6),
	PESEL		char(11),
	SN_DOWODU	char(9),
	NIP		varchar(15),		
	DATA_UR		date,
	PLEC		char(1),

	primary key (ID_PRAC)	
);


create table UMOWYPRACY
(
	NR_UMP		varchar(15)	not null,
	ID_PRAC		char(7)		not null,
	ID_PRACY	varchar(8)	not null,
	DATA_ZAWARCIA	date		not null,
	TYP		varchar(15),

	primary key (NR_UMP),
	foreign key (ID_PRAC) references PRACOWNICY (ID_PRAC) on update cascade on delete no action,
	foreign key (ID_PRACY) references PRACE (ID_PRACY) on update cascade on delete no action
);


create table PRACE
(
	ID_PRACY	varchar(15)	not null,
	CZYNNOSCI	varchar(200),
	KWOTA		float,
	DATA_ROZP	date,
	DATA_ZAK	date,

	primary key	(ID_PRACY)
);


create table ZEZWOLENIA
    (
	NR_ZEZWOL	varchar(15)	not null,
	DATA		date,
	DATA_OTRZ	date,
	DATA_WYG	date,
	OPLATY_MIES	float,
	ID_INST		varchar(15),
	
	primary key (NR_ZEZWOL),
	foreign key (ID_INST) references INSTYTUCJE (ID_INST) on update cascade on delete set null
    );


create table KONTA_BANKOWE
	(
	NR_KB		char(26)		not null,
	BANK		varchar(20),	
	NR_WLASC	varchar(15)	not null,

	primary key (NR_KB)
	);



create table PISMA_PRZYCH
	(
	ID_PP		varchar(15) not null,
	DATA		date,
	DATA_PRZYJ	date,
	DOTYCZY		varchar(100),
	LOK_FIZ		varchar(20),		
	LOK_KOPII	varchar(50),
	ID_NAD		varchar(30),

	primary key (ID_PP)
	);


create table  PISMA_WYCH
	(
	ID_PW		varchar(15) not null,
	DATA		date,
	DATA_WYJ	date,
	DOTYCZY		varchar(100),
	LOK_FK		varchar(20),		
	LOK_EK		varchar(50),
	ID_ODB		varchar(30),

	primary key (ID_PW)
	);


