SELECT count(distinct U.UserID) FROM Item I, User U where I.UserID = U.UserID and U.Rating>1000;
