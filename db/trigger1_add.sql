PRAGMA foreign_keys = ON;

drop trigger if exists T_NUMBER_OF_BIDS_INSERT;
create trigger T_NUMBER_OF_BIDS_INSERT
after INSERT on Bid
for each row
begin
Update Item set Number_of_bids=Number_of_bids+1 WHERE Item.ItemId=New.ItemID;
end;

drop trigger if exists T_NUMBER_OF_BIDS_DELETE;
create trigger T_NUMBER_OF_BIDS_DELETE
after DELETE on Bid
for each row
begin
Update Item set Number_of_bids=Number_of_bids-1 WHERE Item.ItemId=Old.ItemID;
end;

/*
SELECT ItemID from Item WHERE number_of_bids != (SELECT Count(*) From Bid where ItemID=Item.ItemID);

-- Insert dummy values 
INSERT INTO User values('cs145dummyuser', 'US', 'CA', '1');
INSERT INTO Item Values(1, 'The shocking miss Caro Emerald', 1, 0, 100, 200, 'cs145dummyuser', date('now', '-3 months'), date('now'), 'Very shocking');
INSERT INTO Bid Values('cs145dummyuser', 1, date('now', '-1 months'), 150); 

-- Remove dummy values - ON DELETE Cascade will handle everything
DELETE FROM User WHERE UserID='cs145dummyuser';
*/
