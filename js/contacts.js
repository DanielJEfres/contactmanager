document.addEventListener("DOMContentLoaded", function () {
  // Forms
  var addForm = document.getElementById("addContactForm");
  var searchForm = document.getElementById("searchForm");

  // Add-contact inputs (must match contacts.html)
  var firstNameInput = document.getElementById("firstName");
  var lastNameInput = document.getElementById("lastName");
  var emailInput = document.getElementById("email");
  var phoneInput = document.getElementById("phone");

  // Search + output
  var searchInput = document.getElementById("search");
  var contactListDiv = document.getElementById("contactList");
  var statusDiv = document.getElementById("status");

  function setStatus(msg) {
    statusDiv.textContent = msg;
  }

  // For now we expect login.js to store userId like:
  // localStorage.setItem("userId", result.data.userId);
  function getUserId() {
    return localStorage.getItem("userId");
  }

  function postJson(endpoint, bodyObj) {
    return fetch(endpoint, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(bodyObj),
    }).then(function (response) {
      return response.json();
    });
  }

  function renderContacts(contacts) {
    contactListDiv.innerHTML = "";

    if (!contacts || contacts.length === 0) {
      contactListDiv.textContent = "No contacts found.";
      return;
    }

    contacts.forEach(function (c) {
      var row = document.createElement("div");
      row.style.border = "1px solid #ccc";
      row.style.padding = "8px";
      row.style.marginBottom = "8px";

      var contactId = c.ID;
      var fullName = (c.FirstName || "") + " " + (c.LastName || "");
      fullName = fullName.trim();

      var info = document.createElement("div");
      info.textContent =
        "Name: " + fullName +
        " | Email: " + (c.Email || "") +
        " | Phone: " + (c.Phone || "");
      row.appendChild(info);

      // UPDATE button
      var updateBtn = document.createElement("button");
      updateBtn.textContent = "Update";
      updateBtn.style.marginRight = "8px";

      updateBtn.addEventListener("click", function () {
        var userId = getUserId();
        if (!userId) {
          setStatus("Missing userId. Please log in again.");
          return;
        }

        //get new values from the input fields
        var newFirst = firstNameInput.value.trim();
        var newLast  = lastNameInput.value.trim();
        var newEmail = emailInput.value.trim();
        var newPhone = phoneInput.value.trim();

        if (!newFirst || !newLast || !newEmail || !newPhone) {
          setStatus("Fill the fields above, then click Update.");
          return;
        }

        newFirst = newFirst.trim();
        newLast = newLast.trim();
        newEmail = newEmail.trim();
        newPhone = newPhone.trim();

        if (!newFirst || !newLast || !newEmail || !newPhone) {
          setStatus("All fields are required to update.");
          return;
        }

        postJson("api/updateContact.php", {
          contactId: contactId,
          userId: userId,
          firstName: newFirst,
          lastName: newLast,
          phone: newPhone,
          email: newEmail
        })
          .then(function (result) {
            setStatus(result.message);

            if (result.success) {
              doSearch(searchInput.value.trim());
            }
          })
          .catch(function (err) {
            console.log(err);
            setStatus("Update failed (check console).");
          });
      });

      // DELETE button
      var deleteBtn = document.createElement("button");
      deleteBtn.textContent = "Delete";

      deleteBtn.addEventListener("click", function () {
        var ok = confirm("Delete this contact?");
        if (!ok) return;

        var userId = getUserId();
        if (!userId) {
          setStatus("Missing userId. Please log in again.");
          return;
        }

        postJson("api/deleteContact.php", {
          contactId: contactId,
          userId: userId
        })
          .then(function (result) {
            setStatus(result.message);

            if (result.success) {
              doSearch(searchInput.value.trim());
            }
          })
          .catch(function (err) {
            console.log(err);
            setStatus("Delete failed (check console).");
          });
      });

      row.appendChild(updateBtn);
      row.appendChild(deleteBtn);
      contactListDiv.appendChild(row);
    });
  }

  function doSearch(searchText) {
    var userId = getUserId();
    if (!userId) {
      setStatus("Missing userId. Please log in again.");
      return;
    }

    postJson("api/searchcontact.php", {
      userId: userId,
      search: searchText || ""
    })
      .then(function (result) {
        if (!result.success) {
          setStatus(result.message);
          renderContacts([]);
          return;
        }

        // utils.php puts results in "data"
        renderContacts(result.data);
        setStatus(result.message);
      })
      .catch(function (err) {
        console.log(err);
        setStatus("Search failed (check console).");
      });
  }

  // ADD CONTACT submit
  addForm.addEventListener("submit", function (e) {
    e.preventDefault();

    var userId = getUserId();
    if (!userId) {
      setStatus("Missing userId. Please log in again.");
      return;
    }

    var firstName = firstNameInput.value.trim();
    var lastName = lastNameInput.value.trim();
    var email = emailInput.value.trim();
    var phone = phoneInput.value.trim();

    if (!firstName || !lastName || !email || !phone) {
      setStatus("Please fill in all fields.");
      return;
    }

    postJson("api/addcontact.php", {
      userId: userId,
      firstName: firstName,
      lastName: lastName,
      phone: phone,
      email: email
    })
      .then(function (result) {
        setStatus(result.message);

        if (result.success) {
          firstNameInput.value = "";
          lastNameInput.value = "";
          emailInput.value = "";
          phoneInput.value = "";

          doSearch(""); // reload all
        }
      })
      .catch(function (err) {
        console.log(err);
        setStatus("Add contact failed (check console).");
      });
  });

  // SEARCH submit
  searchForm.addEventListener("submit", function (e) {
    e.preventDefault();
    doSearch(searchInput.value.trim());
  });

  // Initial load: show all contacts
  doSearch("");
});
