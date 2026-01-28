-- TODO: Get feedback from API team on which columns they need.
-- TODO: Get feedback from API team on which columns they will be looking for matches from. Do I need to match with the Phone, Email, DateCreated?
/*
* Select a contact record from Contacts based on UserID, and any of the 
* other columns (Firstname, and LastName, Phone, Email, DateCreated)
*
* This query takes 1 search term. The search term can be any of the following:
*    - "firstName" + " " + "lastName"
*    - Phone number
*    - Email address
*/
SELECT ID, FirstName, LastName, Phone, Email, DateCreated
FROM Contacts 
WHERE UserID="cd336184-fbc1-11f0-bb4f-0a0027000002"
    AND (
        CONCAT_WS(' ', FirstName, LastName) LIKE "%c%" 
        OR Phone LIKE "%c%" 
        OR Email Like "%c%" 
    )
ORDER BY FirstName ASC;
LIMIT :limit OFFSET :starting_page;