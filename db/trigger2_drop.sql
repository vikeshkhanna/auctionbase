PRAGMA foreign_keys = ON;

-- Insert dummy values 
INSERT INTO User values('cs145dummyuser', 'US', 'CA', '1');
INSERT INTO Item Values(1, 'The shocking miss Caro Emerald', 100, 0, 100, 200, 'cs145dummyuser', date('now', '-3 months'), date('now'), 'Very shocking');
INSERT INTO Bid Values('cs145dummyuser', 1, date('now', '-1 months'), 150);  -- This will cause violation but it's necessary to setup the case
INSERT INTO Bid Values('cs145dummyuser', 1, date('now', '-0.5 months'), 120); -- This will not cause violation 

-- Remove dummy values - ON DELETE Cascade will handle everything
DELETE FROM User WHERE UserID='cs145dummyuser';

drop trigger T_CURRENTLY_INSERT;
drop trigger T_CURRENTLY_DELETE;
drop trigger T_CURRENTLY_UPDATE;

