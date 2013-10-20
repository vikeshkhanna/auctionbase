CREATE TABLE User(UserID text PRIMARY KEY, Location text, Country text, Rating number);

CREATE TABLE Item(ItemID number PRIMARY KEY, Name text, Currently number, Number_of_Bids number, First_bid number, Buy_Price number, UserID number, Started datetime, Ends datetime, Description text);

CREATE TABLE Bid(UserID text, ItemID number, Time datetime, Amount number, PRIMARY KEY(UserID, ItemID, Time));

CREATE TABLE ItemCategory(ItemID number, Category text);
