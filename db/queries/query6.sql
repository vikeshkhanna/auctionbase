SELECT count(distinct I.UserID) from Item I, Bid B where I.UserID=B.UserID;
