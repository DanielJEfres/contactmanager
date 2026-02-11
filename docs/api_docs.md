# Contact Manager API Doc

## Field Validation Rules

# Phone Numbers
- Pattern: `^\+?[0-9]{7,15}$`
- Must be 7-15 digits
- Can optionally start with `+`
- Examples: `4071234567`, `+14071234567`

# Email Addresses
- Must pass standard email validation (uses PHP `filter_var` with `FILTER_VALIDATE_EMAIL`)
- Examples: `hello@example.com`, `john.doe@company.co.uk`

# Required Fields
All fields are trimmed of whitespace. Empty strings after trimming are considered invalid.

## Response Format

All endpoints return a consistent JSON structure:

```json
{
  "success": boolean,    // true if operation succeeded, false otherwise
  "message": string, 
  "data": mixed         // Response data (null, object, or array depending on endpoint)
}
```

## Endpoints:

### 1. Register User
**Endpoint:** `POST /api/register.php`

**Description:** Create a new user account

**Request Body:**
```json
{
  "username": "johndoe",
  "password": "securePassword123"
}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "User registered successfully",
  "data": null
}
```

**Error Responses:**
```json
{
  "success": false,
  "message": "Missing username or password",
  "data": null
}
```
```json
{
  "success": false,
  "message": "Username already exists",
  "data": null
}
```

### 2. Login User
**Endpoint:** `POST /api/login.php`

**Description:** Authenticate a user and receive their information

**Request Body:**
```json
{
  "username": "johndoe",
  "password": "securePassword123"
}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "username": "johndoe"
  }
}
```

**Error Responses:**
```json
{
  "success": false,
  "message": "Missing username or password",
  "data": null
}
```
```json
{
  "success": false,
  "message": "Login/Password incorrect",
  "data": null
}
```

### 3. Add Contact
**Endpoint:** `POST /api/addcontact.php`

**Description:** Create a new contact for a user

**Request Body:**
```json
{
  "userId": 12,
  "firstName": "John",
  "lastName": "Doe",
  "phone": "4071234567",
  "email": "john@example.com"
}
```

**Field Validation:**
- `userId`: Required, non-empty
- `firstName`: Required, non-empty
- `lastName`: Required, non-empty
- `phone`: Required, 7-15 digits, can start with `+`
- `email`: Required, valid email format

**Success Response (200):**
```json
{
  "success": true,
  "message": "Contact added successfully!",
  "data": null
}
```

**Error Responses:**
```json
{
  "success": false,
  "message": "Missing one or more required fields",
  "data": null
}
```
```json
{
  "success": false,
  "message": "Invalid email format",
  "data": null
}
```
```json
{
  "success": false,
  "message": "Invalid phone number format",
  "data": null
}
```
```json
{
  "success": false,
  "message": "A contact with this email already exists for this user",
  "data": null
}
```

### 4. Update Contact
**Endpoint:** `POST /api/updateContact.php`

**Description:** Update an existing contact (Only contacts owned by the user can be updated)

**Request Body:**
```json
{
  "contactId": 5,
  "userId": 12,
  "firstName": "Johnny",
  "lastName": "Doe",
  "phone": "4079999999",
  "email": "johnny@example.com"
}
```

**Field Validation:**
- All fields from Add Contact, plus `contactId`
- Same validation rules apply

**Success Response (200):**
```json
{
  "success": true,
  "message": "Contact updated",
  "data": null
}
```

**Error Responses:**
```json
{
  "success": false,
  "message": "Contact not found",
  "data": null
}
```
```json
{
  "success": false,
  "message": "Invalid email format",
  "data": null
}
```
```json
{
  "success": false,
  "message": "A contact with this email already exists for this user",
  "data": null
}
```

### 5. Delete Contact
**Endpoint:** `POST /api/deleteContact.php`

**Description:** Delete a contact (Only contacts owned by the user can be deleted)

**Request Body:**
```json
{
  "contactId": 5,
  "userId": 12
}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Contact deleted",
  "data": null
}
```

**Error Responses:**
```json
{
  "success": false,
  "message": "Missing one or more required fields",
  "data": null
}
```
```json
{
  "success": false,
  "message": "Contact not found or cant delete",
  "data": null
}
```

### 6. Search Contacts
**Endpoint:** `POST /api/searchcontact.php`

**Description:** Search and retrieve contacts for a user. This one also supports partial, case-insensitive matching across first name, last name, email, and phone. Finally it returns all contacts if search is empty.

**Request Body:**
```json
{
  "userId": 12,
  "search": "jo"
}
```

**Special Behavior:**
- If `search` is empty string `""`, returns **all contacts** for the user
- Search is **case-insensitive** and matches **partial strings**
- Searches across: `FirstName`, `LastName`, `Email`, `Phone`

**Success Response (200):**
```json
{
  "success": true,
  "message": "Search completed",
  "data": [
    {
      "ID": "5",
      "FirstName": "John",
      "LastName": "Doe",
      "Phone": "4071234567",
      "Email": "john@example.com"
    },
    {
      "ID": "8",
      "FirstName": "Jane",
      "LastName": "Johnson",
      "Phone": "4079876543",
      "Email": "jane@example.com"
    }
  ]
}
```

**Empty Results:**
```json
{
  "success": true,
  "message": "Search completed",
  "data": []
}
```

**Error Responses:**
```json
{
  "success": false,
  "message": "Missing userId",
  "data": null
}
```