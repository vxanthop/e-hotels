CREATE USER 'e-hotels'@'localhost' IDENTIFIED BY 'KostasMitroglou11';

CREATE DATABASE ehotels;

GRANT ALL ON ehotels.* TO 'e-hotels'@'localhost';

CREATE TABLE Hotel_group (
    Hotel_group_ID int(10) UNSIGNED AUTO_INCREMENT NOT NULL,
    Number_of_hotels smallint(4) UNSIGNED DEFAULT 0,
    Address_Street varchar(42) NOT NULL,
    Address_Number smallint(4) UNSIGNED NOT NULL,
    Address_City varchar(42) NOT NULL,
    Address_Postal_Code mediumint(6) UNSIGNED NOT NULL,
    Hotel_group_Name varchar(42) NOT NULL,
    img_src varchar(255),
    PRIMARY KEY (Hotel_group_ID)
);

CREATE TABLE Hotel_group_Email_Address (
    Hotel_group_ID int(10) UNSIGNED NOT NULL,
    Email_Address varchar(42) NOT NULL,
    FOREIGN KEY (Hotel_group_ID) REFERENCES Hotel_group(Hotel_group_ID) ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (Hotel_group_ID, Email_Address)
);

CREATE TABLE Hotel_group_Phone_Number (
    Hotel_group_ID int(10) UNSIGNED NOT NULL,
    Phone_Number bigint(10) UNSIGNED NOT NULL,
    FOREIGN KEY (Hotel_group_ID) REFERENCES Hotel_group(Hotel_group_ID) ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (Hotel_group_ID, Phone_Number)
);

CREATE TABLE Hotel (
    Hotel_ID int(10) UNSIGNED AUTO_INCREMENT NOT NULL,
    Hotel_group_ID int(10) UNSIGNED NOT NULL,
    Stars tinyint(1) UNSIGNED NOT NULL,
    Address_Street varchar(42) NOT NULL,
    Address_Number smallint(4) UNSIGNED NOT NULL,
    Address_City varchar(42) NOT NULL,
    Address_Postal_Code mediumint(6) UNSIGNED NOT NULL,
    Number_of_rooms smallint(4) UNSIGNED DEFAULT 0,
    img_src varchar(255),
    Hotel_Name varchar(42) NOT NULL,
    FOREIGN KEY (Hotel_group_ID) REFERENCES Hotel_group(Hotel_group_ID) ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (Hotel_ID)
);

CREATE TABLE Hotel_Phone_Number (
    Hotel_ID int(10) UNSIGNED NOT NULL,
    Phone_Number bigint(10) UNSIGNED NOT NULL,
    FOREIGN KEY (Hotel_ID) REFERENCES Hotel(Hotel_ID) ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (Hotel_ID, Phone_Number)
);

CREATE TABLE Hotel_Email_Address (
    Hotel_ID int(10) UNSIGNED NOT NULL,
    Email_Address varchar(42) NOT NULL,
    FOREIGN KEY (Hotel_ID) REFERENCES Hotel(Hotel_ID) ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (Hotel_ID, Email_Address)
);

CREATE TABLE Employee (
    Employee_IRS int(9) ZEROFILL UNSIGNED NOT NULL,
    Social_Security_Number bigint(11) ZEROFILL UNSIGNED UNIQUE NOT NULL CHECK(Social_Security_Number >= 01010000000),
    Last_Name varchar(42) NOT NULL,
    First_Name varchar(42) NOT NULL,
    Address_Street varchar(42) NOT NULL,
    Address_Number smallint(4) UNSIGNED NOT NULL,
    Address_City varchar(42) NOT NULL,
    Address_Postal_Code mediumint(6) UNSIGNED NOT NULL,
    PRIMARY KEY (Employee_IRS)
);

CREATE INDEX employee_fullname
ON Employee (Last_Name, First_Name);

CREATE TABLE Works (
    Employee_IRS int(9) UNSIGNED NOT NULL,
    Hotel_ID int(10) UNSIGNED NOT NULL,
    Start_Date date NOT NULL,
    Finish_Date date,
    Position varchar(42) NOT NULL,
    FOREIGN KEY (Employee_IRS) REFERENCES Employee(Employee_IRS) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (Hotel_ID) REFERENCES Hotel(Hotel_ID) ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (Employee_IRS, Hotel_ID, Start_Date, Position)
);

CREATE TABLE Hotel_Room (
    Room_ID smallint(4) UNSIGNED AUTO_INCREMENT NOT NULL,
    Hotel_ID int(10) UNSIGNED NOT NULL,
    Capacity tinyint(2) UNSIGNED NOT NULL,
    View boolean DEFAULT 0,
    Expandable varchar(15) DEFAULT '',
    Repairs_need boolean DEFAULT 0,
    Price decimal(5, 2) UNSIGNED NOT NULL,
    FOREIGN KEY (Hotel_ID) REFERENCES Hotel(Hotel_ID) ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (Room_ID, Hotel_ID)
);

CREATE TABLE Room_Amenities (
    Room_ID smallint(4) UNSIGNED NOT NULL,
    Hotel_ID int(10) UNSIGNED NOT NULL,
    amenity varchar(42) NOT NULL,
    FOREIGN KEY (Room_ID, Hotel_ID) REFERENCES Hotel_Room(Room_ID, Hotel_ID) ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (Room_ID, Hotel_ID, amenity)
);

