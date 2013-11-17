CREATE TABLE User(
	UserID text PRIMARY KEY, 
	Location text,
	Country text,
	Rating number
);

CREATE UNIQUE INDEX IF NOT EXISTS User_UserID on User(UserID);

CREATE TABLE Item(
	ItemID number PRIMARY KEY, 
	Name text NOT NULL, 
	Currently number NOT NULL, 
	Number_of_Bids number NOT NULL, 
	First_bid number NOT NULL, 
	Buy_Price number, 
	UserID number, 
	Started datetime NOT NULL, 
	Ends datetime NOT NULL, 
	Description text NOT NULL, 
	CONSTRAINT ITEM_FK_UserID FOREIGN KEY(UserID) REFERENCES User(UserID) ON DELETE CASCADE, 
	CONSTRAINT ITEM_STARTED_LT_ENDS CHECK(Started < Ends),
	CONSTRAINT ITEM_BUY_PRICE_NULL_OR_GTE_FIRST_BID CHECK(Buy_Price is NULL or Buy_Price >= First_bid),
	CONSTRAINT ITEM_FIRST_BID_POSITIVE CHECK(First_bid > 0)
);

CREATE UNIQUE INDEX IF NOT EXISTS Item_ItemID on Item(ItemID);

CREATE TABLE Bid(
	UserID text, 
	ItemID number, 
	Time datetime NOT NULL, 
	Amount number NOT NULL, 
	CONSTRAINT BID_PK PRIMARY KEY(UserID, ItemID, Time), 
	CONSTRAINT BID_FK_UserID FOREIGN KEY(UserID) REFERENCES User(UserID) ON DELETE CASCADE,
	CONSTRAINT BID_FK_ItemID FOREIGN KEY(ItemID) REFERENCES Item(ItemID) ON DELETE SET NULL
);

CREATE INDEX IF NOT EXISTS Bid_UserID on Bid(UserID);
CREATE INDEX IF NOT EXISTS Bid_ItemID on Bid(ItemID);

CREATE TABLE ItemCategory(
	ItemID number, 
	Category text NOT NULL,
	CONSTRAINT ItemCategory_FK_ItemID FOREIGN KEY(ItemID) REFERENCES Item(ItemID) ON DELETE CASCADE
);

CREATE INDEX IF NOT EXISTS ItemCategory_ItemID on ItemCategory(ItemID);

CREATE TABLE Likes(
	UserID text,
	ItemID number,
	CONSTRAINT LIKES_FK_UserID FOREIGN KEY(UserID) REFERENCES User(UserID) ON DELETE CASCADE,
	CONSTRAINT LIKES_FK_ItemID FOREIGN KEY(ItemID) REFERENCES Item(ItemID) ON DELETE CASCADE,
	UNIQUE(UserID, ItemID)
);

CREATE INDEX IF NOT EXISTS Likes_UserID on Likes(UserID);
CREATE INDEX IF NOT EXISTS Likes_ItemID on Likes(ItemID);
