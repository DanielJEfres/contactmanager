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

    fetch("login.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data)
    })
    .then(function (response) {
      return response.json(); // this will FAIL if login.php returns a PHP parse error page
    })
    .then(function (result) {
      alert(result.message);

      if (result.success) {
        // store whatever login.php returns so contacts.html can use it
        localStorage.setItem("user", JSON.stringify(result));
        window.location.href = "contacts.html";
      }
    })
    .catch(function (error) {
      console.log(error);
      alert("Login failed (check console + make sure login.php returns valid JSON).");
    });

  });

});
