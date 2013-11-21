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
PRAGMA foreign_keys = ON;

drop trigger if exists T_CURRENTLY_INSERT;
create trigger T_CURRENTLY_INSERT
after INSERT on Bid
for each row
when New.Amount > (select currently from Item where Item.ItemID = New.ItemID)
begin
Update Item set Currently=New.Amount WHERE Item.ItemId=New.ItemID;
end;

drop trigger if exists T_CURRENTLY_DELETE;
create trigger T_CURRENTLY_DELETE
after DELETE on Bid
for each row
when Old.Amount = (select currently from Item where Item.ItemID = Old.ItemID)
begin
Update Item set Currently = First_Bid where ItemID = Old.ItemID;
Update Item set Currently = (Select max(Amount) From Bid where ItemID = Old.ItemID) WHERE Item.ItemID=Old.ItemID AND EXISTS(Select ItemID from Bid where Bid.ItemID = Item.ItemID);
end;

drop trigger if exists T_CURRENTLY_UPDATE;
create trigger T_CURRENTLY_UPDATE
after UPDATE on Bid
for each row
when Old.Amount = (select currently from Item where Item.ItemID = New.ItemID)
begin
Update Item set Currently = First_Bid where ItemID = Old.ItemID;
Update Item set Currently = (Select max(Amount) From Bid where ItemID = Old.ItemID) WHERE ItemID=Old.ItemID;
end;


/*
SELECT ItemID from Item WHERE currently != first_bid and currently!= (Select max(amount) from bid where itemid = Item.ItemID);

-- Insert dummy values 
INSERT INTO User values('cs145dummyuser', 'US', 'CA', '1');
INSERT INTO Item Values(1, 'The shocking miss Caro Emerald', 100, 0, 100, 200, 'cs145dummyuser', date('now', '-3 months'), date('now'), 'Very shocking');
INSERT INTO Bid Values('cs145dummyuser', 1, date('now', '-1 months'), 150); 

-- Remove dummy values - ON DELETE Cascade will handle everything
DELETE FROM User WHERE UserID='cs145dummyuser';
*/
PRAGMA foreign_keys = ON;

-- Raise an error if a new bid has amount less than currently

drop trigger if exists T_AMOUNT_INSERT;
create trigger T_AMOUNT_INSERT
after INSERT on Bid
for each row
when New.Amount < (select currently from Item where Item.ItemID = New.ItemID)
begin
select raise(rollback, 'Bid amount must be greater than the current bid.');
end;
PRAGMA foreign_keys = ON;

drop trigger if exists T_BID_INSERT;
create trigger T_BID_INSERT
after INSERT on Bid
for each row
when julianday(New.Time) > (select julianday(ends) from item where itemid=New.ItemID) or (select buy_price==currently from item where itemid=New.ItemID)
begin
select raise(rollback, 'This auction is closed.');
end;

