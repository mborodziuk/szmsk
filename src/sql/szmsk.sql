create table ABONENCI
(
	ID_ABON		char(13)	not null,
	SYMBOL		varchar(30),
	IMIE		varchar(40)	not null,
	NAZWISKO	varchar(40)	not null,
	ID_BUD		char(7)		not null,
	NR_MIESZK	smallint,
	PESEL		char(11),    
	SN_DOW		char(9),
 	AKTYWNY		tn		not null,    
	
	primary key (ID_ABON),
	foreign key (ID_BUD) references BUDYNKI(ID_BUD)	on update cascade on delete no action
);


create table ABONENCI_INST
(
	ID_ABON		char(13)	not null,
	SYMBOL		varchar(30),
	NAZWA		varchar(40)	not null,
	ID_BUD		char(7),
	NR_MIESZK	smallint,	
	NIP		varchar(15),    
	REGON		varchar(15),
 	AKTYWNY		tn		not null,  
	PL_VAT		char(1),     

	primary key (ID_ABON),
	foreign key (ID_BUD) references BUDYNKI(ID_BUD)	on update cascade on delete no action
);


create table UMOWY_ABONENCKIE
    (
	NR_UMA		varchar(10),
	DATA_ZAW	date,
	TYP_UM		varchar(15),
	OKRES		smallint,
	STATUS		char(15),

	ID_ABON		char(13)
	
   );


create table MIEJSCA_INSTALACJI
	(
	ID_BUD		char(7),	
	NR_MIESZK	smallint,	
	ID_ABON		char(13),
	ID_WLASC	char(6)

	);


create table WLASCICIELE
	(
	ID_WLASC	char(6)		not null,
	IMIE		varchar(40)	not null,
	NAZWISKO	varchar(40)	not null,
	ID_BUD		char(7),	
	NR_MIESZK	smallint,
	ZGODA		tn	
	);


create table KONTAKTY
	(
	ID_KONTAKT	char(7)		not null,
	IMIE		varchar(40)	not null,
	NAZWISKO	varchar(40)	not null,
	ID_BUD		char(7),
	NR_MIESZK	smallint,
	ID_PODM		varchar(15),	

	primary key (ID_KONTAKT)	
	);


create table TELEFONY
	(
	KIERUNKOWY	varchar(5),
	TELEFON		char(9),
	TEL_KOM		varchar(11),
	ID_PODM		varchar(15)
	);


create table MAILE
	(
	EMAIL		varchar(20)	not null,
	ID_PODM		varchar(13)	not null
	);


create table BUDYNKI
	(
	ID_BUD 		char(7)		not null,
	ID_UL		char(6)		not null,
	NUMER		varchar(5)	not null,
	IL_MIESZK	smallint,
	PRZYLACZE	varchar(10),
	ID_ADM		char(7)

	primary key (ID_BUD),
	foreign key (ID_ADM) references INSTYTUCJE (ID_INST),
	foreign key (ID_UL)  references ULICE (ID_UL)
	);

create table ULICE
	(
	ID_UL		char(6)		not null,
	NAZWA		varchar(30)	not null,
	MIASTO		varchar(20)	not null,
	KOD		char(6)		not null,

	primary key (ID_UL)
        );


create table INSTYTUCJE
	(
	ID_INST		char(7)		not null,
	NAZWA		varchar(50)	not null,
	ULICA		varchar(30)	not null,
	ID_BUD		varchar(3)	not null,
	NR_MIESZK	varchar(3),	
	MIASTO		varchar(40)	not null,
	KOD		char(6),

	primary key (ID_INST)
	);

