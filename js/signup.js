document.addEventListener("DOMContentLoaded", function () {
  // dont run until page is loaded

  var form = document.getElementById("signupForm");

  form.addEventListener("submit", function (e) {
    e.preventDefault(); // stop page reload

    // grab values
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    // build JSON object
    var data = {
      username: username,
      password: password
    };

    // send request
    fetch("api/register.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(data)
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (result) {
        var msg = document.getElementById("message");
        msg.innerText = result.message;
        msg.style.color = "green";

        if (result.success) {
          setTimeout(function () {
            window.location.href = "login.html";
          }, 1500);
        }
      })
      .catch(function (error) {
        console.log(error);
        alert("Error connecting to server");
      });

  });

});
