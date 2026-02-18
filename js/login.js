document.addEventListener("DOMContentLoaded", function () {

  var form = document.getElementById("loginForm");

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    var data = {
      username: username,
      password: password
    };

    fetch("api/login.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data)
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (result) {

        var msg = document.getElementById("message");
        msg.innerText = result.message;

        if (result.success) {
          msg.style.color = "green";

          // save login info
          localStorage.setItem("userId", result.data.userId);
          localStorage.setItem("username", username);

          // small delay so user sees success
          setTimeout(function () {
            window.location.href = "contacts.html";
          }, 1200);

        } else {
          msg.style.color = "red";
        }

      })
      .catch(function (error) {
        console.log(error);

        var msg = document.getElementById("message");
        msg.innerText = "Unable to connect to server.";
        msg.style.color = "red";
      });

  });

});
