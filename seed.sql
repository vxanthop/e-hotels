USE ehotels;

-- Hotel groups

INSERT INTO Hotel_group(Hotel_group_Name, Address_Street, Address_Number, Address_City, Address_Postal_Code) VALUES
('Hilton', 'Leof. Kifisias', 122, 'Athens', 14950),
('Holiday Inn', 'Leof. Mesogeion', 70, 'Athens', 10399),
('Crowne Plaza', 'Vas. Georgiou', 11, 'Athens', 14094),
('Novotel', 'Leof. Poseidonos', 59, 'Palaio Faliro', 17717),
('Mercure', 'Stamatiados', 43, 'Patra', 71330);


-- Hotel group Emails

INSERT INTO Hotel_group_Email_Address(Hotel_group_ID, Email_Address) VALUES
(1, 'info@hilton.gr'),
(1, 'hilton@hilton.gr'),
(2, 'holidayinn@otenet.gr'),
(2, 'info@holidayinn.gr'),
(2, 'reservations@holidayinn.gr'),
(3, 'info@crowneplaza.gr'),
(4, 'info@novotel.gr'),
(5, 'patras@mercure.com'),
(5, 'info@mercure-hotels.gr');


-- Hotel group Phone Numbers

INSERT INTO Hotel_group_Phone_Number(Hotel_group_ID, Phone_Number) VALUES
(1, 2103133100),
(1, 2103133101),
(1, 2103133102),
(2, 2103438455),
(3, 2107739000),
(3, 2107739001),
(4, 2135991070),
(5, 2710668300);


-- Hotel

INSERT INTO Hotel(Hotel_group_ID, Stars, Address_Street, Address_Number, Address_City, Address_Postal_code, Hotel_Name) VALUES
(1, 5, 'Leof. Vasilissis Sofias', 192, 'Athens', 18441, 'Hilton Athens'),
(1, 5, 'Leof. Amalias', 30, 'Athens', 15510, 'Queen Hotel Athens'),
(1, 4, 'Feidipiddou', 41, 'Athens', 19401, 'Hilton Ampelokipoi'),
(2, 4, 'Syrigou', 98, 'Athens', 11348, 'Athena - Holiday Inn'),
(2, 4, 'Markou Mpotsari', 11, 'Thessaloniki', 54249, 'Holiday Inn Thessaloniki'),
(3, 4, 'Leof. Alexandras', 173, 'Athens', 12491, 'Crowne Plaza'),
(3, 3, 'Dimitriados', 3, 'Volos', 61223, 'Crowne Plaza Volos'),
(3, 3, 'Athinas', 80, 'Patra', 75515, 'Crowne Plaza Patras'),
(4, 4, 'Mourgou', 25, 'Piraeus', 18809, 'Novotel'),
(5, 3, 'Athinas', 12, 'Patra', 75515, 'Mercure Hotel'),
(5, 3, 'Synt. Davaki', 6, 'Kalamata', 44347, 'Mercure Hotel Kalamata');


-- Hotel Phone Number

INSERT INTO Hotel_Phone_Number (Hotel_ID, Phone_Number) VALUES
(1, 2103145510), (1, 2103145511),
(2, 2103844810),
(3, 2103844890),
(4, 2107712388), (4, 2107712389),
(5, 2310485800),
(6, 2107739100), (6, 2107739101), (6, 2107739102),
(7, 2421305140),
(8, 2610248440),
(9, 2135005359),
(10, 2610669101), (10, 2610669102),
(11, 2710485000), (11, 2710485100);


-- Hotel Email Address

INSERT INTO Hotel_Email_Address (Hotel_ID, Email_Address) VALUES
(1, 'athens@hilton.gr'),
(2, 'amalias@hilton.gr'),
(3, 'ampelokipoi@hilton.gr'),
(4, 'athens@holidayinn.gr'),
(5, 'thess@holidayinn.gr'),
(6, 'info@crowneplaza.gr'), (6, 'athens@crowneplaza.gr'),
(7, 'info@crowneplaza.gr'), (7, 'volos@crowneplaza.gr'),
(8, 'info@crowneplaza.gr'), (8, 'patra@crowneplaza.gr'),
(9, 'info@novotel.gr'),
(10, 'patras@mercure.com'), (10, 'info@mercure-hotels.gr'),
(11, 'kalamata@mercure.com'), (11, 'info@mercure-hotels.gr');


-- Employees

