 PRAGMA foreign_keys = ON;

-- For this trigger, contraint is always violated when the trigger is activated. The trigger fixes the violation. 
drop trigger T_NUMBER_OF_BIDS_INSERT;
drop trigger T_NUMBER_OF_BIDS_DELETE;

