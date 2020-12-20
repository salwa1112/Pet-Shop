--create database if not exist
CREATE DATABASE IF NOT EXISTS `assignment3` ;
USE `assignment3`;

--ceate tables (categories, customers, pets, petsoldtransaction, users) if not exist
CREATE TABLE IF NOT EXISTS `categories` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `customers` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `PhoneNumber` varchar(15) NOT NULL,
  `Email` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `pets` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Breed` varchar(50) NOT NULL,
  `DateBirth` date NOT NULL,
  `Photo` varchar(50) DEFAULT NULL,
  `Description` varchar(250) DEFAULT NULL,
  `CategoryID` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_PEST_CATEGORIES` (`CategoryID`),
  CONSTRAINT `FK_PEST_CATEGORIES` FOREIGN KEY (`CategoryID`) REFERENCES `categories` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `petsoldtransaction` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `petId` int(11) DEFAULT NULL,
  `customerId` int(11) DEFAULT current_date(),
  `SoldDate` date DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `petId` (`petId`),
  KEY `FK2_CUSTOMER_CUSTOMERID` (`customerId`),
  CONSTRAINT `FK2_CUSTOMER_CUSTOMERID` FOREIGN KEY (`customerId`) REFERENCES `customers` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_PETS_PETSID` FOREIGN KEY (`petId`) REFERENCES `pets` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `users` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) NOT NULL DEFAULT '',
  `LastName` varchar(50) NOT NULL DEFAULT '0',
  `Email` varchar(100) DEFAULT '0',
  `UserName` varchar(50) NOT NULL DEFAULT '0',
  `Password` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `UserName` (`UserName`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--insert data to user table to create an admin user
INSERT INTO `users` (`Id`, `FirstName`, `LastName`, `Email`, `UserName`, `Password`) 
VALUES ('2', 'admin', 'admin', 'admin@gmail.com', 'admin', 'admin');

