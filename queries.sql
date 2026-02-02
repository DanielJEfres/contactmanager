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
SELECT
    ID,
    FirstName,
    LastName,
    Phone,
    Email,
    DateCreated
FROM
    Contacts
WHERE
    UserID = "cd336184-fbc1-11f0-bb4f-0a0027000002"
    AND (
        CONCAT_WS (' ', FirstName, LastName) LIKE ""
        OR Phone LIKE "%2%"
        OR Email Like ""
    )
ORDER BY
    FirstName ASC
LIMIT
    10
OFFSET
    0;

-- TODO: Get feedback from API team on which columns they need.
/*
 * Get the ID, Password, and Salt associated with a Username
 */
SELECT
    ID,
    Password,
    Salt
FROM
    Users
WHERE
    Username = "charlie";

/*
 * Add contact to user.
 */
INSERT INTO
    Contacts (
        UserID,
        FirstName,
        LastName,
        Phone,
        Email,
        DateCreated
    )
VALUES
    (
        "cd336184-fbc1-11f0-bb4f-0a0027000002",
        "john",
        "doe",
        "475-346-7535",
        "thisisfake@gmk.com",
        CURRENT_TIMESTAMP
    );

/*
 * Update User information
 */
UPDATE Users
SET
    Username = "someUsername",
    Password = "somePassword",
WHERE
    ID = "cd336184-fbc1-11f0-bb4f-0a0027000002";

/*
 * Update Contact information
 */
UPDATE Contacts
SET
    FirstName = "someFirstName",
    LastName = "someLastName",
    Phone = "somePhoneNumber",
    Email = "someEmail"
WHERE
    ID = "f07800ca-fc89-11f0-bb4f-0a0027000002"
    AND UserID = "cd336184-fbc1-11f0-bb4f-0a0027000002";

/*
 * Delete contact information
 */
DELETE FROM Contacts
WHERE
    ID = "f07800ca-fc89-11f0-bb4f-0a0027000002"
    AND UserID = "cd336184-fbc1-11f0-bb4f-0a0027000002";

/*
 * Delete User
 */
DELETE FROM Users
WHERE
    ID = "cd336184-fbc1-11f0-bb4f-0a0027000002";

/*
 * Get Contact by contactID
 */
SELECT
    ID,
    FirstName,
    LastName,
    Phone,
    Email,
    DateCreated
FROM
    Contacts
WHERE
    ID = "f07800ca-fc89-11f0-bb4f-0a0027000002"
    AND UserID = "cd336184-fbc1-11f0-bb4f-0a0027000002";