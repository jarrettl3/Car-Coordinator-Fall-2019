INSERT INTO User
VALUES
(0001, 'jlefler', 'password', 'Jarrett', 'Lefler', '2019-01-17', '3 Somewhere Place', 'State Farm', 333333),
(0002, 'mcameron', 'r0b0t$', 'Marietta', 'Cameron', '2019-07-10', '7 Compsci Ave', 'Progressive', 416503),
(0003, 'jbuggy29', 'greek3!', 'Jake', 'Shelton', '2019-03-24', '33 Parkside Lane', 'Farmers', 888888),
(0004, 'phoenixphella', 'r!s1ng', 'Sarah', 'Fawlkes', '2018-08-14', '16 Wayward Place', 'Geico', 123456),
(0005, 'bigjimmy', 'sm4llj4me$', 'James', 'Hodge', '2018-10-26', '18 Cricket Court', 'Progressive', 102938),
(0006, 'ursamajor', 'b1gd!pper', 'Jade', 'Carroll', '2019-04-17', '43 Gullow Way', 'Farmers', 657483),
(0007, 'redslippers', 'n0tink@nsas', 'Dorothy', 'Gale', '2019-05-04', '44 Yellowbrick Road', 'Goodwitch', 100007),
(0008, 'phrenzie', 'g0w!ld', 'Mark', 'Brinklin', '2019-06-29', '38 Goldfarm Road', 'State Farm', 617283),
(0009, 'redlady3', 'foli0mag!', 'Daisy', 'Darling', '2019-02-14', '77 Crallux Circle', 'Geico', 172937),
(0010, 'hornswoggle', 'g@dz00ks', 'Harry', 'Blumen', '2018-04-17', '1 Guthrie Park', 'Progressive', 654321);

INSERT INTO Vehicle
VALUES
(11111, '0001', 'Cadillac', 'Caterra', 'White', 4, '2019-01-017', 'ABC-1234'),
(22222, '0002', 'Mazda', 'Mazda 4', 'Blue', 5, '2019-07-10', 'HQE-4263'),
(23415, '0003', 'Subaru', 'Forester', 'Grey', 5, '2019-03-26', 'SUB-2007'),
(82391, '0004', 'Toyota', 'Corrola', 'Red', 4, '2018-08-15', 'VUX-1783'),
(66145, '0005', 'Hyundai', 'Tucson', 'White', 5, '2018-10-26', 'JNC-9824'),
(44566, '0006', 'Jeep', 'Cherokee', 'White', 5, '2019-04-20', 'BBQ-1987'),
(11223, '0007', 'Subaru', 'Crosstrek', 'Orange', 4, '2019-05-04', 'FIT-2019'),
(12345, '0008', 'Honda', 'Pilot', 'White', 5, '2019-06-29', 'RRQ-5728'),
(29387, '0008', 'Dodge', 'Challenger', 'Blue', 4, '2019-07-04', 'BBN-8291'),
(98765, '0009', 'Ford', 'Fusion', 'Black', 4, '2019-2-15', 'HKN-4482'),
(44773, '0010', 'Kia', 'Forte', 'Red', 4, '2018-05-23', 'AAA-1111');

INSERT INTO Event
VALUES
(1, '0004', '2019-12-22', '19:00:00', 'Chrimbus Party', "Let's make the yuletide gay, y'all!", '16 Wayward Place',  '2019-12-11'),
(2, '0006', '2019-07-14', '17:00:00', 'My Birthday Party', "I'm turning 22 so come celebrate!", '17 Oak Forge Road', '2019-06-27'),
(3, '0002', '2019-11-24', '08:00:00', 'Undergraduate Research Symposium', "Students will present their finished projects", '1 University Heights', '2019-07-10'),
(4, '0009', '2019-09-18', '14:00:00', 'Falls Creek Hike', "The prettiest waterfall I've ever seen!", '1 Falls Creek Road', '2019-09-04'),
(5, '0003', '2019-11-25', '18:00:00', 'Friendsgiving', "Let's eat, chums! It's a potluck, so bring some food if you like!", '33 Parkside Lane', '2019-11-14'),
(6, '0007', '2019-12-31', '19:00:00', 'New Years', "Ring in the new year with me!", '44 Yellowbrick Road', '2019-12-18'),
(7, '0005', '2019-09-18', '13:00:00', 'Poetry by Carrie', "My sister is reciting some of her amazing poetry! Come support her!", '17 Wilmington Street', '2019-09-03'),
(8, '0006', '2019-04-26', '09:00:00', 'St. Jude Marathon', "Run for charity!", '4 Clarks Park Way', '2019-03-17'),
(9, '0004', '2019-09-12', '14:00:00', 'Filming!', "We're working on scenes for my film and we need a lot of extras", '13 Bridgemont Ave', '2019-09-07'),
(10, '0010', '2020-02-13', '21:00:00', '50s Prom', "A 50s prom-style Valentine's party! I love you all!", '1 Guthrie Park', '2019-12-16');

