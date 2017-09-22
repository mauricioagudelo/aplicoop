-- sql per passar de la versió 2.x a la 3 --

--canvis taula productes --
--- Creem preusi (preu sense iva) que substituirà preu, iva (taxa d'iva), marge (% augment del preu), descompte (% de dscompte)
ALTER TABLE `productes` ADD `preusi` float(7,2) NOT NULL AFTER `actiu`,	
ADD `iva` float(2,2) NOT NULL AFTER `preusi`,
ADD `marge` float (7,4) NOT NULL AFTER `iva`,
ADD `descompte` FLOAT( 4, 4 ) NOT NULL AFTER `marge`;
--- En principi passem els preus antics tal i com estan a preu sense iva i iva=0 ---
--- Cal retocar-ho si es vol manualment producte per producte ---
--- Recordeu que en aquesta versio hi ha una pantalla en que podreu fer aquests canvis en un grup de productes a la vegada ---
UPDATE `productes` SET `preusi`=`preu`;
UPDATE `productes` SET `iva`=0;		
ALTER TABLE `productes` DROP `preu`;
ALTER TABLE `productes` DROP PRIMARY KEY;
--- Numref és una variable temporal per crear la referència, desapareix més endavant ---
ALTER TABLE `productes` ADD `numref` INT( 4 ) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY ( `numref` ); 
-- Creem ref (referència) que seran les 3 primeres lletres del proveïdor més 4 numeros --
ALTER TABLE `productes` ADD `ref` VARCHAR( 7 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL FIRST;
UPDATE `productes` SET `ref` = LEFT( `proveidora` , 3 );
UPDATE `productes` SET `ref` = CONCAT( `ref` , `numref` ); 
ALTER TABLE `productes` DROP `numref`, DROP PRIMARY KEY;
ALTER TABLE `productes` ADD UNIQUE (`ref`),  ADD PRIMARY KEY(`ref`);
----

-- canvis taula comanda -- 
--- Creem numfact (numero de factura). La diferenciem així del numero de comanda (numero). ---
ALTER TABLE `comanda` ADD `numfact` INT NOT NULL AFTER `check2`;
---

-- canvis taula comanda_linia --
--- Acompanyem el camp de preu, de nous camps: iva i descompte ---
ALTER TABLE `comanda_linia` ADD `iva` FLOAT( 2, 2 ) NOT NULL ,
ADD `descompte` FLOAT( 4, 4 ) NOT NULL ;
--- Eliminem producte i proveïdora, que fins ara eran index de la taula, i creem ref (referència) que serà el nou index. --
ALTER TABLE `comanda_linia` DROP INDEX `producte`;
ALTER TABLE `comanda_linia` ADD `ref` VARCHAR( 7 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `numero` ,
ADD INDEX ( `ref` );
UPDATE `comanda_linia` AS `cl`, `productes` AS `pr` SET `cl`.`ref`=`pr`.`ref` WHERE `cl`.`producte`=`pr`.`nom` AND `cl`.`proveidora`=`pr`.`proveidora`;
ALTER TABLE `comanda_linia`  DROP `producte`,  DROP `proveidora`;
---

-- canvis taula usuaris --
--- Creem 3 camps nous: nomf, adressf, niff. Son les dades que apareixeran a les factures ---
ALTER TABLE `usuaris` ADD `nomf` VARCHAR( 100 ) NOT NULL AFTER `email2`,
ADD `adressf` VARCHAR( 200 ) NOT NULL AFTER `nomf`,
ADD `niff` VARCHAR( 9 ) NOT NULL AFTER `adressf`,
ALTER TABLE `usuaris` ADD `kuota` FLOAT(4,2) NOT NULL AFTER `nota`,
ALTER TABLE `usuaris` ADD `IBAN` VARCHAR(24) NOT NULL AFTER `kuota`,
ALTER TABLE `usuaris` ADD `domiciliacion` TINYINT NOT NULL AFTER `IBAN`;  
ALTER TABLE `usuaris` ADD `fechaalta` DATE NOT NULL AFTER `domiciliacion`; 
----

