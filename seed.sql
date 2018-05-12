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


-- Customers

INSERT INTO Customer(Customer_IRS, Social_Security_Number, Last_Name, First_name, Address_Street, Address_Number, Address_City, Address_Postal_Code) VALUES 
(194884191, 19049815101, 'Aggelopoulou', 'Meropi', 'Grigoriadou', 60, 'Iasmos', 15122),
(441491110, 01101514922, 'Filippidis', 'Veniamin', 'Leof. Papakostas', 91, 'Mantoudi', 75323),
(294198441, 31059110345, 'Nikolaou', 'Sofronia', 'Charalampidou', 19, 'Lokroi', 19152),
(031039441, 13013149041, 'Iliopoulou', 'Leoni', 'Stamatiadou', 58, 'Argithea', 52578),
(000041497, 09124309585, 'Papamarkou', 'Themis', 'Leof. Alexandrou', 59, 'Tyrnabos', 53910);