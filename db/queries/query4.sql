SELECT ItemID FROM Item WHERE Currently=(SELECT max(Currently) FROM Item);
