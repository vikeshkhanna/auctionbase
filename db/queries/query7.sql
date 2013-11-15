 SELECT count(distinct Category) from ItemCategory IC, Item I, Bid B where I.ItemID = IC.ItemID and B.ItemID = I.ItemID and amount>100;