INSERT INTO Employee(Employee_IRS, Social_Security_Number, Last_Name, First_name, Address_Street, Address_Number, Address_City, Address_Postal_Code) VALUES 
(403140001, 10023249411, 'Korakas', 'Agamemnon', 'Triantafyllidou', 84, 'Orestiada', 38828),
(104955910, 14056691300, 'Makris', 'Pythagoras', 'Zografou', 94, 'Zichni', 62989),
(051044458, 15069610358, 'Christopoulos', 'Isaias', 'Papakosta', 52, 'Orestiada', 84531),
(747190941, 13094094518, 'Nikolopoulos', 'Achilleas', 'Ioannou', 1, 'Filothei', 29700),
(093495858, 30122031856, 'Laskari', 'Anatoli', 'Makris', 145, 'Polygyros', 31703);


-- Works

INSERT INTO Works(Employee_IRS, Hotel_ID, Start_Date, Finish_Date, Position) VALUES
(403140001, 1, DATE('2016-04-30'), DATE('2019-04-30'), 'chef'),
(104955910, 2, DATE('2015-09-18'), DATE('2016-03-04'), 'accountant'),
(104955910, 2, DATE('2016-03-05'), DATE('2016-09-29'), 'staff manager'),
(104955910, 2, DATE('2016-09-30'), NULL, 'manager'),
(051044458, 4, DATE('2015-01-01'), DATE('2015-11-10'), 'manager'),
(051044458, 3, DATE('2015-11-11'), NULL, 'manager'),
(747190941, 2, DATE('2016-08-01'), DATE('2018-03-01'), 'maid'),
(747190941, 4, DATE('2018-03-02'), DATE('2018-05-29'), 'receptionist'),
(747190941, 5, DATE('2018-07-30'), DATE('2018-08-30'), 'receptionist'),
(093495858, 10, DATE('2017-05-15'), DATE('2017-09-03'), 'technician'),
(093495858, 6, DATE('2018-04-02'), DATE('2018-09-10'), 'technician');


-- Customers

INSERT INTO Customer(Customer_IRS, Social_Security_Number, Last_Name, First_name, Address_Street, Address_Number, Address_City, Address_Postal_Code) VALUES 
(194884191, 19049815101, 'Aggelopoulou', 'Meropi', 'Grigoriadou', 60, 'Iasmos', 15122),
(441491110, 01101514922, 'Filippidis', 'Veniamin', 'Leof. Papakostas', 91, 'Mantoudi', 75323),
(294198441, 31059110345, 'Nikolaou', 'Sofronia', 'Charalampidou', 19, 'Lokroi', 19152),
(031039441, 13013149041, 'Iliopoulou', 'Leoni', 'Stamatiadou', 58, 'Argithea', 52578),
(000041497, 09124309585, 'Papamarkou', 'Themis', 'Leof. Alexandrou', 59, 'Tyrnabos', 53910);


-- Rooms 

INSERT INTO Hotel_Room (Hotel_ID, Capacity, View, Expandable, Repairs_need, Price) VALUES
(1, 2, 1, 'connecting_room', 0, 150), (1, 2, 0, 'more_beds', 1, 100), (1, 3, 0, '', 0, 131),
(2, 4, 1, 'connecting_room', 0, 220), (2, 1, 1, '', 0, 70), (2, 2, 1, 'connecting_room', 0, 131), (2, 3, 0, '', 0, 134),
(3, 4, 1, '', 0, 220), (3, 1, 1, '', 0, 70), (3, 2, 1, 'more_beds', 0, 120),
(4, 1, 1, 'connecting_room', 0, 70), (4, 2, 1, 'more_beds', 0, 120), (4, 3, 0, '', 0, 120),
(5, 4, 1, 'more_beds', 0, 220), (5, 1, 1, '', 0, 70), (5, 2, 1, 'more_beds', 0, 120), (5, 3, 0, '', 0, 120), (5, 5, 1, '', 0, 230), (5, 2, 1, 'connecting_room', 0, 130),
(6, 4, 1, 'connecting_room', 0, 220), (6, 1, 1, '', 0, 70), (6, 2, 1, 'more_beds', 0, 120), (6, 3, 1, 'more_beds', 0, 150),
(7, 1, 1, 'connecting_room', 0, 70), (7, 2, 1, 'more_beds', 0, 120), (7, 3, 0, '', 0, 120),
(8, 1, 1, '', 0, 70), (8, 2, 1, 'more_beds', 0, 140), (8, 3, 0, '', 0, 140),
(9, 1, 1, '', 0, 70), (9, 2, 1, 'more_beds', 0, 112), (9, 3, 0, '', 0, 112), (9, 3, 1, '', 1, 180), (9, 5, 1, '', 1, 202), (9, 2, 0, 'connecting_room', 1, 112),
(10, 1, 1, 'more_beds', 0, 70), (10, 2, 1, 'more_beds', 0, 120), (10, 3, 0, '', 1, 135),
(11, 1, 1, '', 0, 70), (11, 2, 1, 'more_beds', 1, 125), (11, 3, 1, '', 1, 108), (11, 1, 0, '', 0, 60);
