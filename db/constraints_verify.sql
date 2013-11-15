SELECT * FROM Bid WHERE UserID NOT IN (SELECT UserID from User);
SELECT * FROM Bid WHERE ItemID NOT IN (SELECT ItemID from Item);
SELECT * FROM ItemCategory WHERE ItemID NOT IN (SELECT ItemID From Item);
SELECT * FROM Item WHERE UserID NOT IN (SELECT UserID FROM User);

/* Verify T constraints */
SELECT 'T1',ItemID from Item WHERE number_of_bids != (SELECT Count(*) From Bid where ItemID=Item.ItemID);
SELECT 'T2',ItemID from Item WHERE currently != first_bid and currently!= (Select max(amount) from bid where itemid = Item.ItemID);
SELECT 'T3',Bid.ItemID from Bid, Item WHERE Bid.ItemID = Item.ItemID and Amount < Item.First_Bid;
SELECT 'T4',Bid.ItemID from Bid, Item WHERE Bid.ItemID = Item.ItemID and (Time > Item.Ends or Time < Item.Started);
