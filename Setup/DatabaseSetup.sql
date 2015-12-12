CREATE DATABASE clanmanager;

USE clanmanager;

CREATE TABLE clans (
  Counter int(11) NOT NULL auto_increment,
  Kontakt varchar(128) NOT NULL default '',
  Adresse text NOT NULL,
  PLZ int(10) NOT NULL default '0',
  Ort varchar(128) NOT NULL default '',
  Telefon varchar(128) NOT NULL default '',
  Mail varchar(128) NOT NULL default '',
  Clanname varchar(128) NOT NULL default '',
  bDeleted int(2) NOT NULL default '0',
  Nummer int(20) NOT NULL default '0',
  PRIMARY KEY  (Counter)
) TYPE=MyISAM;

CREATE TABLE servers (
  Counter int(11) NOT NULL auto_increment,
  Serverart varchar(128) NOT NULL default '',
  IP varchar(128) NOT NULL default '',
  Slots int(11) NOT NULL default '0',
  bPublic int(1) NOT NULL default '0',
  Voice varchar(128) NOT NULL default '',
  Werbung varchar(128) NOT NULL default '',
  RabattOne int(10) NOT NULL default '0',
  RabattTwo int(10) NOT NULL default '0',
  RabattThree int(10) NOT NULL default '0',
  BeschrRabatte text NOT NULL,
  BeschrServer text NOT NULL,
  AktSpiel varchar(128) NOT NULL default '',
  Preis int(10) NOT NULL default '0',
  Frist int(10) NOT NULL default '0',
  Periode int(10) NOT NULL default '0',
  bDeleted int(1) NOT NULL default '0',
  ClanID int(100) NOT NULL default '0',
  bActive int(2) NOT NULL default '0',
  AktRechnung int(2) NOT NULL default '0',
  AktRechnungMarkiert int(2) NOT NULL default '0',
  LetztePeriode date NOT NULL default '0000-00-00',
  ErstePeriode date NOT NULL default '0000-00-00',
  PRIMARY KEY  (Counter)
) TYPE=MyISAM;
