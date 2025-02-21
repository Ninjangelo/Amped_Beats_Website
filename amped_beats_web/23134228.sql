/*
    -------------------------------------
    |          AMPED   BEATS            |
    |        DATABASE  SCRIPT           |
    -------------------------------------
    Group Members:
    - Mohamed Abraar Hamid (Student ID - 23214034)
    - Adrian Kosowski (Student ID - 23160380)
    - Haris Ahmed Dadd (Student ID - 23229761)
    - Angelo Luis Lagdameo (Student ID - 23134228)
*/;



/* ---------- DATABASE CREATION QUERY ---------- */;
CREATE DATABASE `23134228`;

USE `23134228`;
/* ---------- DATABASE CREATION QUERY ---------- */;


/* ---------- TABLE CREATION QUERIES ---------- */;

/* ---------- Customer Table ----------  */;
DROP TABLE IF EXISTS `customer`;

CREATE TABLE `customer` (
  `customerID` int(8) NULL AUTO_INCREMENT,
  `accountID` int(8) NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  PRIMARY KEY (`customerID`),
  KEY `accountID` (`accountID`)
) ENGINE=InnoDB CHARSET=utf8;
/* ---------- Customer Table ----------  */;


/* ---------- DJ Table ----------  */;
DROP TABLE IF EXISTS `discjockey`;

CREATE TABLE `discjockey` (
  `discjockeyID` int(8) NULL AUTO_INCREMENT,
  `accountID` int(8) NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`discjockeyID`),
  KEY `accountID` (`accountID`)
) ENGINE=InnoDB CHARSET=utf8;
/* ---------- DJ Table ----------  */;


/* ---------- Account Table ----------  */;
DROP TABLE IF EXISTS `account`;

CREATE TABLE `account` (
  `accountID` int(8) NULL AUTO_INCREMENT,
  `customerID` int(8) NULL,
  `discjockeyID` int(8) NULL,
  `adminID` int(8) NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`accountID`),
  KEY `customerID` (`customerID`),
  KEY `discjockeyID` (`discjockeyID`)
) ENGINE=InnoDB CHARSET=utf8;
/* ---------- Account Table ----------  */;


/* ---------- Booking Table ----------  */;
DROP TABLE IF EXISTS `booking`;

CREATE TABLE `booking` (
  `bookingID` int(8) NOT NULL AUTO_INCREMENT,
  `customerID` int(8) NULL,
  `discjockeyID` int(8) NULL,
  `bookingname` varchar(255) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `location` varchar(255) NOT NULL,
  `date` DATE,
  `status` varchar(50) NOT NULL,
  `customerFirstName` varchar(255) NOT NULL,
  `customerLastName` varchar(255) NOT NULL,
  PRIMARY KEY (`bookingID`),
  KEY `customerID` (`customerID`),
  KEY `discjockeyID` (`discjockeyID`)
) ENGINE=InnoDB CHARSET=utf8;
/* ---------- Booking Table ----------  */;


/* ---------- Review Table ----------  */;
CREATE TABLE `review` (
  `reviewID` int(8) NOT NULL AUTO_INCREMENT,
  `customerID` int(8) NULL,
  `ratingvalue` DECIMAL(3, 1) NOT NULL,
  `reviewdescription` varchar(1024) NOT NULL,
  `customerFirstName` varchar(255) NOT NULL,
  `customerLastName` varchar(255) NOT NULL,
  PRIMARY KEY (`reviewID`)
) ENGINE=InnoDB CHARSET=utf8;
/* ---------- Review Table ----------  */;

/* ---------- Admin Table ----------  */;
CREATE TABLE `admin` (
  `adminID` int(8) NOT NULL AUTO_INCREMENT,
  `accountID` int(8) NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  PRIMARY KEY (`adminID`)
) ENGINE=InnoDB CHARSET=utf8;
/* ---------- Review Table ----------  */;


/* ---------- TABLE CREATION QUERIES ---------- */;


/* ---------- FORIEGN KEY CONSTRAINTS (Relationships) ---------- */;

/* ---------- Customer Table ----------  */;
ALTER TABLE `customer`
ADD CONSTRAINT `accountID_customerFK` FOREIGN KEY (`accountID`) REFERENCES `account` (`accountID`) ON DELETE CASCADE;
/* ---------- Customer Table ----------  */;


