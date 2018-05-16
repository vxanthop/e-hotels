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

INSERT INTO Employee(Employee_IRS, Social_Security_Number, Last_Name, First_Name, Address_Street, Address_Number, Address_Postal_Code, Address_City) VALUES
(245200205, '12024905602', 'Theodorou', 'Agisilaos', 'Xanthopoulos', 6, 13669, 'Markopoulo Mesogaias'),
(225744, '16076198834', 'Xanthopoulou', 'Semina', 'Gaspari', 83, 78555, 'Parga'),
(472800425, '08056249165', 'Nikolaidis', 'Foteinos', 'Koronaios', 2, 41604, 'Ilio'),
(738242228, '14038347787', 'Iatridis', 'Paris', 'Papadopoulos', 3, 87295, 'Patra'),
(248719098, '14115661875', 'Vitali', 'Ira', 'Koliatsos', 8, 56829, 'Naupaktia'),
(38701508, '12034117037', 'Aggelopoulou', 'Paraskeui', 'Protonotarios', 3, 81227, 'Elassona'),
(715833361, '11047284440', 'Antonopoulou', 'Iordania', 'Euthymiadis', 5, 62948, 'Orestiada'),
(341921072, '02087468262', 'Argyrou', 'Aglaia', 'Papakonstantinou', 8, 28215, 'Athina'),
(739244938, '24068114946', 'Spanou', 'Rea', 'Antoniadis', 977, 3334, 'Kileler'),
(539079664, '01098876842', 'Christopoulos', 'Logothetis', 'Charalabidou', 8, 87468, 'Peiraias'),
(551977697, '08079721090', 'Sideris', 'Mauroeidis', 'Labropoulos', 279, 21867, 'Agioi'),
(882434479, '20046628689', 'Lameras', 'Laurentios', 'Euthymiadou', 633, 48813, 'Alonnisos'),
(613380839, '26025562377', 'Kontos', 'Tsabikos', 'Spanou', 394, 8379, 'Alexandreia'),
(234857075, '28036380532', 'Voulgaris', 'Spyridon', 'Oikonomidou', 638, 74666, 'Leukada'),
(391318113, '28108265715', 'Argyrou', 'Kalliniki', 'Xanthopoulos', 608, 17319, 'Deskati'),
(991468022, '26054798902', 'Papakiriskou', 'Apollonia', 'Giannopoulos', 0, 7390, 'Karpathos'),
(660013294, '25125151027', 'Papadopoulou', 'Amfitriti', 'Kapetanaki', 279, 11496, 'Korydallos'),
(105392357, '24126994739', 'Triantafyllidou', 'Ioanna', 'Triantafyllidis', 1, 38628, 'Chalandri'),
(287984962, '29055119172', 'Eutaxias', 'Diogenis', 'Korakas', 5, 89200, 'Ydra'),
(557997197, '25038330792', 'Chatziioannou', 'Kali', 'Papagos', 3, 34919, 'Volos');


-- Works

