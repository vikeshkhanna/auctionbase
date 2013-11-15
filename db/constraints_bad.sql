PRAGMA foreign_keys = ON;

/* K constraints */
-- PK on User(UserID)
INSERT INTO User SELECT * FROM User T WHERE T.UserID = (Select max(U.UserID) FROM User U);

-- PK on Item(ItemID)
INSERT INTO Item SELECT * FROM Item T WHERE T.ItemID = (Select max(I.ItemID) FROM Item I);

-- PK on Bid(UserID, ItemID, Time)
INSERT INTO Bid SELECT * From Bid where UserID = (Select max(B.UserID) From Bid B);

/* R constraints */
-- FK Bid(UserID) -> User(UserID)
INSERT INTO Bid VALUES('cs145dummyuser', 1, date('now'), 300); 

-- FK Bid(ItemID) -> Item(ItemID)
INSERT INTO Bid VALUES('cs145dummyuser', 1, date('now'), 300); 

-- FK ItemCategory(ItemID) -> Item(ItemID)
INSERT INTO ItemCategory Values(1, 'Music');

-- FK Item(UserID) -> User(UserID):
UPDATE Item SET UserID='cs145dummyuser' WHERE ItemID = (Select min(I.ItemID) From Item I);

/* C constraints */
-- Start Time <End Time
Update Item set Started = date(Ends, '+2 months') WHERE ItemID = (Select min(I.ItemID) from Item I);

-- Buy Price of an item should be greater than First_Bid or NULL
Update Item set Buy_Price = First_Bid-20 WHERE ItemID = (Select min(I.ItemID) from Item I);

-- First_Bid should be positive
Update Item set First_Bid=-20 WHERE ItemID = (Select min(I.ItemID) from Item I);