/* ---------- DJ Table ----------  */;
ALTER TABLE `discjockey`
ADD CONSTRAINT `accountID_discjockeyFK` FOREIGN KEY (`accountID`) REFERENCES `account` (`accountID`) ON DELETE CASCADE;
/* ---------- DJ Table ----------  */;


/* ---------- Account Table ----------  */;
ALTER TABLE `account`
ADD CONSTRAINT `customerID_accountFK` FOREIGN KEY (`customerID`) REFERENCES `customer` (`customerID`) ON DELETE CASCADE,
ADD CONSTRAINT `discjockeyID_accountFK` FOREIGN KEY (`discjockeyID`) REFERENCES `discjockey` (`discjockeyID`) ON DELETE CASCADE,
ADD CONSTRAINT `adminID_accountFK` FOREIGN KEY (`adminID`) REFERENCES `admin` (`adminID`) ON DELETE CASCADE,
ADD CONSTRAINT `unique_emailValue` UNIQUE (`email`);
/* ---------- Account Table ----------  */;


/* ---------- Booking Table ----------  */;
ALTER TABLE `booking`
ADD CONSTRAINT `customerID_bookingFK` FOREIGN KEY (`customerID`) REFERENCES `customer` (`customerID`) ON DELETE SET NULL,
ADD CONSTRAINT `discjockeyID_bookingFK` FOREIGN KEY (`discjockeyID`) REFERENCES `discjockey` (`discjockeyID`) ON DELETE SET NULL;
/* ---------- Booking Table ----------  */;


/* ---------- Review Table ----------  */;
ALTER TABLE `review`
ADD CONSTRAINT `customerID_reviewFK` FOREIGN KEY (`customerID`) REFERENCES `customer` (`customerID`) ON DELETE SET NULL;
/* ---------- Review Table ----------  */;


/* ---------- Admin Table ----------  */;
ALTER TABLE `admin`
ADD CONSTRAINT `accountID_adminFK` FOREIGN KEY (`accountID`) REFERENCES `account` (`accountID`) ON DELETE CASCADE;
/* ---------- Review Table ----------  */;


/* ---------- PRE-MADE ACCOUNTS (Testing Purposes) ---------- */;

/* Admin Account Creation */
INSERT INTO `account` (`username`, `password`, `email`, `phone`, `address`)
VALUES ('adminAccount', '$2y$10$d0bfGQ5hVXH.7EUiHlSiteHIVFq41aFZIDXVgepcb5PaUwI1zy7Pi', 'admin@mail.com', '07123456789', '1 Admin, Admin Street, Admin Village, ADA A11');
INSERT INTO `admin` (`accountID`, `firstName`, `lastName`)
VALUES (1, 'Robert', 'Brookes');
UPDATE account SET adminID = 1 WHERE accountID = 1;


/* DJ Creation */
INSERT INTO `account` (`username`, `password`, `email`, `phone`, `address`)
VALUES ('discjockeyAccount', '$2y$10$3.ZUWcck9ea8UUm7CF3ybO8OQYpz1Ensn/Gz6wUDwtnYbqw6crlcK', 'disc.jockey@mail.com', '07712484937', '42 Music Corner, Song Hill, Note Ville, M34 9MS');
INSERT INTO `discjockey` (`accountID`, `firstName`, `lastName`, `description`, `genre`, `type`)
VALUES (2, 'Molly', 'Williams', 'This is an example DJ Account', 'RnB', 'Wedding');
UPDATE account SET discjockeyID = 1 WHERE accountID = 2;


/* Customer Creation */
INSERT INTO `account` (`username`, `password`, `email`, `phone`, `address`)
VALUES ('customerAccount', '$2y$10$3.ZUWcck9ea8UUm7CF3ybO8OQYpz1Ensn/Gz6wUDwtnYbqw6crlcK', 'customer@mail.com', '07712484937', '42 Customer Row, Little Town, Service Village, C21 4MC');
INSERT INTO `customer` (`accountID`, `firstName`, `lastName`)
VALUES (3, 'Haris', 'Dadd');
UPDATE account SET customerID = 1 WHERE accountID = 3;