INSERT INTO Works(Employee_IRS, Hotel_ID, Start_Date, Finish_Date, Position) VALUES
(245200205, 2, DATE('2014-01-23'), DATE('2018-11-07'), 'technician'),
(225744, 7, DATE('2005-04-10'), DATE('2007-06-19'), 'technician'),
(225744, 5, DATE('2007-06-20'), DATE('2011-03-13'), 'accountant'),
(225744, 6, DATE('2011-03-14'), DATE('2014-08-05'), 'technician'),
(225744, 8, DATE('2014-08-06'), DATE('2019-03-05'), 'gardener'),
(472800425, 5, DATE('2005-07-27'), DATE('2010-01-13'), 'technician'),
(472800425, 5, DATE('2010-01-14'), DATE('2010-09-23'), 'manager'),
(472800425, 5, DATE('2010-09-24'), DATE('2015-04-01'), 'accountant'),
(472800425, 5, DATE('2015-04-02'), DATE('2018-11-06'), 'accountant'),
(738242228, 2, DATE('2006-06-22'), DATE('2008-02-06'), 'waiter'),
(738242228, 10, DATE('2008-02-07'), DATE('2010-09-11'), 'receptionist'),
(738242228, 7, DATE('2010-09-12'), DATE('2012-07-25'), 'marketing manager'),
(738242228, 6, DATE('2012-07-26'), DATE('2017-01-09'), 'gardener'),
(738242228, 10, DATE('2017-01-10'), DATE('2018-12-11'), 'waiter'),
(248719098, 5, DATE('2011-05-22'), DATE('2014-07-31'), 'manager'),
(248719098, 4, DATE('2014-08-01'), DATE('2018-09-22'), 'chef'),
(38701508, 6, DATE('2013-09-20'), DATE('2016-05-02'), 'marketing manager'),
(38701508, 10, DATE('2016-05-03'), DATE('2017-10-06'), 'technician'),
(38701508, 4, DATE('2017-10-07'), DATE('2020-07-19'), 'chef'),
(715833361, 11, DATE('2011-03-01'), DATE('2014-08-27'), 'marketing manager'),
(715833361, 8, DATE('2014-08-28'), DATE('2019-05-23'), 'receptionist'),
(341921072, 7, DATE('2018-01-03'), DATE('2018-01-06'), 'technician'),
(341921072, 1, DATE('2018-01-07'), DATE('2018-03-21'), 'technician'),
(341921072, 3, DATE('2018-03-22'), DATE('2022-02-26'), 'receptionist'),
(739244938, 6, DATE('2000-06-14'), DATE('2002-11-28'), 'maid'),
(739244938, 10, DATE('2002-11-29'), DATE('2003-12-12'), 'manager'),
(739244938, 8, DATE('2003-12-13'), DATE('2008-01-09'), 'manager'),
(739244938, 5, DATE('2008-01-10'), DATE('2012-01-20'), 'technician'),
(739244938, 4, DATE('2012-01-21'), DATE('2012-06-03'), 'accountant'),
(739244938, 10, DATE('2012-06-04'), DATE('2016-03-16'), 'accountant'),
(739244938, 6, DATE('2016-03-17'), DATE('2019-12-30'), 'marketing manager'),
(539079664, 7, DATE('2013-11-18'), DATE('2014-05-10'), 'gardener'),
(539079664, 3, DATE('2014-05-10'), DATE('2015-07-30'), 'gardener'),
(539079664, 9, DATE('2015-07-30'), DATE('2019-04-03'), 'manager'),
(551977697, 9, DATE('2004-01-04'), DATE('2005-06-27'), 'maid'),
(551977697, 7, DATE('2005-06-28'), DATE('2006-01-03'), 'marketing manager'),
(551977697, 8, DATE('2006-01-04'), DATE('2007-04-12'), 'waiter'),
(551977697, 5, DATE('2007-04-13'), DATE('2009-03-14'), 'receptionist'),
(551977697, 2, DATE('2009-03-15'), DATE('2010-10-27'), 'technician'),
(551977697, 11, DATE('2010-10-28'), DATE('2011-04-14'), 'maid'),
(551977697, 6, DATE('2011-04-15'), DATE('2012-03-21'), 'manager'),
(551977697, 9, DATE('2012-03-22'), DATE('2014-05-18'), 'maid'),
(551977697, 6, DATE('2014-05-19'), DATE('2015-03-19'), 'waiter'),
(551977697, 1, DATE('2015-03-20'), DATE('2015-10-06'), 'technician'),
(551977697, 4, DATE('2015-10-07'), DATE('2020-02-07'), 'accountant'),
(882434479, 1, DATE('2014-04-13'), DATE('2016-12-25'), 'gardener'),
(882434479, 6, DATE('2016-12-26'), DATE('2021-08-10'), 'technician'),
(613380839, 4, DATE('2010-05-02'), DATE('2011-04-05'), 'manager'),
(613380839, 6, DATE('2011-04-06'), DATE('2012-06-20'), 'marketing manager'),
(613380839, 11, DATE('2012-06-21'), DATE('2016-07-22'), 'chef'),
(613380839, 2, DATE('2016-07-23'), DATE('2019-01-10'), 'gardener'),
(234857075, 7, DATE('2001-11-17'), DATE('2005-04-26'), 'gardener'),
(234857075, 10, DATE('2005-04-27'), DATE('2007-08-24'), 'maid'),
(234857075, 5, DATE('2007-08-25'), DATE('2007-09-23'), 'manager'),
(234857075, 4, DATE('2007-09-24'), DATE('2011-11-25'), 'waiter'),
(234857075, 7, DATE('2011-11-26'), DATE('2014-03-11'), 'receptionist'),
(234857075, 10, DATE('2014-03-12'), DATE('2017-05-29'), 'chef'),
(234857075, 5, DATE('2017-05-30'), DATE('2021-10-31'), 'receptionist'),
(391318113, 3, DATE('2009-06-28'), DATE('2010-04-21'), 'waiter'),
(391318113, 7, DATE('2010-04-22'), DATE('2015-02-23'), 'technician'),
(391318113, 2, DATE('2015-02-24'), DATE('2018-06-06'), 'chef'),
(991468022, 2, DATE('2007-01-14'), DATE('2007-04-21'), 'waiter'),
(991468022, 11, DATE('2007-04-21'), DATE('2010-12-14'), 'receptionist'),
(991468022, 5, DATE('2010-12-15'), DATE('2015-10-22'), 'accountant'),
(991468022, 1, DATE('2015-10-23'), DATE('2017-05-05'), 'maid'),
(991468022, 11, DATE('2017-05-06'), DATE('2020-01-15'), 'marketing manager'),
(660013294, 4, DATE('2015-09-20'), DATE('2017-01-10'), 'chef'),
(660013294, 4, DATE('2017-01-11'), DATE('2017-08-09'), 'maid'),
(660013294, 11, DATE('2017-08-10'), DATE('2020-02-13'), 'maid'),
(105392357, 6, DATE('2004-06-18'), DATE('2007-09-12'), 'accountant'),
(105392357, 4, DATE('2007-09-13'), DATE('2012-04-02'), 'maid'),
(105392357, 3, DATE('2012-04-03'), DATE('2012-08-28'), 'waiter'),
(105392357, 7, DATE('2012-08-29'), DATE('2016-01-28'), 'waiter'),
(105392357, 2, DATE('2016-01-29'), DATE('2019-06-17'), 'chef'),
(287984962, 5, DATE('2011-11-23'), DATE('2015-01-06'), 'marketing manager'),
(287984962, 7, DATE('2015-01-07'), DATE('2016-01-01'), 'marketing manager'),
(287984962, 1, DATE('2016-01-02'), DATE('2019-10-23'), 'manager'),
(557997197, 4, DATE('2001-11-18'), DATE('2004-06-30'), 'chef'),
(557997197, 3, DATE('2004-07-01'), DATE('2005-05-03'), 'maid'),
(557997197, 4, DATE('2005-05-04'), DATE('2009-10-07'), 'accountant'),
(557997197, 1, DATE('2009-10-08'), DATE('2012-07-29'), 'receptionist'),
(557997197, 8, DATE('2012-07-30'), DATE('2017-01-24'), 'gardener'),
(557997197, 10, DATE('2017-01-25'), DATE('2017-07-07'), 'accountant'),
(557997197, 4, DATE('2017-07-08'), DATE('2021-01-31'), 'accountant');


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
