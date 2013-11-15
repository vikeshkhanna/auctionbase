SELECT count(*) FROM (SELECT ItemID FROM ItemCategory GROUP BY ItemID HAVING count(distinct Category)==4);
