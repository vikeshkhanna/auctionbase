PRAGMA foreign_keys = ON;

-- Raise an error if a new bid has amount less than currently

drop trigger if exists T_AMOUNT_INSERT;
create trigger T_AMOUNT_INSERT
after INSERT on Bid
for each row
when New.Amount <= (select currently from Item where Item.ItemID = New.ItemID)
begin
select raise(rollback, 'Bid amount must be greater than the current bid.');
end;
