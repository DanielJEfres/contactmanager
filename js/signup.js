document.addEventListener("DOMContentLoaded", function () {

  var form = document.getElementById("signupForm");

  form.addEventListener("submit", function (e) 
  {
    e.preventDefault(); // stop page reload

    // grab values
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    // build JSON object
    var data = 
    {
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
    .then(function(response) {
      return response.json();
    })
    .then(function(result) {
      alert(result.message);

      if (result.success) {
        window.location.href = "login.html";
      }
    })
    .catch(function(error) {
      console.log(error);
      alert("Error connecting to server");
    });

  });

});