CREATE TABLE Customer (
    Customer_IRS int(9) ZEROFILL UNSIGNED NOT NULL,
    Social_Security_Number bigint(11) ZEROFILL UNSIGNED UNIQUE NOT NULL CHECK(Social_Security_Number >= 01010000000),
    Last_Name varchar(42) NOT NULL,
    First_Name varchar(42) NOT NULL,
    Address_Street varchar(42) NOT NULL,
    Address_Number smallint(4) UNSIGNED NOT NULL,
    Address_City varchar(42) NOT NULL,
    Address_Postal_Code mediumint(6) UNSIGNED NOT NULL,
    First_Registration date NOT NULL,
    PRIMARY KEY (Customer_IRS)
);

CREATE INDEX customer_fullname
ON Customer (Last_Name, First_Name);

CREATE TABLE Reserves (
    Room_ID smallint(4) UNSIGNED,
    Hotel_ID int(10) UNSIGNED,
    Customer_IRS int(9) UNSIGNED NOT NULL,
    Start_Date date NOT NULL,
    Finish_Date date,
    Paid boolean DEFAULT 0,
    UNIQUE (Room_ID, Hotel_ID, Start_Date),
    FOREIGN KEY (Room_ID) REFERENCES Hotel_Room(Room_ID) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (Hotel_ID) REFERENCES Hotel(Hotel_ID) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (Customer_IRS) REFERENCES Customer(Customer_IRS) ON UPDATE CASCADE
);

CREATE TABLE Rents (
    Room_ID smallint(4) UNSIGNED,
    Hotel_ID int(10) UNSIGNED,
    Customer_IRS int(9) UNSIGNED NOT NULL,
    Employee_IRS int(9) UNSIGNED NOT NULL,
    Start_Date date NOT NULL,
    Finish_Date date,
    Rent_ID int(10) UNSIGNED AUTO_INCREMENT NOT NULL,
    UNIQUE (Room_ID, Hotel_ID, Start_Date),
    FOREIGN KEY (Room_ID) REFERENCES Hotel_Room(Room_ID) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (Hotel_ID) REFERENCES Hotel(Hotel_ID) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (Customer_IRS) REFERENCES Customer(Customer_IRS) ON UPDATE CASCADE,
    FOREIGN KEY (Employee_IRS) REFERENCES Employee(Employee_IRS) ON UPDATE CASCADE,
    PRIMARY KEY (Rent_ID)
);

-- Rent-Transaction is a 1:1 relationship, so Rent_ID is both a foreign and a primary key in Payment_Transaction
CREATE TABLE Payment_Transaction (
    Rent_ID int(10) UNSIGNED NOT NULL,
    Payment_Amount decimal(7, 2) UNSIGNED NOT NULL,
    Payment_Method varchar(6) NOT NULL,
    PRIMARY KEY (Rent_ID),
    FOREIGN KEY (Rent_ID) REFERENCES Rents(Rent_ID) ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TRIGGER first_registration BEFORE INSERT ON Customer
    FOR EACH ROW
        SET NEW.First_Registration = CURDATE();

CREATE TRIGGER add_hotel AFTER INSERT ON Hotel
    FOR EACH ROW
        UPDATE Hotel_group SET Number_of_hotels = Number_of_hotels + 1 WHERE Hotel_group_ID = NEW.Hotel_group_ID;

CREATE TRIGGER add_room AFTER INSERT ON Hotel_Room
    FOR EACH ROW
        UPDATE Hotel SET Number_of_rooms = Number_of_rooms + 1 WHERE Hotel_ID = NEW.Hotel_ID;

CREATE TRIGGER delete_hotel AFTER DELETE ON Hotel
    FOR EACH ROW
        UPDATE Hotel_group SET Number_of_hotels = Number_of_hotels - 1 WHERE Hotel_group_ID = OLD.Hotel_group_ID;

CREATE TRIGGER delete_room AFTER DELETE ON Hotel_Room
    FOR EACH ROW
        UPDATE Hotel SET Number_of_rooms = Number_of_rooms - 1 WHERE Hotel_ID = OLD.Hotel_ID;

-- Employee assignment checks
DELIMITER $$
CREATE TRIGGER assign_employee BEFORE INSERT ON Works
    FOR EACH ROW BEGIN
        IF NEW.Finish_Date IS NOT NULL AND NEW.Finish_Date < NEW.Start_Date THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: Finish date cannot be set earlier than the start date';
        END IF;
        IF (SELECT COUNT(Employee_IRS) FROM Works WHERE Employee_IRS = NEW.Employee_IRS AND
            Start_Date <= IFNULL(NEW.Finish_Date, Start_Date) AND NEW.Start_Date <= IFNULL(Finish_Date, NEW.Start_Date)
        ) >= 1 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: Cannot assign a work to this employee, since the given period conflicts with an existent working period of his.';
        END IF;
        IF NEW.Position = 'manager' AND
            (SELECT COUNT(Employee_IRS) FROM Works WHERE
                Hotel_ID = NEW.Hotel_ID AND Position = 'manager' AND
                Start_Date <= IFNULL(NEW.Finish_Date, Start_Date) AND NEW.Start_Date <= IFNULL(Finish_Date, NEW.Start_Date)
            ) >= 1 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: Cannot assign a manager to this Hotel, since the given period conflicts with an existent manager period.';
        END IF;
    END$$
DELIMITER ;