INSERT INTO Invitation
VALUES
('1', '1', '0003'), ('2', '1', '0010'), ('3', '1', '0009'), ('4', '1', '0008'), ('5', '1', '0001'), /*First Event 'Chrimbus Party'*/
('6', '2', '0003'), ('7', '2', '0007'), ('8', '2', '0009'), ('9', '2', '0005'), ('10', '2', '0010'), /*Second Event 'My Birthday Party'*/
('11', '3', '0001'), ('12', '3', '0003'), ('13', '3', '0004'), ('14', '3', '0008'), ('15', '3', '00010'), /*Third Event 'Undergraduate Research Symposium'*/
('16', '4', '0003'), ('17', '4', '0004'), ('18', '4', '0010'), ('19', '4', '0007'), ('20', '4', '0005'), /*Fourth Event 'Falls Creek Hike'*/
('21', '5', '0001'), ('22', '5', '0004'), ('23', '5', '0006'), ('24', '5', '0010'), ('25', '5', '0007'), /*Fifth Event 'Friendsgiving'*/
('26', '6', '0003'), ('27', '6', '0001'), ('28', '6', '0008'), ('29', '6', '0002'), ('30', '6', '0004'), /*Sixth Event 'New Years'*/
('31', '7', '0006'), ('32', '7', '0004'), ('33', '7', '0001'), ('34', '7', '0010'), ('35', '7', '0003'), /*Seventh Event 'Poetry by Carrie'*/
('36', '8', '0001'), ('37', '8', '0003'), ('38', '8', '0005'), ('39', '8', '0007'), ('40', '8', '0009'), /*Eigth Event 'St. Jude Marathon'*/
('41', '9', '0003'), ('42', '9', '0005'), ('43', '9', '0008'), ('44', '9', '0009'), ('45', '9', '0007'), /*Nineth Event 'Filming!'*/
('46', '10', '0001'), ('47', '10', '0003'), ('48', '10', '0004'), ('49', '10', '0009'), ('50', '10', '0005'); /*Tenth Event '50s Prom'*/

INSERT INTO Vehicle_Pledge
VALUES
(1, '23415', '1', '2019-12-13', "I think I'll head out around 8 and I'm stopping by Ingles"), (2, '44773', '1', '2019-12-11', "Description"), /*Event 1*/
(3, '11223', '2', '2019-06-28', "Coming from West AVL"), (4, '44773', '2', '2019-06-29', "Probably won't stay long"), /*Event 2*/
(5, '23415', '3', '2019-07-10', "Driving to but not from"), /*Event 3*/
(6, '44773', '4', '2019-09-05', "I can't go until after 9, but I'm good to stay till whenever"), (7, '66145', '4', '2019-09-06', "I wanna drive"), /*Event 4*/
(8, '82391', '5', '2019-11-14', "Arriving early, but leaving early too"), (9, '11223', '5', '2019-11-13', "Bringing drinks from Harris Teeter"), /*Event 5*/
(10, '22222', '6', '2019-12-19', "Facts about my drive"), (11, '29387', '6', '2019-12-18', "Info on my pledge"), /*Event 6*/
(12, '11111', '7', '2019-09-04', "I'm leaving at a time coming from a place"), (13, '23415', '7', '2019-09-04', "Heading out from North Asheville"), (14, '82391', '7', '2019-09-05', "I'm driving in from Candler"), /*Event 7*/
(15, '66145', '8', '2019-03-17', "Describing"), (16, '11111', '8', '2019-03-18', "Something something something"), /*Event 8*/
(17, '29387', '8', '2019-09-07', "blah blah blah"), (18, '98765', '8', '2019-09-08', "I drive slow but I'm good at it"), (19, '23415', '8', '2019-09-09', "I'd appreciate some gas money"), /*Event 9*/
(20, '11111', '8', '2020-02-03', "I eat peanuts in my car a lot so if you got allergies don't ride here"), (21, '66145', '8', '2020-01-27', "Respect my vehicle pls"); /*Event 10*/

INSERT INTO Seat_Claim
VALUES
(1, 1,'9'), (2, 2,'8'), (3, 2,'1'), /*Event 1*/
(4, '3','9'), (5, '3','3'), (6, '4','5'), /*Event 2*/
(7, '5','10'), (8, '5','8'), (9, '5','1'), (10, '5', '4'), /*Event 3*/
(11, '6','7'), (12, '7','4'), (13, '7','3'), /*Event 4*/
(14, '8','10'), (15, '8','6'), (16, '9','1'), /*Event 5*/
(17, '10','4'), (18, '11','1'), (19, '11','3'), /*Event 6*/
(20, '12','10'), (21, '14','6'), /*Event 7*/
(22, '15','9'), (23, '16','7'), (24, '16','3'), /*Event 8*/
(25, '17','5'), (26, '18','7'), /*Event 9*/
(27, '20','9'), (28, '21','3'), (29, '21','4'); /*Event 10*/
