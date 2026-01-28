USE ContactManager
CREATE TABLE
    Users (
        ID CHAR(36) DEFAULT (UUID ()) PRIMARY KEY,
        Username VARCHAR(50) NOT NULL,
        Password VARCHAR(255) NOT NULL
    );

CREATE TABLE
    Contacts (
        ID CHAR(36) DEFAULT (UUID ()) PRIMARY KEY,
        UserID CHAR(36) NOT NULL,
        FirstName VARCHAR(50) NULL,
        LastName VARCHAR(50) NULL,
        Phone VARCHAR(50) NULL,
        Email VARCHAR(50) NULL,
        DateCreated DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (UserID) REFERENCES Users (ID) ON DELETE CASCADE
    );