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

    // IMPORTANT: make this match your actual folder structure
    fetch("api/login.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data)
    })
    .then(function (response) {
      return response.json();
    })
    .then(function (result) {
      alert(result.message);

      if (result.success) {
        // utils.php returns payload in result.data
        // expects: result.data.userId
        localStorage.setItem("userId", result.data.userId);

        // optional: show name later
        localStorage.setItem("username", username);

        window.location.href = "contacts.html";
      }
    })
    .catch(function (error) {
      console.log(error);
      alert("Login failed (likely because login.php is currently broken / not returning JSON).");
    });

  });

});
