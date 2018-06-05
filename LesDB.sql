CREATE DATABASE LesDB;

USE LesDB;

CREATE TABLE vestigingen
(vesnaam	CHAR(20) NOT NULL,
 branche	CHAR(20),
 plaats 	CHAR(20),
 CONSTRAINT pk_vestigingen PRIMARY KEY (vesnaam)) ENGINE = INNODB;

CREATE TABLE functies
(ftienaam 	CHAR(20) NOT NULL,
 minsal		INT,
 maxsal		INT,
 CONSTRAINT pk_functies PRIMARY KEY(ftienaam)) ENGINE = INNODB;

CREATE TABLE werknemers
(wnr		INT NOT NULL,
 wnaam		CHAR(20),
 afdeling	CHAR(2),
 ftienaam	CHAR(20),
 salaris	INT,
 vesnaam	CHAR(20),
 CONSTRAINT pk_werknemers PRIMARY KEY(wnr),
 CONSTRAINT fk1_werknemers FOREIGN KEY(vesnaam) REFERENCES vestigingen(vesnaam),
 CONSTRAINT fk2_werknemers FOREIGN KEY(ftienaam) REFERENCES functies(ftienaam)) ENGINE = INNODB;

CREATE TABLE vervangingen
(wnr		INT NOT NULL,
 vervangernr	INT NOT NULL,
 CONSTRAINT pk_vervangingen PRIMARY KEY(wnr, vervangernr),
 CONSTRAINT fk1_vervangingen FOREIGN KEY(wnr) REFERENCES werknemers(wnr),
 CONSTRAINT fk2_vervangingen FOREIGN KEY(vervangernr) REFERENCES werknemers(wnr)) ENGINE = INNODB;

INSERT INTO vestigingen VALUES ('Computerland','Verkoop','Brussel');
INSERT INTO vestigingen VALUES ('Technica','Verkoop','Antwerpen');
INSERT INTO vestigingen VALUES ('Paradise','Verkoop','Gent');
INSERT INTO vestigingen VALUES ('Training','Opleiding','Antwerpen');
INSERT INTO vestigingen VALUES ('Leasing','Verhuur','Antwerpen');
INSERT INTO vestigingen VALUES ('BrugIT','Opleiding','Brugge');

INSERT INTO functies VALUES ('Directeur',100000,140000);
INSERT INTO functies VALUES ('Onderdirecteur',75000,100000);
INSERT INTO functies VALUES ('DBA',65000,85000);
INSERT INTO functies VALUES ('Lesgever',55000,80000);
INSERT INTO functies VALUES ('Analist',45000,60000);
INSERT INTO functies VALUES ('Programmeur',32000,44000);
INSERT INTO functies VALUES ('Technicus',30000,37000);
INSERT INTO functies VALUES ('Vertegenwoordiger',30000,40000);
INSERT INTO functies VALUES ('Security',40000,60000);

INSERT INTO werknemers VALUES (1,'Buylaert','B3','Vertegenwoordiger',40000,'Computerland');
INSERT INTO werknemers VALUES (2,'Vervekke','B3','Vertegenwoordiger',42000,'Computerland');
INSERT INTO werknemers VALUES (3,'Janssens','B1','Directeur',100000,'Computerland');
INSERT INTO werknemers VALUES (4,'Lievens','B2','Analist',55000,'Computerland');
INSERT INTO werknemers VALUES (5,'Lutenberg','B2','Analist',60000,'Computerland');
INSERT INTO werknemers VALUES (6,'Jens','A1','Directeur',150000,'Technica');
INSERT INTO werknemers VALUES (7,'Timan','A1','Onderdirecteur',120000,'Technica');
INSERT INTO werknemers VALUES (8,'Imbrecht','A2','Programmeur',35000,'Technica');
INSERT INTO werknemers VALUES (9,'Pieters','A2','Analist',43000,'Technica');
INSERT INTO werknemers VALUES (10,'Peeters','A2','Analist',50000,'Technica');
INSERT INTO werknemers VALUES (11,'Mansaert','A2','DBA',70000,'Technica');
INSERT INTO werknemers VALUES (12,'Lutenberg','G1','Onderdirecteur',85000,'Paradise');
INSERT INTO werknemers VALUES (13,'Klerk','G3','Vertegenwoordiger',28000,'Paradise');
INSERT INTO werknemers VALUES (14,'Konings','G2','Analist',45000,'Paradise');
INSERT INTO werknemers VALUES (15,'Dingens','A1','Directeur',80000,'Training');
INSERT INTO werknemers VALUES (16,'Van Loo','A4','Lesgever',81000,'Training');
INSERT INTO werknemers VALUES (17,'Van Snit','A4','Lesgever',60000,'Training');
INSERT INTO werknemers VALUES (18,'Van Meer','A3','Technicus',43000,'Leasing');
INSERT INTO werknemers VALUES (19,'Meesen','A3','Technicus',37000,'Leasing');
INSERT INTO werknemers VALUES (20,'Delmot','A1','Onderdirecteur',83000,'Leasing');
INSERT INTO werknemers VALUES (21,'Capelle',NULL,NULL,NULL,NULL);

INSERT INTO vervangingen VALUES (1,2);
INSERT INTO vervangingen VALUES (4,5);
INSERT INTO vervangingen VALUES (5,4);
INSERT INTO vervangingen VALUES (3,6);
INSERT INTO vervangingen VALUES (6,7);
INSERT INTO vervangingen VALUES (7,6);
INSERT INTO vervangingen VALUES (8,9);
INSERT INTO vervangingen VALUES (8,10);
INSERT INTO vervangingen VALUES (9,10);
INSERT INTO vervangingen VALUES (10,9);
INSERT INTO vervangingen VALUES (14,11);
INSERT INTO vervangingen VALUES (16,17);
INSERT INTO vervangingen VALUES (17,16);
INSERT INTO vervangingen VALUES (18,19);
INSERT INTO vervangingen VALUES (19,18);
INSERT INTO vervangingen VALUES (20,15);