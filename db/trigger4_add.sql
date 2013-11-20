PRAGMA foreign_keys = ON;

drop trigger if exists T_BID_INSERT;
create trigger T_BID_INSERT
after INSERT on Bid
for each row
when julianday(New.Time) > (select julianday(ends) from item where itemid=New.ItemID) or (select buy_price==currently from item where itemid=New.ItemID)
begin
select raise(rollback, 'This auction is closed.');
end;

