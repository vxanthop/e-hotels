USE ehotels;

SELECT
IF(
    (SELECT COUNT(1) FROM Hotel_group) >= 5,
    "OK",
    "NO"
) AS '>= 5 groups',

IF(
    (SELECT SUM(chk = 0) FROM
        (SELECT (COUNT(1) >= 5) AS chk FROM Hotel GROUP BY Hotel_group_ID) AS tbl
    ) = 0,
    "OK",
    "NO"
) AS '>= 5 hotels/group',

IF(
    (SELECT SUM(chk = 0) FROM
        (SELECT (COUNT(DISTINCT Stars) >= 3) AS chk FROM Hotel GROUP BY Hotel_group_ID) AS tbl
    ) = 0,
    "OK",
    "NO"
) AS '>= 3 distinct hotel stars/group',

IF(
    (SELECT SUM(chk > 0) FROM
        (SELECT 
            (SELECT COUNT(DISTINCT Address_City) FROM Hotel WHERE Hotel_group_ID = Hotel_group.Hotel_group_ID) = Number_of_hotels AS chk
        FROM Hotel_group) AS tbl
    ) = 0,
    "OK",
    "NO"
) AS '>= 2 hotels in same city/group',

IF(
    (SELECT SUM(chk = 0) FROM
        (SELECT (COUNT(DISTINCT Capacity) >= 5) AS chk FROM Hotel_Room GROUP BY Hotel_ID) AS tbl
    ) = 0,
    "OK",
    "NO"
) AS '>= 5 distinct room capacities/hotel'
;