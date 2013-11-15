PRAGMA foreign_keys = ON;

-- Inserting dummy values. Will be removed later in the same file
INSERT INTO User values('cs145dummyuser', 'US', 'CA', '1');
INSERT INTO Item Values(1, 'The shocking miss Caro Emerald', 1, 0, 100, 200, 'cs145dummyuser', date('now', '-3 months'), date('now'), 'Very shocking');
INSERT INTO Bid Values('cs145dummyuser', 1, date('now', '-1 months'), 150); 

/* K constraints */
-- PK on User(UserID)
INSERT INTO User SELECT UserID||'z', Country, Location, Rating FROM User T WHERE T.UserID = (Select max(U.UserID) FROM User U);
DELETE FROM User WHERE UserID = (SELECT max(U.UserID) From User U);

-- PK on Item(ItemID)
INSERT INTO Item SELECT ItemID+1, Name, Currently, 0, First_Bid, Buy_Price, UserID, Started, Ends, Description FROM Item T WHERE T.ItemID = (Select max(I.ItemID) FROM Item I);
DELETE FROM Item WHERE ItemID = (SELECT max(I.ItemID) FROM Item I);

-- PK on Bid(UserID, ItemID, Time)
INSERT INTO Bid SELECT UserID, ItemID, date('now'), Amount From Bid where UserID = (Select max(B.UserID) From Bid B);
Delete FROM Bid WHERE UserID = (Select max(B.UserID) FROM Bid B)  and Time = (Select max(B.Time) From Bid B);

/* R constraints */
-- FK Bid(UserID) -> User(UserID)
INSERT INTO Bid Values('cs145dummyuser', 1, date('now','-1.1 months'), 300);
DELETE FROM Bid WHERE UserId = 'cs145dummyuser';

-- FK Bid(ItemID) -> Item(ItemID)
INSERT INTO Bid Values('cs145dummyuser', 1, date('now','-1.2 months'), 150);
DELETE FROM Bid WHERE UserId = 'cs145dummyuser';

-- FK ItemCategory(ItemID) -> Item(ItemID)
INSERT INTO ItemCategory Values(1, 'Music');
DELETE FROM ItemCategory WHERE ItemID = 1;

-- FK Item(UserID) -> User(UserID)
INSERT INTO Item Values(2, 'Bad moon rising', 1, 0, 100, 200, 'cs145dummyuser', date('now', '-2 months'), date('now'), 'Creedence Clearwater Revival');
DELETE FROM Item WHERE ItemID = 2;

/* C constraints */
-- Start Time <End Time
Update Item set Started = date(Ends, '-2 months') WHERE ItemID=1;
Update Item set Started = date(Ends, '-3 months') WHERE ItemID=1;

-- Buy Price of an item should be greater than First_Bid or NULL
Update Item set Buy_Price = First_Bid+20 WHERE ItemID=1;
Update Item set Buy_Price = NULL where ItemID=1;
Update Item set Buy_Price = First_Bid+100 WHERE ItemID=1;

-- First_Bid should be positive
Update Item set First_Bid=20 WHERE ItemID=1;
Update Item set First_Bid = 100 WHERE ItemID=1;

/* Remove dummy rows */
DELETE FROM User where UserID='cs145dummyuser';
DELETE FROM Item WHERE ItemID = 1;
DELETE FROM Bid WHERE ItemID = 1;
