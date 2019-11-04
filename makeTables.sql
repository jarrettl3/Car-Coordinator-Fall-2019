-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema jleflerDB
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema jleflerDB
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `jleflerDB` DEFAULT CHARACTER SET utf8 ;
USE `jleflerDB` ;

-- -----------------------------------------------------
-- Table `jleflerDB`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `jleflerDB`.`User` (
  `User_ID` INT NOT NULL,
  `Username` VARCHAR(45) NULL,
  `Password` VARCHAR(45) NULL,
  `Firstname` VARCHAR(45) NULL,
  `Lastname` VARCHAR(45) NULL,
  `Date_added` DATE NULL,
  `Address` VARCHAR(45) NULL,
  `Insurance_Provider` VARCHAR(45) NULL,
  `Policy_Number` INT NULL,
  PRIMARY KEY (`User_ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `jleflerDB`.`Vehicle`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `jleflerDB`.`Vehicle` (
  `VIN` INT NOT NULL,
  `User_ID` INT NULL,
  `Make` VARCHAR(45) NULL,
  `Model` VARCHAR(45) NULL,
  `Color` VARCHAR(45) NULL,
  `Num_of_seats` INT NULL,
  `Date_added` DATE NULL,
  `Plate_Num` VARCHAR(8) NULL,
  PRIMARY KEY (`VIN`),
  INDEX `User_ID_idx` (`User_ID` ASC),
  CONSTRAINT `User_ID`
    FOREIGN KEY (`User_ID`)
    REFERENCES `jleflerDB`.`User` (`User_ID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `jleflerDB`.`Event`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `jleflerDB`.`Event` (
  `Event_ID` INT NOT NULL,
  `Host_ID` INT NULL,
  `Date` DATE NULL,
  `Time` TIME NULL,
  `Event_Name` VARCHAR(45) NULL,
  `Description` VARCHAR(200) NULL,
  `Address` VARCHAR(45) NULL,
  `Date_added` DATE NULL,
  PRIMARY KEY (`Event_ID`),
  INDEX `Host_ID_idx` (`Host_ID` ASC),
  CONSTRAINT `Host_ID`
    FOREIGN KEY (`Host_ID`)
    REFERENCES `jleflerDB`.`User` (`User_ID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `jleflerDB`.`Vehicle_Pledge`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `jleflerDB`.`Vehicle_Pledge` (
  `Pledge_ID` INT NOT NULL,
  `Vehicle_ID` INT NULL,
  `Event_Pledged_To` INT NULL,
  `Date_added` DATE NULL,
  `Pledge_Description` VARCHAR(100) NULL,
  PRIMARY KEY (`Pledge_ID`),
  INDEX `Vehicle_ID_idx` (`Vehicle_ID` ASC),
  INDEX `Event_Pledged_To_idx` (`Event_Pledged_To` ASC),
  CONSTRAINT `Vehicle_ID`
    FOREIGN KEY (`Vehicle_ID`)
    REFERENCES `jleflerDB`.`Vehicle` (`VIN`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `Event_Pledged_To`
    FOREIGN KEY (`Event_Pledged_To`)
    REFERENCES `jleflerDB`.`Event` (`Event_ID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `jleflerDB`.`Seat_Claim`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `jleflerDB`.`Seat_Claim` (
  `Claim_ID` INT NOT NULL,
  `Pledge_ID` INT NULL,
  `Claiming_User_ID` INT NULL,
  PRIMARY KEY (`Claim_ID`),
  INDEX `Pledge_ID_idx` (`Pledge_ID` ASC),
  INDEX `Claiming_User_ID_idx` (`Claiming_User_ID` ASC),
  CONSTRAINT `Pledge_ID`
    FOREIGN KEY (`Pledge_ID`)
    REFERENCES `jleflerDB`.`Vehicle_Pledge` (`Pledge_ID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `Claiming_User_ID`
    FOREIGN KEY (`Claiming_User_ID`)
    REFERENCES `jleflerDB`.`User` (`User_ID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `jleflerDB`.`Invitation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `jleflerDB`.`Invitation` (
  `Invite_ID` INT NOT NULL,
  `Event_ID` INT NULL,
  `Invited_User_ID` INT NULL,
  PRIMARY KEY (`Invite_ID`),
  INDEX `Event_ID_idx` (`Event_ID` ASC),
  INDEX `Invited_User_ID_idx` (`Invited_User_ID` ASC),
  CONSTRAINT `Event_ID`
    FOREIGN KEY (`Event_ID`)
    REFERENCES `jleflerDB`.`Event` (`Event_ID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `Invited_User_ID`
    FOREIGN KEY (`Invited_User_ID`)
    REFERENCES `jleflerDB`.`User` (`User_ID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
